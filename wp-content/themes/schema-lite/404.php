<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Schema Lite
 */

get_header(); ?>

<div id="page" class="single clear">
	<article id="content" class="article page single_post">
		<header>
			<h1 class="title"><?php esc_html_e( 'Error 404 Not Found', 'schema-lite' ); ?></h1>
		</header>
		<div class="post-content">
			<p><?php esc_html_e( 'Oops! We couldn\'t find this Page.', 'schema-lite' ); ?></p>
			<p><?php esc_html_e( 'Please check your URL or use the search form below.', 'schema-lite' ); ?></p>
			<?php get_search_form(); ?>
		</div><!--.post-content-->
	</article>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
