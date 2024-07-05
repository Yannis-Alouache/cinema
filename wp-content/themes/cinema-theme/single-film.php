<?php get_header(); ?>

<?php
// Récupérer les métadonnées du film
$director = get_post_meta(get_the_ID(), 'film_director', true);
$actors = get_post_meta(get_the_ID(), 'film_actors', true);
$duration = get_post_meta(get_the_ID(), 'film_duration', true);
$country = get_post_meta(get_the_ID(), 'film_country', true);
$imdb_score = get_post_meta(get_the_ID(), 'film_imdb_score', true);
$synopsis = get_post_meta(get_the_ID(), 'film_synopsis', true);
$image_url = get_post_meta(get_the_ID(), 'film_image', true);
$trailer_link = get_post_meta(get_the_ID(), 'film_trailer_link', true);
?>

<div class="container mx-auto">
    <h1 class="font-bold text-2xl mt-10"><?php the_title(); ?></h1>
    <div class="py-8 flex">
        <!-- Image à gauche -->
        <div class="flex-shrink-0 w-1/3 pr-8">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($film_title); ?>" class="w-full h-auto">
        </div>

        <!-- Informations à droite -->
        <div class="w-2/3">
            <h1 class="text-3xl font-bold mb-4"><?php echo esc_html($film_title); ?></h1>

            <div class="mb-4">
                <h2 class="text-xl font-semibold">Director:</h2>
                <p><?php echo esc_html($director); ?></p>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-semibold">Actors:</h2>
                <p><?php echo esc_html($actors); ?></p>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-semibold">Synopsis:</h2>
                <p><?php echo esc_html($synopsis); ?></p>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-semibold">Duration:</h2>
                <p><?php echo esc_html($duration); ?> minutes</p>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-semibold">Country:</h2>
                <p><?php echo esc_html($country); ?></p>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-semibold">IMDb Score:</h2>
                <p><?php echo esc_html($imdb_score); ?></p>
            </div>

            <div class="mb-4">
                <h2 class="text-xl font-semibold">Horaires de diffusion:</h2>
                <?php echo do_shortcode('[cinema_schedules film_id="' . get_the_ID() . '"]'); ?>
            </div>
        </div>
    </div>

    <div class="mt-3 mb-4">
        <h2 class="text-xl font-semibold">Trailer:</h2>
        <?php if (!empty($trailer_link)) : ?>
            <div class="video-container">
                <iframe width="100%" height="600" src="<?php echo str_replace("watch?v=", "embed/", $trailer_link); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        <?php else : ?>
            <p>Trailer pas disponible...</p>
        <?php endif; ?>
    </div>

</div>

<?php get_footer(); ?>