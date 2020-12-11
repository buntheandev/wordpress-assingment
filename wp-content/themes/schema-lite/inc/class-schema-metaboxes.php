<?php
/**
 * Theme administration metaboxes
 *
 * @package Point
 */

defined( 'WPINC' ) || exit;

/**
 * Add a "Sidebar" selection metabox.
 */
function mts_add_sidebar_metabox() {
	$screens = array( 'post', 'page' );
	foreach ( $screens as $screen ) {
		add_meta_box( 'mts_sidebar_metabox', esc_html__( 'Point Settings', 'schema-lite' ), 'mts_inner_sidebar_metabox', $screen, 'side', 'high' );
	}
}
add_action( 'add_meta_boxes', 'mts_add_sidebar_metabox' );

/**
 * Print the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */
function mts_inner_sidebar_metabox( $post ) {
	global $wp_registered_sidebars;

	// Add an nonce field so we can check for it later.
	wp_nonce_field( 'mts_inner_sidebar_metabox', 'mts_inner_sidebar_metabox_nonce' );

	/*
	* Use get_post_meta() to retrieve an existing value
	* from the database and use the value for the form.
	*/
	$custom_sidebar        = get_post_meta( $post->ID, '_custom_sidebar', true );
	$content_layout        = get_post_meta( $post->ID, '_content_layout', true );
	$disable_header        = get_post_meta( $post->ID, '_disable_header', true );
	$disable_title         = get_post_meta( $post->ID, '_disable_title', true );
	$disable_post_meta     = get_post_meta( $post->ID, '_disable_post_meta', true );
	$disable_related_posts = get_post_meta( $post->ID, '_disable_related_posts', true );
	$disable_author_box    = get_post_meta( $post->ID, '_disable_author_box', true );
	$disable_footer        = get_post_meta( $post->ID, '_disable_footer', true );

	// Select custom sidebar from dropdown.
	echo '<p><strong>' . __( 'Sidebar', 'schema-lite' ) . '</p></strong>';
	echo '<select name="custom_sidebar" id="custom_sidebar" style="margin-bottom: 10px;">';
	echo '<option value="default" ' . selected( 'default', $custom_sidebar ) . '>' . __( 'Default', 'schema-lite' ) . ' </option>';
	echo '<option value="sclayout" ' . selected( 'sclayout', $custom_sidebar ) . '>' . __( 'Left Sidebar', 'schema-lite' ) . '</option>';
	echo '<option value="cslayout" ' . selected( 'cslayout', $custom_sidebar ) . '>' . __( 'Right Sidebar', 'schema-lite' ) . '</option>';
	echo '<option value="nosidebar" ' . selected( 'nosidebar', $custom_sidebar ) . '>' . __( 'No Sidebar', 'schema-lite' ) . '</option>';
	echo '</select><br />';

	// Select content layout from dropdown.
	echo '<p><strong>' . __( 'Content Layout', 'schema-lite' ) . '</strong></p>';
	echo '<select name="content_layout" id="content_layout" style="margin-bottom: 10px;">';
	echo '<option value="default" ' . selected( 'default', $content_layout ) . '>' . __( 'Default', 'schema-lite' ) . ' </option>';
	echo '<option value="boxed" ' . selected( 'boxed', $content_layout ) . '>' . __( 'Boxed', 'schema-lite' ) . '</option>';
	echo '<option value="fullcontent" ' . selected( 'fullcontent', $content_layout ) . '>' . __( 'Full Width / Contained', 'schema-lite' ) . '</option>';
	echo '<option value="fullstretched" ' . selected( 'fullstretched', $content_layout ) . '>' . __( 'Full Width / Stretched', 'schema-lite' ) . '</option>';
	echo '</select><br />';

	// Disable sections.
	echo '<div class="disable_sections">';
	echo '<label for="disable_header" style="display: block; margin-bottom: 5px;"><input type="checkbox" name="disable_header" id="disable_header" value="header"' . checked( 'header', $disable_header, false ) . '>' . __( 'Disable Header', 'schema-lite' ) . '</label>';
	echo '<label for="disable_title" style="display: block; margin-bottom: 5px;"><input type="checkbox" name="disable_title" id="disable_title" value="title"' . checked( 'title', $disable_title, false ) . '>' . __( 'Disable Title', 'schema-lite' ) . '</label>';
	// Show these options on pages only.
	$current_screen = get_current_screen();
	if ( 'post' === $current_screen->post_type ) {
		echo '<label for="disable_post_meta" style="display: block; margin-bottom: 5px;"><input type="checkbox" name="disable_post_meta" id="disable_post_meta" value="post_meta"' . checked( 'post_meta', $disable_post_meta, false ) . '>' . __( 'Disable Post Meta', 'schema-lite' ) . '</label>';
		echo '<label for="disable_related_posts" style="display: block; margin-bottom: 5px;"><input type="checkbox" name="disable_related_posts" id="disable_related_posts" value="related_posts"' . checked( 'related_posts', $disable_related_posts, false ) . '>' . __( 'Disable Related Posts', 'schema-lite' ) . '</label>';
		echo '<label for="disable_author_box" style="display: block; margin-bottom: 5px;"><input type="checkbox" name="disable_author_box" id="disable_author_box" value="author_box"' . checked( 'author_box', $disable_author_box, false ) . '>' . __( 'Disable Author Box', 'schema-lite' ) . '</label>';
	}
	echo '<label for="disable_footer" style="display: block; margin-bottom: 5px;"><input type="checkbox" name="disable_footer" id="disable_footer" value="footer"' . checked( 'footer', $disable_footer, false ) . '>' . __( 'Disable Footer', 'schema-lite' ) . '</label>';
	echo '</div>';

}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 *
 * @return int
 */
function mts_save_custom_sidebar( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['mts_inner_sidebar_metabox_nonce'] ) ) {
		return $post_id;
	}

	$nonce = $_POST['mts_inner_sidebar_metabox_nonce'];

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $nonce, 'mts_inner_sidebar_metabox' ) ) {
		return $post_id;
	}

	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}

	// Check the user's permissions.
	if ( 'page' === $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		}
	} else {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
	}

	/* OK, its safe for us to save the data now. */

	// Sanitize user input.
	$sidebar_name          = sanitize_text_field( $_POST['custom_sidebar'] );
	$content_layout        = sanitize_text_field( $_POST['content_layout'] );
	$disable_header        = sanitize_text_field( $_POST['disable_header'] );
	$disable_title         = sanitize_text_field( $_POST['disable_title'] );
	$disable_post_meta     = sanitize_text_field( $_POST['disable_post_meta'] );
	$disable_related_posts = sanitize_text_field( $_POST['disable_related_posts'] );
	$disable_author_box    = sanitize_text_field( $_POST['disable_author_box'] );
	$disable_footer        = sanitize_text_field( $_POST['disable_footer'] );

	// Update the meta field in the database.
	update_post_meta( $post_id, '_custom_sidebar', $sidebar_name );
	update_post_meta( $post_id, '_content_layout', $content_layout );
	update_post_meta( $post_id, '_disable_header', $disable_header );
	update_post_meta( $post_id, '_disable_title', $disable_title );
	update_post_meta( $post_id, '_disable_post_meta', $disable_post_meta );
	update_post_meta( $post_id, '_disable_related_posts', $disable_related_posts );
	update_post_meta( $post_id, '_disable_author_box', $disable_author_box );
	update_post_meta( $post_id, '_disable_footer', $disable_footer );
}
add_action( 'save_post', 'mts_save_custom_sidebar' );
