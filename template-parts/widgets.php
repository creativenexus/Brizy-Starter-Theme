<?php
/**
 * Displays the footer widget area
 */

if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

	<aside class="widget-area" role="complementary" aria-label="<?php esc_attr_e( 'Footer', 'creativenexus-visual' ); ?>">
		<?php
			if ( is_active_sidebar( 'sidebar-1' ) ) {
				?>
					<div class="widget-column footer-widget-1">
						<?php dynamic_sidebar( 'sidebar-1' ); ?>
					</div>
				<?php
			}
		?>
	</aside><!-- .widget-area -->

<?php endif; ?>
