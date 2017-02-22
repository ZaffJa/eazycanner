<?php
/**
	DISPLAY SHORTCODE
**/
if( !function_exists('tlg_framework_intro_content_shortcode') ) {
	function tlg_framework_intro_content_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'image' 				=> '',
			'title' 				=> '',
			'subtitle' 				=> '',
			'btn_link' 				=> '',
			'button_text' 			=> '',
			'button_layout'			=> '',
			'modal_button_layout'	=> 'play-dark',
			'modal_embed' 			=> '',
			'layout' 				=> 'standard-left',
			'box_bg_color' 			=> '',
			'box_text_color' 		=> '',
			'hover' 				=> '',
			'customize_button' 		=> '',
			'btn_custom_layout' 	=> 'btn',
			'btn_color' 			=> '',
			'btn_color_hover' 		=> '',
			'btn_bg' 				=> '',
			'btn_bg_hover' 			=> '',
			'btn_border' 			=> '',
			'btn_border_hover' 		=> '',
		), $atts ) );
		$output 		= '';
		$custom_css 	= '';
		$link_prefix 	= '';
		$link_sufix 	= '';
		$modal 			= '';
		$modal_btn 		= '';
		$modal_class	= '';
		$element_id 	= uniqid('btn-');
		$modal_id 		= uniqid('modal-');

		// BUILD STYLE
		$styles_button 		= '';
		$styles_box_bg 		= '';
		$styles_box_text 	= '';

		if( 'box-top' == $layout || 'box-bottom' == $layout ) {
			$styles_box_bg = $box_bg_color ? 'background-color:'.$box_bg_color.'!important;' : '';
			$styles_box_text = $box_text_color ? 'color:'.$box_text_color.'!important;' : '';
		}
		
		if ( 'yes' == $customize_button ) {
			$button_layout 		= 'btn-link' != $button_layout ? $btn_custom_layout : 'btn-link';
			$btn_color 			= $btn_color 		? $btn_color : '#565656';
			$btn_bg 			= $btn_bg 			? $btn_bg : 'transparent';
			$btn_border 		= $btn_border 		? $btn_border : 'transparent';
			$btn_color_hover 	= $btn_color_hover 	? $btn_color_hover : $btn_color;
			$btn_bg_hover 		= $btn_bg_hover 	? $btn_bg_hover : $btn_bg;
			$btn_border_hover 	= $btn_border_hover ? $btn_border_hover : $btn_border;

			$styles_button 		.= 'color:'.$btn_color.';background-color:'.$btn_bg.';border-color:'.$btn_border.';';
			$custom_css 		.= '<style type="text/css" id="tlg-custom-css-'.$element_id.'">#'.$element_id.':hover{color:'.$btn_color_hover.'!important;background-color:'.$btn_bg_hover.'!important;border-color:'.$btn_border_hover.'!important;}</style>';
			echo "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}

		if ( ! empty( $modal_embed ) ) {
			$modal = '<div class="modal-button"><div class="md-modal md-modal-7" id="'.esc_attr($modal_id).'">'.
			    '<div class="md-content"><div class="md-content-inner">'.wp_oembed_get($modal_embed).'</div></div>'.
			    '<div class="text-center"><a class="md-close inline-block mt24" href="#"><i class="ti-close"></i></a></div>'.
			    '</div><div class="md-overlay"></div></div>';
			$modal_link_prefix 	= '<a data-modal="'.esc_attr($modal_id).'" class="md-trigger m0 '.esc_attr($modal_button_layout).'" href= "#">';
			$modal_link_sufix 	= '</a>';
			$modal_text 		= 'play' == $modal_button_layout ? '<div class="play-button inline"></div>' : '<div class="play-button dark inline"></div>';
			$modal_btn 			= '<div class="modal-video-mask">'.$modal_link_prefix.$modal_text.$modal_link_sufix.'</div>';
			$modal_class = 'modal-video-wrap';
		}

		// GET STYLE
		if ( ! empty( $styles_button ) ) {
			$style_button = 'style="' . esc_attr( $styles_button ) . '"';
		} else {
			$style_button = '';
		}
		if ( ! empty( $styles_box_bg ) ) {
			$style_box_bg = 'style="' . esc_attr( $styles_box_bg ) . '"';
		} else {
			$style_box_bg = '';
		}
		if ( ! empty( $styles_box_text ) ) {
			$style_box_text = 'style="' . esc_attr( $styles_box_text ) . '"';
		} else {
			$style_box_text = '';
		}
		
		// LINK
		if( '' != $btn_link ) {
			$href = vc_build_link( $btn_link );
			if( $href['url'] !== "" ) {
				$target 		= isset($href['target']) && $href['target'] ? "target='".esc_attr($href['target'])."'" : 'target="_self"';
				$rel 			= isset($href['rel']) && $href['rel'] ? "rel='".esc_attr($href['rel'])."'" : '';
				$link_prefix 	= '<a '.$style_button.' id="'.esc_attr($element_id).'" class="' .esc_attr($button_layout. ' ' .$hover). ' btn-lg btn-sm-sm text-center mr-0 mb0 mt24" href= "'.esc_url($href['url']).'" '. $target.' '.$rel.'>';
				$link_sufix 	= '</a>';
			}
		}

		// DISPLAY
		switch ($layout) {
			case 'halfscreen-left':
				$output = '<section class="image-half p0 '.$modal_class.'">
						    <div class="col-lg-6 p0">
						    	<div class="intro-image">'. wp_get_attachment_image( $image, 'full', 0, array('class' => 'mb-xs-24') ) .$modal_btn.'
						    	</div>
						    </div>
						    <div class="container">
						        <div class="col-lg-6 col-lg-offset-1 pl-l-80 vertical-alignment right">'.
						        	( $title ? '<h5 class="widgettitle mb16">'. htmlspecialchars_decode($title) .'</h5>' : '' ) .
						        	( $subtitle ? '<div class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '' ) .
						            '<div>'.do_shortcode($content) .'</div>'.
						            ( $button_text ? $link_prefix. $button_text .$link_sufix : '' ).
						        '</div>
						    </div>'.$modal.'
						</section>';
				break;

			case 'halfscreen-right':
				$output = '<section class="image-half p0 '.$modal_class.'">
						    <div class="col-lg-6 p0 col-lg-push-6">
						    	<div class="intro-image">'. 
						    		wp_get_attachment_image( $image, 'full', 0, array('class' => 'mb-xs-24') ) .$modal_btn.'
						    	</div>
						    </div>
						    <div class="container">
						        <div class="col-lg-6 col-lg-pull-0 pr-l-80 vertical-alignment">'.
						            ( $title ? '<h5 class="widgettitle mb16">'. htmlspecialchars_decode($title) .'</h5>' : '' ) .
						        	( $subtitle ? '<div class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '' ) .
						           	'<div>'.do_shortcode($content) .'</div>'.
						           	( $button_text ? $link_prefix. $button_text .$link_sufix : '' ).
						        '</div>
						    </div>'.$modal.'
						</section>';
				break;

			case 'box-top':
				$output = '<div '.$style_box_bg.' class="boxed-intro overflow-hidden bg-white '.$modal_class.'">
							<div class="intro-image">'.
								wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .$modal_btn.'
							</div>
							<div class="pt32 pb16 pl-32 pr-32">'.
								( $title ? '<h5 '.$style_box_text.' class="widgettitle dark-color mb16">'. htmlspecialchars_decode($title) .'</h5>' : '' ) .
					        	( $subtitle ? '<div '.$style_box_text.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '' ) .
					           	'<div '.$style_box_text.' class="text-color mt8">'.do_shortcode($content) .'</div>'.
					           	( $button_text ? $link_prefix. $button_text .$link_sufix : '' ).
							'</div>'.$modal.'
						</div>';
				break;

			case 'box-bottom':
				$output = '<div '.$style_box_bg.' class="boxed-intro overflow-hidden bg-white '.$modal_class.'">
							<div class="pt32 pb16 pl-32 pr-32">'.
								( $title ? '<h5 '.$style_box_text.' class="widgettitle dark-color mb16">'. htmlspecialchars_decode($title) .'</h5>' : '' ) .
					        	( $subtitle ? '<div '.$style_box_text.' class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '' ) .
					           	'<div '.$style_box_text.' class="text-color mt8">'.do_shortcode($content) .'</div>'.
					           	( $button_text ? $link_prefix. $button_text .$link_sufix : '' ).
							'</div>
							<div class="intro-image">'. wp_get_attachment_image( $image, 'full', 0, array('class' => 'background-image') ) .$modal_btn.'
							</div>'.$modal.'
						</div>';
				break;

			case 'standard-left':
				$output = '<section class="image-standard '.$modal_class.'">
						    <div class="container p0-sm-min">
						        <div class="row vertical-flex">
						            <div class="col-md-7 col-sm-6 text-center mb-xs-24 p0-sm-min border-radius-m">
						            	<div class="intro-image">'. 
						            		wp_get_attachment_image( $image, 'full', 0 ) .$modal_btn.'
						            	</div>
						            </div>
						            <div class="col-md-4 col-md-offset-1 col-sm-5 col-sm-offset-1 p0-sm-min">'.
						                ( $title ? '<h5 class="widgettitle mb16">'. htmlspecialchars_decode($title) .'</h5>' : '' ) .
							        	( $subtitle ? '<div class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '' ) .
							           	'<div>'.do_shortcode($content) .'</div>'.
							           	( $button_text ? $link_prefix. $button_text .$link_sufix : '' ).
						            '</div>
						        </div>
						    </div>'.$modal.'
						</section>';
				break;

			case 'stanndard-right':
			default:
				$output = '<section class="image-standard '.$modal_class.'">
						    <div class="container p0-sm-min">
						        <div class="row vertical-flex">
						            <div class="col-md-4 col-sm-5 mb-xs-24 p0-sm-min">'.
						                ( $title ? '<h5 class="widgettitle mb16">'. htmlspecialchars_decode($title) .'</h5>' : '' ) .
							        	( $subtitle ? '<div class="widgetsubtitle">'. htmlspecialchars_decode($subtitle) .'</div>' : '' ) .
							           	'<div>'.do_shortcode($content) .'</div>'.
							           	( $button_text ? $link_prefix. $button_text .$link_sufix : '' ).
						            '</div>
						            <div class="col-md-7 col-md-offset-1 col-sm-6 col-sm-offset-1 text-center p0-sm-min border-radius-m"><div class="intro-image">'. wp_get_attachment_image( $image, 'full', 0 ) .$modal_btn.'</div></div>
						        </div>
						    </div>'.$modal.'
						</section>';
				break;
		}
		
		return $output;
	}
	add_shortcode( 'tlg_intro_content', 'tlg_framework_intro_content_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_intro_content_shortcode_vc') ) {
	function tlg_framework_intro_content_shortcode_vc() {
		vc_map( array(
		    'name'                    	=> esc_html__( 'Intro content' , 'tlg_framework' ),
		    'description'             	=> esc_html__( 'Create fancy text & image content', 'tlg_framework' ),
		    'icon' 						=> 'tlg_vc_icon_intro_content',
		    'base'                    	=> 'tlg_intro_content',
		    'category' 					=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
		    'params' 					=> array(
		    	array(
		    		'type' 			=> 'dropdown',
		    		'heading' 		=> esc_html__( 'Display stype', 'tlg_framework' ),
		    		'param_name' 	=> 'layout',
		    		'value' 		=> array(
		    			esc_html__( 'Standard image left', 'tlg_framework' ) 		=> 'standard-left',
		    			esc_html__( 'Standard image right', 'tlg_framework' ) 		=> 'stanndard-right',
		    			esc_html__( 'Half-screen image left', 'tlg_framework' ) 	=> 'halfscreen-left',
		    			esc_html__( 'Half-screen image right', 'tlg_framework' ) 	=> 'halfscreen-right',
		    			esc_html__( 'Boxed image top', 'tlg_framework' ) 			=> 'box-top',
		    			esc_html__( 'Boxed image bottom', 'tlg_framework' ) 		=> 'box-bottom'
		    		),
		    		'admin_label' 	=> true,
		    	),
		    	array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Boxed background color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for the background in box layout.', 'tlg_framework' ),
					'param_name' 	=> 'box_bg_color',
					'dependency' 	=> array('element' => 'layout','value' => array('box-top','box-bottom')),
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Boxed text color', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select color for the text in box layout.', 'tlg_framework' ),
					'param_name' 	=> 'box_text_color',
					'dependency' 	=> array('element' => 'layout','value' => array('box-top','box-bottom')),
				),
		    	array(
		    		'type' 			=> 'attach_image',
		    		'heading' 		=> esc_html__( 'Image', 'tlg_framework' ),
		    		'param_name' 	=> 'image'
		    	),
		    	array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Title', 'tlg_framework' ),
					'param_name' 	=> 'title',
					'holder' 		=> 'div',
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Subtitle', 'tlg_framework' ),
					'param_name' 	=> 'subtitle',
					'holder' 		=> 'div',
				),
		    	array(
					'type' 			=> 'textarea_html',
					'heading' 		=> esc_html__( 'Content', 'tlg_framework' ),
					'param_name' 	=> 'content',
					'holder' 		=> 'div'
				),
				array(
					'type' 			=> 'vc_link',
					'heading' 		=> esc_html__( 'Button link', 'tlg_framework' ),
					'param_name' 	=> 'btn_link',
					'value' 		=> '',
			  	),
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Button text', 'tlg_framework' ),
					'param_name' => 'button_text',
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button style', 'tlg_framework' ),
					'param_name' 	=> 'button_layout',
					'value' 		=> tlg_framework_get_button_layouts() + array( esc_html__( 'Link', 'tlg_framework' ) => 'btn-link' ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Button animation', 'tlg_framework' ),
					'param_name' 	=> 'hover',
					'value' 		=> tlg_framework_get_hover_effects(),
				),
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Video URL (use with \'Play button\')', 'tlg_framework' ),
					'param_name' 	=> 'modal_embed',
					'description' 	=> wp_kses( __( 'Enter link to video. Please check out the embed service supported <a target="_blank" href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">here</a>.', 'tlg_framework' ), tlg_framework_allowed_tags() ),
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Modal button style', 'tlg_framework' ),
					'param_name' 	=> 'modal_button_layout',
					'value' 		=> array( esc_html__( 'Dark play button (modal popup)', 'tlg_framework' ) => 'play-dark' ) + array( esc_html__( 'Light play button (modal popup)', 'tlg_framework' ) => 'play' ),
				),
				// Customize buttons - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
		            array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Enable customize button?', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select \'Yes\' if you want to customize colors/layout for this button.', 'tlg_framework' ),
						'class' 		=> '',
						'admin_label' 	=> false,
						'param_name' 	=> 'customize_button',
						'value' 		=> array(
							esc_html__( 'No', 'tlg_framework' ) => '',
							esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes',
						),
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
				  	),
				  	array(
						'type' 			=> 'dropdown',
						'heading' 		=> esc_html__( 'Button customize layout', 'tlg_framework' ),
						'param_name' 	=> 'btn_custom_layout',
						'value' 		=> array(
							esc_html__( 'Standard', 'tlg_framework' ) => 'btn',
							esc_html__( 'Rounded', 'tlg_framework' ) 	=> 'btn btn-rounded',
						),
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
				  	),
		            array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button text color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button text.', 'tlg_framework' ),
						'param_name' 	=> 'btn_color',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button background.', 'tlg_framework' ),
						'param_name' 	=> 'btn_bg',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button border color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button border.', 'tlg_framework' ),
						'param_name' 	=> 'btn_border',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER text color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover text.', 'tlg_framework' ),
						'param_name' 	=> 'btn_color_hover',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER background color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover background.', 'tlg_framework' ),
						'param_name' 	=> 'btn_bg_hover',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
					array(
						'type' 			=> 'colorpicker',
						'heading' 		=> esc_html__( 'Button HOVER border color', 'tlg_framework' ),
						'description' 	=> esc_html__( 'Select color for button hover border.', 'tlg_framework' ),
						'param_name' 	=> 'btn_border_hover',
						'group' 		=> esc_html__( 'Button Options', 'tlg_framework' ),
						'dependency' 	=> array('element' => 'customize_button','value' => array('yes')),
					),
		    )
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_intro_content_shortcode_vc' );
}