<?php
defined( 'ABSPATH' ) or	die( __( 'Cheatin&#8217; uh?', 'rocket' ) );


/*
 * Replace URL by CDN of all thumbnails and smilies.
 *
 * @since 2.1
 *
 */

add_filter( 'wp_get_attachment_url'	, 'rocket_cdn_file', PHP_INT_MAX );
add_filter( 'smilies_src'			, 'rocket_cdn_file', PHP_INT_MAX );
add_filter( 'stylesheet_uri'		, 'rocket_cdn_file', PHP_INT_MAX );
// If for some completely unknown reason the user is using WP Minify or Better WordPress Minify instead of the WP Rocket minification
add_filter( 'wp_minify_css_url'		, 'rocket_cdn_file', PHP_INT_MAX );
add_filter( 'wp_minify_js_url'		, 'rocket_cdn_file', PHP_INT_MAX );
add_filter( 'bwp_get_minify_src'	, 'rocket_cdn_file', PHP_INT_MAX );
function rocket_cdn_file( $url )
{

	$filter = current_filter();
	switch ( $filter ) {
		
		case 'wp_get_attachment_url':
		case 'smilies_src':

			$zone = array( 'all', 'images' );
			break;

		case 'stylesheet_uri':
		case 'wp_minify_css_url':
		case 'wp_minify_js_url':
		case 'bwp_get_minify_src':

			$zone = array( 'all', 'css_and_js' );
			break;

	}

	if ( ! is_admin() && $cnames = get_rocket_cdn_cnames( $zone ) ) {
		$url = get_rocket_cdn_url( $url, $zone );
	}

	return $url;

}



/*
 * Replace URL by CDN of all images display in a post content or a widget text.
 *
 * @since 2.1
 *
 */

add_filter( 'the_content', 'rocket_cdn_images', PHP_INT_MAX );
add_filter( 'widget_text', 'rocket_cdn_images', PHP_INT_MAX );
function rocket_cdn_images( $html )
{

	// Don't use CDN if the image is in admin, a feed or in a post preview
	if ( is_admin() || is_feed() || is_preview() || empty( $html ) ) {
		return $html;
	}

	$zone = array( 'all', 'images' );
	if ( $cnames = get_rocket_cdn_cnames( $zone ) ) {

		// Get all images of the content
		preg_match_all( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#i', $html, $images_match );

		foreach ( $images_match[2] as $k=>$image_url ) {

			// Get host of the URL
			$image_host = parse_url( $image_url, PHP_URL_HOST );

			// Check if the link isn't external
			if( empty( $image_host ) || $image_host == rocket_remove_url_protocol( home_url() ) ) {

				$html = str_replace(
					$images_match[0][$k],
					sprintf(
						'<img %1$s %2$s %3$s />',
						$images_match[1][$k],
						'src="' . get_rocket_cdn_url( $image_url, $zone ) .'"',
						$images_match[3][$k]
					),
					$html
				);

			}

		}

	}

	return $html;

}



/*
 * Replace URL by CDN of all scripts and styles enqueues with WordPress functions
 *
 * @since 2.1
 *
 */

add_filter( 'style_loader_src', 'rocket_cdn_enqueue', PHP_INT_MAX );
add_filter( 'script_loader_src', 'rocket_cdn_enqueue', PHP_INT_MAX );
function rocket_cdn_enqueue( $src )
{

	global $pagenow;
	
	// Don't use CDN if in admin, in login page, in register page or in a post preview
	if ( is_admin() || is_preview() || in_array( $pagenow, array('wp-login.php', 'wp-register.php' ) ) ) {
		return $src;
	}

	$zone = array( 'all', 'css_and_js' );
	if ( $cnames = get_rocket_cdn_cnames( $zone ) ) {

		// Get host of the URL
		$src_host = parse_url( $src, PHP_URL_HOST );

		// Check if the link isn't external
		if ( empty( $src_host ) || $src_host == rocket_remove_url_protocol( home_url() ) ) {
			$src = get_rocket_cdn_url( $src, $zone );
		}

	}

	return $src;

}