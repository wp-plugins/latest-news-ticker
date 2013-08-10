<?php
/**
 * @package Latest News Ticker
 * @version 1.32
 */
/*
Plugin Name: Latest News Ticker
Plugin URI: http://www.latestnewsticker.com
Description: With Latest News Ticker for WordPress you too can have a news ticker along the bottom of your site highlighting the latest posts on your site.
Author: Shane Jones
Version: 1.31
Author URI: http://profiles.wordpress.org/ShaneJones/
*/

include "functions.php";


if (is_admin()){
	
    add_action('admin_menu'  , 'sdj_lnt_admin_add_page');
    add_action('admin_init'  , 'sdj_lnt_admin_init');
	
} else {
	add_action('init'        , 'sdj_lnt_scripts');
    add_action('wp_footer'   , 'sdj_lnt_build_ticker');
}

register_activation_hook(__FILE__, 'sdj_lnt_defaults');
register_deactivation_hook(__FILE__, 'sdj_lnt_defaults_remove');

?>