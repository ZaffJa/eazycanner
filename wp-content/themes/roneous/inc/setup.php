<?php
/**
 * Theme Setup
 *
 * @package TLG Theme
 *
 */

if( !function_exists('roneous_init_theme') ) {
	function roneous_init_theme() {
	    global $content_width;
	    if ( ! isset( $content_width ) ) $content_width = 1170;
	    add_editor_style( 'assets/css/editor.css' );
	    remove_post_type_support( 'portfolio', 'post-formats' );
	    remove_post_type_support( 'portfolio', 'comments' );
	    remove_post_type_support( 'page', 'comments' );
	}
	add_action( 'init', 'roneous_init_theme', 10 );
}

if( !function_exists('roneous_setup_theme') ) {
	function roneous_setup_theme() {
		load_theme_textdomain( 'roneous', trailingslashit( get_template_directory() ) . 'languages' );
		
		add_theme_support( 'custom-background', array( 'default-color' => 'eeeeee' ) );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form' ) );
		add_theme_support( 'title-tag' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'post-formats', array('gallery', 'video', 'audio', 'quote', 'link') );
		add_theme_support( 'post-thumbnails' );

		add_image_size( 'roneous_grid', 600, 400, true );
		add_image_size( 'roneous_box', 650, 600, true );
	}
	add_action( 'after_setup_theme', 'roneous_setup_theme', 10 );
}