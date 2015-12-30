<?php

// ========================
// http://wordpress.stackexchange.com/a/182023/76002
// Add all required styles of parent before child.
//
// The idea is to simply filter the call to get_stylesheet_uri() in the parent
// theme to return it's own stylesheet instead of the child theme's.
// The child theme's stylesheet is then enqueued later in the action hook my_theme_styles.
// ========================

// Filter get_stylesheet_uri() to return the parent theme's stylesheet 
add_filter('stylesheet_uri', 'use_parent_theme_stylesheet');
function use_parent_theme_stylesheet() {
    // Use the parent theme's stylesheet
    return get_template_directory_uri() . '/style.css';
}

// Enqueue this theme's scripts and styles (after parent theme)
add_action('wp_enqueue_scripts', 'my_theme_styles', 20);
function my_theme_styles() {
    $themeVersion = wp_get_theme()->get('Version');

    // Enqueue our style.css with our own version
    wp_enqueue_style('child-theme-style', get_stylesheet_directory_uri() . '/style.css', array(), $themeVersion);
}





require get_stylesheet_directory() . '/inc/template-tags.php'; # Contains functions that output HTML

function d_flat_logo() {
	$header_display = flat_get_theme_option( 'header_display', 'site_title' );

	if ( 'both_title_logo' === $header_display ) {
		$header_class = 'display-title-logo';
	} else if ( 'site_logo' === $header_display ) {
		$header_class = 'display-logo';
	} else {
		$header_class = 'display-title';
	}

	$logo = esc_url( flat_get_theme_option( 'logo' ) );
	$tagline = get_bloginfo( 'description' );

	echo '<h1 class="site-title ' . esc_attr( $header_class ) . '"><a href="' . esc_url( home_url( '/' ) ) . '" title="'. esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">';

	if ( 'display-title' !== $header_class ) {
		echo '<img alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" src="' . esc_attr( $logo ) . '" />';
	}
	if ( 'display-logo' !== $header_class ) {
		echo '<span>' . esc_attr( get_bloginfo( 'name' ) ) . '</span>';
	}

	echo '</a></h1>';

	if ( $tagline ) {
		echo '<h2 class="site-description">' . esc_attr( $tagline ) . '</h2>';
	}
}