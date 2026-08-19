<?php
/**
 * NotOnlyBook Modern theme bootstrap.
 *
 * @package NotOnlyBook_Modern
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'NOB_THEME_VERSION', '1.0.0' );

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
}
add_action( 'after_setup_theme', 'nob_theme_setup' );

function nob_enqueue_assets() {
	wp_enqueue_style( 'notonlybook-modern', get_stylesheet_uri(), array(), NOB_THEME_VERSION );
	wp_enqueue_script( 'notonlybook-modern', get_template_directory_uri() . '/assets/js/theme.js', array(), NOB_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'nob_enqueue_assets' );

function nob_register_sidebars() {
	register_sidebar( array(
		'name' => __( 'Article sidebar', 'notonlybook-modern' ), 'id' => 'article-sidebar',
		'description' => __( 'Widgets shown beside single articles. Ad space stays separate from navigation and download controls.', 'notonlybook-modern' ),
		'before_widget' => '<section id="%1$s" class="nob-widget %2$s">', 'after_widget' => '</section>', 'before_title' => '<h2>', 'after_title' => '</h2>',
	) );
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
