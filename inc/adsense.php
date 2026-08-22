<?php
/** AdSense-safe manual ad zones. */
if ( ! defined( 'ABSPATH' ) ) { exit; }
function nob_sanitize_adsense_client( $value ) { $value = trim( (string) $value ); return preg_match( '/^ca-pub-[0-9]{6,}$/', $value ) ? $value : ''; }
function nob_sanitize_ad_slot( $value ) { $value = preg_replace( '/[^0-9]/', '', (string) $value ); return strlen( $value ) >= 5 ? $value : ''; }
function nob_adsense_customize_register( $wp_customize ) {
	$wp_customize->add_section( 'nob_adsense', array( 'title' => __( 'AdSense placements', 'notonlybook-modern' ), 'description' => __( 'Optional manual ad units. Keep Site Kit/AdSense privacy messaging configured separately. Ads are never placed on search, 404, checkout, cart, account or standard pages.', 'notonlybook-modern' ), 'priority' => 160 ) );
	$settings = array(
		'nob_adsense_client' => array( __( 'Publisher client (ca-pub-…)', 'notonlybook-modern' ), 'nob_sanitize_adsense_client' ),
		'nob_ad_home_mid' => array( __( 'Homepage mid-content slot ID', 'notonlybook-modern' ), 'nob_sanitize_ad_slot' ),
		'nob_ad_article_end' => array( __( 'Article end slot ID', 'notonlybook-modern' ), 'nob_sanitize_ad_slot' ),
		'nob_ad_sidebar' => array( __( 'Article sidebar slot ID', 'notonlybook-modern' ), 'nob_sanitize_ad_slot' ),
	);
	foreach ( $settings as $id => $setting ) { $wp_customize->add_setting( $id, array( 'default' => '', 'sanitize_callback' => $setting[1] ) ); $wp_customize->add_control( $id, array( 'label' => $setting[0], 'section' => 'nob_adsense', 'type' => 'text' ) ); }
}
add_action( 'customize_register', 'nob_adsense_customize_register' );
function nob_manual_ads_enabled() { return get_theme_mod( 'nob_adsense_client', '' ) && array_filter( array( get_theme_mod( 'nob_ad_home_mid', '' ), get_theme_mod( 'nob_ad_article_end', '' ), get_theme_mod( 'nob_ad_sidebar', '' ) ) ); }
function nob_adsense_head() { if ( is_admin() || ! nob_manual_ads_enabled() ) { return; } $client = get_theme_mod( 'nob_adsense_client', '' ); printf( '<script async src="%1$s" crossorigin="anonymous"></script>' . "\n", esc_url( 'https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=' . rawurlencode( $client ) ) ); }
add_action( 'wp_head', 'nob_adsense_head', 20 );
function nob_render_ad( $placement ) {
	$allowed = array( 'home_mid' => 'nob_ad_home_mid', 'article_end' => 'nob_ad_article_end', 'sidebar' => 'nob_ad_sidebar' );
	if ( empty( $allowed[ $placement ] ) || is_search() || is_404() || is_attachment() ) { return; }
	if ( function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() ) ) { return; }
	if ( 'home_mid' === $placement && ! is_front_page() ) { return; }
	if ( in_array( $placement, array( 'article_end', 'sidebar' ), true ) && ! is_singular( 'post' ) ) { return; }
	$client = get_theme_mod( 'nob_adsense_client', '' ); $slot = get_theme_mod( $allowed[ $placement ], '' ); if ( ! $client || ! $slot ) { return; }
	?><div class="nob-ad nob-ad--<?php echo esc_attr( str_replace( '_', '-', $placement ) ); ?>" role="complementary" aria-label="<?php esc_attr_e( 'Advertisement', 'notonlybook-modern' ); ?>"><div class="nob-ad-label"><?php esc_html_e( 'Advertisement', 'notonlybook-modern' ); ?></div><ins class="adsbygoogle" style="display:block" data-ad-client="<?php echo esc_attr( $client ); ?>" data-ad-slot="<?php echo esc_attr( $slot ); ?>" data-ad-format="auto" data-full-width-responsive="true"></ins></div><script>(window.adsbygoogle=window.adsbygoogle||[]).push({});</script><?php
}
