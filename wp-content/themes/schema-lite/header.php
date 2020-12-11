<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Schema Lite
 */

$custom_sidebar = schema_lite_custom_sidebar_layout();
$container      = schema_lite_conatiner();

$show_header = '';
if ( is_singular() ) {
	$show_header = get_post_meta( get_the_ID(), '_disable_header', true );
}

$class = $container . ' ' . $custom_sidebar;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head itemscope itemtype="http://schema.org/WebSite">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class( $class ); ?> itemscope itemtype="http://schema.org/WebPage">
	<div class="main-container">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'schema-lite' ); ?></a>
		<?php
		if ( empty( $show_header ) ) {
			?>
			<div class="top-navigation">
				<div class="container clear">
					<nav id="navigation" class="top-navigation" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
						<?php
						if ( has_nav_menu( 'top' ) ) {
							wp_nav_menu(
								array(
									'theme_location' => 'top',
									'menu_class'     => 'menu clearfix',
									'container'      => '',
								)
							);
						}
						?>
					</nav><!-- #site-navigation -->
				</div>
			</div>
			<header id="site-header" role="banner" itemscope itemtype="http://schema.org/WPHeader">
				<?php
				// Elementor `header` location.
				if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
					?>
					<div class="container clear">
						<div class="site-branding">
							<?php if ( has_custom_logo() ) { ?>
								<?php if ( is_front_page() || is_home() || is_404() ) { ?>
									<h1 id="logo" class="image-logo" itemprop="headline">
										<?php the_custom_logo(); ?>
									</h1><!-- END #logo -->
								<?php } else { ?>
									<h2 id="logo" class="image-logo" itemprop="headline">
										<?php the_custom_logo(); ?>
									</h2><!-- END #logo -->
								<?php } ?>
							<?php } else { ?>
								<?php if ( is_front_page() || is_home() || is_404() ) { ?>
									<h1 id="logo" class="site-title" itemprop="headline">
										<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
									</h1><!-- END #logo -->
								<?php } else { ?>
									<h2 id="logo" class="site-title" itemprop="headline">
										<a href="<?php echo esc_url( home_url() ); ?>"><?php bloginfo( 'name' ); ?></a>
									</h2><!-- END #logo -->
								<?php } ?>
							<?php } ?>
						</div><!-- .site-branding -->

						<div class="primary-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
							<a href="#" id="pull" class="toggle-mobile-menu"><?php esc_html_e( 'Menu', 'schema-lite' ); ?></a>
							<nav id="navigation" class="primary-navigation mobile-menu-wrapper" role="navigation">
								<?php
								if ( has_nav_menu( 'primary' ) ) {
									wp_nav_menu(
										array(
											'theme_location' => 'primary',
											'menu_class' => 'menu clearfix',
											'container'  => '',
										)
									);
								} else {
									?>
									<ul class="menu clearfix">
										<?php wp_list_categories( 'title_li=' ); ?>
									</ul>
								<?php } ?>
							</nav><!-- #site-navigation -->
						</div>
					</div>
					<?php
				}
				?>
			</header><!-- #masthead -->
			<?php
		}
		?>
