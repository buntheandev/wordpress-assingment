<?php
/**
 * The main template file.
 *
 * Used to display the homepage when home.php doesn't exist.
 */

get_header(); ?>

<div id="page" class="home-page clear">
	<div id="content" class="article">
		<?php
		// Elementor `archive` location.
		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					schema_lite_archive_post();
				endwhile;
				schema_lite_post_navigation();
			endif;
		}
		?>
	</div><!-- .article -->
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
