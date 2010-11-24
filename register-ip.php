<?php
/*
Plugin Name: Register IP - MultiSite
Version: 1.0
Description: Logs the IP of the user when they register a new account.
Author: Mika Epstein, Johnny White
Author URI: http://ipstenu.org
Plugin URI: http://code.ipstenu.org/register-ip-ms

Register IP Copyright (c) 2005 Johnny White
Register IP - MultiSite (c) 2010 Mika Epstein

Taken over in 2010 by Mika Epstein under GPL provisons

        This plugin is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 2 of the License, or
        (at your option) any later version.

        This plugin is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
        GNU General Public License for more details.

*/

/* Internationlization */
load_plugin_textdomain('signup_ip', false, dirname(plugin_basename(__FILE__)) . '/language');

/* Version Check - This only works on 3.x branch! */
global $wp_version;

$exit_msg = 'This plugin requires WordPress 3.0 or newer.';

if(version_compare($wp_version, "3.0", "<"))
{
        exit($exit_msg);
}

function log_ip($user_id){
        $ip = $_SERVER['REMOTE_ADDR']; //Get the IP of the person registering
        update_user_meta($user_id, 'signup_ip', $ip); //Add user metadata to the usermeta table
}

// Hook into when the user is registered.
add_action('user_register', 'log_ip');

// If you have the permissions to edit users, you can see their IP in their profile.
add_action('edit_user_profile', 'show_ip_on_profile');

// Formatting for how it looks on the profile page.
function show_ip_on_profile() {
        $user_id = $_GET['user_id'];
?>
        <h3><?php _e('Signup IP Address',signup_ip); ?></h3>
        <p style="text-indent:15px;"><?php
        $ip_address = get_user_meta($user_id, 'signup_ip', true);
        echo $ip_address;
        ?></p>
<?php
}

// Add in a column header
function signup_ip($column_headers) {
    $column_headers['signup_ip'] = __('IP Address', 'signup_ip');
    return $column_headers;
}

// In WordPress 3.0 - Formatting output for Single Site. Only called if Multisite is disabled.
// In WordPress 3.1+ - Formatting output for EVERYTHING
// See http://core.trac.wordpress.org/ticket/14562 for more info

function ripms_columns($value, $column_name, $user_id) {
        if ( $column_name == 'signup_ip' ) {
                $ip = get_user_meta($user_id, 'signup_ip', true);
                if ($ip != ""){
                        $ret = '<em>'.__($ip, 'signup_ip').'</em>';
                        return $ret;
                } else {
                        $ret = '<em>'.__('None Recorded', 'signup_ip').'</em>';
                        return $ret;
                }
        }
        return $value;
}


// Formatting output for MultiSite. Only called if Multisite is enabled - This is for WP 3.0 and 3.0.1
function ripms_multi_columns($column_name, $user_id ) {
        if ( $column_name == 'signup_ip' ) {
                $ip = get_user_meta($user_id, 'signup_ip', true);
                if ($ip != ""){
                        $ret = '<em>'.__($ip, 'signup_ip').'</em>';
                        echo $ret;
                } else {
                        $ret = '<em>'.__('None recorded', 'signup_ip').'</em>';
                        echo $ret;
                }
        }
}

if ( is_multisite() ) {
        // Adding in filters and actions for Multi Site installs
        add_filter('wpmu_users_columns', 'signup_ip');
        if(version_compare($wp_version, "3.1", "<")) {
         add_action('manage_users_custom_column',  'ripms_multi_columns', 10, 2);
        }
        if(version_compare($wp_version, "3.0.1", ">")) {
         add_action('manage_users_custom_column',  'ripms_columns', 10, 3);
        }
} else {
        // Adding in filters and actions for Single Site installs
        add_filter('manage_users_columns', 'signup_ip');
        add_action('manage_users_custom_column',  'ripms_columns', 10, 3);
}

?>