<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }

function nob_page_url_by_slug( $slug ) { $page = get_page_by_path( $slug ); return $page ? get_permalink( $page ) : ''; }
function nob_category_url_by_name( $name ) { $term = get_term_by( 'name', $name, 'category' ); return ( $term && ! is_wp_error( $term ) ) ? get_term_link( $term ) : ''; }

function nob_get_year_categories() {
	$categories = get_categories( array( 'hide_empty' => true, 'number' => 100 ) );
	$years = array();
	foreach ( $categories as $category ) {
		if ( preg_match( '/\bYear\s+([0-9]{1,2})\b/i', $category->name, $match ) ) {
			$number = (int) $match[1];
			if ( ! isset( $years[ $number ] ) || $category->count > $years[ $number ]->count ) { $years[ $number ] = $category; }
		}
	}
	ksort( $years, SORT_NUMERIC ); return $years;
}

function nob_get_featured_topics() {
	$preferred = array( 'Past Papers','IGCSE Subjects','Math','Physic-0625','Chemistry','BIOLOGY -9','Accounting 0452','WorkSheets' );
	$items = array();
	foreach ( $preferred as $name ) { $term = get_term_by( 'name', $name, 'category' ); if ( $term && ! is_wp_error( $term ) && $term->count > 0 ) { $items[ $term->term_id ] = $term; } }
	if ( count( $items ) < 8 ) {
		foreach ( get_categories( array( 'hide_empty' => true, 'orderby' => 'count', 'order' => 'DESC', 'number' => 12 ) ) as $term ) {
			if ( 'Uncategorized' === $term->name ) { continue; }
			$items[ $term->term_id ] = $term; if ( count( $items ) >= 8 ) { break; }
		}
	}
	return array_slice( array_values( $items ), 0, 8 );
}

function nob_reading_time( $post_id = 0 ) { $post_id = $post_id ? $post_id : get_the_ID(); $content = get_post_field( 'post_content', $post_id ); $words = str_word_count( wp_strip_all_tags( strip_shortcodes( $content ) ) ); return max( 1, (int) ceil( $words / 220 ) ); }
function nob_primary_category( $post_id = 0 ) { $categories = get_the_category( $post_id ? $post_id : get_the_ID() ); if ( empty( $categories ) ) { return null; } usort( $categories, function( $a, $b ) { return $b->parent <=> $a->parent; } ); return $categories[0]; }

function nob_breadcrumbs() {
	if ( is_front_page() ) { return; }
	echo '<nav class="nob-breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'notonlybook-modern' ) . '"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'notonlybook-modern' ) . '</a><span aria-hidden="true">/</span>';
	if ( is_singular( 'post' ) ) { $category = nob_primary_category(); if ( $category ) { echo '<a href="' . esc_url( get_category_link( $category ) ) . '">' . esc_html( $category->name ) . '</a><span aria-hidden="true">/</span>'; } echo '<span aria-current="page">' . esc_html( wp_trim_words( get_the_title(), 8 ) ) . '</span>'; }
	elseif ( is_category() || is_tag() || is_tax() ) { echo '<span aria-current="page">' . esc_html( single_term_title( '', false ) ) . '</span>'; }
	elseif ( is_page() ) { echo '<span aria-current="page">' . esc_html( get_the_title() ) . '</span>'; }
	elseif ( is_search() ) { echo '<span aria-current="page">' . esc_html__( 'Search', 'notonlybook-modern' ) . '</span>'; }
	else { echo '<span aria-current="page">' . esc_html( wp_get_document_title() ) . '</span>'; }
	echo '</nav>';
}

function nob_legal_links() {
	$pages = array( 'privacy-policy' => __( 'Privacy Policy', 'notonlybook-modern' ), 'terms-and-conditions' => __( 'Terms & Conditions', 'notonlybook-modern' ), 'disclaimer' => __( 'Disclaimer', 'notonlybook-modern' ), 'about-us' => __( 'About Us', 'notonlybook-modern' ), 'contact-us' => __( 'Contact Us', 'notonlybook-modern' ) );
	echo '<ul>';
	foreach ( $pages as $slug => $label ) { $url = nob_page_url_by_slug( $slug ); if ( ! $url && 'disclaimer' === $slug ) { $url = nob_page_url_by_slug( 'privacy-policy-2-2disclaimer' ); } if ( $url ) { printf( '<li><a href="%1$s">%2$s</a></li>', esc_url( $url ), esc_html( $label ) ); } }
	echo '</ul>';
}

function nob_related_posts( $post_id, $limit = 3 ) { return new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'posts_per_page' => $limit, 'post__not_in' => array( $post_id ), 'category__in' => wp_get_post_categories( $post_id ), 'ignore_sticky_posts' => true, 'no_found_rows' => true ) ); }
