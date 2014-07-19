<?php
/*
Plugin Name: WP Google Maps - Visitor Generated Markers
Plugin URI: http://www.wpgmaps.com
Description: This is an add-on for WP Google Maps that allows your visitors to create and input markers on your maps.
Version: 2.0
Author: WP Google Maps
Author URI: http://www.wpgmaps.com
 *
 * 2.0
 * Code improvements
 * Users can now upload images with their markers
 * 
 * 1.9 Small bug fix
 * 
 * 1.8
 * Fixed a conflict with the NextGen plugin
 * 
 * 1.7
 * Fixed an error output bug
 * 
 * 1.6
 * Fixed a bug that stopped you from selecting "registered users"
 * 
 * 1.5
 * JS now included in it's own file and not in-line
 * Users can now select a category for their marker - you also have the option to enable or disable this
 * Coming soon:
 *  * Ability for users to add images
 *  * Ability for users to add icons
 * 
 * 1.4
 * Added user access roles (Who can add markers)
 * 
 * 1.3
 * This version allows the plugin to update itself moving forward
 * 
 * 1.2
 * Fixed a bug that was stopping the plugin from working on IIS servers
 * 
 * 1.1
 * Fixed a bug whereby users that weren't logged in couldnt add a marker
 *
 * 1.0
 * Released: 28 August 2012
 *
 *
 *
*/

global $wpgmza_ugm_version;
$wpgmza_ugm_version = "2.0";
$wpgmza_ugm_string = "ugm";


register_activation_hook( __FILE__, 'wpgmaps_ugm_activate' );
register_deactivation_hook( __FILE__, 'wpgmaps_ugm_deactivate' );
add_action('init', 'wpgmza_register_ugm_version');
add_action('admin_head', 'wpgmaps_head_ugm');
add_action('init', 'wpgmaps_user_head_ugm');

function wpgmaps_ugm_activate() { wpgmza_cURL_response_ugm("activate"); }
function wpgmaps_ugm_deactivate() { wpgmza_cURL_response_ugm("deactivate"); }

add_action('wp_ajax_ugm_add_marker', 'wpgmaps_action_callback_ugm');
add_action('wp_ajax_nopriv_ugm_add_marker', 'wpgmaps_action_callback_ugm');

function wpgmza_register_ugm_version() {
    global $wpgmza_ugm_version;
    global $wpgmza_ugm_string;
    if (!get_option('WPGMZA_UGM')) {
        add_option('WPGMZA_UGM',array("version" => $wpgmza_ugm_version, "version_string" => $wpgmza_ugm_string));
    }
}


function wpgmza_cURL_response_ugm($action) {
    if (function_exists('curl_version')) {
        global $wpgmza_ugm_version;
        global $wpgmza_ugm_string;
        $request_url = "http://www.wpgmaps.com/api/rec.php?action=$action&dom=".$_SERVER['HTTP_HOST']."&ver=".$wpgmza_gold_version.$wpgmza_gold_string;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
    }

}


function wpgmza_ugm_addon_display_mapspage() {
    
    $res = wpgmza_get_map_data($_GET['map_id']);


    if ($res->ugm_enabled) { $wpgmza_ugm_enabled[$res->ugm_enabled] = "SELECTED"; } else { $wpgmza_ugm_enabled[2] = "SELECTED"; }
    if ($res->ugm_category_enabled) { $wpgmza_ugm_category_enabled[$res->ugm_category_enabled] = "SELECTED"; } else { $wpgmza_ugm_category_enabled[2] = "SELECTED"; }
    if ($res->ugm_access) { $wpgmza_ugm_access[$res->ugm_access] = "SELECTED"; } else { $wpgmza_ugm_access[2] = "SELECTED"; }

    for ($i=0;$i<3;$i++) {
        if (!isset($wpgmza_ugm_enabled[$i])) { $wpgmza_ugm_enabled[$i] = ""; }
    }
    for ($i=0;$i<3;$i++) {
        if (!isset($wpgmza_ugm_category_enabled[$i])) { $wpgmza_ugm_category_enabled[$i] = ""; }
    }
    for ($i=0;$i<3;$i++) {
        if (!isset($wpgmza_ugm_access[$i])) { $wpgmza_ugm_access[$i] = ""; }
    }
    
    $map_other_settings = maybe_unserialize($res->other_settings);
    if (isset($map_other_settings['wpgmza_ugm_upload_images'])) { $wpgmza_ugm_upload_images[1] = "SELECTED"; } else { $wpgmza_ugm_upload_images[2] = "SELECTED"; }
    for ($i=0;$i<3;$i++) {
        if (!isset($wpgmza_ugm_upload_images[$i])) { $wpgmza_ugm_upload_images[$i] = ""; }
    }

        

    $ret = "
        <div style=\"display:block; overflow:auto; background-color:#FFFBCC; padding:10px; border:1px solid #E6DB55; margin-top:35px; margin-bottom:5px;\">
            <h2 style=\"padding-top:0; margin-top:0;\">".__("Visitor Generated Markers - Settings","wp-google-maps")."</h2>
            <p></p>
                <form action='' method='post' id='wpgmaps_ugm_map_options'>
                    <table>
                    <input type=\"hidden\" name=\"wpgmza_map_id\" id=\"wpgmza_map_id\" value=\"".$_GET['map_id']."\" />
                        <tr style='margin-bottom:10px;'>
                            <td>".__("Enable Visitor Generated Markers?","wp-google-maps")."</td>
                            <td>
                                <select id='wpgmza_ugm_enbaled' name='wpgmza_ugm_enbaled'>
                                    <option value=\"1\" ".$wpgmza_ugm_enabled[1].">".__("Yes","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_ugm_enabled[2].">".__("No","wp-google-maps")."</option>
                                </select>
                            </td>
                         </tr>
                        <tr style='margin-bottom:10px;'>
                            <td>".__("Who can add markers?","wp-google-maps")."</td>
                            <td>
                                <select id='wpgmza_ugm_access' name='wpgmza_ugm_access'>
                                    <option value=\"1\" ".$wpgmza_ugm_access[1].">".__("Everyone","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_ugm_access[2].">".__("Registered Users","wp-google-maps")."</option>
                                </select>
                            </td>
                         </tr>
                        <tr style='margin-bottom:20px;'>
                            <td>".__("Allow users to select a marker category?","wp-google-maps")."</td>
                            <td>
                                <select id='wpgmza_ugm_category_enbaled' name='wpgmza_ugm_category_enbaled'>
                                    <option value=\"1\" ".$wpgmza_ugm_category_enabled[1].">".__("Yes","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_ugm_category_enabled[2].">".__("No","wp-google-maps")."</option>
                                </select>
                            </td>
                         </tr>
                        <tr style='margin-bottom:20px;'>
                            <td>".__("Allow users to upload images?","wp-google-maps")."</td>
                            <td>
                                <select id='wpgmza_ugm_upload_images' name='wpgmza_ugm_upload_images'>
                                    <option value=\"1\" ".$wpgmza_ugm_upload_images[1].">".__("Yes","wp-google-maps")."</option>
                                    <option value=\"2\" ".$wpgmza_ugm_upload_images[2].">".__("No","wp-google-maps")."</option>
                                </select>
                            </td>
                         </tr>
                         
                     </table>
                    <p class='submit'><input type='submit' name='wpgmza_save_ugm_settings' value='".__("Save Settings","wp-google-maps")." &raquo;' /></p>
                </form>
        </div>
    ";
    return $ret;


}
function wpgmaps_head_ugm() {
   if (isset($_POST['wpgmza_save_ugm_settings'])){

        global $wpdb;
        global $wpgmza_tblname_maps;

        $map_id = $_POST['wpgmza_map_id'];
        $ugm_enabled = esc_attr($_POST['wpgmza_ugm_enbaled']);
        $ugm_category_enabled = esc_attr($_POST['wpgmza_ugm_category_enbaled']);
        $ugm_access = esc_attr($_POST['wpgmza_ugm_access']);
        
        $res = wpgmza_get_map_data($map_id);
        $other_settings = maybe_unserialize($res->other_settings);
        $other_settings['wpgmza_ugm_upload_images'] = intval($_POST['wpgmza_ugm_upload_images']);
        
        $other_settings = maybe_serialize($other_settings);
        
        
        
        $rows_affected = $wpdb->query( $wpdb->prepare(
                "UPDATE $wpgmza_tblname_maps SET
                ugm_enabled = %d,
                ugm_category_enabled = %d,
                ugm_access = %d,
                other_settings = %s
                WHERE id = %d",

                $ugm_enabled,
                $ugm_category_enabled,
                $ugm_access,
                $other_settings,
                $map_id)
        );

    echo "
    <div class='updated'>
        Your User Generated Marker Settings have been saved.
    </div>
    ";
   }
}



function wpgmaps_ugm_user_form($mapid) {
    global $wpdb;
    global $wpgmza_tblname_maps;
    global $current_user;
    
    $results = $wpdb->get_results("
        SELECT *
        FROM $wpgmza_tblname_maps
        WHERE `id` = '$mapid' LIMIT 1
    ");
    

    foreach ( $results as $result ) {
        
        $other_settings = maybe_unserialize($result->other_settings);
        $upload_images = $other_settings['wpgmza_ugm_upload_images'];
        
        $ugm_access = $result->ugm_access;
        if (isset($ugm_access) && $ugm_access == 2) { // only registered users can add markers
            if ( is_user_logged_in() ) {
            
                $userRole = ($current_user->roles);
                switch($userRole) {
                    
                    case ('administrator'||'editor'||'contributor'||'author'||'subscriber'):
                            $ugm_display = true;
                    break;
                    default:
                    break;
                }
            } else {
                $ugm_display = false;
            }
        } else {
            $ugm_display = true;
        }
    }
    if ($ugm_display) {
        $r_msg = "<h2 style=\"clear:both;\">Add your own marker</h2>";
        $r_msg .= " <form action=\"\" method=\"POST\" name=\"wpgmaps_ugm\" class=\"wpgmaps_user_form\" enctype=\"multipart/form-data\">";
        $r_msg .= "     <input type=\"hidden\" name=\"wpgmza_ugm_map_id\" id=\"wpgmza_ugm_map_id\" value=\"$mapid\" />";
        $r_msg .= "     <input type=\"hidden\" name=\"wpgmza_ugm_lat\" id=\"wpgmza_ugm_lat\" value=\"\" />";
        $r_msg .= "     <input type=\"hidden\" name=\"wpgmza_ugm_lng\" id=\"wpgmza_ugm_lng\" value=\"\" />";
        $r_msg .= "     <table class='wpgmza_table' style='border:0 !important; width:100%;'>";
        $r_msg .= "         <tr>";
        $r_msg .= "             <td valign=\"top\">".__("Marker Title","wp-google-maps")."</td>";
        $r_msg .= "             <td><input id='wpgmza_ugm_add_title' name='wpgmza_ugm_add_title' type='text' size='35' maxlength='200' value='' /></td>";
        $r_msg .= "         </tr>";
        $r_msg .= "         <tr>";
        $r_msg .= "             <td valign=\"top\">".__("Marker Address or GPS Location","wp-google-maps")."</td>";
        $r_msg .= "             <td><input id='wpgmza_ugm_add_address' name='wpgmza_ugm_add_address' type='text' size='35' maxlength='200' value='' /></td>";
        $r_msg .= "         </tr>";
        $r_msg .= "         <tr>";
        $r_msg .= "             <td valign=\"top\">".__("Marker Description","wp-google-maps")."</td>";
        $r_msg .= "             <td><textarea id='wpgmza_ugm_add_desc' name='wpgmza_ugm_add_desc'  rows='3' cols='37'></textarea> </td>";
        $r_msg .= "         </tr>";
        if ($upload_images == 1) {
        $r_msg .= "         <tr>";
        $r_msg .= "             <td valign=\"top\">".__("Image","wp-google-maps").":</td>";
        $r_msg .= "             <td><input type='file' id='wpgmza_ugm_add_file' name='wpgmza_ugm_add_file' /></td>";
        $r_msg .= "         </tr>";
        }
        if ($result->ugm_category_enabled == 2) { } else { 
        $r_msg .= "         <tr>";
        $r_msg .= "             <td valign=\"top\">".__("Marker Category","wp-google-maps")."</td>";
        $r_msg .= "             <td><select name=\"wpgmza_category\" id=\"wpgmza_category\">".wpgmza_pro_return_category_select_list($mapid)."</td>";
        $r_msg .= "         </tr>";
        }

        $r_msg .= "             <td valign=\"top\"></td>";
        $r_msg .= "             <td><input id='wpgmza_ugm_spm' name='wpgmza_ugm_spm' type='checkbox' value='1'  /> ".__("Please tick this box to prove you are human","wp-google-maps")."</td>";
        $r_msg .= "         </tr>";
        $r_msg .= "         <tr>";
        $r_msg .= "             <td valign=\"top\"></td>";
        $r_msg .= "             <td><input type=\"button\" id=\"wpgmza_ugm_addmarker\" name=\"wpgmza_ugm_addmarker\" class=\"button-primary\" value=\"".__("Add marker","wp-google-maps")."\" /><span id=\"wpgmza_ugm_addmarker_loading\" style=\"display:none;\">".__("Adding","wp-google-maps")."...</span></td>";
        $r_msg .= "         </tr>";
        $r_msg .= "     </table>";
        $r_msg .= " ";
        $r_msg .= " ";
        $r_msg .= " ";
        $r_msg .= " ";
        $r_msg .= "</form>";
        return $r_msg;
    }

}


function wpgmaps_user_head_ugm() {
    if (isset($_POST['wpgmza_ugm_spm']) && $_POST['wpgmza_ugm_spm'] != '') {
        
        global $wpdb;
        global $wpgmza_tblname;
        $table_name = $wpdb->prefix . "wpgmza";
        wpgmaps_filter($_POST);
        $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
        if (isset($wpgmza_settings['wpgmza_settings_ugm_striptags'])) { $wpgmza_settings_ugm_striptags = $wpgmza_settings['wpgmza_settings_ugm_striptags']; } else { $wpgmza_settings_ugm_striptags = ""; }

          if ($wpgmza_settings_ugm_striptags == "yes") {
              $desc = strip_tags($_POST['wpgmza_ugm_add_desc']);
              $title = strip_tags($_POST['wpgmza_ugm_add_title']);
          }  else {
              $desc = $_POST['wpgmza_ugm_add_desc'];
              $title = $_POST['wpgmza_ugm_add_title'];
          }
          
          $movefile['url'] = "";
          if (isset($_FILES['wpgmza_ugm_add_file']) && $_FILES['wpgmza_ugm_add_file'] != '0') {
          if ( ! function_exists( 'wp_handle_upload' ) ) require_once( ABSPATH . 'wp-admin/includes/file.php' );
            $uploadedfile = $_FILES['wpgmza_ugm_add_file'];
            $upload_overrides = array( 'test_form' => false );
            $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
            if ( $movefile ) {
                if (isset($movefile['error'])) { 
                    $movefile['url'] = "";
                }
            } else {
                $movefile['url'] = "";
                echo "Possible file upload attack!\n";
            }
          } else {
              $movefile['url'] = "";
          }
          $ins_array = array( 
              'map_id' => $_POST['wpgmza_ugm_map_id'], 
              'title' => $title, 
              'address' => $_POST['wpgmza_ugm_add_address'], 
              'description' => $desc, 
              'lat' => $_POST['wpgmza_ugm_lat'], 
              'lng' => $_POST['wpgmza_ugm_lng'], 
              'infoopen' => '', 
              'anim' => '', 
              'link' => '', 
              'pic' => $movefile['url'], 
              'category' => ''
          );


          $rows_affected = $wpdb->insert( $table_name, $ins_array );
          wpgmaps_update_xml_file($_POST['wpgmza_ugm_map_id']);
        
        
    }
    
    
}


$wpgmaps_ugm_api_url = 'http://wpgmaps.com/apid/';
$wpgmaps_ugm_plugin_slug = basename(dirname(__FILE__));


add_filter('pre_set_site_transient_update_plugins', 'wpgmaps_ugm_check_for_plugin_update');

function wpgmaps_ugm_check_for_plugin_update($checked_data) {
	global $wpgmaps_ugm_api_url, $wpgmaps_ugm_plugin_slug, $wp_version;
	
	//Comment out these two lines during testing.
	if (empty($checked_data->checked))
		return $checked_data;
	
        
        
	$args = array(
		'slug' => $wpgmaps_ugm_plugin_slug,
		'version' => $checked_data->checked[$wpgmaps_ugm_plugin_slug .'/'. $wpgmaps_ugm_plugin_slug .'.php'],
	);
	$request_string = array(
			'body' => array(
				'action' => 'basic_check', 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	// Start checking for an update
	$raw_response = wp_remote_post($wpgmaps_ugm_api_url, $request_string);
        
        
	if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
		$response = unserialize($raw_response['body']);
	
	if (is_object($response) && !empty($response)) // Feed the update data into WP updater
		$checked_data->response[$wpgmaps_ugm_plugin_slug .'/'. $wpgmaps_ugm_plugin_slug .'.php'] = $response;
	
	return $checked_data;
}



add_filter('plugins_api', 'wpgmaps_ugm_plugin_api_call', 10, 3);

function wpgmaps_ugm_plugin_api_call($def, $action, $args) {
	global $wpgmaps_ugm_plugin_slug, $wpgmaps_ugm_api_url, $wp_version;
	
	if (!isset($args->slug) || ($args->slug != $wpgmaps_ugm_plugin_slug))
		return false;
	
	// Get the current version
	$plugin_info = get_site_transient('update_plugins');
	$current_version = $plugin_info->checked[$wpgmaps_ugm_plugin_slug .'/'. $wpgmaps_ugm_plugin_slug .'.php'];
	$args->version = $current_version;
	
	$request_string = array(
			'body' => array(
				'action' => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	$request = wp_remote_post($wpgmaps_ugm_api_url, $request_string);
	
	if (is_wp_error($request)) {
		$res = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
	} else {
		$res = unserialize($request['body']);
		
		if ($res === false)
			$res = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $request['body']);
	}
	
	return $res;
}






function wpgmaps_ugm_user_javascript() {
    $ajax_nonce_ugm = wp_create_nonce("wpgmza_ugm");
    echo "var wpgmaps_nonce = '$ajax_nonce_ugm';";
    
}

function wpgmaps_ugm_settings_page() {
    $wpgmza_settings = get_option("WPGMZA_OTHER_SETTINGS");
    if (isset($wpgmza_settings['wpgmza_settings_ugm_striptags'])) { $wpgmza_settings_ugm_striptags = $wpgmza_settings['wpgmza_settings_ugm_striptags']; } else { $wpgmza_settings_ugm_striptags = ""; }
    if ($wpgmza_settings_ugm_striptags == "yes") { $wpgmza_striptags_checked = "checked='checked'"; }


        return "
            <h3>".__("Visitor Generated Marker Settings","wp-google-maps")."</h3>
                <table class='form-table'>
                    <tr>
                         <td width='200' valign='top'>".__("Visitor Marker Input Settings","wp-google-maps").":</td>
                         <td>
                                <input name='wpgmza_settings_map_striptags' type='checkbox' id='wpgmza_settings_map_striptags' value='yes' $wpgmza_striptags_checked /> ".__("Strip all HTML tags in descriptions and titles","wp-google-maps")."<br />
                        </td>
                    </tr>
                </table>
            ";



}