<?php
/**
 * @package Latest News Ticker
 * @version 1.1
 */
/*
Plugin Name: Latest News Ticker
Plugin URI: http://www.latestnewsticker.com
Description: Latest news ticker
Author: Shane Jones
Version: 1.1
Author URI: http://profiles.wordpress.org/ShaneJones/
*/

include "functions.php";


if (is_admin()){
	
    add_action('admin_menu' , 'sdj_lnt_admin_add_page');
    add_action('admin_init' , 'sdj_lnt_admin_init');
	
} else {
	add_action('init'       , 'sdj_lnt_scripts');
    add_action('wp_footer'  , 'sdj_lnt_build_ticker');
}

register_activation_hook(__FILE__, 'sdj_lnt_defaults');

?>