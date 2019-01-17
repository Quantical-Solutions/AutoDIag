<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
$option_name = 'wporg_option';
 
delete_option($option_name);

delete_site_option($option_name);

global $wpdb;

$wpdb->query("DROP TABLE {$wpdb->prefix}autodiag;");
$wpdb->query("DROP TABLE {$wpdb->prefix}autodiag_users;");
$wpdb->query("DROP TABLE {$wpdb->prefix}autodiag_refs;");
$wpdb->query("DROP TABLE {$wpdb->prefix}autodiag_settings;");

$timestamp = wp_next_scheduled( 'bl_cron_hook' );
wp_unschedule_event( $timestamp, 'bl_cron_hook' );

register_deactivation_hook( __FILE__, 'bl_deactivate' );
 
function bl_deactivate() {
   $timestamp = wp_next_scheduled( 'bl_cron_hook' );
   wp_unschedule_event( $timestamp, 'bl_cron_hook' );
}