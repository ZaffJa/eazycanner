<?php 
/**
 * Theme Script
 *
 * @package TLG Theme
 *
 */


if( !function_exists('roneous_fonts_url') ) {
	function roneous_fonts_url() {
	    $fonts_url 		= '';
	    $font_families 	= array();

	    $body_font 		= roneous_parsing_fonts( get_option('roneous_font'), 'Hind', 400 );
		$heading_font 	= roneous_parsing_fonts( get_option('roneous_header_font'), 'Montserrat', 400 );
		$menu_font 		= roneous_parsing_fonts( get_option('roneous_menu_font'), 'Roboto', 400 );
	    
	    /*
	    Translators: If there are characters in your language that are not supported
	    by chosen font(s), translate this to 'off'. Do not translate into your own language.
	     */
	    if ( 'off' !== _x( 'on', 'Body font: on or off', 'roneous' ) ) {
	    	$font_families[] = $body_font['family'];
	    }
	    if ( 'off' !== _x( 'on', 'Heading font: on or off', 'roneous' ) ) {
	    	$font_families[] = $heading_font['family'];
	    }
	    if ( 'off' !== _x( 'on', 'Menu font: on or off', 'roneous' ) ) {
	    	$font_families[] = $menu_font['family'];
	    }
	    if ( 'off' !== _x( 'on', 'Open Sans font: on or off', 'roneous' ) ) {
	    	$font_families[] = 'Open Sans:300,400';
	    }

	    $query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	    return esc_url_raw( $fonts_url );
	}
}


if( !function_exists('roneous_load_scripts') ) {
	function roneous_load_scripts() {
		# FONT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		wp_enqueue_style( 'roneous-google-fonts', roneous_fonts_url() );
		# CSS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		wp_enqueue_style( 'roneous-libs', TLG_THEME_DIRECTORY . 'assets/css/libs.css' );
		if( class_exists('bbPress') ) {
			wp_enqueue_style( 'roneous-bbpress', TLG_THEME_DIRECTORY . 'assets/css/bbpress.css' );
		}
		if( roneous_is_plugin_active( 'tlg_framework/index.php' ) ) {
			wp_enqueue_style( 'roneous-theme-styles', TLG_THEME_DIRECTORY . 'assets/css/theme.less' );
		} else {
			wp_enqueue_style( 'roneous-theme-styles', TLG_THEME_DIRECTORY . 'assets/css/theme.min.css' );
		}
		wp_enqueue_style( 'roneous-style', get_stylesheet_uri() );
		wp_add_inline_style( 'roneous-style', get_option( 'roneous_custom_css', '' ) );
		# JS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		wp_enqueue_script( 'bootstrap', TLG_THEME_DIRECTORY . 'assets/js/bootstrap.js', array('jquery'), false, true );
		wp_enqueue_script( 'roneous-libs', TLG_THEME_DIRECTORY . 'assets/js/libs.js', array('jquery'), false, true );
		wp_enqueue_script( 'roneous-scripts', TLG_THEME_DIRECTORY . 'assets/js/scripts.js', array('jquery'), false, true );
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
		wp_localize_script( 'roneous-scripts', 'wp_data', array(
			'roneous_ajax_url' 		=> admin_url( 'admin-ajax.php' ),
			'roneous_menu_height' 	=> get_option( 'roneous_menu_height', '64' ),
			'roneous_permalink' 	=> get_permalink(),
		));
	}
	add_action( 'wp_enqueue_scripts', 'roneous_load_scripts', 110 );
}


if( !function_exists('roneous_admin_load_scripts') ) {
	function roneous_admin_load_scripts() {
		# FONT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -		
		wp_enqueue_style( 'roneous-fonts', TLG_THEME_DIRECTORY . 'assets/css/fonts.css' );
		# CSS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -		
		wp_enqueue_style( 'roneous-admin-css', TLG_THEME_DIRECTORY . 'assets/css/admin.css' );
		$custom_css = '';
		if( 'no' == get_option( 'roneous_enable_portfolio', 'yes' ) ) {
			$custom_css .= '#menu-posts-portfolio,[data-element="tlg_portfolio"]{display:none!important;}';
		}
		if( 'no' == get_option( 'roneous_enable_team', 'yes' ) ) {
			$custom_css .= '#menu-posts-team,[data-element="tlg_team"]{display:none!important;}';
		}
		if( 'no' == get_option( 'roneous_enable_client', 'yes' ) ) {
			$custom_css .= '#menu-posts-client,[data-element="tlg_clients"]{display:none!important;}';
		}
		if( 'no' == get_option( 'roneous_enable_testimonial', 'yes' ) ) {
			$custom_css .= '#menu-posts-testimonial,[data-element="tlg_testimonial"]{display:none!important;}';
		}
		if( $custom_css ) {
			wp_add_inline_style( 'roneous-admin-css', $custom_css );
		}
		# JS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -		
		wp_enqueue_script( 'roneous-admin-js', TLG_THEME_DIRECTORY . 'assets/js/admin.js', array('jquery'), false, true );
	}
	add_action( 'admin_enqueue_scripts', 'roneous_admin_load_scripts', 200 );
}


if( !function_exists('roneous_less_vars') ) {
	function roneous_less_vars( $vars, $handle = 'roneous-theme-styles' ) {
		$body_font 		= roneous_parsing_fonts( get_option('roneous_font'), 'Hind', 400 );
		$heading_font 	= roneous_parsing_fonts( get_option('roneous_header_font'), 'Montserrat', 400 );
		$menu_font 		= roneous_parsing_fonts( get_option('roneous_menu_font'), 'Roboto', 400 );
		$vars['body-font']       	 = $body_font['name'];
		$vars['body-font-weight']    = $body_font['weight'];
		$vars['body-font-style']   	 = $body_font['style'];
		$vars['heading-font']    	 = $heading_font['name'];
		$vars['heading-font-weight'] = $heading_font['weight'];
		$vars['heading-font-style']  = $heading_font['style'];
		$vars['menu-font']    	 	 = $menu_font['name'];
		$vars['text-color']    	 	 = get_option('roneous_color_text', '#565656');
		$vars['primary-color']   	 = get_option('roneous_color_primary', '#10B8D2');
		$vars['dark-color']      	 = get_option('roneous_color_dark', '#28262b');
		$vars['bg-dark-color']       = get_option('roneous_color_bg_dark', '#1c1d1f');
		$vars['bg-graydark-color']   = get_option('roneous_color_bg_graydark', '#393939');
		$vars['secondary-color'] 	 = get_option('roneous_color_secondary', '#f7f7f7');
		$vars['menu-badge-color'] 	 = get_option('roneous_color_menu_badge', '#8fae1b');
		$vars['menu-height']   		 = (int) get_option('roneous_menu_height', '64').'px';
		$vars['menu-column-width']   = (int) get_option('roneous_menu_column_width', '230').'px';
		$vars['menu-vertical-width'] = (int) get_option('roneous_menu_vertical_width', '280').'px';
		$vars['menu-rmargin']   	 = (int) get_option('roneous_menu_right_space', '32').'px';
	    return $vars;
	}
	if( roneous_is_plugin_active( 'tlg_framework/index.php' ) ) {
		add_filter( 'less_vars', 'roneous_less_vars', 10, 2 );
	}
}