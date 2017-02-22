<?php
/**
 * Theme shortcodes
 *
 * @package TLG Framework
 *
 */

/**
	DROPCAP SHORTCODE
**/
if( !function_exists('tlg_framework_shortcode_dropcap') ) {
	function tlg_framework_shortcode_dropcap( $atts ) {
		extract(shortcode_atts(array(
			'text' => '',
			'background' => '',
			'color' => '',
		), $atts ));
		$dropcap_css = 'display: inline-block;float: left;font-size: 400%;width: 1em;height: 1em;line-height: 1;text-align: center;margin-right: 10px;border-radius: 2px; margin-bottom: 0;';
		$dropcap_css .= $color ? 'color:'.$color.';' : '';
		$dropcap_css .= $background ? 'background:'.$background.';font-size: 200%;width: 2em;height: 2em;line-height: 2;' : '';
		return '<span style="'.esc_attr($dropcap_css).'">'. $text .'</span>';
	}
	add_shortcode( 'tlg_dropcap', 'tlg_framework_shortcode_dropcap' );
}

/**
	HIGHLIGHT SHORTCODE
**/
if( !function_exists('tlg_framework_shortcode_highlight') ) {
	function tlg_framework_shortcode_highlight( $atts ) {
		extract(shortcode_atts(array(
			'text' => '',
			'background' => '#1e1e1e',
			'color' => '#fff',
		), $atts ));
		return '<span style="background:'.esc_attr($background).';color:'.esc_attr($color) .'">'. $text .'</span>';
	}
	add_shortcode( 'tlg_highlight', 'tlg_framework_shortcode_highlight' );
}

/**
	BLOCK SHORTCODE
**/
if( !function_exists('tlg_framework_shortcode_block') ) {
	function tlg_framework_shortcode_block( $atts ) {
		extract(shortcode_atts(array(
			'text' 			=> '',
			'background' 	=> '#bbb',
			'color' 		=> '#565656',
			'caption' 		=> '',
			'style' 		=> '',
		), $atts ));
		if ( 'legend' == $style ) {
			$output = '<div style="border: 4px double '.esc_attr($background).';color:'.esc_attr($color) .';margin: 3em 0;padding: 30px;"><h4 class="legend" style="font-size: 16px;color:'.esc_attr($background).';float: left;left: 11px; line-height: 18px; margin: 0 0 -9px !important; padding: 0 10px; position: relative; text-transform: uppercase; top: -41px;">'.$caption.'</h4><p style="clear: both;margin: 7px;">'. $text .'</p></div>';
		} else {
			$output = '<div class="mb16" style="padding: 30px;background:'.esc_attr($background).';color:'.esc_attr($color) .'"><h5 style="color:'.esc_attr($color) .';margin-bottom:8px;">'.$caption.'</h5>'. $text .'</div>';
		}
		return $output;
	}
	add_shortcode( 'tlg_block', 'tlg_framework_shortcode_block' );
}

/**
	VISUAL COMPOSER SHORTCODE
**/
if( function_exists('vc_set_as_theme') ) {
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_spacer.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_header_single.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_header_slider.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_page_title.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_headings.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_blog.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_portfolio.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_team.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_clients.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_testimonials.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_icon_box.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_icons.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_alert.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_skill_bar.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_counter.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_accordion.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_tabs.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_showcase.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_gmap.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_intro_content.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_intro_carousel.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_image_caption.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_pricing_table.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_icon_title_list.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_buttons.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_buttons_modal.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_countdown.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_cta.php' );
	require_once( TLG_FRAMEWORK_PATH . 'includes/vc_shortcodes/tlg_instagram.php' );

	if ( function_exists( 'vc_add_shortcode_param' ) ) {

		if( !function_exists('tlg_framework_vc_number_field') ) {		
			function tlg_framework_vc_number_field($settings, $value) {
				$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
				$type = isset($settings['type']) ? $settings['type'] : '';
				$min = isset($settings['min']) ? $settings['min'] : '';
				$max = isset($settings['max']) ? $settings['max'] : '';
				$step = isset($settings['step']) ? $settings['step'] : '';
				$suffix = isset($settings['suffix']) ? $settings['suffix'] : '';
				return '<input type="number" min="'.esc_attr($min).'" max="'.esc_attr($max).'" step="'.esc_attr($step).'" class="wpb_vc_param_value ' . esc_attr($param_name) . ' ' . esc_attr($type) . '" name="' . esc_attr($param_name) . '" value="'.esc_attr($value).'" style="max-width:100px; margin-right: 10px;" />'.$suffix;
			}
			vc_add_shortcode_param( 'tlg_number', 'tlg_framework_vc_number_field' );
		}

		if( !function_exists('tlg_framework_vc_icons_field') ) {
			function tlg_framework_vc_icons_field( $settings, $value ) {
				$icons  = $settings['value'];
				$output = '<div class="tlg-icons"><div class="tlg-icons-wrapper">';
				foreach( $icons as $icon ) {
					$active  = $value == $icon ? ' active' : '';
					$output .= '<i class="icon '. $icon . $active .'" data-icon-class="'. $icon .'"></i>';
				}
				$output .= '</div><input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput tlg-icon-value ' .esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />' . '</div>';
			    return $output;
			}
			vc_add_shortcode_param( 'tlg_icons', 'tlg_framework_vc_icons_field' );
		}

		if( !function_exists('tlg_framework_vc_datetime_field') ) {
			function tlg_framework_vc_datetime_field( $settings, $value ) {
				$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
				$type = isset($settings['type']) ? $settings['type'] : '';
				$class = isset($settings['class']) ? $settings['class'] : '';
				$uid = uniqid('datetimepicker-'.esc_attr(rand()));
				return '<div><input id="datetimepicker'.esc_attr( $uid ).'" type="text" size="16" readonly class="wpb_vc_param_value ' . esc_attr( $param_name . ' ' . $type . ' ' . $class ) . '" name="' . esc_attr( $param_name ) . '" value="'. esc_attr( $value ) .'"/></div>'.
						'<script type="text/javascript">jQuery(document).ready(function(){jQuery("#datetimepicker'.esc_attr( $uid ).'").datetimepicker();})</script>';
			}
			vc_add_shortcode_param( 'tlg_datetime', 'tlg_framework_vc_datetime_field' );
		}
	}
}