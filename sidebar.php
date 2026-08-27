<?php
/** Article sidebar. @package NotOnlyBook_Modern */
?>
<aside class="nob-sidebar" style="min-width:0;max-width:100%" aria-label="<?php esc_attr_e( 'Article sidebar', 'notonlybook-modern' ); ?>">
	<?php if ( is_active_sidebar( 'article-sidebar' ) ) : ?>
		<?php dynamic_sidebar( 'article-sidebar' ); ?>
	<?php else : ?>
		<section class="nob-widget">
			<h2><?php esc_html_e( 'Explore topics', 'notonlybook-modern' ); ?></h2>
			<ul>
				<?php foreach ( array_slice( nob_get_featured_topics(), 0, 7 ) as $topic ) : ?>
					<li><a href="<?php echo esc_url( get_term_link( $topic ) ); ?>"><?php echo esc_html( $topic->name ); ?> <small>(<?php echo esc_html( number_format_i18n( $topic->count ) ); ?>)</small></a></li>
				<?php endforeach; ?>
			</ul>
		</section>
	<?php endif; ?>

	<div class="nob-sidebar-sticky-ad">
		<?php nob_render_widget_ad_area( 'ad_sidebar_sticky', 'nob-ad-zone--sidebar' ); ?>
		<?php nob_render_ad( 'sidebar' ); ?>
	</div>
</aside>
