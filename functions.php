<?php
/**
 * NotOnlyBook Modern theme bootstrap.
 *
 * @package NotOnlyBook_Modern
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'NOB_THEME_VERSION', '1.1.0' );

require_once get_template_directory() . '/inc/template-tags.php';
require_once get_template_directory() . '/inc/adsense.php';
require_once get_template_directory() . '/inc/content-compat.php';
require_once get_template_directory() . '/inc/seo.php';
require_once get_template_directory() . '/inc/content-health.php';

function nob_theme_setup() {
	load_theme_textdomain( 'notonlybook-modern', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-logo', array( 'height' => 100, 'width' => 320, 'flex-height' => true, 'flex-width' => true ) );
	add_theme_support( 'html5', array( 'search-form','comment-form','comment-list','gallery','caption','style','script','navigation-widgets' ) );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'style.css' );
	add_theme_support( 'woocommerce' );
	register_nav_menus( array( 'primary' => __( 'Primary navigation', 'notonlybook-modern' ), 'footer' => __( 'Footer navigation', 'notonlybook-modern' ) ) );
	set_post_thumbnail_size( 1200, 675, true );
	add_image_size( 'nob-nav-thumb', 150, 150, true );
}
add_action( 'after_setup_theme', 'nob_theme_setup' );

function nob_enqueue_assets() {
	wp_enqueue_style( 'notonlybook-modern', get_stylesheet_uri(), array(), NOB_THEME_VERSION );
	wp_enqueue_script( 'notonlybook-modern', get_template_directory_uri() . '/assets/js/theme.js', array(), NOB_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'nob_enqueue_assets' );

function nob_defer_theme_script( $tag, $handle, $src ) {
	if ( 'notonlybook-modern' !== $handle ) { return $tag; }
	return '<script src="' . esc_url( $src ) . '" defer></script>';
}
add_filter( 'script_loader_tag', 'nob_defer_theme_script', 10, 3 );

function nob_register_sidebars() {
	register_sidebar( array(
		'name' => __( 'Article sidebar', 'notonlybook-modern' ), 'id' => 'article-sidebar',
		'description' => __( 'Widgets shown beside single articles. Ad space stays separate from navigation and download controls.', 'notonlybook-modern' ),
		'before_widget' => '<section id="%1$s" class="nob-widget %2$s">', 'after_widget' => '</section>', 'before_title' => '<h2>', 'after_title' => '</h2>',
	) );

	$ad_zones = array(
		'ad_top_post'       => __( 'Ad — Top Post', 'notonlybook-modern' ),
		'ad_incontent_1'    => __( 'Ad — In Content 1', 'notonlybook-modern' ),
		'ad_incontent_2'    => __( 'Ad — In Content 2', 'notonlybook-modern' ),
		'ad_sidebar_sticky' => __( 'Ad — Sidebar Sticky', 'notonlybook-modern' ),
		'ad_bottom_post'    => __( 'Ad — Bottom Post', 'notonlybook-modern' ),
		'ad_footer_anchor'  => __( 'Ad — Mobile Footer Anchor', 'notonlybook-modern' ),
	);

	foreach ( $ad_zones as $id => $name ) {
		register_sidebar( array(
			'name'          => $name,
			'id'            => $id,
			'description'   => __( 'Responsive advertising zone. Add a Custom HTML widget containing the AdSense unit code.', 'notonlybook-modern' ),
			'before_widget' => '<div id="%1$s" class="nob-ad-widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<span class="screen-reader-text">',
			'after_title'   => '</span>',
		) );
	}
}
add_action( 'widgets_init', 'nob_register_sidebars' );

function nob_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'nob_identity', array( 'title' => __( 'NotOnlyBook presentation', 'notonlybook-modern' ), 'priority' => 35 ) );
	$wp_customize->add_setting( 'nob_hero_title', array( 'default' => 'Study smarter. Find the right IGCSE resource faster.', 'sanitize_callback' => 'sanitize_text_field' ) );
	$wp_customize->add_control( 'nob_hero_title', array( 'label' => __( 'Homepage hero title', 'notonlybook-modern' ), 'section' => 'nob_identity', 'type' => 'text' ) );
	$wp_customize->add_setting( 'nob_hero_text', array( 'default' => 'Cambridge resources, books, notes, worksheets and past papers — organised for students, parents and educators.', 'sanitize_callback' => 'sanitize_textarea_field' ) );
	$wp_customize->add_control( 'nob_hero_text', array( 'label' => __( 'Homepage hero text', 'notonlybook-modern' ), 'section' => 'nob_identity', 'type' => 'textarea' ) );
}
add_action( 'customize_register', 'nob_customize_register' );

function nob_body_classes( $classes ) { if ( is_singular( 'post' ) ) { $classes[] = 'nob-single-post'; } return $classes; }
add_filter( 'body_class', 'nob_body_classes' );
function nob_excerpt_length( $length ) { return is_admin() ? $length : 24; }
add_filter( 'excerpt_length', 'nob_excerpt_length', 20 );
function nob_excerpt_more() { return '…'; }
add_filter( 'excerpt_more', 'nob_excerpt_more' );

function nob_fallback_menu() {
	$items = array(
		array( 'label' => __( 'Home', 'notonlybook-modern' ), 'url' => home_url( '/' ) ),
		array( 'label' => __( 'Past Papers', 'notonlybook-modern' ), 'url' => nob_category_url_by_name( 'Past Papers' ) ),
		array( 'label' => __( 'IGCSE Subjects', 'notonlybook-modern' ), 'url' => nob_category_url_by_name( 'IGCSE Subjects' ) ),
		array( 'label' => __( 'Math', 'notonlybook-modern' ), 'url' => nob_category_url_by_name( 'Math' ) ),
		array( 'label' => __( 'About', 'notonlybook-modern' ), 'url' => nob_page_url_by_slug( 'about-us' ) ),
		array( 'label' => __( 'Contact', 'notonlybook-modern' ), 'url' => nob_page_url_by_slug( 'contact-us' ) ),
	);
	echo '<ul>';
	foreach ( $items as $item ) { if ( ! empty( $item['url'] ) ) { printf( '<li><a href="%1$s">%2$s</a></li>', esc_url( $item['url'] ), esc_html( $item['label'] ) ); } }
	echo '</ul>';
}

function nob_clean_archive_title( $title ) {
	if ( is_category() ) { return single_cat_title( '', false ); }
	if ( is_tag() ) { return single_tag_title( '', false ); }
	return $title;
}
add_filter( 'get_the_archive_title', 'nob_clean_archive_title' );

/**
 * Force native lazy loading for non-priority content images and iframes.
 * The single-post hero remains explicitly eager/fetchpriority=high in single.php.
 */
function nob_lazy_load_content_media( $content ) {
	if ( is_admin() || ! is_singular( 'post' ) || false === stripos( $content, '<' ) ) { return $content; }
	$content = preg_replace( '/<img(?![^>]*\bloading=)([^>]*)>/i', '<img loading="lazy" decoding="async"$1>', $content );
	$content = preg_replace( '/<iframe(?![^>]*\bloading=)([^>]*)>/i', '<iframe loading="lazy"$1>', $content );
	return $content;
}
add_filter( 'the_content', 'nob_lazy_load_content_media', 8 );

function nob_capture_widget_area( $sidebar_id, $extra_class = '' ) {
	if ( ! is_active_sidebar( $sidebar_id ) ) { return ''; }
	ob_start();
	echo '<aside class="nob-ad-zone ' . esc_attr( $extra_class ) . '" data-ad-zone="' . esc_attr( $sidebar_id ) . '" aria-label="' . esc_attr__( 'Advertisement', 'notonlybook-modern' ) . '">';
	echo '<div class="nob-ad-label">' . esc_html__( 'Advertisement', 'notonlybook-modern' ) . '</div>';
	dynamic_sidebar( $sidebar_id );
	echo '</aside>';
	return (string) ob_get_clean();
}

function nob_render_widget_ad_area( $sidebar_id, $extra_class = '' ) {
	echo nob_capture_widget_area( $sidebar_id, $extra_class ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- dynamic_sidebar output is trusted widget markup.
}

function nob_plain_word_count( $html ) {
	$text = wp_strip_all_tags( $html, true );
	$text = preg_replace( '/\s+/u', ' ', trim( $text ) );
	if ( '' === $text ) { return 0; }
	return count( preg_split( '/\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY ) );
}

/**
 * Add an automatic TOC when the rendered article contains at least three H2 headings.
 */
function nob_add_automatic_toc( $content ) {
	if ( is_admin() || ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) { return $content; }
	if ( ! preg_match_all( '/<h2([^>]*)>(.*?)<\/h2>/is', $content, $matches, PREG_SET_ORDER ) || count( $matches ) < 3 ) { return $content; }

	$used = array();
	$items = array();
	foreach ( $matches as $match ) {
		$label = trim( wp_strip_all_tags( $match[2] ) );
		if ( '' === $label ) { continue; }
		$slug = sanitize_title( $label );
		if ( '' === $slug ) { $slug = 'section-' . ( count( $items ) + 1 ); }
		$base = $slug;
		$suffix = 2;
		while ( isset( $used[ $slug ] ) ) { $slug = $base . '-' . $suffix++; }
		$used[ $slug ] = true;
		$items[] = array( 'label' => $label, 'id' => $slug, 'original' => $match[0], 'attrs' => $match[1], 'inner' => $match[2] );
	}
	if ( count( $items ) < 3 ) { return $content; }

	foreach ( $items as $item ) {
		$attrs = preg_replace( '/\s+id=("|\').*?\1/i', '', $item['attrs'] );
		$replacement = '<h2' . $attrs . ' id="' . esc_attr( $item['id'] ) . '">' . $item['inner'] . '</h2>';
		$content = preg_replace( '/' . preg_quote( $item['original'], '/' ) . '/', addcslashes( $replacement, '\\$' ), $content, 1 );
	}

	$toc = '<nav class="nob-toc" aria-labelledby="nob-toc-title"><h2 id="nob-toc-title">' . esc_html__( 'Table of contents', 'notonlybook-modern' ) . '</h2><ol>';
	foreach ( $items as $item ) {
		$toc .= '<li><a href="#' . esc_attr( $item['id'] ) . '">' . esc_html( $item['label'] ) . '</a></li>';
	}
	$toc .= '</ol></nav>';
	return $toc . $content;
}
add_filter( 'the_content', 'nob_add_automatic_toc', 11 );

/**
 * Insert widget-controlled ads into article content while respecting a 300-word intro.
 * Requested paragraph targets are preserved where possible; safety rules win if content is shorter.
 */
function nob_insert_incontent_ads( $content ) {
	if ( is_admin() || ! is_singular( 'post' ) || ! in_the_loop() || ! is_main_query() ) { return $content; }
	$zones = array_filter( array(
		'ad_top_post'    => nob_capture_widget_area( 'ad_top_post', 'nob-ad-zone--top' ),
		'ad_incontent_1' => nob_capture_widget_area( 'ad_incontent_1', 'nob-ad-zone--incontent' ),
		'ad_incontent_2' => nob_capture_widget_area( 'ad_incontent_2', 'nob-ad-zone--incontent' ),
	) );
	if ( empty( $zones ) || ! preg_match_all( '/<p\b[^>]*>.*?<\/p>/is', $content, $paragraphs, PREG_OFFSET_CAPTURE ) ) { return $content; }

	$placements = array();
	$cumulative_words = 0;
	$last_position = 0;
	$paragraph_number = 0;
	$targets = array( 'ad_top_post' => 1, 'ad_incontent_1' => 2, 'ad_incontent_2' => 5 );
	$pending = array_keys( $zones );

	foreach ( $paragraphs[0] as $paragraph ) {
		$paragraph_number++;
		$cumulative_words += nob_plain_word_count( $paragraph[0] );
		if ( $cumulative_words < 300 ) { continue; }
		foreach ( $pending as $key => $zone_id ) {
			if ( $paragraph_number < $targets[ $zone_id ] ) { continue; }
			$position = $paragraph[1] + strlen( $paragraph[0] );
			if ( $position <= $last_position ) { continue; }
			$placements[] = array( 'position' => $position, 'html' => $zones[ $zone_id ] );
			$last_position = $position;
			unset( $pending[ $key ] );
			break;
		}
		if ( empty( $pending ) ) { break; }
	}

	usort( $placements, function( $a, $b ) { return $b['position'] <=> $a['position']; } );
	foreach ( $placements as $placement ) {
		$content = substr_replace( $content, $placement['html'], $placement['position'], 0 );
	}
	return $content;
}
add_filter( 'the_content', 'nob_insert_incontent_ads', 20 );
