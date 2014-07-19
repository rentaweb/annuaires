<?php
defined( 'ABSPATH' ) or	die( __( 'Cheatin&#8217; uh?', 'rocket' ) );


/**
 * Remove tags of deferred JavaScript files 
 *
 * @since 1.3.0 This process is called via the new filter rocket_buffer
 * @since 1.1.0
 *
 */

add_filter( 'rocket_buffer', 'rocket_exclude_deferred_js', 11 );
function rocket_exclude_deferred_js( $buffer )
{

	// Get all JS files with this regex
	preg_match_all( '#<script.*src=[\'|"]([^\'|"]+\.js?.+)[\'|"].*></script>#iU', $buffer, $tags_match );
	
	if ( isset( $tags_match[0] ) ) {
	   
	    foreach ( $tags_match[0] as $i=>$tag ) {

			// Strip query args.
			$url = strtok( $tags_match[1][$i] , '?' );
			
			// Get all js files to remove
			$deferred_js_files = apply_filters( 'rocket_minify_deferred_js', get_rocket_option( 'deferred_js_files' ) );

			// Check if this file is deferred loading
			if ( in_array( $url, $deferred_js_files ) ) {
				$buffer = str_replace( $tag, '', $buffer );
			}
				
		}
    }

	return $buffer;
}



/**
 * Insert LABjs deferred process in footer
 *
 * @since 1.1.0
 *
 */

add_action( 'wp_footer', 'rocket_insert_deferred_js', PHP_INT_MAX );
function rocket_insert_deferred_js( $buffer )
{

	$labjs_src 	       = apply_filters( 'rocket_labjs_src', WP_ROCKET_FRONT_JS_URL . 'LAB.' . WP_ROCKET_LAB_JS_VERSION . '.min.js' );
	$labjs_options     = apply_filters( 'rocket_labjs_options', array( 'AlwaysPreserveOrder' => true ) );
	$deferred_js_files = apply_filters( 'rocket_labjs_deferred_js', get_rocket_option( 'deferred_js_files' ) );
	$deferred_js_wait  = apply_filters( 'rocket_labjs_deferred_wait', get_rocket_option( 'deferred_js_wait' ) );

	$defer  = '<script src="' . $labjs_src . '" data-no-minify="1"></script>';
	$defer .= '<script>';
	$defer .= '$LAB';
	
	// Set LABjs options
	// All options is available in http://labjs.com/documentation.php#optionsobject
	if ( count( $labjs_options ) ) {
		$defer .= '.setOptions(' . json_encode( $labjs_options ) . ')';	
	}

	foreach( $deferred_js_files as $k => $js ) {
		$wait 	= $deferred_js_wait[$k] == '1' ? '.wait(' . esc_js( apply_filters( 'rocket_labjs_wait_callback', false, $js ) ) . ')' : '';
		$defer .= '.script("' . esc_js( $js ) . '")' . $wait;
	}

	$defer .= ';</script>';
	echo $defer;
}