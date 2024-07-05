<?php get_header(); ?>

<?php
// Récupérer la catégorie actuelle
$category = get_queried_object();

// Définir les images de fond pour chaque catégorie
$background_images = [
    'action' => 'images/categories/action.jpg',
    'comedie' => 'images/categories/comedie.jpg',
    'drame' => 'images/categories/drame.jpg',
    'horreur' => 'images/categories/horreur.jpg',
    'science-fiction' => 'images/categories/science-fiction.jpg',
    'animation' => 'images/categories/animation.jpg',
    'documentaire' => 'images/categories/documentaire.jpg',
    // Ajoutez d'autres catégories et images correspondantes ici
];

// Obtenir le slug de la catégorie actuelle
$category_slug = $category->slug;

// Définir l'image de fond par défaut
$background_image = isset($background_images[$category_slug]) ? get_template_directory_uri() . '/' . $background_images[$category_slug] : get_template_directory_uri() . '/images/categories/default.jpg';
?>

<style>
    html {
        background-image: url('<?php echo esc_url($background_image); ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>

<main class="container mx-auto max-w-6xl p-4 bg-white h-screen">
    <h1 class="text-3xl font-bold mb-4"><?php single_cat_title(); ?></h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        <?php
        $args = array(
            'post_type' => 'film',
            'cat' => $category->cat_ID, // Utilisez l'ID de la catégorie actuelle
            'posts_per_page' => -1, // Retrieve all films
        );
        $films_query = new WP_Query($args);
        if ($films_query->have_posts()) :
            while ($films_query->have_posts()) : $films_query->the_post();
                // Get the URL of the image associated with the film
                $film_image = get_post_meta(get_the_ID(), 'film_image', true);
        ?>
                <div class="flex flex-col">
                    <a href="<?php the_permalink(); ?>" class="block mb-2">
                        <?php if (!empty($film_image)) : ?>
                            <img src="<?php echo esc_url($film_image); ?>" alt="<?php the_title(); ?>" class="w-full sm:h-96 object-cover">
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri() . '/placeholder.jpg'; ?>" alt="Placeholder" class="w-full h-64 object-cover">
                        <?php endif; ?>
                    </a>
                    <h3 class="text-lg font-bold uppercase"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                </div>
        <?php
            endwhile;
            wp_reset_postdata(); // Reset post data
        else :
            echo '<p>Aucun films trouvé.</p>';
        endif;
        ?>
    </div>
</main>

<?php get_footer(); ?>