<?php
/** Site footer. @package NotOnlyBook_Modern */
?>
<footer class="nob-site-footer">
	<div class="nob-container">
		<div class="nob-footer-grid">
			<section>
				<h2><?php bloginfo( 'name' ); ?></h2>
				<p><?php esc_html_e( 'A focused educational library for IGCSE students, parents and educators.', 'notonlybook-modern' ); ?></p>
				<p><?php esc_html_e( 'Use educational resources responsibly and verify exam information with the relevant official examination board.', 'notonlybook-modern' ); ?></p>
			</section>
			<section>
				<h3><?php esc_html_e( 'Explore', 'notonlybook-modern' ); ?></h3>
				<ul>
					<?php foreach ( array_slice( nob_get_featured_topics(), 0, 6 ) as $topic ) : ?>
						<li><a href="<?php echo esc_url( get_term_link( $topic ) ); ?>"><?php echo esc_html( $topic->name ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</section>
			<section>
				<h3><?php esc_html_e( 'Trust & policies', 'notonlybook-modern' ); ?></h3>
				<?php nob_legal_links(); ?>
			</section>
		</div>
		<div class="nob-footer-bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'notonlybook-modern' ); ?></span>
			<span><?php esc_html_e( 'Independent educational resource website.', 'notonlybook-modern' ); ?></span>
		</div>
	</div>
</footer>
<?php nob_render_widget_ad_area( 'ad_footer_anchor', 'nob-ad-zone--footer-anchor' ); ?>
<?php wp_footer(); ?>
</body>
</html>
