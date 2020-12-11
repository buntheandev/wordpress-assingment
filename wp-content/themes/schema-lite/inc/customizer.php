<?php
/**
 * Schema Theme Customizer.
 *
 * @package Schema Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function schema_lite_customize_register( $wp_customize ) {

	/**
	 * Theme Options
	 */
	$wp_customize->add_panel( 'panel_id', array(
		'priority'    => 121,
		'capability'  => 'edit_theme_options',
		'title'       => __( 'Theme Options', 'schema-lite' ),
		'description' => __( 'MyThemeShop Mission Control Center', 'schema-lite' ),
	) );

	/**
	 * Styling
	 */
	$wp_customize->add_section( 'schema_lite_styling_settings', array(
		'title'      => __( 'Styling Settings', 'schema-lite' ),
		'priority'   => 122,
		'capability' => 'edit_theme_options',
		'panel'      => 'panel_id',
	) );

	// Container.
	$wp_customize->add_setting( 'schema_lite_container', array(
		'capability'        => 'edit_theme_options',
		'default'           => 'boxed',
		'sanitize_callback' => 'schema_lite_sanitize_choices',
	));
	$wp_customize->add_control( 'schema_lite_container', array(
		'settings' => 'schema_lite_container',
		'label'    => __( 'Default Container', 'schema-lite' ),
		'section'  => 'schema_lite_styling_settings',
		'type'     => 'select',
		'choices'  => array(
			'boxed'         => __( 'Boxed', 'schema-lite' ),
			'fullcontent'   => __( 'Full Width / Contained', 'schema-lite' ),
			'fullstretched' => __( 'Full Width / Stretched', 'schema-lite' ),
		),
	));

	// Layout.
	$wp_customize->add_setting( 'schema_lite_layout', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'schema_lite_sanitize_choices',
		'default'           => 'cslayout',
	));
	$wp_customize->add_control( 'schema_lite_layout', array(
		'settings' => 'schema_lite_layout',
		'label'    => __( 'Sidebar Position', 'schema-lite' ),
		'section'  => 'schema_lite_styling_settings',
		'type'     => 'radio',
		'choices'  => array(
			'cslayout'  => __( 'Right Sidebar', 'schema-lite' ),
			'sclayout'  => __( 'Left Sidebar', 'schema-lite' ),
			'nosidebar' => __( 'No Sidebar', 'schema-lite' ),
		),
	));

	// Color Scheme.
	$wp_customize->add_setting( 'schema_lite_color_scheme', array(
		'default'           => '#0274be',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'schema_lite_color_scheme', array(
		'label'    => __( 'Primary Color Scheme', 'schema-lite' ),
		'section'  => 'schema_lite_styling_settings',
		'settings' => 'schema_lite_color_scheme',
	)) );

	$wp_customize->add_setting( 'schema_lite_color_scheme2', array(
		'default'           => '#222222',
		'sanitize_callback' => 'sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'schema_lite_color_scheme2', array(
		'label'    => __( 'Secondary Color Scheme', 'schema-lite' ),
		'section'  => 'schema_lite_styling_settings',
		'settings' => 'schema_lite_color_scheme2',
	)) );

	// Full posts.
	$wp_customize->add_setting( 'schema_lite_full_posts', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'schema_lite_sanitize_choices',
		'default'           => '0',
	));
	$wp_customize->add_control( 'schema_lite_full_posts', array(
		'settings' => 'schema_lite_full_posts',
		'label'    => __( 'Posts on Homepage', 'schema-lite' ),
		'section'  => 'schema_lite_styling_settings',
		'type'     => 'radio',
		'choices'  => array(
			'0' => __( 'Excerpts', 'schema-lite' ),
			'1' => __( 'Full Posts', 'schema-lite' ),
		),
	));

	/**
	 * Header
	 */
	$wp_customize->add_section( 'schema_lite_header_settings', array(
		'title'      => __( 'Header', 'schema-lite' ),
		'priority'   => 122,
		'capability' => 'edit_theme_options',
		'panel'      => 'panel_id',
	) );

	/**
	 * Pagination
	 */
	$wp_customize->add_section( 'schema_lite_pagination_settings', array(
		'title'      => __( 'Pagination Type', 'schema-lite' ),
		'priority'   => 122,
		'capability' => 'edit_theme_options',
		'panel'      => 'panel_id',
	) );

	$wp_customize->add_setting( 'schema_lite_pagination_type', array(
		'default'           => '1',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'schema_lite_sanitize_choices',
	));

	$wp_customize->add_control(
		new WP_Customize_Control(
			$wp_customize,
			'schema_lite_pagination_type',
			array(
				'label'     => __( 'Pagination Type', 'schema-lite' ),
				'section'   => 'schema_lite_pagination_settings',
				'settings'  => 'schema_lite_pagination_type',
				'type'      => 'radio',
				'choices'   => array(
					'0' => __( 'Next/Previous', 'schema-lite' ),
					'1' => __( 'Numbered', 'schema-lite' ),
				),
				'transport' => 'refresh',
			)
		)
	);

	/**
	 * Footer
	 */
	$wp_customize->add_section( 'schema_lite_footer_settings', array(
		'title'      => __( 'Footer', 'schema-lite' ),
		'priority'   => 122,
		'capability' => 'edit_theme_options',
		'panel'      => 'panel_id',
	) );

	$wp_customize->add_setting( 'schema_lite_copyright_text', array(
		'default'           => __( 'Theme by', 'schema-lite' ) . ' <a href="http://mythemeshop.com/" rel="nofollow">MyThemeShop</a>.',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'wp_kses_post',
	));
	$wp_customize->add_control( 'schema_lite_copyright_text', array(
		'label'       => __( 'Copyrights Text', 'schema-lite' ),
		'description' => __( 'You can change or remove our link from footer and use your own custom text.(You can also use your affiliate link to earn 70% of sales. Ex: https://mythemeshop.com/?ref=username)', 'schema-lite' ),
		'section'     => 'schema_lite_footer_settings',
		'settings'    => 'schema_lite_copyright_text',
		'type'        => 'textarea',
	));

	/**
	 * Single Post
	 */
	$wp_customize->add_section( 'schema_lite_single_settings', array(
		'title'      => __( 'Single Post Settings', 'schema-lite' ),
		'priority'   => 122,
		'capability' => 'edit_theme_options',
		'panel'      => 'panel_id',
	) );

	// Breadcrumb.
	$wp_customize->add_setting( 'schema_lite_single_breadcrumb_section', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'schema_lite_sanitize_choices',
		'transport'         => 'refresh',
		'default'           => '1',
	));
	$wp_customize->add_control( 'schema_lite_single_breadcrumb_section', array(
		'label'    => __( 'Breadcrumb Section', 'schema-lite' ),
		'section'  => 'schema_lite_single_settings',
		'settings' => 'schema_lite_single_breadcrumb_section',
		'type'     => 'radio',
		'choices'  => array(
			'0' => __( 'OFF', 'schema-lite' ),
			'1' => __( 'ON', 'schema-lite' ),
		),
	));

	// Tags.
	$wp_customize->add_setting( 'schema_lite_single_tags_section', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'schema_lite_sanitize_choices',
		'transport'         => 'refresh',
		'default'           => '1',
	));
	$wp_customize->add_control( 'schema_lite_single_tags_section', array(
		'label'    => __( 'Tags Section', 'schema-lite' ),
		'section'  => 'schema_lite_single_settings',
		'settings' => 'schema_lite_single_tags_section',
		'type'     => 'radio',
		'choices'  => array(
			'0' => __( 'OFF', 'schema-lite' ),
			'1' => __( 'ON', 'schema-lite' ),
		),
	));

	// Related Posts.
	$wp_customize->add_setting( 'schema_lite_relatedposts_section', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'schema_lite_sanitize_choices',
		'transport'         => 'refresh',
		'default'           => '1',
	));
	$wp_customize->add_control( 'schema_lite_relatedposts_section', array(
		'label'    => __( 'Related Posts Section', 'schema-lite' ),
		'section'  => 'schema_lite_single_settings',
		'settings' => 'schema_lite_relatedposts_section',
		'type'     => 'radio',
		'choices'  => array(
			'0' => __( 'OFF', 'schema-lite' ),
			'1' => __( 'ON', 'schema-lite' ),
		),
	));

	// Author Box.
	$wp_customize->add_setting( 'schema_lite_authorbox_section', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'schema_lite_sanitize_choices',
		'transport'         => 'refresh',
		'default'           => '1',
	));
	$wp_customize->add_control( 'schema_lite_authorbox_section', array(
		'label'    => __( 'Author box Section', 'schema-lite' ),
		'section'  => 'schema_lite_single_settings',
		'settings' => 'schema_lite_authorbox_section',
		'type'     => 'radio',
		'choices'  => array(
			'0' => __( 'OFF', 'schema-lite' ),
			'1' => __( 'ON', 'schema-lite' ),
		),
	));

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'custom_logo', array(
		'settings' => 'custom_logo',
	));
	$wp_customize->get_setting( 'custom_logo' )->transport = 'postMessage';

}
add_action( 'customize_register', 'schema_lite_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function schema_lite_customize_preview_js() {
	wp_enqueue_script( 'schema_lite_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'schema_lite_customize_preview_js' );
