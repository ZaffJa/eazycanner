<?php 
/**
 * Theme Metabox
 *
 * @package TLG Theme
 *
 */

if( !function_exists('roneous_metaboxes') ) {
	function roneous_metaboxes( $meta_boxes ) {
		$title_options 	= tlg_framework_get_page_title_options();
		$menus = wp_get_nav_menus();
		$menu_options = array();
		if( is_array($menus) && count($menus) ) {
			foreach($menus as $menu) {
				$menu_options[$menu->term_id] = $menu->name;
			}
		}
		$menu_options = array( 0 => esc_html__( '(default menu)', 'roneous' ) ) + $menu_options;
		$layout_options = array( 'default' => esc_html__( '(default layout)', 'roneous' ) ) + tlg_framework_get_site_layouts();
		$header_options = array( 'default' => esc_html__( '(default layout)', 'roneous' ) ) + tlg_framework_get_header_options();
		$footer_options = array( 'default' => esc_html__( '(default layout)', 'roneous' ) ) + tlg_framework_get_footer_options();
		$yesno_options  = array( 'yes' => esc_html__( 'Yes', 'roneous' ), 'no' => esc_html__( 'No', 'roneous' ) );
		$prefix 		= '_tlg_';
# PAGE/POST SETTINGS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$meta_boxes[] = array(
			'id' => 'page_metabox',
			'title' => esc_html__( 'Page Settings', 'roneous' ),
			'object_types' => array( 'page', 'post', 'portfolio', 'product' ),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
					'name'         	=> esc_html__( 'Site Layout', 'roneous' ),
					'desc'         	=> esc_html__( 'Default Site Layout is set in: Appearance > Customize > Site Identity', 'roneous' ),
					'id'           	=> $prefix . 'layout_override',
					'type'         	=> 'select',
					'options'      	=> $layout_options,
					'std'          	=> 'default'
				),
				array(
					'name'         	=> esc_html__( 'Header Layout', 'roneous' ),
					'desc'         	=> esc_html__( 'Default Header Layout is set in: Appearance > Customize > Header', 'roneous' ),
					'id'           	=> $prefix . 'header_override',
					'type'         	=> 'select',
					'options'      	=> $header_options,
					'std'          	=> 'default'
				),
				array(
					'name'         	=> esc_html__( 'Footer Layout', 'roneous' ),
					'desc'         	=> esc_html__( 'Default Footer Layout is set in: Appearance > Customize > Footer', 'roneous' ),
					'id'           	=> $prefix . 'footer_override',
					'type'         	=> 'select',
					'options'      	=> $footer_options,
					'std'          	=> 'default'
				),
				array(
					'name' 			=> esc_html__( 'Page Title Layout', 'roneous' ),
					'desc' 			=> esc_html__( 'Choose the page title layout you want.', 'roneous' ),
					'id' 			=> $prefix . 'page_title_layout',
					'type' 			=> 'select',
					'options' 		=> $title_options
				),
				array(
					'name' 			=> esc_html__( 'Page Title Subtitle', 'roneous' ),
					'desc' 			=> esc_html__( 'Enter a subtitle for this page (optional).', 'roneous' ),
					'id'   			=> $prefix . 'the_subtitle',
					'type' 			=> 'text',
				),
				array(
					'name' 			=> esc_html__( 'Page Title Background Image Type', 'roneous' ),
					'desc' 			=> esc_html__( 'Select a background image type for page title Background or Parallax layouts.', 'roneous' ),
					'id' 			=> $prefix . 'title_bg_featured',
					'type' 			=> 'select',
					'options' 		=> array( 'yes' => esc_html__( 'Featured Image', 'roneous' ), 'no' => esc_html__( 'Custom Background Image', 'roneous' ) )
				),
				array(
		            'name' 			=> esc_html__( 'Custom Background Image', 'roneous' ),
		            'desc' 			=> esc_html__( 'Select image pattern for stunning header background', 'roneous' ),
		            'id'   			=> $prefix . 'title_bg_img',
	                'type' 			=> 'file',
		        ),
			)
		);
# MENU SETTINGS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$meta_boxes[] = array(
			'id' => 'menu_metabox',
			'title' => esc_html__( 'Menu Settings', 'roneous' ),
			'object_types' => array( 'page', 'post', 'portfolio', 'product' ),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
					'name'         	=> esc_html__( 'Selected Menu', 'roneous' ),
					'desc'         	=> esc_html__( 'Default Selected Menu is the menu in primary location', 'roneous' ),
					'id'           	=> $prefix . 'menu_override',
					'type'         	=> 'select',
					'options'      	=> $menu_options,
					'std'          	=> 'default'
				),
				array(
				    'name' 			=> esc_html__( 'Hide Header Cart?', 'roneous' ),
				    'desc' 			=> esc_html__( 'Check this option to hide header cart icon.', 'roneous' ),
				    'id'   			=> $prefix . 'menu_hide_cart',
				    'type' 			=> 'checkbox'
				),
				array(
				    'name' 			=> esc_html__( 'Hide Header Search?', 'roneous' ),
				    'desc' 			=> esc_html__( 'Check this option to hide header search icon.', 'roneous' ),
				    'id'   			=> $prefix . 'menu_hide_search',
				    'type' 			=> 'checkbox'
				),
				array(
				    'name' 			=> esc_html__( 'Hide Header Language?', 'roneous' ),
				    'desc' 			=> esc_html__( 'Check this option to hide header language icon.', 'roneous' ),
				    'id'   			=> $prefix . 'menu_hide_language',
				    'type' 			=> 'checkbox'
				),
			)
		);
# PORTFOLIO SETTINGS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$meta_boxes[] = array(
			'id' => 'portfolio_metabox',
			'title' => esc_html__( 'Portfolio Settings (using with default WordPress visual editor only)', 'roneous' ),
			'object_types' => array('portfolio'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
					'name' => esc_html__( 'Client Name', 'roneous' ),
					'desc' => esc_html__( 'Enter a client name for this project.', 'roneous' ),
					'id'   => $prefix . 'portfolio_client',
					'type' => 'text',
				),
				array(
					'name' => esc_html__( 'Client URL', 'roneous' ),
					'desc' => esc_html__( 'Enter a URL client for this project.', 'roneous' ),
					'id'   => $prefix . 'portfolio_client_url',
					'type' => 'text',
				),
				array(
					'name' => esc_html__( 'Release Date', 'roneous' ),
					'desc' => esc_html__( 'Select the release date for this project.', 'roneous' ),
					'id'   => $prefix . 'portfolio_date',
					'type' => 'text_date_timestamp',
				),
				array(
				    'name' => esc_html__( 'Show Date?', 'roneous' ),
				    'desc' => esc_html__( 'Check this option to show the release date.', 'roneous' ),
				    'id'   => $prefix . 'portfolio_show_date',
				    'type' => 'checkbox'
				),
				array(
				    'name' => esc_html__( 'Show Category?', 'roneous' ),
				    'desc' => esc_html__( 'Check this option to show the category info.', 'roneous' ),
				    'id'   => $prefix . 'portfolio_show_cat',
				    'type' => 'checkbox'
				),
				array(
				    'name' => esc_html__( 'Show Client?', 'roneous' ),
				    'desc' => esc_html__( 'Check this option to show the client name & URL.', 'roneous' ),
				    'id'   => $prefix . 'portfolio_show_client',
				    'type' => 'checkbox'
				),
				array(
					'name' => esc_html__( 'Title - Attribute 1', 'roneous' ),
					'desc' => esc_html__( 'Enter a title for attribute 1.', 'roneous' ),
					'id'   => $prefix . 'portfolio_attribute_1',
					'type' => 'text',
				),
				array(
					'name' => esc_html__( 'Value - Attribute 1', 'roneous' ),
					'desc' => esc_html__( 'Enter a value for attribute 1.', 'roneous' ),
					'id'   => $prefix . 'portfolio_attribute_1_value',
					'type' => 'text',
				),
				array(
				    'name' => esc_html__( 'Show Attribute 1?', 'roneous' ),
				    'desc' => esc_html__( 'Check this option to show the attribute 1.', 'roneous' ),
				    'id'   => $prefix . 'portfolio_attribute_1_show',
				    'type' => 'checkbox'
				),
				array(
					'name' => esc_html__( 'Title - Attribute 2', 'roneous' ),
					'desc' => esc_html__( 'Enter a title for attribute 2.', 'roneous' ),
					'id'   => $prefix . 'portfolio_attribute_2',
					'type' => 'text',
				),
				array(
					'name' => esc_html__( 'Value - Attribute 2', 'roneous' ),
					'desc' => esc_html__( 'Enter a value for attribute 2.', 'roneous' ),
					'id'   => $prefix . 'portfolio_attribute_2_value',
					'type' => 'text',
				),
				array(
				    'name' => esc_html__( 'Show Attribute 2?', 'roneous' ),
				    'desc' => esc_html__( 'Check this option to show the attribute 2.', 'roneous' ),
				    'id'   => $prefix . 'portfolio_attribute_2_show',
				    'type' => 'checkbox'
				),
				array(
					'name' => esc_html__( 'Title - Attribute 3', 'roneous' ),
					'desc' => esc_html__( 'Enter a title for attribute 3.', 'roneous' ),
					'id'   => $prefix . 'portfolio_attribute_3',
					'type' => 'text',
				),
				array(
					'name' => esc_html__( 'Value - Attribute 3', 'roneous' ),
					'desc' => esc_html__( 'Enter a value for attribute 3.', 'roneous' ),
					'id'   => $prefix . 'portfolio_attribute_3_value',
					'type' => 'text',
				),
				array(
				    'name' => esc_html__( 'Show Attribute 3?', 'roneous' ),
				    'desc' => esc_html__( 'Check this option to show the attribute 3.', 'roneous' ),
				    'id'   => $prefix . 'portfolio_attribute_3_show',
				    'type' => 'checkbox'
				),
				array(
					'name' => esc_html__( 'Title - Attribute 4', 'roneous' ),
					'desc' => esc_html__( 'Enter a title for attribute 4.', 'roneous' ),
					'id'   => $prefix . 'portfolio_attribute_4',
					'type' => 'text',
				),
				array(
					'name' => esc_html__( 'Value - Attribute 4', 'roneous' ),
					'desc' => esc_html__( 'Enter a value for attribute 4.', 'roneous' ),
					'id'   => $prefix . 'portfolio_attribute_4_value',
					'type' => 'text',
				),
				array(
				    'name' => esc_html__( 'Show Attribute 4?', 'roneous' ),
				    'desc' => esc_html__( 'Check this option to show the attribute 4.', 'roneous' ),
				    'id'   => $prefix . 'portfolio_attribute_4_show',
				    'type' => 'checkbox'
				),
			),
		);		
# CLIENT SETTINGS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$meta_boxes[] = array(
			'id' => 'clients_metabox',
			'title' => esc_html__( 'Client Settings', 'roneous' ),
			'object_types' => array('client'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
					'name' => esc_html__( 'Client URL', 'roneous' ),
					'desc' => esc_html__( 'Enter a URL for this client.', 'roneous' ),
					'id'   => $prefix . 'client_url',
					'type' => 'text',
				),
			),
		);
# TEAM SETTINGS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$meta_boxes[] = array(
			'id' => 'team_metabox',
			'title' => esc_html__( 'Team Member Settings', 'roneous' ),
			'object_types' => array('team'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
				    'name' => esc_html__( 'Member description', 'roneous' ),
				    'desc' => esc_html__( 'Member description for this person.', 'roneous' ),
				    'id' => $prefix . 'team_about',
				    'type' => 'wysiwyg',
				    'options' => array(),
				),
				array(
					'name' => esc_html__( 'Member position', 'roneous' ),
					'desc' => esc_html__( 'Member position for this person.', 'roneous' ),
					'id'   => $prefix . 'team_position',
					'type' => 'text',
				),
				array(
				    'id'          => $prefix . 'team_social_icons',
				    'type'        => 'group',
				    'options'     => array(
				        'add_button'    => esc_html__( 'Add Icon', 'roneous' ),
				        'remove_button' => esc_html__( 'Remove Icon', 'roneous' ),
				        'sortable'      => true
				    ),
				    'fields' => array(
						array(
							'name' 			=> esc_html__( 'Social Icon', 'roneous' ),
							'description' 	=> esc_html__( 'Leave text field blank for no icon.', 'roneous' ),
							'id' 			=> $prefix . 'team_social_icon',
							'std' 			=> 'none',
							'type' 			=> 'tlg_social_icons',
						),
						array(
							'name' => esc_html__( 'Social URL', 'roneous' ),
							'desc' => esc_html__( 'Enter the URL for Social Icon.', 'roneous' ),
							'id'   => $prefix . 'team_social_icon_url',
							'type' => 'text_url',
						),
				    ),
				),
				array(
					'name' => esc_html__( 'Member URL (optional)', 'roneous' ),
					'desc' => esc_html__( 'Enter a URL for this member.', 'roneous' ),
					'id'   => $prefix . 'team_url',
					'type' => 'text',
				),
			)
		);
# TESTIMONIAL SETTINGS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$meta_boxes[] = array(
			'id' => 'testimonials_metabox',
			'title' => esc_html__( 'Testimonial Settings', 'roneous' ),
			'object_types' => array('testimonial'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
				    'name' => esc_html__( 'Testimonial Content', 'roneous' ),
				    'desc' => esc_html__( 'Enter the testimonial content.', 'roneous' ),
				    'id' => $prefix . 'testimonial_content',
				    'type' => 'wysiwyg',
				    'options' => array(),
				),
				array(
					'name' => esc_html__( 'Author Info', 'roneous' ),
					'desc' => esc_html__( 'Enter author infomation for this testimonial.', 'roneous' ),
					'id'   => $prefix . 'testimonial_info',
					'type' => 'text',
				),
		        array(
					'name' => esc_html__( 'Author URL (optional)', 'roneous' ),
					'desc' => esc_html__( 'Enter a URL for this author.', 'roneous' ),
					'id'   => $prefix . 'testimonial_url',
					'type' => 'text',
				),
			)
		);
# POST VIDEO SETTINGS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$meta_boxes[] = array(
			'id' => 'post_format_metabox_video',
			'title' => esc_html__( 'Videos & oEmbeds', 'roneous' ),
			'object_types' => array('post'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
					'name' => esc_html__( 'oEmbed', 'roneous' ),
					'desc' => esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'roneous' ),
					'id'   => $prefix . 'the_oembed',
					'type' => 'oembed',
				),
			)
		);
# POST AUDIO SETTINGS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$meta_boxes[] = array(
			'id' => 'post_format_metabox_audio',
			'title' => esc_html__( 'Audio Embed', 'roneous' ),
			'object_types' => array('post'),
			'context' => 'normal',
			'priority' => 'high',
			'show_names' => true,
			'fields' => array(
				array(
					'name' => esc_html__( 'oEmbed', 'roneous' ),
					'desc' => esc_html__( 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.', 'roneous' ),
					'id'   => $prefix . 'the_audio_oembed',
					'type' => 'oembed',
				),
			)
		);
		return $meta_boxes;
	}
	add_filter( 'cmb2_meta_boxes', 'roneous_metaboxes' );
}