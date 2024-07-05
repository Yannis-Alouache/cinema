<?php
/*
Plugin Name: Cinema Schedule
Description: Gestion des horaires de diffusion pour les films de cinéma
Version: 1.0
Author: Yannis Alouache
*/

// Empêche l'accès direct au fichier
if (!defined('ABSPATH')) {
    exit;
}

// Fonction exécutée lors de l'activation du plugin
register_activation_hook(__FILE__, 'cinema_schedule_activate');

function cinema_schedule_activate() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'cinema_schedules';
    
    $charset_collate = $wpdb->get_charset_collate();

    // Création de la table pour stocker les horaires
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        film_id bigint(20) NOT NULL,
        schedule_datetime datetime NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Ajout du menu dans l'interface d'administration
add_action('admin_menu', 'cinema_schedule_menu');

function cinema_schedule_menu() {
    add_menu_page(
        'Horaires Films',
        'Horaires Films',
        'manage_options',
        'cinema-schedules',
        'cinema_schedule_admin_page',
        'dashicons-list-view',
        6
    );
}

// Page d'administration pour gérer les horaires
function cinema_schedule_admin_page() {
    global $wpdb;

    // Vérification des permissions
    if (!current_user_can('manage_options')) {
        return;
    }

    $table_name = $wpdb->prefix . 'cinema_schedules';

    // Traitement de la suppression d'un horaire
    if (isset($_POST['action']) && $_POST['action'] == 'delete_schedule' && check_admin_referer('cinema_schedule_action', 'cinema_schedule_nonce')) {
        $schedule_id = intval($_POST['schedule_id']);
        $wpdb->delete($table_name, array('id' => $schedule_id));
    }

    // Traitement de l'ajout d'un nouvel horaire
    if (isset($_POST['submit_schedule']) && check_admin_referer('cinema_schedule_action', 'cinema_schedule_nonce')) {
        $film_id = intval($_POST['film_id']);
        $schedule_datetime = sanitize_text_field($_POST['schedule_datetime']);
        
        $mysql_datetime = date('Y-m-d H:i:s', strtotime($schedule_datetime));
        
        $wpdb->insert(
            $table_name,
            array(
                'film_id' => $film_id,
                'schedule_datetime' => $mysql_datetime,
            )
        );
    }

    // Affichage du formulaire et de la liste des horaires
    ?>
    <div class="wrap">
        <h1>Gestion des horaires de diffusion</h1>
        <form method="post" action="">
            <?php wp_nonce_field('cinema_schedule_action', 'cinema_schedule_nonce'); ?>
            <select name="film_id">
                <?php
                // Récupération et affichage de tous les films
                $films = get_posts(array('post_type' => 'film', 'numberposts' => -1));
                foreach ($films as $film) {
                    echo '<option value="' . $film->ID . '">' . $film->post_title . '</option>';
                }
                ?>
            </select>
            <input type="datetime-local" name="schedule_datetime" required>
            <input type="submit" name="submit_schedule" class="button button-primary" value="Ajouter un horaire">
        </form>

        <h2>Horaires existants</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Film</th>
                    <th>Date et heure</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Récupération et affichage de tous les horaires
                $schedules = $wpdb->get_results("SELECT * FROM $table_name ORDER BY schedule_datetime");
                foreach ($schedules as $schedule) {
                    $film_title = get_the_title($schedule->film_id);
                    $formatted_date = date('d/m/Y H:i', strtotime($schedule->schedule_datetime));
                    echo "<tr>";
                    echo "<td>$film_title</td>";
                    echo "<td>$formatted_date</td>";
                    echo "<td>
                        <form method='post' style='display:inline;'>
                            <input type='hidden' name='action' value='delete_schedule'>
                            <input type='hidden' name='schedule_id' value='{$schedule->id}'>
                            " . wp_nonce_field('cinema_schedule_action', 'cinema_schedule_nonce', true, false) . "
                            <input type='submit' class='button button-small' value='Supprimer' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet horaire ?\");'>
                        </form>
                    </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php
}

// Définition du shortcode pour afficher les horaires
add_shortcode('cinema_schedules', 'cinema_schedule_shortcode');

function cinema_schedule_shortcode($atts) {
    $atts = shortcode_atts(array(
        'film_id' => 0,
    ), $atts, 'cinema_schedules');

    $film_id = intval($atts['film_id']);    

    global $wpdb;
    $table_name = $wpdb->prefix . 'cinema_schedules';

    // Récupération des horaires pour un film spécifique
    $schedules = $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table_name WHERE film_id = %d ORDER BY schedule_datetime",
        $film_id
    ));

    // Génération du HTML pour afficher les horaires
    $output = '<div class="cinema-schedules">';
    $output .= '<ul>';
    foreach ($schedules as $schedule) {
        $output .= '<li>' . date('d/m/Y H:i', strtotime($schedule->schedule_datetime)) . '</li>';
    }
    $output .= '</ul>';
    $output .= '</div>';

    return $output;
}

// Chargement des styles CSS pour le frontend
function cinema_schedule_enqueue_styles() {
    wp_enqueue_style('cinema-schedule-styles', plugins_url('cinema-schedule.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'cinema_schedule_enqueue_styles');