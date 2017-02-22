<?php
/*
Plugin Name: TLG Framework
Plugin URI: http://www.themelogi.com
Description: The custom post types, widgets and Visual Composer shortcodes for THEMELOGI's WordPress Themes.
Version: 1.1.1
Author: THEMELOGI
Author URI: http://www.themelogi.com
*/
define( 'TLG_FRAMEWORK_PATH', trailingslashit(plugin_dir_path(__FILE__)) );
define( 'TLG_FRAMEWORK_URL', trailingslashit(plugin_dir_url(__FILE__)) );

# Load plugin textdomain
if( !function_exists( 'tlg_framework_load_plugin_textdomain' ) ) {
	function tlg_framework_load_plugin_textdomain() {
	  	load_plugin_textdomain( 'tlg_framework', false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
	}
	add_action( 'plugins_loaded', 'tlg_framework_load_plugin_textdomain' );
}

# Load plugin scripts
if( !function_exists( 'tlg_framework_load_plugin_scripts' ) ) {
	function tlg_framework_load_plugin_scripts() {
	    wp_enqueue_script( 'tlg_framework-script', TLG_FRAMEWORK_URL. 'assets/js/admin.js', array('jquery') );
	    wp_enqueue_style( 'tlg_framework-style', TLG_FRAMEWORK_URL. 'assets/css/admin.css', array());
	}
	add_action( 'admin_enqueue_scripts','tlg_framework_load_plugin_scripts' );
}

# Including lib
require_once( TLG_FRAMEWORK_PATH . 'includes/lib/lessc.inc.php' );
require_once( TLG_FRAMEWORK_PATH . 'includes/lib/wp-less.php' );
require_once( TLG_FRAMEWORK_PATH . 'includes/lib/aq_resize.php' );
require_once( TLG_FRAMEWORK_PATH . 'includes/lib/metaboxes/init.php' );

# Including custom post types
require_once( TLG_FRAMEWORK_PATH . 'includes/tlg_cpt.php' );

# Including theme helpers
require_once( TLG_FRAMEWORK_PATH . 'includes/tlg_helper.php' );

# Including theme layouts
require_once( TLG_FRAMEWORK_PATH . 'includes/tlg_layouts.php' );

# Including theme shortcodes
require_once( TLG_FRAMEWORK_PATH . 'includes/tlg_shortcodes.php' );

# Including theme widgets
require_once( TLG_FRAMEWORK_PATH . 'includes/tlg_widgets.php' );