<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
function nob_content_health_menu() { add_theme_page( __( 'NotOnlyBook Content Health', 'notonlybook-modern' ), __( 'Content Health', 'notonlybook-modern' ), 'edit_posts', 'nob-content-health', 'nob_content_health_page' ); }
add_action( 'admin_menu', 'nob_content_health_menu' );
function nob_content_health_scan() {
	$posts = get_posts( array( 'post_type' => array( 'post','page' ), 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids' ) );
	$result = array( 'total' => count( $posts ), 'thin' => array(), 'no_featured' => array(), 'demo_links' => array(), 'nested_document' => array(), 'downloads' => array() );
	foreach ( $posts as $post_id ) {
		$content = (string) get_post_field( 'post_content', $post_id ); $words = str_word_count( wp_strip_all_tags( strip_shortcodes( $content ) ) );
		if ( 'post' === get_post_type( $post_id ) && $words < 500 ) { $result['thin'][] = $post_id; }
		if ( 'post' === get_post_type( $post_id ) && ! has_post_thumbnail( $post_id ) ) { $result['no_featured'][] = $post_id; }
		if ( preg_match( '/demosoledad\.pencidesign\.net|example\.com/i', $content ) ) { $result['demo_links'][] = $post_id; }
		if ( false !== stripos( $content, '<!DOCTYPE' ) || false !== stripos( $content, '<html' ) ) { $result['nested_document'][] = $post_id; }
		if ( preg_match( '/drive\.google\.com|\.pdf\b|download/i', $content ) ) { $result['downloads'][] = $post_id; }
	}
	return $result;
}
function nob_content_health_ids( $ids, $limit = 12 ) {
	if ( empty( $ids ) ) { return '<span style="color:#18794e;font-weight:600">None detected</span>'; }
	$links = array(); foreach ( array_slice( $ids, 0, $limit ) as $post_id ) { $links[] = sprintf( '<a href="%1$s">%2$s</a>', esc_url( get_edit_post_link( $post_id ) ), esc_html( '#' . $post_id . ' ' . wp_trim_words( get_the_title( $post_id ), 6 ) ) ); }
	$suffix = count( $ids ) > $limit ? ' … +' . ( count( $ids ) - $limit ) : ''; return implode( '<br>', $links ) . esc_html( $suffix );
}
function nob_content_health_page() {
	if ( ! current_user_can( 'edit_posts' ) ) { return; }
	$scan = nob_content_health_scan();
	$legal = array( 'Privacy' => (bool) get_page_by_path( 'privacy-policy' ), 'Terms' => (bool) get_page_by_path( 'terms-and-conditions' ), 'Disclaimer' => (bool) ( get_page_by_path( 'disclaimer' ) || get_page_by_path( 'privacy-policy-2-2disclaimer' ) ), 'About' => (bool) get_page_by_path( 'about-us' ), 'Contact' => (bool) get_page_by_path( 'contact-us' ) );
	?><div class="wrap"><h1><?php esc_html_e( 'NotOnlyBook Content Health', 'notonlybook-modern' ); ?></h1><p><?php esc_html_e( 'Read-only checks for the existing content. Nothing is automatically deleted or rewritten.', 'notonlybook-modern' ); ?></p><h2><?php esc_html_e( 'Legal / trust pages', 'notonlybook-modern' ); ?></h2><table class="widefat striped" style="max-width:900px"><tbody><?php foreach ( $legal as $label => $exists ) : ?><tr><th><?php echo esc_html( $label ); ?></th><td><?php echo $exists ? '✓ Found' : '⚠ Missing'; ?></td></tr><?php endforeach; ?></tbody></table><h2 style="margin-top:28px"><?php esc_html_e( 'Content checks', 'notonlybook-modern' ); ?></h2><table class="widefat striped" style="max-width:1100px"><thead><tr><th>Check</th><th>Count</th><th>Examples</th></tr></thead><tbody><tr><th>Published posts under 500 words</th><td><?php echo esc_html( count( $scan['thin'] ) ); ?></td><td><?php echo wp_kses_post( nob_content_health_ids( $scan['thin'] ) ); ?></td></tr><tr><th>Posts without featured images</th><td><?php echo esc_html( count( $scan['no_featured'] ) ); ?></td><td><?php echo wp_kses_post( nob_content_health_ids( $scan['no_featured'] ) ); ?></td></tr><tr><th>Legacy demo/external template links</th><td><?php echo esc_html( count( $scan['demo_links'] ) ); ?></td><td><?php echo wp_kses_post( nob_content_health_ids( $scan['demo_links'] ) ); ?></td></tr><tr><th>Nested HTML document markup</th><td><?php echo esc_html( count( $scan['nested_document'] ) ); ?></td><td><?php echo wp_kses_post( nob_content_health_ids( $scan['nested_document'] ) ); ?></td></tr><tr><th>Download / PDF / Drive references</th><td><?php echo esc_html( count( $scan['downloads'] ) ); ?></td><td><?php echo wp_kses_post( nob_content_health_ids( $scan['downloads'] ) ); ?></td></tr></tbody></table><p><strong>Important:</strong> Verify that every downloadable book, paper, image and file is licensed for distribution before monetization.</p></div><?php
}
