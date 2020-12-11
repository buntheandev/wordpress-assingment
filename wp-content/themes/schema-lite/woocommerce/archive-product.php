<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 */

get_header( 'shop' );
?>
<div id="page clear">
	<article id="content" class="article">
		<div id="content_box" >
			<?php
			do_action( 'woocommerce_before_main_content' );

			if ( apply_filters( 'woocommerce_show_page_title', true ) ) :
				?>
				<h1 class="page-title"><?php woocommerce_page_title(); ?></h1>
				<?php
			endif;

			do_action( 'woocommerce_archive_description' );

			if ( have_posts() ) :
				do_action( 'woocommerce_before_shop_loop' );
				woocommerce_product_loop_start();
				woocommerce_product_subcategories();

				while ( have_posts() ) :
					the_post();
					wc_get_template_part( 'content', 'product' );
				endwhile; // end of the loop.

				woocommerce_product_loop_end();

				do_action( 'woocommerce_after_shop_loop' );
			elseif ( ! woocommerce_product_subcategories(
				array(
					'before' => woocommerce_product_loop_start( false ),
					'after'  => woocommerce_product_loop_end( false ),
				)
			) ) :
				wc_get_template( 'loop/no-products-found.php' );
			endif;

			do_action( 'woocommerce_after_main_content' );
			?>
		</div>
	</article>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
