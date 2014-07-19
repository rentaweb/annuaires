<?php
defined( 'ABSPATH' ) or	die( __( 'Cheatin&#8217; uh?', 'rocket' ) );


/*
 * Tell WP what to do when admin is loaded aka upgrader
 *
 * since 1.0
 *
 */

add_action( 'admin_init', 'rocket_upgrader' );
function rocket_upgrader()
{
	// Grab some infos
	$actual_version = get_rocket_option( 'version' );
	// You can hook the upgrader to trigger any action when WP Rocket is upgraded
	// first install
	if( !$actual_version )
	{
		do_action( 'wp_rocket_first_install' );
	}
	// already installed but got updated
	elseif( WP_ROCKET_VERSION != $actual_version )
	{
		do_action( 'wp_rocket_upgrade', WP_ROCKET_VERSION, $actual_version );
	}

	// If any upgrade has been done, we flush and update version #
	if( did_action( 'wp_rocket_first_install' ) || did_action( 'wp_rocket_upgrade' ) )
	{
		flush_rocket_htaccess();
		flush_rewrite_rules();
		rocket_renew_all_boxes( 0, 'rocket_warning_plugin_modification' );
		$options = get_option( WP_ROCKET_SLUG ); // do not use get_rocket_option() here
		$options['version'] = WP_ROCKET_VERSION;

		if( isset( $options['consumer_key'] ) && $options['consumer_key']==hash( 'crc32', rocket_get_domain( home_url() ) ) )
		{
			$response = wp_remote_get( WP_ROCKET_WEB_VALID, array( 'timeout'=>30 ) );
			if( !is_a($response, 'WP_Error') && strlen( $response['body'] )==32 )
				$options['secret_key'] = $response['body'];
		}


		update_option( WP_ROCKET_SLUG, $options );

	}

	if( !rocket_valid_key() && current_user_can( apply_filters( 'rocket_capacity', 'manage_options' ) ) )
	{
		add_action( 'admin_notices', 'rocket_need_api_key' );
		add_filter( 'rocket_pointer_apikey', '__return_true' );
	}

}

/* BEGIN UPGRADER'S HOOKS */

/**
 * Keeps this function up to date at each version
 *
 * since 1.0
 *
 */

add_action( 'wp_rocket_first_install', 'rocket_first_install' );
function rocket_first_install()
{

	// Generate an random key for cache dir of user
	$secret_cache_key = create_rocket_uniqid();

	// Generate an random key for minify md5 filename
	$minify_css_key = create_rocket_uniqid();
	$minify_js_key = create_rocket_uniqid();

	// Create Option
	add_option( WP_ROCKET_SLUG,
		array(
			'secret_cache_key'		=> $secret_cache_key,
			'cache_mobile'			=> 0,
			'cache_logged_user'		=> 0,
			'cache_ssl'				=> 0,
			'cache_reject_uri'		=> array(),
			'cache_reject_cookies'	=> array(),
			'cache_purge_pages'		=> array(),
			'purge_cron_interval'	=> 24,
			'purge_cron_unit'		=> 'HOUR_IN_SECONDS',
			'exclude_css'			=> array(),
			'exclude_js'			=> array(),
			'deferred_js_files'		=> array(),
			'deferred_js_wait'		=> array(),
			'lazyload'				=> 0,
			'minify_css'			=> 0,
			'minify_css_key'		=> $minify_css_key,
			'minify_js'				=> 0,
			'minify_js_key'			=> $minify_js_key,
			'minify_html'			=> 0,
			'dns_prefetch'			=> 0,
			'cdn'					=> 0,
			'cdn_cnames'			=> array(),
			'cdn_zone'		=> array()
		)
	);
	rocket_dismiss_box( 'rocket_warning_plugin_modification' );
	rocket_reset_white_label_values( false );

}



/**
 * What to do when Rocket is updated, depending on versions
 *
 * since 1.0
 *
 */

add_action( 'wp_rocket_upgrade', 'rocket_new_upgrade', 10, 2 );
function rocket_new_upgrade( $wp_rocket_version, $actual_version )
{

	if( version_compare( $actual_version, '1.0.1', '<' ) )
	{
		wp_clear_scheduled_hook( 'rocket_check_event' );
	}

	if( version_compare( $actual_version, '1.2.0', '<' ) )
	{
		// Delete old WP Rocket cache dir
		rocket_rrmdir( WP_ROCKET_PATH . 'cache' );

		// Create new WP Rocket cache dir
		if( !is_dir( WP_ROCKET_CACHE_PATH ) )
			mkdir( WP_ROCKET_CACHE_PATH );
	}

	if( version_compare( $actual_version, '1.3.0', '<' ) )
	{
		rocket_dismiss_boxes( array( 'box'=>'rocket_warning_plugin_modification', '_wpnonce'=>wp_create_nonce( 'rocket_ignore_rocket_warning_plugin_modification' ), 'action'=>'rocket_ignore' ) );
	}

	if( version_compare( $actual_version, '1.3.3', '<' ) )
	{

		// Clean cache
		rocket_clean_domain();

		// Create cache files
		run_rocket_bot( 'cache-preload' );
	}

	if( version_compare( $actual_version, '2.0', '<' ) )
	{

		// Add secret cache key
		$options = get_option( WP_ROCKET_SLUG );
		$options['secret_cache_key'] = create_rocket_uniqid();
		update_option( WP_ROCKET_SLUG, $options );

		global $wp_filesystem;
	    if( !$wp_filesystem )
	    {
			require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php' );
			require_once( ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php' );
			$wp_filesystem = new WP_Filesystem_Direct( new StdClass() );
		}

		// Get chmod of old folder cache
		$chmod = is_dir( WP_CONTENT_DIR . '/wp-rocket-cache' ) ? substr( sprintf( '%o', fileperms( WP_CONTENT_DIR . '/wp-rocket-cache' ) ), -4 ) : CHMOD_WP_ROCKET_CACHE_DIRS;

		// Check and create cache folder in wp-content if not already exist
		if( !$wp_filesystem->is_dir( WP_CONTENT_DIR . '/cache' ) )
			$wp_filesystem->mkdir( WP_CONTENT_DIR . '/cache' , octdec($chmod) );

		$wp_filesystem->mkdir( WP_CONTENT_DIR . '/cache/wp-rocket' , octdec($chmod) );

		// Move old cache folder in new path
		@rename( WP_CONTENT_DIR . '/wp-rocket-cache', WP_CONTENT_DIR . '/cache/wp-rocket'  );

		// Add WP_CACHE constant in wp-config.php
		set_rocket_wp_cache_define( true );

		// Create advanced-cache.php file
		rocket_generate_advanced_cache_file();

		// Create config file
		rocket_generate_config_file();

	}

	if( version_compare( $actual_version, '2.1', '<' ) )
	{

		rocket_reset_white_label_values( false );
		
		// Create minify cache folder if not exist
	    if( !is_dir( WP_ROCKET_MINIFY_CACHE_PATH ) ) {
			rocket_mkdir_p( WP_ROCKET_MINIFY_CACHE_PATH );
	    }
		
		// Create config domain folder if not exist
	    if( !is_dir( WP_ROCKET_CONFIG_PATH ) ) {
			rocket_mkdir_p( WP_ROCKET_CONFIG_PATH );
	    }
	    
	    // Create advanced-cache.php file
		rocket_generate_advanced_cache_file();
	    
	    // Create config file
		rocket_generate_config_file();
		
	}

}


/* END UPGRADER'S HOOKS */