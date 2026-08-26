<?php
/**
 * Native WordPress comments template.
 *
 * @package NotOnlyBook_Modern
 */

if ( post_password_required() ) {
	return;
}

$commenter = wp_get_current_commenter();
$required  = (bool) get_option( 'require_name_email' );
$req_attr  = $required ? ' required' : '';
$aria_req  = $required ? ' aria-required="true"' : '';
$field_css = 'width:100%;max-width:100%;';
?>
<section id="comments" class="nob-widget nob-comments" aria-labelledby="nob-comments-title">
	<?php if ( have_comments() ) : ?>
		<h2 id="nob-comments-title">
			<?php
			printf(
				esc_html( _nx( '%1$s comment', '%1$s comments', get_comments_number(), 'comments title', 'notonlybook-modern' ) ),
				esc_html( number_format_i18n( get_comments_number() ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 56,
				)
			);
			?>
		</ol>

		<?php
		the_comments_pagination(
			array(
				'prev_text' => esc_html__( 'Older comments', 'notonlybook-modern' ),
				'next_text' => esc_html__( 'Newer comments', 'notonlybook-modern' ),
			)
		);
		?>
	<?php else : ?>
		<h2 id="nob-comments-title"><?php esc_html_e( 'Comments', 'notonlybook-modern' ); ?></h2>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p><?php esc_html_e( 'Comments are closed.', 'notonlybook-modern' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form(
		array(
			'class_submit'         => 'submit nob-btn',
			'title_reply_before'   => '<h2 id="reply-title" class="comment-reply-title">',
			'title_reply_after'    => '</h2>',
			'comment_notes_before' => '<p class="comment-notes">' . esc_html__( 'Your email address will not be published. Required fields are marked.', 'notonlybook-modern' ) . '</p>',
			'comment_field'        => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'notonlybook-modern' ) . '</label><textarea id="comment" name="comment" rows="8" maxlength="65525" required style="' . esc_attr( $field_css ) . '"></textarea></p>',
			'fields'               => array(
				'author' => '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'notonlybook-modern' ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" maxlength="245" autocomplete="name" style="' . esc_attr( $field_css ) . '"' . $aria_req . $req_attr . '></p>',
				'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'notonlybook-modern' ) . '</label><input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" maxlength="100" autocomplete="email" style="' . esc_attr( $field_css ) . '"' . $aria_req . $req_attr . '></p>',
				'url'    => '<p class="comment-form-url"><label for="url">' . esc_html__( 'Website', 'notonlybook-modern' ) . '</label><input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" maxlength="200" autocomplete="url" style="' . esc_attr( $field_css ) . '"></p>',
			),
		)
	);
	?>
</section>
