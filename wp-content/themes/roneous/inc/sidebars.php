<?php
/**
 * Theme Sidebar
 *
 * @package TLG Theme
 *
 */

if( !function_exists('roneous_register_sidebars') ) {
	function roneous_register_sidebars() {
		register_sidebar(
			array(
				'id' 			=> 'primary',
				'name' 			=> esc_html__( 'Blog Sidebar', 'roneous' ),
				'description' 	=> esc_html__( 'Widget appears in the Blog sidebar.', 'roneous' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h6 class="title">',
				'after_title' 	=> '</h6>'
			) 
		);
		register_sidebar(
			array(
				'id' 			=> 'page',
				'name' 			=> esc_html__( 'Page Sidebar', 'roneous' ),
				'description' 	=> esc_html__( 'Widget appears in the Sidebar page template.', 'roneous' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h6 class="title">',
				'after_title' 	=> '</h6>'
			) 
		);
		register_sidebar(
			array(
				'id' 			=> 'shop',
				'name' 			=> esc_html__( 'Shop Sidebar', 'roneous' ),
				'description' 	=> esc_html__( 'Widget appears in the Shop sidebar.', 'roneous' ),
				'before_widget' => '<div id="%1$s" class="sidebox widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h6 class="title">',
				'after_title' 	=> '</h6>'
			) 
		);
		register_sidebar(
			array(
				'id' 			=> 'footer1',
				'name' 			=> esc_html__( 'Footer Column 1', 'roneous' ),
				'description' 	=> esc_html__( 'Widget appears in the Footer column 1', 'roneous' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h6 class="title">',
				'after_title' 	=> '</h6>'
			)
		);
		register_sidebar(
			array(
				'id' 			=> 'footer2',
				'name' 			=> esc_html__( 'Footer Column 2', 'roneous' ),
				'description' 	=> esc_html__( 'Widget appears in the Footer column 2.', 'roneous' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h6 class="title">',
				'after_title' 	=> '</h6>'
			)
		);
		register_sidebar(
			array(
				'id' 			=> 'footer3',
				'name' 			=> esc_html__( 'Footer Column 3', 'roneous' ),
				'description' 	=> esc_html__( 'Widget appears in the Footer column 3.', 'roneous' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h6 class="title">',
				'after_title' 	=> '</h6>'
			)
		);
		register_sidebar(
			array(
				'id' 			=> 'footer4',
				'name' 			=> esc_html__( 'Footer Column 4', 'roneous' ),
				'description' 	=> esc_html__( 'Widget appears in the Footer column 4.', 'roneous' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<h6 class="title">',
				'after_title' 	=> '</h6>'
			)
		);
	}
	add_action( 'widgets_init', 'roneous_register_sidebars' );
}