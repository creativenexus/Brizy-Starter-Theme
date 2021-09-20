<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		if ( have_posts() ) {

			// Load posts loop.
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/excerpt' );
			}

            // Previous/next page navigation.
            the_posts_pagination(
                array(
                    'mid_size'  => 2,
                    'prev_text' => sprintf(
                        '<span class="nav-prev-text">%s</span>',
                        __( 'Newer posts', 'creativenexus-visual' )
                    ),
                    'next_text' => sprintf(
                        '<span class="nav-next-text">%s</span>',
                        __( 'Older posts', 'creativenexus-visual' )
                    ),
                )
            );

		} else {

			// If no content, include the "No posts found" template.
			get_template_part( 'template-parts/none' );

		}
		?>

		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php
get_footer();
