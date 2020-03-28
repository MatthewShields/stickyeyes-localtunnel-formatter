<?php
/*
Plugin Name: Stickyeyes Localtunnel Formatter
Description: When using ngrok for localtunnel functionality it will make the urls within the page relative so still function with different URL.
Plugin URI: http://www.stickyeyes.com
Version: 0.1
Author: Matthew Shields
Author URI: https://www.stickyeyes.com
Author Email: matthew.shields@stickyeyes.com
License: None

Based heavily off the plugin by https://sparanoid.com/work/relative-url/ and customised for our specific use
*/

function change_urls($page_html) {
  if(defined('LOCALTUNNEL_ACTIVE') && LOCALTUNNEL_ACTIVE === true) {

    $wp_home_url = esc_url(home_url('/'));
    $rel_home_url = wp_make_link_relative($wp_home_url);

    $esc_home_url = str_replace('/', '\/', $wp_home_url);
    $rel_esc_home_url = str_replace('/', '\/', $rel_home_url);

    $rel_page_html = str_replace($wp_home_url, $rel_home_url, $page_html);
    $esc_page_html = str_replace($esc_home_url, $rel_esc_home_url, $rel_page_html);

    return $esc_page_html;
  }
}

function buffer_start_relative_url() { 
  if(defined('LOCALTUNNEL_ACTIVE') && LOCALTUNNEL_ACTIVE === true) {
    ob_start('change_urls'); 
  }
}
function buffer_end_relative_url() { 
  if(defined('LOCALTUNNEL_ACTIVE') && LOCALTUNNEL_ACTIVE === true) {
    @ob_end_flush(); 
  }
}

add_action('registered_taxonomy', 'buffer_start_relative_url');
add_action('shutdown', 'buffer_end_relative_url');