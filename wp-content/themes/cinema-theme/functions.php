<?php
function create_post_type_film() {
    register_post_type('film',
        array(
            'labels' => array(
                'name' => __('Films'),
                'singular_name' => __('Film'),
                'add_new_item' => __('Ajouter nouveau film'),
            ),
            'public' => true,
            'has_archive' => false,
            'rewrite' => array('slug' => 'films'),
            'supports' => array('title', 'thumbnail'),
            'taxonomies' => array('category'),
        )
    );
}
add_action('init', 'create_post_type_film');


function add_film_meta_boxes() {
    add_meta_box('film_details', 'Détail Film', 'film_details_callback', 'film', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_film_meta_boxes');

function film_details_callback($post) {
    wp_nonce_field('save_film_details', 'film_details_nonce');
    $director = get_post_meta($post->ID, 'film_director', true);
    $actors = get_post_meta($post->ID, 'film_actors', true);
    $duration = get_post_meta($post->ID, 'film_duration', true);
    $country = get_post_meta($post->ID, 'film_country', true);
    $imdb_score = get_post_meta($post->ID, 'film_imdb_score', true);
    $synopsis = get_post_meta($post->ID, 'film_synopsis', true);
    $image = get_post_meta($post->ID, 'film_image', true);
    $trailer_link = get_post_meta($post->ID, 'film_trailer_link', true);

    ?>

    <p>
        <label for="film_director">Réalisateurs (séparé par des virgules):</label>
        <input type="text" id="film_director" name="film_director" value="<?php echo esc_attr($director); ?>" class="widefat" />
    </p>
    <p>
        <label for="film_actors">Acteurs (séparé par des virgules):</label>
        <input type="text" id="film_actors" name="film_actors" value="<?php echo esc_attr($actors); ?>" class="widefat" />
    </p>
    <p>
        <label for="film_duration">Durée (en minutes):</label>
        <input type="text" id="film_duration" name="film_duration" value="<?php echo esc_attr($duration); ?>" class="widefat" />
    </p>
    <p>
        <label for="film_country">Pays:</label>
        <input type="text" id="film_country" name="film_country" value="<?php echo esc_attr($country); ?>" class="widefat" />
    </p>
    <p>
        <label for="film_imdb_score">Score IMDb:</label>
        <input type="text" id="film_imdb_score" name="film_imdb_score" value="<?php echo esc_attr($imdb_score); ?>" class="widefat" />
    </p>
    <p>
        <label for="film_synopsis">Synopsis:</label>
        <textarea id="film_synopsis" name="film_synopsis" class="widefat"><?php echo esc_textarea($synopsis); ?></textarea>
    </p>
    <p>
        <label for="film_image">Image mise en avant:</label>
        <input type="text" id="film_image" name="film_image" value="<?php echo esc_attr($image); ?>" class="widefat" readonly />
        <input type="button" value="Choisir une image" class="button-secondary" id="upload_image_button" />
    </p>
    <p>
    <label for="film_trailer_link">Lien du trailer:</label>
        <input type="text" id="film_trailer_link" name="film_trailer_link" value="<?php echo esc_attr($trailer_link); ?>" class="widefat" />
    </p>

    
    <?php
}


function save_film_details($post_id) {
    // Vérifier le nonce pour la sécurité
    if (!isset($_POST['film_details_nonce']) || !wp_verify_nonce($_POST['film_details_nonce'], 'save_film_details')) {
        return;
    }

    // Vérifier les sauvegardes automatiques
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Vérifier les permissions de l'utilisateur
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Enregistrer les champs supplémentaires
    $fields = array('film_director', 'film_actors', 'film_duration', 'film_country', 'film_imdb_score', 'film_synopsis', 'film_image', 'film_trailer_link');
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        }
    }
}
add_action('save_post', 'save_film_details');



// Enqueue Tailwind CSS et le style principal
function my_theme_enqueue_styles() {
    wp_enqueue_style('tailwindcss', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css', [], null);
    wp_enqueue_style('main-styles', get_template_directory_uri() . '/style.css', [], null);
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_styles');


function custom_admin_scripts() {
    if (isset($_GET['post_type']) && $_GET['post_type'] == 'film') {
        wp_enqueue_media();
        wp_enqueue_script('custom-admin-script', get_template_directory_uri() . '/js/custom-admin-script.js', array('jquery'), null, true);
    }
}
add_action('admin_enqueue_scripts', 'custom_admin_scripts');
?>

