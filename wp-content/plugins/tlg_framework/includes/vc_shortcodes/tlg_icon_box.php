<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_icon_box_shortcode') ) {
	function tlg_framework_icon_box_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'title' 		 => '',
			'subtitle' 		 => '',
			'customize_icon' => 'no',
			'icon' 			 => '',
			'image' 		 => '',
			'icon_color' 	 => '',
			'icon_bg_color'  => '',
			'icon_layout' 	 => '',
			'icon_size' 	 => '',
			'box_layout' 	 => 'text-center',
			'icon_box_link'  => '',
			'color' 		 => '',
			// color
			'title_color' 		=> '',
			'title_hover_color' => '',
			'subtitle_color' 	=> '',
			'content_color' 	=> '',
			'image_hover_color' => '',
			// customize font
			'customize_font' 	=> '',
			'title_font' 		=> '',
			'subtitle_font' 	=> '',
			'title_size' 		=> '',
			'subtitle_size' 	=> '',
			'title_uppercase' 	 => 'yes',
			'subtitle_uppercase' => 'no',
		), $atts ) );
		$output 		= '';
		$custom_css 	= '';
		$icon_image 	= '';
		$link_prefix 	= '';
		$link_sufix 	= '';
		$element_id 	= uniqid('iconbox-');
		$fonts 			= array();

		// BUILD STYLE
		$styles_title 		= '';
		$styles_subtitle 	= '';
		$styles_content 	= '';
		$styles_icon 		= '';
		
		$styles_title 		.= $title_color 					? 'color:'.$title_color.';' : '';
		$styles_subtitle 	.= $subtitle_color 					? 'color:'.$subtitle_color.';' : '';
		$styles_content 	.= $content_color 					? 'color:'.$content_color.';' : '';
		$styles_icon 		.= $icon_size && !$icon_layout 		? 'font-size:'.$icon_size.'px!important;' : '';
		$styles_icon 		.= $icon_color 						? 'color:'.$icon_color.';' : '';
		$styles_icon 		.= $icon_bg_color && $icon_layout 	? 'background-color:'.$icon_bg_color.';border-color:'.$icon_bg_color.';' : '';

		if ( 'yes' == $customize_font ) {
			$styles_title 		.= '' != $title_size 			? 'font-size:'.$title_size.'px!important;line-height:'.($title_size+10).'px;' : '';
			$styles_title 		.= 'yes' == $title_uppercase 	? 'text-transform: uppercase!important;' : 'text-transform: none!important;';
			$styles_subtitle 	.= '' != $subtitle_size 		? 'font-size:'.$subtitle_size.'px!important;line-height:'.($subtitle_size+5).'px;' : '';
			$styles_subtitle 	.= 'yes' == $subtitle_uppercase ? 'text-transform: uppercase!important;' : 'text-transform: none!important;';
			
			// BUILD FONT
			$title_font 			 = $title_font ? tlg_framework_parsing_fonts( $title_font, 'Montserrat', 400 ) : '';
			if ( $title_font ) {
				$fonts[] 			 = $title_font['family'];
				$styles_title  		.= 'text-shadow:none;font-family:'.$title_font['name'].';font-weight:'.$title_font['weight'].';font-style:'.$title_font['style'].';';
			}
			$subtitle_font 			 = $subtitle_font ? tlg_framework_parsing_fonts( $subtitle_font, 'Droid Sans', 400 ) : '';
			if ( $subtitle_font ) {
				$fonts[] 			 = $subtitle_font['family'];
				$styles_subtitle 	.= 'text-shadow:none;font-family:'.$subtitle_font['name'].';font-weight:'.$subtitle_font['weight'].';font-style:'.$subtitle_font['style'].';';
			}
			if( count( $fonts ) ) {
				wp_enqueue_style( 'tlg-ggfonts-'. $element_id, tlg_framework_fonts_url( $fonts ), array() );
			}
		}

		// ICON IMAGE
		if ( 'yes' == $customize_icon && isset($image) ) {
			$url = wp_get_attachment_image_src($image, 'full');
	    	if ( isset($url[0]) && $url[0] ) {
	    		$image_url = tlg_framework_resize_image($url[0], 600, 600, true);
	    	}
			$icon_image = '<div class="icon-image"><img src="'.esc_url($image_url).'" alt="icon-image" /><div class="image-overlay"><i class="'. esc_attr($icon) .'"></i></div></div>';
		}

		// CUSTOM CSS
		$custom_css .= $image_hover_color && $icon_image ? '#'.$element_id.' .icon-link:hover .icon-image .image-overlay{background: '.tlg_framework_hex2rgba($image_hover_color, 0.8).';}' : '';
		$custom_css .= $title_hover_color ? '#'.$element_id.' .icon-link:hover .widgettitle{color:'.$title_hover_color.'!important;}' : '';
		$custom_css = $custom_css ? '<style type="text/css" id="tlg-custom-css-'.$element_id.'">'.$custom_css.'</style>' : '';
		
		// LINK
		if( '' != $icon_box_link ) {
			$href = vc_build_link( $icon_box_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_prefix 	= '<a class="inherit" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}

		// GET STYLE
		if ( ! empty( $styles_title ) ) {
			$style_title = 'style="' . esc_attr( $styles_title ) . '"';
		} else {
			$style_title = '';
		}
		if ( ! empty( $styles_subtitle ) ) {
			$style_subtitle = 'style="' . esc_attr( $styles_subtitle ) . '"';
		} else {
			$style_subtitle = '';
		}
		if ( ! empty( $styles_content ) ) {
			$style_content = 'style="' . esc_attr( $styles_content ) . '"';
		} else {
			$style_content = '';
		}
		if ( ! empty( $styles_icon ) ) {
			$style_icon = 'style="' . esc_attr( $styles_icon ) . '"';
		} else {
			$style_icon = '';
		}

		// DISPLAY
		switch ($box_layout) {
			case 'left':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) . ' inline-block mb16 mr-25 ms-text icon-lg"></i>';
				$output = $link_prefix .'<div class="display-table mb16 mb-xs-24 text-left">
				    		<div class="display-cell vertical-top">
				    			'.( $icon_image ? $icon_image : $icon ).'
				    		</div>
				    		<div class="display-cell">
				    			<h5 '.$style_title.' class="widgettitle '.($subtitle ? 'mb0' : 'mb8').'">'. htmlspecialchars_decode($title) .'</h5>
				    			<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>
				    			<div '.$style_content.' class="icon-content">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>
				    		</div>
				    	</div>'. $link_sufix;
				break;

			case 'right':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) . ' inline-block mb16 ml-25 ms-text icon-lg"></i>';
				$output = $link_prefix .'<div class="display-table mb16 mb-xs-24 text-right">
							<div class="display-cell">
								<h5 '.$style_title.' class="widgettitle '.($subtitle ? 'mb0' : 'mb8').'">'. htmlspecialchars_decode($title) .'</h5>
								<div '.$style_subtitle.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>
								<div '.$style_content.' class="icon-content">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>
							</div>
							<div class="display-cell vertical-top">
								'.( $icon_image ? $icon_image : $icon ).'
							</div>
						</div>'. $link_sufix;
				break;

			case 'center-box':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) . ( $icon_layout ? ' top50 ' : '' ) .' inline-block mb16 ms-text icon-lg"></i>';
				$output = $link_prefix .'<div class="boxed-icon boxed relative mb0 text-center '. ( $icon_layout ? ' mt50 ' : '' ) .'">
								'.( $icon_image ? $icon_image : $icon ).'
							<h5 '.$style_title.' class="widgettitle '.($subtitle ? 'mb0' : 'mb8').' '. ( $icon_layout ? ( strpos($icon_layout,'small') !== false ? 'mt24' : 'mt50' ) : '' ) .'">'. htmlspecialchars_decode($title) .'</h5>
							<div '.$style_subtitle.' class="widgetsubtitle mb16">'. htmlspecialchars_decode($subtitle) .'</div>
							<div '.$style_content.' class="icon-content">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>
						</div>'. $link_sufix;
				break;

			case 'center-box-left':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) . ( $icon_layout ? ' top50 ' : '' ) .' inline-block mb16 ms-text icon-lg"></i>';
				$output = $link_prefix .'<div class="boxed-icon boxed boxed-left relative mb0 text-left '. ( $icon_layout ? ' mt50 ' : '' ) .'">
							'.( $icon_image ? $icon_image : $icon ).'
							<h5 '.$style_title.' class="widgettitle '.($subtitle ? 'mb0' : 'mb8').' '. ( $icon_layout ? ( strpos($icon_layout,'small') !== false ? 'mt24' : 'mt50' ) : '' ) .'">'. htmlspecialchars_decode($title) .'</h5>
							<div '.$style_subtitle.' class="widgetsubtitle mb16">'. htmlspecialchars_decode($subtitle) .'</div>
							<div '.$style_content.' class="icon-content">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>
						</div>'. $link_sufix;
				break;

			case 'center-box-right':
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) . ( $icon_layout ? ' top50 ' : '' ) .' inline-block mb16 ms-text icon-lg"></i>';
				$output = $link_prefix .'<div class="boxed-icon boxed boxed-right relative mb0 text-right '. ( $icon_layout ? ' mt50 ' : '' ) .'">
							'.( $icon_image ? $icon_image : $icon ).'
							<h5 '.$style_title.' class="widgettitle '.($subtitle ? 'mb0' : 'mb8').' '. ( $icon_layout ? ( strpos($icon_layout,'small') !== false ? 'mt24' : 'mt50' ) : '' ) .'">'. htmlspecialchars_decode($title) .'</h5>
							<div '.$style_subtitle.' class="widgetsubtitle mb16">'. htmlspecialchars_decode($subtitle) .'</div>
							<div '.$style_content.' class="icon-content">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div>
						</div>'. $link_sufix;
				break;
			
			case 'center':
			default:
				$icon = '<i '.$style_icon.' class="'. esc_attr( $icon .' '. $icon_layout ) . '  inline-block mb16 ms-text icon-lg"></i>';
				$output = $link_prefix .'<div class="relative mb0 text-center">
							'.( $icon_image ? $icon_image : $icon ).'
							<h5 '.$style_title.' class="widgettitle '.($subtitle ? 'mb0' : 'mb8').'">'. htmlspecialchars_decode($title) .'</h5>
							<div '.$style_subtitle.' class="widgetsubtitle mb16">'. htmlspecialchars_decode($subtitle) .'</div>
							<div '.$style_content.' class="icon-content">'. wpautop(do_shortcode(htmlspecialchars_decode($content))) .'</div> 
						</div>'. $link_sufix;
				break;
		}
		$output = '<div id="'.esc_attr($element_id).'" class="'.esc_attr($color).'"><div class="icon-link">'.$output.'</div></div>';
		if ( $custom_css ) {
			$output .= "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}
		return $output;
	}
	add_shortcode( 'tlg_icon_box', 'tlg_framework_icon_box_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_icon_box_shortcode_vc') ) {
	function tlg_framework_icon_box_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Icon Box', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds icon contents', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_icon_box',
			'base' 			=> 'tlg_icon_box',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Enable icon image?', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select \'Yes\' if you want to use icon as image.', 'tlg_framework' ),
					'class' 		=> '',
					'admin_label' 	=> false,
					'param_name' 	=> 'customize_icon',
					'value' 		=> array(
						esc_html__( 'No', 'tlg_framework' ) => 'no',
						esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
					),
			  	),
				array(
					'type' => 'tlg_icons',
					'heading' => esc_html__( 'Click an Icon to choose', 'tlg_framework' ),
					'param_name' => 'icon',
					'value' => tlg_framework_get_icons(),
					'description' => esc_html__( 'Leave blank to hide icons.', 'tlg_framework' ),
				),
				array(
					'type' 			=> 'attach_image',
					'heading' 		=> esc_html__( 'Icon Image', 'tlg_framework' ),
					'param_name' 	=> 'image',
					'description' => esc_html__( 'Leave blank to hide the image.', 'tlg_framework' ),
					'dependency' 	=> array('element' => 'customize_icon', 'value' => array('yes')),
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Title', 'tlg_framework' ),
					'param_name' => 'title',
					'holder' => 'div',
					'admin_label' 	=> false,
				),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Subtitle', 'tlg_framework' ),
					'param_name' => 'subtitle',
					'holder' => 'div',
					'admin_label' 	=> false,
				),
				array(
					'type' => 'textarea_html',
					'heading' => esc_html__( 'Content', 'tlg_framework' ),
					'param_name' => 'content',
					'holder' => 'div'
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Icon style', 'tlg_framework' ),
					'param_name' => 'icon_layout',
					'value' => array(
						esc_html__( 'Standard', 'tlg_framework' ) => '',
						esc_html__( 'Circle', 'tlg_framework' ) => 'circle-icon',
						esc_html__( 'Circle small', 'tlg_framework' ) => 'circle-icon small-icon',
						esc_html__( 'Circle background', 'tlg_framework' ) => 'circle-icon circle-icon-bg',
						esc_html__( 'Circle background small', 'tlg_framework' ) => 'circle-icon circle-icon-bg small-icon',
						esc_html__( 'Square', 'tlg_framework' ) => 'square-icon',
						esc_html__( 'Square small', 'tlg_framework' ) => 'square-icon small-icon',
						esc_html__( 'Square background', 'tlg_framework' ) => 'square-icon square-icon-bg',
						esc_html__( 'Square background small', 'tlg_framework' ) => 'square-icon square-icon-bg small-icon',
					),
					'admin_label' 	=> true,
					'dependency' 	=> array('element' => 'customize_icon', 'value' => array('no')),
				),
				array(
					'type' 			=> 'tlg_number',
					'heading' 		=> esc_html__( 'Icon font size', 'tlg_framework' ),
					'param_name' 	=> 'icon_size',
					'holder' 		=> 'div',
					'min' 			=> 1,
					'suffix' 		=> 'px',
					'dependency' 	=> array('element' => 'icon_layout', 'value' => array('')),
					'dependency' 	=> array('element' => 'customize_icon', 'value' => array('no')),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'icon_color',
					'dependency' 	=> array('element' => 'customize_icon', 'value' => array('no')),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Icon background color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select background color for icon.', 'tlg_framework' ),
					'param_name' 	=> 'icon_bg_color',
					'dependency' 	=> array('element' => 'customize_icon', 'value' => array('no')),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Box style', 'tlg_framework' ),
					'param_name' 	=> 'box_layout',
					'value' 		=> array(
						esc_html__( 'Center', 'tlg_framework' ) => 'center',
						esc_html__( 'Center boxed', 'tlg_framework' ) => 'center-box',
						esc_html__( 'Center boxed icon left', 'tlg_framework' ) => 'center-box-left',
						esc_html__( 'Center boxed icon right', 'tlg_framework' ) => 'center-box-right',
						esc_html__( 'Left', 'tlg_framework' ) => 'left',
						esc_html__( 'Right', 'tlg_framework' ) => 'right',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' => 'dropdown',
					'heading' => esc_html__( 'Display color', 'tlg_framework' ),
					'param_name' => 'color',
					'value' => array(
						esc_html__( 'Default', 'tlg_framework' ) => '',
						esc_html__( 'Light', 'tlg_framework' ) => 'color-white',
					),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'vc_link',
					'heading' 		=> esc_html__( 'Icon Box link', 'tlg_framework' ),
					'param_name' 	=> 'icon_box_link',
					'value' 		=> '',
			  	),

			  	// Color
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Title color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for title.', 'tlg_framework' ),
						'param_name' 	=> 'title_color',
						'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Title hover color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select hover color for title.', 'tlg_framework' ),
						'param_name' 	=> 'title_hover_color',
						'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Subtitle color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for subtitle.', 'tlg_framework' ),
						'param_name' 	=> 'subtitle_color',
						'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Content color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for content.', 'tlg_framework' ),
						'param_name' 	=> 'content_color',
						'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Image hover color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select hover color for image.', 'tlg_framework' ),
						'param_name' 	=> 'image_hover_color',
						'group' 		=> esc_html__( 'Color Options', 'tlg_framework' ),
					),

			  	// Font - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	            	array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Enable customize font?', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select \'Yes\' if you want to customize font style for this heading.', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'customize_font',
						'value' 		=> array(
							esc_html__( 'No', 'tlg_framework' ) => '',
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
						),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
				  	),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Title font style', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'title_font',
						'value' 		=> array_flip(tlg_framework_get_font_options()),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Title uppercase?', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'title_uppercase',
						'value' 		=> array(
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
							esc_html__( 'No', 'tlg_framework' ) => 'no',
						),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
				  	),
					array(
						'type' 			=> 'tlg_number',
						'heading' 		=> esc_html__( 'Title font size', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'title_size',
						'holder' 		=> 'div',
						'min' 			=> 1,
						'suffix' 		=> 'px',
						'admin_label' 	=> false,
						'description' 	=> esc_html__( 'Leave empty to use the default title font style.', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Subtitle font style', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'subtitle_font',
						'value' 		=> array_flip(tlg_framework_get_font_options()),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
					array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Subtitle uppercase?', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'subtitle_uppercase',
						'value' 		=> array(
							esc_html__( 'No', 'tlg_framework' ) => 'no',
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
						),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
				  	),
					array(
						'type' 			=> 'tlg_number',
						'heading' 		=> esc_html__( 'Subtitle font size', 'tlg_framework' ),
						'group' 		=> esc_html__( 'Font Options', 'tlg_framework' ),
						'param_name' 	=> 'subtitle_size',
						'holder' 		=> 'div',
						'min' 			=> 1,
						'suffix' 		=> 'px',
						'admin_label' 	=> false,
						'description' 	=> esc_html__( 'Leave empty to use the default subtitle font style.', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_font', 'value' => array('yes')),
					),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_icon_box_shortcode_vc' );
}