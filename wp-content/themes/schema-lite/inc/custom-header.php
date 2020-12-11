<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package Schema Lite
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses schema_lite_header_style()
 */
function schema_lite_custom_header_setup() {
	add_theme_support( 'custom-logo', array(
		'width'       => 150,
		'height'      => 28,
		'flex-height' => true,
		'flex-width'  => true,
		'header-text' => array( 'site-title', 'site-description' ),
	) );
	add_theme_support( 'custom-header', array(
		'default-image'      => '',
		'default-text-color' => 'ffffff',
		'width'              => 1900,
		'height'             => 74,
		'flex-width'         => true,
		'flex-height'        => true,
		'wp-head-callback'   => 'schema_lite_header_style',
	) );
}
add_action( 'after_setup_theme', 'schema_lite_custom_header_setup' );

if ( ! function_exists( 'schema_lite_header_style' ) ) :
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see schema_lite_custom_header_setup().
	 */
	function schema_lite_header_style() {
		$header_text_color = get_header_textcolor();

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style type="text/css">
		<?php if ( ! display_header_text() ) : ?>
			.site-title,
			.site-description {
				position: absolute;
				clip: rect(1px, 1px, 1px, 1px);
			}
		<?php else : ?>
			.site-title a,
			.site-description, #navigation a {
				color: #<?php echo esc_attr( $header_text_color ); ?>;
			}
		<?php endif; ?>
		</style>
		<?php
	}
endif;
