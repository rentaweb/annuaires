<?php
defined( 'ABSPATH' ) or	die( __( 'Cheatin&#8217; uh?', 'rocket' ) );


/**
 * Renew all boxes for everyone if $uid is missing
 *
 * @since 1.1.10
 * @modified 2.1 : 
 *	- Better usage of delete_user_meta into delete_metadata
 *
 * @param (int|null)$uid : a User id, can be null, null = all users
 * @param (string|array)$keep_this : which box have to be kept
 */

function rocket_renew_all_boxes( $uid = null, $keep_this = array() )
{

	// Delete a user meta for 1 user or all at a time
	delete_metadata( 'user', $uid, 'rocket_boxes', null == $uid );

	// $keep_this works only for the current user
	if ( ! empty( $keep_this ) && null != $uid ) {
		if ( is_array( $keep_this ) ) {
			foreach ( $keep_this as $kt ) {
				rocket_dismiss_box( $kt );
			}
		} else {
			rocket_dismiss_box( $keep_this );
		}
	}

}



/**
 * Renew a dismissed error box admin side
 *
 * @since 1.1.10
 *
 */

function rocket_renew_box( $function, $uid = 0 )
{
	global $current_user;
	$uid = $uid == 0 ? $current_user->ID : $uid;
	$actual = get_user_meta( $uid, 'rocket_boxes', true );

	if ( $actual ) {
		unset( $actual[ array_search( $function, $actual ) ] );
		update_user_meta( $uid, 'rocket_boxes', $actual );
	}

}


/**
 * Is this version White Labeled?
 *
 * @since 2.1
 *
 */

function rocket_is_white_label()
{
	$names = array( 'wl_plugin_name', 'wl_plugin_URI', 'wl_description', 'wl_author', 'wl_author_URI' );
	$options = '';
	foreach( $names as $value )
	{
		$options .= !is_array( get_rocket_option( $value ) ) ? get_rocket_option( $value ) : reset( ( get_rocket_option( $value ) ) );
	}
	return 'a509cac94e0cd8238b250074fe802b90' != md5( $options );
}


/**
 * Create a unique id for some Rocket options and functions
 *
 * @since 2.1
 *
 */

function create_rocket_uniqid()
{
	return str_replace( '.', '', uniqid( '', true ) );
}