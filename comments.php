<?php
/**
 * Native WordPress comments template.
 *
 * @package NotOnlyBook_Modern
 */

if ( post_password_required() ) {
	return;
}
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
		)
	);
	?>
</section>
