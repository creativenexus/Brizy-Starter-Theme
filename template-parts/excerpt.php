<?php
/**
 * Template part for displaying post archives and search results
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="page-header">
		<?php
		if ( is_sticky() && is_home() && ! is_paged() ) {
			printf( '<span class="sticky-post">%s</span>', _x( 'Featured', 'post', 'creativenexus-visual' ) );
		}
		the_title( sprintf( '<h2 class="page-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
		?>
	</header><!-- .entry-header -->

	<?php brizy_starter_theme_post_thumbnail(); ?>

	<div class="page-content">
		<?php the_excerpt(); ?>
	</div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php brizy_starter_theme_entry_footer(); ?>
    </footer><!-- .entry-footer -->

</article><!-- #post-${ID} -->
