<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Schema Lite
 */
$schema_lite_single_breadcrumb_section = get_theme_mod( 'schema_lite_single_breadcrumb_section', '1' );
$schema_lite_single_tags_section       = get_theme_mod( 'schema_lite_single_tags_section', '1' );
$schema_lite_authorbox_section         = get_theme_mod( 'schema_lite_authorbox_section', '1' );
$schema_lite_relatedposts_section      = get_theme_mod( 'schema_lite_relatedposts_section', '1' );
$disable_title                         = get_post_meta( get_the_ID(), '_disable_title', true );
$disable_post_meta                     = get_post_meta( get_the_ID(), '_disable_post_meta', true );
$disable_author_box                    = get_post_meta( get_the_ID(), '_disable_author_box', true );
$disable_related_posts                 = get_post_meta( get_the_ID(), '_disable_related_posts', true );

get_header(); ?>

<div id="page" class="single clear">
	<div class="content">
		<article class="article">
			<?php
			// Elementor `single` location.
			if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
						<div id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
							<div class="single_post">

								<?php if ( '1' === $schema_lite_single_breadcrumb_section && empty( $disable_title ) ) { ?>
									<?php schema_lite_the_breadcrumb(); ?>
								<?php } ?>

								<?php if ( empty( $disable_title ) || empty( $disable_post_meta ) ) { ?>
									<header>
										<?php if ( empty( $disable_title ) ) { ?>
											<h1 class="title single-title"><?php the_title(); ?></h1>
										<?php } ?>
										<?php if ( empty( $disable_post_meta ) ) { ?>
											<div class="post-info">
												<span class="theauthor"><i class="schema-lite-icon icon-user"></i> <?php esc_html_e( 'By', 'schema-lite' ); ?> <?php the_author_posts_link(); ?></span>
												<span class="posted-on entry-date date updated"><i class="schema-lite-icon icon-calendar"></i> <?php the_time( get_option( 'date_format' ) ); ?></span>
												<span class="featured-cat"><i class="schema-lite-icon icon-tags"></i> <?php the_category( ', ' ); ?></span>
												<span class="thecomment"><i class="schema-lite-icon icon-comment"></i> <a href="<?php comments_link(); ?>"><?php comments_number( __( '0 Comments', 'schema-lite' ), __( '1 Comment', 'schema-lite' ), __( '% Comments', 'schema-lite' ) ); ?></a></span>
											</div>
										<?php } ?>
									</header>
								<?php } ?>

								<!-- Start Content -->
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

									if ( '1' === $schema_lite_single_tags_section ) {
										?>
										<!-- Start Tags -->
										<div class="tags"><?php the_tags( '<span class="tagtext">' . __( 'Tags', 'schema-lite' ) . ':</span>', ', ' ); ?></div>
										<!-- End Tags -->
										<?php
									}
									?>
								</div><!-- End Content -->

								<?php
								// Related Posts.
								if ( '1' === $schema_lite_relatedposts_section && empty( $disable_related_posts ) ) {
									$categories = get_the_category( $post->ID );
									if ( $categories ) {
										$category_ids = array();

										foreach ( $categories as $individual_category ) {
											$category_ids[] = $individual_category->term_id;
										}

										$args = array(
											'category__in' => $category_ids,
											'post__not_in' => array( $post->ID ),
											'ignore_sticky_posts' => 1,
											'showposts'    => 3,
											'orderby'      => 'rand',
										);

										$my_query = new wp_query( $args );

										if ( $my_query->have_posts() ) {
											echo '<div class="related-posts"><div class="postauthor-top"><h3>' . __('Related Posts', 'schema-lite') . '</h3></div>';

											$j = 0;

											while ( $my_query->have_posts() ) {

												$my_query->the_post();
												?>
												<article class="post excerpt  <?php echo ( ++$j % 3 == 0 ) ? 'last' : ''; ?>">
													<?php if ( has_post_thumbnail() ) { ?>
														<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" id="featured-thumbnail">
															<div class="featured-thumbnail">
																<?php the_post_thumbnail( 'schema-lite-related', array( 'title' => '' ) ); ?>
																<?php if ( function_exists( 'wp_review_show_total' ) ) wp_review_show_total( true, 'latestPost-review-wrapper' ); ?>
															</div>
															<header>
																<h4 class="title front-view-title"><?php the_title(); ?></h4>
															</header>
														</a>
													<?php } else { ?>
														<a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>" id="featured-thumbnail">
															<div class="featured-thumbnail">
																<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/nothumb-related.png" class="attachment-featured wp-post-image" alt="<?php the_title_attribute(); ?>">
																<?php if ( function_exists( 'wp_review_show_total' ) ) wp_review_show_total( true, 'latestPost-review-wrapper' ); ?>
															</div>
															<header>
																<h4 class="title front-view-title"><?php the_title(); ?></h4>
															</header>
														</a>
													<?php } ?>
												</article><!--.post.excerpt-->
												<?php
											} echo '</div>';
										}
									}
									wp_reset_postdata();
								}

								if ( '1' === $schema_lite_authorbox_section && empty( $disable_author_box ) ) {
									?>
									<!-- Start Author Box -->
									<div class="postauthor">
										<h4><?php esc_html_e( 'About Author', 'schema-lite' ); ?></h4>
										<?php
										if ( function_exists( 'get_avatar' ) ) {
											echo get_avatar( get_the_author_meta( 'email' ), '100' );
										}
										?>
										<h5><?php the_author_meta( 'nickname' ); ?></h5>
										<p><?php the_author_meta( 'description' ); ?></p>
									</div>
									<!-- End Author Box -->
									<?php
								}

								comments_template( '', true );
								?>

							</div>
						</div>
						<?php
					endwhile;
				endif;
			}
			?>
		</article>

		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>
