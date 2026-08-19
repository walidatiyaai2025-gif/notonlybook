<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
function nob_normalize_legacy_content( $content ) {
	if ( is_admin() || is_feed() || empty( $content ) ) { return $content; }
	if ( false !== stripos( $content, '<!DOCTYPE' ) || false !== stripos( $content, '<html' ) ) {
		$content = preg_replace( '/<!DOCTYPE[^>]*>/i', '', $content );
		$content = preg_replace( '/<head\b[^>]*>.*?<\/head>/is', '', $content );
		$content = preg_replace( '/<\/?html\b[^>]*>/i', '', $content );
		$content = preg_replace( '/<\/?body\b[^>]*>/i', '', $content );
	}
	return $content;
}
add_filter( 'the_content', 'nob_normalize_legacy_content', 8 );
function nob_external_link_attributes( $content ) {
	if ( is_admin() || ! is_singular() || empty( $content ) ) { return $content; }
	$host = wp_parse_url( home_url( '/' ), PHP_URL_HOST ); if ( ! $host ) { return $content; }
	return preg_replace_callback( '/<a\s+([^>]*href=["\']https?:\/\/([^"\'\/]+)[^"\']*["\'][^>]*)>/i', function( $match ) use ( $host ) {
		$tag_host = strtolower( $match[2] );
		if ( strtolower( $host ) === $tag_host || str_ends_with( $tag_host, '.' . strtolower( $host ) ) ) { return $match[0]; }
		$attrs = $match[1]; if ( false === stripos( $attrs, 'rel=' ) ) { $attrs .= ' rel="noopener noreferrer"'; } if ( false === stripos( $attrs, 'target=' ) ) { $attrs .= ' target="_blank"'; } return '<a ' . $attrs . '>';
	}, $content );
}
add_filter( 'the_content', 'nob_external_link_attributes', 25 );
function nob_robots_policy( $robots ) {
	$should_noindex = is_search() || is_404();
	if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() ) ) { $should_noindex = true; }
	if ( $should_noindex ) { $robots['noindex'] = true; $robots['follow'] = true; }
	return $robots;
}
add_filter( 'wp_robots', 'nob_robots_policy' );
