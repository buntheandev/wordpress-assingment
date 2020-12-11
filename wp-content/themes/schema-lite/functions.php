<?php
/**
 * Schema Lite functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Schema Lite
 */

if ( ! function_exists( 'schema_lite_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function schema_lite_setup() {
		define( 'SCHEMA_LITE_THEME_VERSION', '1.2.2' );

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Schema Lite, use a find and replace
		 * to change 'schema-lite' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'schema-lite', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		// Gutenberg Support.
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 150, 150, true );
		add_image_size( 'schema-lite-featured', 680, 350, true ); // Featured.
		add_image_size( 'schema-lite-related', 210, 150, true ); // Related.

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'top'     => esc_html__( 'Top', 'schema-lite' ),
			'primary' => esc_html__( 'Primary', 'schema-lite' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		if ( schema_lite_is_wc_active() ) {
			add_theme_support( 'woocommerce' );
		}

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'schema_lite_custom_background_args', array(
			'default-color' => '#eeeeee',
			'default-image' => '',
		) ) );
	}
endif;
add_action( 'after_setup_theme', 'schema_lite_setup' );

/**
 * Store install date.
 *
 * @return void
 */
function schema_activation_hook() {
	if ( get_option( 'schema_lite_install_date' ) ) {
		return;
	}
	update_option( 'schema_lite_install_date', time() );
}
add_action( 'after_switch_theme', 'schema_activation_hook' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function schema_lite_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'schema_lite_content_width', 678 );
}
add_action( 'after_setup_theme', 'schema_lite_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function schema_lite_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'schema-lite' ),
		'id'            => 'sidebar',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// First Footer.
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'schema-lite' ),
		'description'   => __( 'First footer column', 'schema-lite' ),
		'id'            => 'footer-first',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Second Footer.
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'schema-lite' ),
		'description'   => __( 'Second footer column', 'schema-lite' ),
		'id'            => 'footer-second',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	// Third Footer.
	register_sidebar( array(
		'name'          => __( 'Footer 3', 'schema-lite' ),
		'description'   => __( 'Third footer column', 'schema-lite' ),
		'id'            => 'footer-third',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	if ( schema_lite_is_wc_active() ) {
		// Register WooCommerce Shop and Single Product Sidebar.
		register_sidebar( array(
			'name'          => __( 'Shop Page Sidebar', 'schema-lite' ),
			'description'   => __( 'Appears on Shop main page and product archive pages.', 'schema-lite' ),
			'id'            => 'shop-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
		register_sidebar( array(
			'name'          => __( 'Single Product Sidebar', 'schema-lite' ),
			'description'   => __( 'Appears on single product pages.', 'schema-lite' ),
			'id'            => 'product-sidebar',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );
	}
}
add_action( 'widgets_init', 'schema_lite_widgets_init' );

/**
 * Retrieve the ID of the sidebar.
 *
 * @return string
 */
function schema_lite_custom_sidebar() {
	// Default sidebar.
	$sidebar = 'sidebar';

	// Woocommerce.
	if ( schema_lite_is_wc_active() ) {
		if ( is_shop() || is_product_category() ) {
			$sidebar = 'shop-sidebar';
		}
		if ( is_product() ) {
			$sidebar = 'product-sidebar';
		}
	}

	return $sidebar;
}

/**
 * Retrieve the sidebar layout
 *
 * @return string
 */
function schema_lite_custom_sidebar_layout() {
	$sidebar_layout = get_theme_mod( 'schema_lite_layout', 'cslayout' );

	if ( is_singular() ) :
		$sidebar_layout = get_post_meta( get_the_ID(), '_custom_sidebar', true );

		if ( 'default' === $sidebar_layout ) :
			$sidebar_layout = get_theme_mod( 'schema_lite_layout', 'cslayout' );
		endif;
	endif;

	return $sidebar_layout;
}

/**
 * Retrieve the container layout.
 *
 * @return string
 */
function schema_lite_conatiner() {
	$container = get_theme_mod( 'schema_lite_container', 'boxed' );

	if ( is_singular() ) :
		$container = get_post_meta( get_the_ID(), '_content_layout', true );

		if ( 'default' === $container ) :
			$container = get_theme_mod( 'schema_lite_container', 'boxed' );
		endif;
	endif;

	return $container;
}

/**
 * Enqueue scripts and styles.
 */
function schema_lite_scripts() {
	wp_enqueue_style( 'schema-lite-style', get_stylesheet_uri() );
	wp_enqueue_script( 'jquery' );

	$handle = 'schema-lite-style';

	// WooCommerce.
	if ( schema_lite_is_wc_active() ) {
		if ( is_woocommerce() || is_cart() || is_checkout() ) {
			wp_enqueue_style( 'schema-lite-woocommerce', get_template_directory_uri() . '/css/woocommerce2.css' );
			$handle = 'schema-lite-woocommerce';
		}
	}

	wp_enqueue_script( 'schema-lite-customscripts', get_template_directory_uri() . '/js/customscripts.js', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	$schema_lite_color_scheme  = esc_attr( get_theme_mod( 'schema_lite_color_scheme', '#0274be' ) );
	$schema_lite_color_scheme2 = esc_attr( get_theme_mod( 'schema_lite_color_scheme2', '#222222' ) );
	$header_image              = esc_attr( get_header_image() );

	$custom_css = "
		#site-header, #navigation.mobile-menu-wrapper { background-image: url('$header_image'); }
		.primary-navigation #navigation li:hover > a, #tabber .inside li .meta b,footer .widget li a:hover,.fn a,.reply a,#tabber .inside li div.info .entry-title a:hover, #navigation ul ul a:hover,.single_post a:not(.wp-block-button__link), a:hover, .sidebar.c-4-12 .textwidget a, #site-footer .textwidget a, #commentform a, #tabber .inside li a, .copyrights a:hover, a, .sidebar.c-4-12 a:hover, .top a:hover, footer .tagcloud a:hover, .title a, .related-posts .post:hover .title { color: $schema_lite_color_scheme; }

		#navigation ul li.current-menu-item a { color: $schema_lite_color_scheme!important; }

		.nav-previous a:hover, .nav-next a:hover, #commentform input#submit, #searchform input[type='submit'], .home_menu_item, .currenttext, .pagination a:hover, .mts-subscribe input[type='submit'], .pagination .current, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-product-search input[type='submit'], .woocommerce a.button, .woocommerce-page a.button, .woocommerce button.button, .woocommerce-page button.button, .woocommerce input.button, .woocommerce-page input.button, .woocommerce #respond input#submit, .woocommerce-page #respond input#submit, .woocommerce #content input.button, .woocommerce-page #content input.button, .featured-thumbnail .latestPost-review-wrapper.wp-review-show-total, .tagcloud a, .woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-page nav.woocommerce-pagination ul li span.current, .woocommerce #content nav.woocommerce-pagination ul li span.current, .woocommerce-page #content nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, #searchform input[type='submit'], .woocommerce-product-search input[type='submit'] { background-color: $schema_lite_color_scheme; }

		.woocommerce nav.woocommerce-pagination ul li span.current, .woocommerce-page nav.woocommerce-pagination ul li span.current, .woocommerce #content nav.woocommerce-pagination ul li span.current, .woocommerce-page #content nav.woocommerce-pagination ul li span.current, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce-page nav.woocommerce-pagination ul li a:hover, .woocommerce #content nav.woocommerce-pagination ul li a:hover, .woocommerce-page #content nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce-page nav.woocommerce-pagination ul li a:focus, .woocommerce #content nav.woocommerce-pagination ul li a:focus, .woocommerce-page #content nav.woocommerce-pagination ul li a:focus, .pagination .current, .tagcloud a { border-color: $schema_lite_color_scheme; }
		.corner { border-color: transparent transparent $schema_lite_color_scheme transparent;}

		footer, #commentform input#submit:hover, .featured-thumbnail .latestPost-review-wrapper { background-color: $schema_lite_color_scheme2; }
			";

	wp_add_inline_style( $handle, $custom_css );
}
add_action( 'wp_enqueue_scripts', 'schema_lite_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Add the Social buttons Widget.
 */
require_once 'functions/widget-social.php';

/**
 * Add Meta boxes.
 */
require_once 'inc/class-schema-metaboxes.php';

/**
 * Load Recommended Plugins.
 */
require get_template_directory() . '/inc/plugin-activation.php';

if ( ! function_exists( 'schema_lite_copyrights_credit' ) ) {
	/**
	 * Copyrights
	 */
	function schema_lite_copyrights_credit() {
		?>
		<!--start copyrights-->
		<div class="copyrights">
			<div class="container">
				<div class="row" id="copyright-note">
					<span><a href="<?php echo esc_url( home_url() ); ?>/" title="<?php bloginfo( 'description' ); ?>"><?php bloginfo( 'name' ); ?></a> <?php esc_html_e( 'Copyright', 'schema-lite' ); ?> &copy; <?php echo esc_attr( date_i18n( __( 'Y', 'schema-lite' ) ) ); ?>.</span>
					<div class="top">
						<?php
						$allowed_tags = array(
							'a'      => array(
								'class' => array(),
								'href'  => array(),
								'rel'   => array(),
								'title' => array(),
							),
							'b'      => array(),
							'strong' => array(),
							'i'      => array(),
							'em'     => array(),
						);

						$schema_lite_copyright_text = get_theme_mod( 'schema_lite_copyright_text', __( 'Theme by', 'schema-lite' ) . ' <a href="http://mythemeshop.com/" rel="nofollow">MyThemeShop</a>.' );
						echo wp_kses_post( $schema_lite_copyright_text, $allowed_tags );
						?>
						<a href="#top" class="toplink"><?php esc_html_e( 'Back to Top', 'schema-lite' ); ?> &uarr;</a>
					</div>
				</div>
			</div>
		</div>
		<!--end copyrights-->
		<?php
	}
}

if ( ! function_exists( 'schema_lite_comments' ) ) {
	/**
	 * Custom Comments template
	 */
	function schema_lite_comment( $comment, $args, $depth ) {
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div id="comment-<?php comment_ID(); ?>" style="position:relative;" itemscope itemtype="http://schema.org/UserComments">
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment->comment_author_email, 80 ); ?>
					<div class="comment-metadata">
						<?php printf( '<span class="fn" itemprop="creator" itemscope itemtype="http://schema.org/Person">%s</span>', get_comment_author_link() ); ?>
						<time><?php comment_date( get_option( 'date_format' ) ); ?></time>
						<span class="comment-meta">
							<?php edit_comment_link( __( '(Edit)', 'schema-lite' ), '  ', '' ); ?>
						</span>
					</div>
				</div>
				<?php if ( '0' === $comment->comment_approved ) : ?>
					<em><?php esc_html_e( 'Your comment is awaiting moderation.', 'schema-lite' ); ?></em>
					<br />
				<?php endif; ?>
				<div class="commentmetadata" itemprop="commentText">
					<?php comment_text(); ?>
					<span class="reply">
						<?php
						comment_reply_link( array_merge( $args, array(
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
						)) );
						?>
					</span>
				</div>
			</div>
			<?php
	}
}

/**
 * Excerpt
 */
function schema_lite_excerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );
	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( ' ', $excerpt );
	} else {
		$excerpt = implode( ' ', $excerpt );
	}
	$excerpt = preg_replace( '`[[^]]*]`', '', $excerpt );
	return $excerpt . '...';
}

/**
 * Shorthand function to check for more tag in post.
 *
 * @return bool|int
 */
function schema_lite_post_has_moretag() {
	return strpos( get_the_content(), '<!--more-->' );
}

if ( ! function_exists( 'schema_lite_readmore' ) ) {
	/**
	 * Display a "read more" link.
	 */
	function schema_lite_readmore() {
		?>
		<div class="readMore">
			<a href="<?php echo esc_url( get_the_permalink() ); ?>" title="<?php the_title_attribute(); ?>">
				<?php esc_html_e( '[Continue reading...]', 'schema-lite' ); ?>
			</a>
		</div>
		<?php
	}
}

// Last item in the breadcrumbs
if ( ! function_exists( 'get_itemprop_3' ) ) {
	function get_itemprop_3( $title = '', $position = '2' ) {
		echo '<div itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
		echo '<span itemprop="name">' . $title . '</span>';
		echo '<meta itemprop="position" content="' . $position . '" />';
		echo '</div>';
	}
}
if ( ! function_exists( 'schema_lite_the_breadcrumb' ) ) {
	/**
	 * Display the breadcrumbs.
	 */
	function schema_lite_the_breadcrumb() {
		if ( is_front_page() ) {
			return;
		}
		if ( function_exists( 'rank_math_the_breadcrumbs' ) && RankMath\Helper::get_settings( 'general.breadcrumbs' ) ) {
			rank_math_the_breadcrumbs();
			return;
		}
		$seperator = '<span><i class="schema-lite-icon icon-right-dir"></i></span>';
		echo '<div class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">';
		echo '<span class="home"><i class="schema-lite-icon icon-home"></i></span>';
		echo '<div itemprop="itemListElement" itemscope
	      itemtype="https://schema.org/ListItem" class="root"><a href="';
		echo esc_url( home_url() );
		echo '" itemprop="item"><span itemprop="name">' . esc_html__( 'Home', 'schema-lite' );
		echo '</span><meta itemprop="position" content="1" /></a></div>' . $seperator;
		if ( is_single() ) {
			$categories = get_the_category();
			if ( $categories ) {
				$level         = 0;
				$hierarchy_arr = array();
				foreach ( $categories as $cat ) {
					$anc       = get_ancestors( $cat->term_id, 'category' );
					$count_anc = count( $anc );
					if ( 0 < $count_anc && $level < $count_anc ) {
						$level         = $count_anc;
						$hierarchy_arr = array_reverse( $anc );
						array_push( $hierarchy_arr, $cat->term_id );
					}
				}
				if ( empty( $hierarchy_arr ) ) {
					$category = $categories[0];
					echo '<div itemprop="itemListElement" itemscope
				      itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $category->name ) . '</span><meta itemprop="position" content="2" /></a></div>' . $seperator;
				} else {
					foreach ( $hierarchy_arr as $cat_id ) {
						$category = get_term_by( 'id', $cat_id, 'category' );
						echo '<div itemprop="itemListElement" itemscope
					      itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $category->name ) . '</span><meta itemprop="position" content="2" /></a></div>' . $seperator;
					}
				}
				get_itemprop_3( get_the_title(), '3' );
			} else {
				get_itemprop_3( get_the_title() );
			}
		} elseif ( is_page() ) {
			$parent_id = wp_get_post_parent_id( get_the_ID() );
			if ( $parent_id ) {
				$breadcrumbs = array();
				while ( $parent_id ) {
					$page          = get_page( $parent_id );
					$breadcrumbs[] = '<div itemprop="itemListElement" itemscope
				      itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_permalink( $page->ID ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( get_the_title( $page->ID ) ) . '</span><meta itemprop="position" content="2" /></a></div>' . $seperator;

					$parent_id = $page->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				foreach ( $breadcrumbs as $crumb ) {
					echo $crumb;
				}
				get_itemprop_3( get_the_title(), 3 );
			} else {
				get_itemprop_3( get_the_title() );
			}
		} elseif ( is_category() ) {
			global $wp_query;
			$cat_obj       = $wp_query->get_queried_object();
			$this_cat_id   = $cat_obj->term_id;
			$hierarchy_arr = get_ancestors( $this_cat_id, 'category' );
			if ( $hierarchy_arr ) {
				$hierarchy_arr = array_reverse( $hierarchy_arr );
				foreach ( $hierarchy_arr as $cat_id ) {
					$category = get_term_by( 'id', $cat_id, 'category' );
					echo '<div itemprop="itemListElement" itemscope
				      itemtype="https://schema.org/ListItem"><a href="' . esc_url( get_category_link( $category->term_id ) ) . '" itemprop="item"><span itemprop="name">' . esc_html( $category->name ) . '</span><meta itemprop="position" content="2" /></a></div>' . $seperator;
				}
			}
			get_itemprop_3( single_cat_title( '', false ) );
		} elseif ( is_author() ) {
			if ( get_query_var( 'author_name' ) ) :
				$curauth = get_user_by( 'slug', get_query_var( 'author_name' ) );
			else :
				$curauth = get_userdata( get_query_var( 'author' ) );
			endif;
			get_itemprop_3( esc_html( $curauth->nickname ) );
		} elseif ( is_search() ) {
			get_itemprop_3( get_search_query() );
		} elseif ( is_tag() ) {
			get_itemprop_3( single_tag_title( '', false ) );
		}
		echo '</div>';
	}
}

/**
 * Google Fonts
 */
function schema_lite_fonts_url() {
	$fonts_url = '';

	/** Translators: If there are characters in your language that are not
	 * supported by Roboto Slab, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$roboto_slab = _x( 'on', 'Roboto Slab font: on or off', 'schema-lite' );

	/** Translators: If there are characters in your language that are not
	 * supported by Raleway, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$raleway = _x( 'on', 'Raleway font: on or off', 'schema-lite' );

	if ( 'off' !== $roboto_slab || 'off' !== $raleway ) {
		$font_families = array();

		if ( 'off' !== $roboto_slab ) {
			$font_families[] = 'Roboto Slab:300,400';
		}

		if ( 'off' !== $raleway ) {
			$font_families[] = 'Raleway:400,500,700';
		}

		$query_args = array(
			'family' => rawurlencode( implode( '|', $font_families ) ),
			'subset' => rawurlencode( 'latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

/**
 * Enqueue Fonts
 */
function schema_lite_scripts_styles() {
	wp_enqueue_style( 'schema-lite-fonts', schema_lite_fonts_url(), array(), null );
}
add_action( 'wp_enqueue_scripts', 'schema_lite_scripts_styles' );

/**
 * WP Mega Menu Plugin Support
 */
function schema_lite_megamenu_parent_element( $selector ) {
	return '.primary-navigation .container';
}
add_filter( 'wpmm_container_selector', 'schema_lite_megamenu_parent_element' );

/**
 * Determines whether the WooCommerce plugin is active or not.
 *
 * @return bool
 */
function schema_lite_is_wc_active() {
	if ( is_multisite() ) {
		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		return is_plugin_active( 'woocommerce/woocommerce.php' );
	} else {
		return in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true );
	}
}

/**
 * WooCommerce
 */
if ( schema_lite_is_wc_active() ) {
	if ( ! function_exists( 'schema_lite_loop_columns' ) ) {
		/**
		 * Change number or products per row to 3
		 *
		 * @return int
		 */
		function schema_lite_loop_columns() {
			return 3; // 3 products per row
		}
	}
	add_filter( 'loop_shop_columns', 'schema_lite_loop_columns' );

	/**
	 * Redefine schema_lite_output_related_products()
	 */
	function schema_lite_output_related_products() {
		$args = array(
			'posts_per_page' => 3,
			'columns'        => 3,
		);
		woocommerce_related_products( $args ); // Display 3 products in rows of 1.
	}

	/**
	 * Change the number of product thumbnails to show per row to 4.
	 *
	 * @return int
	 */
	function schema_lite_woocommerce_thumb_cols() {
		return 4; // .last class applied to every 4th thumbnail
	}
	add_filter( 'woocommerce_product_thumbnails_columns', 'schema_lite_woocommerce_thumb_cols' );

	/**
	 * Optimize WooCommerce Scripts
	 * Updated for WooCommerce 2.0+
	 * Remove WooCommerce Generator tag, styles, and scripts from non WooCommerce pages.
	 */
	function schema_lite_manage_woocommerce_styles() {

		// First check that woo exists to prevent fatal errors.
		if ( function_exists( 'is_woocommerce' ) ) {
			// Dequeue scripts and styles.
			if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
				wp_dequeue_style( 'woocommerce-layout' );
				wp_dequeue_style( 'woocommerce-smallscreen' );
				wp_dequeue_style( 'woocommerce-general' );
				wp_dequeue_style( 'wc-bto-styles' ); // Composites Styles.
				wp_dequeue_script( 'wc-add-to-cart' );
				wp_dequeue_script( 'wc-cart-fragments' );
				wp_dequeue_script( 'woocommerce' );
				wp_dequeue_script( 'jquery-blockui' );
				wp_dequeue_script( 'jquery-placeholder' );
			}
		}
	}
	add_action( 'wp_enqueue_scripts', 'schema_lite_manage_woocommerce_styles', 99 );

}

/**
 * Post Layout for Archives
 */
if ( ! function_exists( 'schema_lite_archive_post' ) ) {
	/**
	 * Display a post of specific layout.
	 *
	 * @param string $layout Archive Post Layout.
	 */
	function schema_lite_archive_post( $layout = '' ) {
		$schema_lite_full_posts = get_theme_mod( 'schema_lite_full_posts', '0' );
		?>
		<article class="post excerpt">
			<header>
				<h2 class="title">
					<a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a>
				</h2>
				<div class="post-info">
					<span class="theauthor"><i class="schema-lite-icon icon-user"></i> <?php esc_html_e( 'By', 'schema-lite' ); ?> <?php esc_url( the_author_posts_link() ); ?></span>
					<span class="posted-on entry-date date updated"><i class="schema-lite-icon icon-calendar"></i> <?php the_time( get_option( 'date_format' ) ); ?></span>
					<span class="featured-cat"><i class="schema-lite-icon icon-tags"></i> <?php the_category( ', ' ); ?></span>
					<span class="thecomment"><i class="schema-lite-icon icon-comment"></i> <a href="<?php esc_url( comments_link() ); ?>"><?php comments_number( __( '0 Comments', 'schema-lite' ), __( '1 Comment', 'schema-lite' ), __( '% Comments', 'schema-lite' ) ); ?></a></span>
				</div>
			</header><!--.header-->
			<?php
			if ( empty( $schema_lite_full_posts ) ) :
				if ( has_post_thumbnail() ) {
					?>
					<a href="<?php esc_url( the_permalink() ); ?>" title="<?php the_title_attribute(); ?>" id="featured-thumbnail">
						<div class="featured-thumbnail">
							<?php
							the_post_thumbnail( 'schema-lite-featured', array( 'title' => '' ) );
							if ( function_exists( 'wp_review_show_total' ) ) {
								wp_review_show_total( true, 'latestPost-review-wrapper' );
							}
							?>
						</div>
					</a>
				<?php } ?>
				<div class="post-content">
					<?php echo schema_lite_excerpt( 42 ); // PHPCS:ignore ?>
				</div>
				<?php
				schema_lite_readmore();
			else :
				?>
				<div class="post-content full-post">
					<?php the_content(); ?>
				</div>
				<?php
				if ( schema_lite_post_has_moretag() ) :
					schema_lite_readmore();
				endif;
			endif;
			?>
		</article>
		<?php
	}
}

/**
 * Single Post Schema
 */
function schema_lite_single_post_schema() {
	if ( is_singular( 'post' ) ) {
		global $post;
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( has_post_thumbnail( $post->ID ) && ! empty( $custom_logo_id ) ) {
			$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
			if ( $logo_id ) {

				$images  = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
				$logo    = wp_get_attachment_image_src( $logo_id, 'full' );
				$excerpt = schema_lite_escape_text_tags( $post->post_excerpt );
				$content = $excerpt === '' ? mb_substr( schema_lite_escape_text_tags( $post->post_content ), 0, 110 ) : $excerpt;
				$args    = array(
					'@context'         => 'http://schema.org',
					'@type'            => 'BlogPosting',
					'mainEntityOfPage' => array(
						'@type' => 'WebPage',
						'@id'   => get_permalink( $post->ID ),
					),
					'headline'         => ( function_exists( '_wp_render_title_tag' ) ? wp_get_document_title() : wp_title( '', false, 'right' ) ),
					'image'            => array(
						'@type'  => 'ImageObject',
						'url'    => $images[0],
						'width'  => $images[1],
						'height' => $images[2],
					),
					'datePublished'    => get_the_time( DATE_ISO8601, $post->ID ),
					'dateModified'     => get_post_modified_time( DATE_ISO8601, __return_false(), $post->ID ),
					'author'           => array(
						'@type' => 'Person',
						'name'  => schema_lite_escape_text_tags( get_the_author_meta( 'display_name', $post->post_author ) ),
					),
					'publisher'        => array(
						'@type' => 'Organization',
						'name'  => get_bloginfo( 'name' ),
						'logo'  => array(
							'@type'  => 'ImageObject',
							'url'    => $logo[0],
							'width'  => $logo[1],
							'height' => $logo[2],
						),
					),
					'description'      => ( class_exists( 'WPSEO_Meta' ) ? WPSEO_Meta::get_value( 'metadesc' ) : $content ),
				);
				echo '<script type="application/ld+json">' , PHP_EOL;
				echo wp_json_encode( $args, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT ) , PHP_EOL;
				echo '</script>' , PHP_EOL;
			}
		}
	}
}
add_action( 'wp_head', 'schema_lite_single_post_schema' );

/**
 * Sanitizes choices (selects / radios)
 * Checks that the input matches one of the available choices
 *
 * @param array $input the available choices.
 * @param array $setting the setting object.
 */
function schema_lite_sanitize_choices( $input, $setting ) {
	// Ensure input is a slug.
	$input = sanitize_key( $input );

	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;

	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

/* Display a admin notice about Pro version */
add_action( 'admin_notices', 'schema_admin_notice' );
function schema_admin_notice() {
	global $current_user;
	$user_id = $current_user->ID;

	// Bail if this notice was dismissed already.
	$dismissed = get_user_meta( $user_id, 'schema_ignore_notice' );
	if ( $dismissed ) {
		return;
	}

	// Check if notice should show based on install date.
	$install_date = get_option( 'schema_lite_install_date' );
	if ( time() < $install_date + WEEK_IN_SECONDS ) {
		return;
	}

	// Only show notice if RM notice was dismissed in the past OR if RM is installed already.
	$rmu_dismissed       = (array) get_user_meta( $user_id, 'rmu_dismiss', true );
	$rm_notice_dismissed = ! empty( $rmu_dismissed['main_notice'] );
	if ( $rm_notice_dismissed || RMU_INSTALLED ) {
		echo '<div class="updated notice-info schema-notice" style="position:relative;"><p>';
		printf( __('Like Schema theme? You will <strong>LOVE Schema Pro</strong>!', 'schema-lite' ) . '&nbsp;<a href="https://mythemeshop.com/themes/schema/?utm_source=Schema+Free&utm_medium=Notification+Link&utm_content=Schema+Pro+LP&utm_campaign=WordPressOrg" target="_blank">' . __('Click here for all the exciting features.', 'schema' ) . '</a><a href="%1$s" class="notice-dismiss" style="text-decoration:none;"></a>', '?schema_notice_ignore=0' );
		echo '</p></div>';
	}
}

add_action( 'admin_init', 'schema_notice_ignore' );
function schema_notice_ignore() {
	global $current_user;
	$user_id = $current_user->ID;
	/* If user clicks to ignore the notice, add that to their user meta */
	if ( isset( $_GET['schema_notice_ignore'] ) && '0' === $_GET['schema_notice_ignore'] ) {
		add_user_meta( $user_id, 'schema_ignore_notice', 'true', true );
	}
}

/**
 * Loads files related to Rank Math.
 */
function schema_lite_suggest_rank_math() {
	if ( ! is_admin() ) {
		return;
	}
	if ( ! apply_filters( 'mts_disable_rmu', false ) ) {
		if ( ! defined( 'RMU_ACTIVE' ) ) {
			include_once 'inc/class-mts-rmu.php';
		}
		$mts_rmu = MTS_RMU::init();
	}
}

schema_lite_suggest_rank_math();

if ( ! function_exists( 'schema_lite_register_elementor_locations' ) ) {
	/**
	 * Register Elementor Locations
	 */
	function schema_lite_register_elementor_locations( $elementor_theme_manager ) {
		if ( apply_filters( 'schema_lite_register_elementor_locations', true ) ) {
			$elementor_theme_manager->register_all_core_location();
			$elementor_theme_manager->register_location( 'archive' );
			$elementor_theme_manager->register_location(
				'main-sidebar',
				[
					'label'           => __( 'Main Sidebar', 'schema-lite' ),
					'multiple'        => true,
					'edit_in_content' => false,
				]
			);
		}
	}
}
add_action( 'elementor/theme/register_locations', 'schema_lite_register_elementor_locations' );
