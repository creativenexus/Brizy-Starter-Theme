<?php
/**
 * The template for displaying archive pages
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			</header>

			<?php
			// Start the Loop.
			while ( have_posts() ) :
				the_post();

				/**
				 * If you want to override this in a child theme, then include a file
				 * called excerpt.php and that will be used instead.
				 */
				get_template_part( 'template-parts/excerpt' );

				// End the loop.
			endwhile;

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

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/none' );

		endif;
		?>
		</main><!-- #main -->
	</section><!-- #primary -->

<?php
get_footer();
