<?php
defined( 'ABSPATH' ) or	die( __( 'Cheatin&#8217; uh?', 'rocket' ) );


/**
 * Link to the configuration page of the plugin
 *
 * Since 1.0
 *
 */

add_filter( 'plugin_action_links_'.plugin_basename( WP_ROCKET_FILE ), 'rocket_settings_action_links' );
function rocket_settings_action_links( $actions )
{
    array_unshift( $actions, '<a href="' . admin_url( 'options-general.php?page='.WP_ROCKET_PLUGIN_SLUG ) . '">' . __( 'Settings' ) . '</a>' );
    return $actions;
}


/**
 * Add a link "Purge this cache" in the post edit area
 *
 * since 1.0
 *
 */

add_filter( 'page_row_actions', 'rocket_row_actions', 10, 2 );
add_filter( 'post_row_actions', 'rocket_row_actions', 10, 2 );
function rocket_row_actions( $actions, $post )
{
	if( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) )
	{
		$url = wp_nonce_url( admin_url( 'admin-post.php?action=purge_cache&type=post-'.$post->ID ), 'purge_cache_post-'.$post->ID );
	    $actions['rocket_purge'] = '<a href="'.$url.'">' . __ ( 'Clear this cache', 'rocket' ) . '</a>';
	}
    return $actions;
}



/**
 * Add a link "Purge cache" in the post submit area
 *
 * since 1.0
 *
 */

add_action( 'post_submitbox_start', 'rocket_post_submitbox_start' );
function rocket_post_submitbox_start()
{
	if ( current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) )
	{
		global $post;
		echo '<div id="purge-action"><a class="button-secondary" href="'.wp_nonce_url( admin_url( 'admin-post.php?action=purge_cache&type=post-' . $post->ID ), 'purge_cache_post-' . $post->ID ).'">'.__( 'Clear cache', 'rocket' ).'</a></div>';
	}
}



/**
 * Add the CSS and JS files for WP Rocket options page
 *
 * since 1.0.0
 *
 */

add_action( 'admin_print_styles-settings_page_'.WP_ROCKET_PLUGIN_SLUG, 'rocket_add_admin_css_js' );
function rocket_add_admin_css_js()
{
	wp_enqueue_script( 'jquery-ui-sortable', null, array( 'jquery', 'jquery-ui-core' ), null, true );
	wp_enqueue_script( 'jquery-ui-draggable', null, array( 'jquery', 'jquery-ui-core' ), null, true );
	wp_enqueue_script( 'jquery-ui-droppable', null, array( 'jquery', 'jquery-ui-core' ), null, true );
	wp_enqueue_script( 'options-wp-rocket', WP_ROCKET_ADMIN_JS_URL . 'options.js', array( 'jquery', 'jquery-ui-core' ), WP_ROCKET_VERSION, true );
	wp_enqueue_script( 'fancybox-wp-rocket', WP_ROCKET_ADMIN_JS_URL . '/vendors/jquery.fancybox.pack.js', array( 'options-wp-rocket' ), WP_ROCKET_VERSION, true );
	wp_enqueue_style( 'options-wp-rocket', WP_ROCKET_ADMIN_CSS_URL . 'options.css', array(), WP_ROCKET_VERSION );
	wp_enqueue_style( 'fancybox-wp-rocket', WP_ROCKET_ADMIN_CSS_URL . 'fancybox/jquery.fancybox.css', array( 'options-wp-rocket' ), WP_ROCKET_VERSION );
}



/**
 * Add the CSS and JS files needed by WP Rocket everywhere on admin pages
 *
 * since 2.1
 *
 */

add_action( 'admin_print_styles', 'rocket_add_admin_css_js_everywhere', 11 );
function rocket_add_admin_css_js_everywhere()
{
	wp_enqueue_script( 'all-wp-rocket', WP_ROCKET_ADMIN_JS_URL . 'all.js', array( 'jquery' ), WP_ROCKET_VERSION, true );
}



/**
 * Add some CSS to display the dismiss cross
 *
 * since 1.1.10
 *
 */

add_action( 'admin_print_styles', 'rocket_admin_print_styles' );
function rocket_admin_print_styles()
{
	wp_enqueue_style( 'admin-wp-rocket', WP_ROCKET_ADMIN_CSS_URL . 'admin.css', array(), WP_ROCKET_VERSION );
}



/**
 // copied from core to reduct backcompat to 3.1 and not 3.5
 * Send a JSON response back to an Ajax request.
 *
 * @since WordPress 3.5.0
 *
 * @param mixed $response Variable (usually an array or object) to encode as JSON, then print and die.
 */

if ( ! function_exists( 'wp_send_json' ) ) {
	function wp_send_json( $response ) {
		@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
		echo json_encode( $response );
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
			wp_die();
		else
			die;
	}
}

/**
 * Manage the dismissed boxes
 *
 * since 1.3.0 $args can replace $_GET when called internaly
 * since 1.1.10
 *
 */

add_action( 'wp_ajax_rocket_ignore', 'rocket_dismiss_boxes' );
add_action( 'admin_post_rocket_ignore', 'rocket_dismiss_boxes' );
function rocket_dismiss_boxes( $args )
{
	$args = empty( $args ) ? $_GET : $args;
	if ( isset( $args['box'], $args['_wpnonce'] ) ) {

		if ( ! wp_verify_nonce( $args['_wpnonce'], $args['action'] . '_' . $args['box'] ) ) {
			if ( defined( 'DOING_AJAX' ) ) {
				wp_send_json( array( 'error'=>1 ) );
			} else { 
				wp_nonce_ays( '' );
			}
		}
		global $current_user;
		$actual = get_user_meta( $current_user->ID, 'rocket_boxes', true );
		update_user_meta( $current_user->ID, 'rocket_boxes', array_filter( array_merge( (array)$actual, array( $args['box'] ) ) ) );
		if( 'admin-post.php'==$GLOBALS['pagenow'] ){
			if ( defined( 'DOING_AJAX' ) ) {
				wp_send_json( array( 'error'=>0 ) );
			} else { 
				wp_safe_redirect( wp_get_referer() );
				die();
			}
		}
	}
}


/**
 * Dismissed 1 box, wrapper of rocket_dismiss_boxes()
 *
 * since 1.3.0
 *
 */

function rocket_dismiss_box( $function )
{
	rocket_dismiss_boxes( 
		array( 
			'box'      => $function, 
			'_wpnonce' => wp_create_nonce( 'rocket_ignore_'.$function ), 
			'action'   => 'rocket_ignore' 
		) 
	);
}



/**
 * Renew the plugin modification warning on plugin de/activation
 *
 * since 1.3.0
 *
 */

add_action( 'activated_plugin', 'rocket_dismiss_plugin_box' );
add_action( 'deactivated_plugin', 'rocket_dismiss_plugin_box' );
function rocket_dismiss_plugin_box( $plugin )
{
	if ( $plugin != plugin_basename( WP_ROCKET_FILE ) ) {
		rocket_renew_box( 'rocket_warning_plugin_modification' );
	}
}



/**
 * Display a prevention message when enabling or disabling a plugin can be in conflict with WP Rocket
 *
 * since 1.3.0
 *
 */

add_action( 'admin_post_deactivate_plugin', 'rocket_deactivate_plugin' );
function rocket_deactivate_plugin()
{

	$_plugin = $_GET['plugin'];

	if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'deactivate_plugin' ) ) {
		wp_nonce_ays( '' );
	}
	deactivate_plugins( $_plugin );

	wp_safe_redirect( wp_get_referer() );
	die();
}


/**
 * Reset white label options
 *
 * since 2.1
 *
 */

function rocket_reset_white_label_values( $hack_post )
{

		// White Label default values - !!! DO NOT TRANSLATE !!!
		$options = get_option( WP_ROCKET_SLUG );
		$options['wl_plugin_name']	= 'WP Rocket';
		$options['wl_plugin_slug']	= 'wprocket';
		$options['wl_plugin_URI']	= 'http://www.wp-rocket.me';
		$options['wl_description']	= array( 'The best WordPress performance plugin.' );
		$options['wl_author']		= 'WP Rocket';
		$options['wl_author_URI']	= 'http://www.wp-rocket.me';
		if ( $hack_post ) {
			// hack $_POST to force refresh of files, sorry
			$_POST['page'] = 'wprocket';
		}
		update_option( WP_ROCKET_SLUG, $options );

}

/**
 * Reset White Label values to WP Rocket default values
 *
 * since 2.1
 *
 */

add_action( 'admin_post_resetwl', '__rocket_reset_white_label_values_action' );
function __rocket_reset_white_label_values_action()
{
	if ( isset( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'resetwl' ) ) {
		rocket_reset_white_label_values( true );
	}
	wp_safe_redirect( add_query_arg( 'page', 'wprocket', remove_query_arg( 'page', wp_get_referer() ) ) );
	die();
}


/**
 * White Label the plugin, if you need to
 *
 * @since 2.1
 *
 */

add_filter( 'all_plugins', '__rocket_white_label' );
function __rocket_white_label( $plugins )
{

	// We change the plugin's header
	$plugins['wp-rocket/wp-rocket.php'] = array(
	      'Name' => get_rocket_option( 'wl_plugin_name' ),
	      'PluginURI' => get_rocket_option( 'wl_plugin_URI' ),
	      'Version' => isset( $plugins['wp-rocket/wp-rocket.php']['Version'] ) ? $plugins['wp-rocket/wp-rocket.php']['Version'] : '',
	      'Description' => reset( ( get_rocket_option( 'wl_description' ) ) ),
	      'Author' => get_rocket_option( 'wl_author' ),
	      'AuthorURI' => get_rocket_option( 'wl_author_URI' ),
	      'TextDomain' => isset( $plugins['wp-rocket/wp-rocket.php']['TextDomain'] ) ? $plugins['wp-rocket/wp-rocket.php']['TextDomain'] : '',
	      'DomainPath' => isset( $plugins['wp-rocket/wp-rocket.php']['DomainPath'] ) ? $plugins['wp-rocket/wp-rocket.php']['DomainPath'] : '',
	      );

	// if white label, remove our names from contributors
	if ( rocket_is_white_label() ) {
		remove_filter( 'plugin_row_meta', 'rocket_plugin_row_meta', 10, 2 );
	}

	return $plugins;
}


/**
 * When you're doing an update, the constant does not contain yet your option or any value, reset and redirect!
 *
 * @since 2.1
 *
 */

add_action( 'admin_init', '__rocket_check_no_empty_name', 11 );
function __rocket_check_no_empty_name()
{
	$wl_plugin_name = trim( get_rocket_option( 'wl_plugin_name' ) );
	if( empty( $wl_plugin_name ) ) {

		rocket_reset_white_label_values( false );
		
		wp_safe_redirect( $_SERVER['REQUEST_URI'] );

		die();		
	}
}