<?php get_header(); ?>
<main class="container mx-auto p-4">

    <!-- Display all categories -->
    <section class="categories mb-8">
        <h2 class="text-3xl font-bold mb-4">Catégories</h2>
        <ul class="list-disc list-inside">
            <?php
            $categories = get_categories();
            foreach ($categories as $category) {
                echo '<li class="mb-2"><a href="' . get_category_link($category->term_id) . '" class="text-blue-500">' . $category->name . '</a> (' . $category->count . ')</li>';
            }
            ?>
        </ul>
    </section>

    <section>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 gap-y-8">
            <?php
            $args = array(
                'post_type' => 'film',
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
                                <img src="<?php echo esc_url($film_image); ?>" alt="<?php the_title(); ?>" class="w-full lg:h-96 sm:h-80  object-cover">
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
    </section>

</main>
<?php get_footer(); ?>