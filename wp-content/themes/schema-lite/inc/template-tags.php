<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Schema Lite
 */

if ( ! function_exists( 'schema_lite_post_navigation' ) ) :
	/**
	 * Display navigation to next/previous post when applicable.
	 *
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function schema_lite_post_navigation() { ?>
		<nav class="navigation posts-navigation" role="navigation">
			<!--Start Pagination-->
			<?php
			$schema_lite_nav_type = get_theme_mod( 'schema_lite_pagination_type', '1' );
			if ( ! empty( $schema_lite_nav_type ) ) {
				$schema_lite_pagination = get_the_posts_pagination( array(
					'mid_size'  => 2,
					'prev_text' => '<i class="schema-lite-icon icon-angle-left"></i>',
					'next_text' => '<i class="schema-lite-icon icon-angle-right"></i>',
				) );
				echo $schema_lite_pagination;
			} else {
				?>
				<h2 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'schema-lite' ); ?></h2>
				<div class="pagination nav-links">
					<?php if ( get_next_posts_link() ) : ?>
						<div class="nav-previous"><?php next_posts_link( '<i class="schema-lite-icon icon-angle-left"></i>' . __( ' Older posts', 'schema-lite' ) ); ?></div>
					<?php endif; ?>

					<?php if ( get_previous_posts_link() ) : ?>
						<div class="nav-next"><?php previous_posts_link( __( 'Newer posts ', 'schema-lite' ) . ' <i class="schema-lite-icon icon-angle-right"></i>' ); ?></div>
					<?php endif; ?>
				</div>
			<?php } ?>
		</nav><!--End Pagination-->
		<?php
	}
endif;
