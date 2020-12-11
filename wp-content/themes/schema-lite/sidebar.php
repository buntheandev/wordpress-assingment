<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Schema Lite
 */

$sidebar        = schema_lite_custom_sidebar();
$sidebar_layout = schema_lite_custom_sidebar_layout();

if ( 'nosidebar' !== $sidebar_layout ) {
	?>

	<aside class="sidebar c-4-12">
		<div id="sidebars" class="sidebar">
			<div class="sidebar_list">
				<?php
				// Elementor `main-sidebar` location.
				if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'main-sidebar' ) ) {
					if ( ! dynamic_sidebar( $sidebar ) ) :
					?>
						<div id="sidebar-search" class="widget">
							<h3><?php esc_html_e( 'Search', 'schema-lite' ); ?></h3>
							<div class="widget-wrap">
								<?php get_search_form(); ?>
							</div>
						</div>
						<div id="sidebar-archives" class="widget">
							<h3><?php esc_html_e( 'Archives', 'schema-lite' ); ?></h3>
							<div class="widget-wrap">
								<ul>
									<?php wp_get_archives( 'type=monthly' ); ?>
								</ul>
							</div>
						</div>
						<div id="sidebar-meta" class="widget">
							<h3><?php esc_html_e( 'Meta', 'schema-lite' ); ?></h3>
							<div class="widget-wrap">
								<ul>
									<?php wp_register(); ?>
									<li><?php wp_loginout(); ?></li>
									<?php wp_meta(); ?>
								</ul>
							</div>
						</div>
						<?php
					endif;
				}
				?>
			</div>
		</div><!--sidebars-->
	</aside>
	<?php
}
?>
