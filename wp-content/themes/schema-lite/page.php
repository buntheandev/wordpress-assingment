<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Schema Lite
 */

get_header(); ?>

<div id="page" class="single clear">
	<div class="content">
		<article class="article">
			<div id="content_box" >
				<?php
				if ( have_posts() ) while ( have_posts() ) :
					the_post();
					?>
					<div id="post-<?php the_ID(); ?>" <?php post_class( 'g post' ); ?>>
						<div class="single_page single_post clear">
							<header>
								<h1 class="title"><?php the_title(); ?></h1>
							</header>
							<div id="content" class="post-single-content box mark-links">
								<?php
								the_content();
								wp_link_pages(
									array(
										'before'           => '<div class="pagination">',
										'after'            => '</div>',
										'link_before'      => '<span class="current"><span class="currenttext">',
										'link_after'       => '</span></span>',
										'next_or_number'   => 'next_and_number',
										'nextpagelink'     => __('Next', 'schema-lite'),
										'previouspagelink' => __('Previous', 'schema-lite'),
										'pagelink'         => '%',
										'echo'             => 1,
									)
								);
								?>
							</div><!--.post-content box mark-links-->
							<?php comments_template( '', true ); ?>
						</div>
					</div>
					<?php
				endwhile;
				?>
			</div>
		</article>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>
