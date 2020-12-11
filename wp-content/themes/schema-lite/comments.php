<?php
/**
 * The template for displaying the comments.
 *
 * This contains both the comments and the comment form.
 */
if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments','schema-lite'); ?>.</p>
<?php return; } ?>

<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
	<div id="comments">
		<h4 class="total-comments"><?php comments_number(__('No Comments','schema-lite'), __('One Comment','schema-lite'),  __('% Comments','schema-lite') );?></h4>
		<ol class="commentlist">
			<div class="navigation">
				<div class="alignleft"><?php previous_comments_link() ?></div>
				<div class="alignright"><?php next_comments_link() ?></div>
			</div>
			<?php wp_list_comments('type=comment&callback=schema_lite_comment'); ?>
			<div class="navigation bottomnav">
				<div class="alignleft"><?php previous_comments_link() ?></div>
				<div class="alignright"><?php next_comments_link() ?></div>
			</div>
		</ol>
	</div>
<?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
	<?php else : // comments are closed ?>
	<?php endif; ?>
<?php endif; ?>
<?php if ('open' == $post->comment_status) : ?>
	<div id="commentsAdd">
		<div id="respond" class="box m-t-6">
			<?php global $aria_req; 
			$consent  = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
			$comments_args = array(
				'title_reply'=>'<h4><span>'.__('Add a Comment','schema-lite').'</span></h4></h4>',
				'label_submit' => __('Add Comment','schema-lite'),
				'comment_field' => '<p class="comment-form-comment"><label for="comment">'.__('Comment:','schema-lite').'<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="5" aria-required="true"></textarea></p>',
				'fields' => apply_filters( 'comment_form_default_fields',
					array(
					'author' => '<p class="comment-form-author">' 
						. '<label for="author">' . __( 'Name', 'schema-lite' ) . ':<span class="required">*</span></label>' 
						. ( $req ? '' : '' ) . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
						
					'email' => '<p class="comment-form-email"><label for="email">' . __( 'Email Address', 'schema-lite' ) . ':<span class="required">*</span></label>' 
						. ( $req ? '' : '' ) . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
						
					'url' => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'schema-lite' ) . ':</label>' . '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
					'cookies' => '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' />' .
					'<label for="wp-comment-cookies-consent">' . __( 'Save my name, email, and website in this browser for the next time I comment.', 'schema-lite' ) . '</label></p>', 
			))
			); 
			comment_form($comments_args); ?>
		</div>
	</div>
<?php endif; // if you delete this the sky will fall on your head ?>
