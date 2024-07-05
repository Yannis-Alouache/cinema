<?php get_header(); ?>

<?php
// Récupérer l'ID de la catégorie principale de l'article
$category = get_the_category();
$category_slug = !empty($category) ? $category[0]->slug : 'default';

// Définir les images de fond pour chaque catégorie
$background_images = [
    'action' => 'images/categories/action.jpg',
    'comedy' => 'images/categories/comedy.jpg',
    'drama' => 'images/categories/drama.jpg',
    'horror' => 'images/categories/horror.jpg',
    'sci-fi' => 'images/categories/sci-fi.jpg',
    // Ajoutez d'autres catégories et images correspondantes ici
];

// Définir l'image de fond par défaut
$background_image = isset($background_images[$category_slug]) ? get_template_directory_uri() . '/' . $background_images[$category_slug] : get_template_directory_uri() . '/images/categories/default.jpg';
?>

<style>
    body {
        background-image: url('<?php echo esc_url($background_image); ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>

<main class="container mx-auto p-4 bg-white bg-opacity-90 rounded-lg shadow-lg mt-8 h-screen">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <article class="mb-4">
            <h1 class="text-3xl font-bold mb-2"><?php the_title(); ?></h1>
            <p class="text-gray-600 mb-4"><?php the_date(); ?> by <span class="text-blue-500"><?php the_author(); ?></span></p>
            <div class="content mb-8">
                <?php the_content(); ?>
            </div>
            <div class="categories">
                <h2 class="text-xl font-semibold mb-2">Categories</h2>
                <ul class="list-disc list-inside">
                    <?php
                    $categories = get_the_category();
                    foreach ($categories as $category) {
                        echo '<li class="mb-2"><a href="' . get_category_link($category->term_id) . '" class="text-blue-500 hover:text-blue-700">' . $category->name . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </article>
    <?php endwhile; else : ?>
        <p><?php esc_html_e('Sorry, no posts matched your criteria.'); ?></p>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
