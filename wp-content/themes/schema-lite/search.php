<?php
/**
 * The template for displaying search results pages.
 *
 * @package Schema Lite
 */

get_header(); ?>

<div id="page" class="search-area clear">
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
			else :
				?>
				<div class="single_post clear">
					<header>
						<h1 class="title"><?php esc_html_e( 'Nothing Found', 'schema-lite' ); ?></h1>
					</header>
					<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'schema-lite' ); ?></p>
					<?php get_search_form(); ?>
				</div>
				<?php
			endif;
		}
		?>
	</div><!-- .article -->
	<?php get_sidebar(); ?>
</div><!-- #primary -->
<?php get_footer(); ?>
