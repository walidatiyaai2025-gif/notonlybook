<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
function nob_has_seo_plugin() { return defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'WPSEO_VERSION' ) || class_exists( 'RankMath' ) || class_exists( 'AIOSEO\\Plugin\\AIOSEO' ); }
function nob_meta_description() {
	if ( is_singular() ) { $description = get_the_excerpt(); if ( ! $description ) { $description = wp_trim_words( wp_strip_all_tags( get_post_field( 'post_content', get_queried_object_id() ) ), 28, '' ); } return $description; }
	if ( is_category() || is_tag() || is_tax() ) { return wp_strip_all_tags( term_description() ); }
	if ( is_front_page() ) { return get_bloginfo( 'description' ); }
	return '';
}
function nob_seo_head() {
	if ( nob_has_seo_plugin() || is_admin() || is_search() || is_404() ) { return; }
	$description = trim( nob_meta_description() );
	if ( $description ) { printf( '<meta name="description" content="%s">' . "\n", esc_attr( $description ) ); }
	if ( is_singular() ) {
		printf( '<meta property="og:type" content="%s">' . "\n", is_singular( 'post' ) ? 'article' : 'website' );
		printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( wp_strip_all_tags( get_the_title() ) ) );
		printf( '<meta property="og:url" content="%s">' . "\n", esc_url( get_permalink() ) );
		if ( $description ) { printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $description ) ); }
		if ( has_post_thumbnail() ) { $image = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' ); if ( $image ) { printf( '<meta property="og:image" content="%s">' . "\n", esc_url( $image ) ); } }
	}
	$schema = array( '@context' => 'https://schema.org', '@type' => 'WebSite', 'name' => get_bloginfo( 'name' ), 'url' => home_url( '/' ) );
	if ( is_singular( 'post' ) ) {
		$schema = array( '@context' => 'https://schema.org', '@type' => 'Article', 'headline' => wp_strip_all_tags( get_the_title() ), 'datePublished' => get_the_date( DATE_W3C ), 'dateModified' => get_the_modified_date( DATE_W3C ), 'mainEntityOfPage' => get_permalink(), 'author' => array( '@type' => 'Person', 'name' => get_the_author() ), 'publisher' => array( '@type' => 'Organization', 'name' => get_bloginfo( 'name' ) ) );
		if ( has_post_thumbnail() ) { $image = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' ); if ( $image ) { $schema['image'] = array( $image ); } }
	}
	echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'nob_seo_head', 6 );
