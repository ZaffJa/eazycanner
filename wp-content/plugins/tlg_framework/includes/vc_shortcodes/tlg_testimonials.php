<?php
/**
	DISPLAY SHORTCODE
**/
if( !function_exists('tlg_framework_testimonial_shortcode') ) {
	function tlg_framework_testimonial_shortcode( $atts ) {
		# GET PARAMS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 		
		extract( shortcode_atts( array(
			'pppage' => '999',
			'filter' => 'all',
			'layout' => 'standard',
			'color'  => '',
		), $atts ) );
		# BUILD QUERY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 		
		$query_args = array(
			'post_type' 		=> 'testimonial',
			'posts_per_page' 	=> $pppage
		);
		if ( 'all' != $filter ) {
			if( function_exists( 'icl_object_id' ) ) {
				$filter = (int) icl_object_id( $filter, 'testimonial_category', true);
			}
			$query_args['tax_query'] = array(
				array(
					'taxonomy' 	=> 'testimonial_category',
					'field' 	=> 'id',
					'terms' 	=> $filter
				)
			);
		}
		$tlg_query = new WP_Query( $query_args );
		# DISPLAY CONTENT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 		
		ob_start();
		$testimonial_id = uniqid( "testimonial_" );
		$custom_css = '';
		if ( $color ) {
			$custom_css = '<style>#'.$testimonial_id.'.testimonials.slider-quote .owl-carousel .owl-controls .owl-nav .owl-prev:before, #'.$testimonial_id.'.testimonials.slider-quote .owl-carousel .owl-controls .owl-nav .owl-next:before {background-color:'.$color.'!important;}#'.$testimonial_id.'.testimonials.slider-quote .owl-carousel .owl-controls .owl-nav .owl-prev:hover:before, #'.$testimonial_id.'.testimonials.slider-quote .owl-carousel .owl-controls .owl-nav .owl-next:hover:before {background-color:#28262b!important;}</style>';
			echo "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}
		if ( $tlg_query->have_posts() ) {
			switch ( $layout ) {
				case 'carousel':
					echo '<div id="'.esc_attr($testimonial_id).'" class="testimonials text-slider text-center slider-standard"><ul class="slides carousel-one-item owl-carousel owl-theme">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', 'carousel' );
					endwhile;
					echo '</ul></div>';
					break;

				case 'carousel-quote':
					echo '<div id="'.esc_attr($testimonial_id).'" class="testimonials text-slider text-left slider-quote"><ul class="slides carousel-one-item owl-carousel owl-theme">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', 'carousel-quote' );
					endwhile;
					echo '</ul></div>';
					break;

				case 'carousel-no-control':
					echo '<div id="'.esc_attr($testimonial_id).'" class="testimonials text-slider text-center slider-rotator"><ul class="slides">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', 'carousel-no-control' );
					endwhile;
					echo '</ul></div>';
					break;

				case 'standard':
				default:
					echo '<div id="'.esc_attr($testimonial_id).'" class="testimonials"><div class="row">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/testimonial/inc', 'standard' );
						if( ($tlg_query->current_post + 1) % 3 == 0 ) echo '</div><div class="row">';
					endwhile;
					echo '</div></div>';
					break;
			}
		} else get_template_part( 'templates/post/content', 'none' );
		wp_reset_postdata();
		# RETURN - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 			
		$output = ob_get_contents(); ob_end_clean();
		return $output;
	}
	add_shortcode( 'tlg_testimonial', 'tlg_framework_testimonial_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_testimonial_shortcode_vc') ) {
	function tlg_framework_testimonial_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Testimonials', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds testimonials content', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_testimonial',
			'base' 			=> 'tlg_testimonial',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
			'params' => array(
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Number of posts to show', 'tlg_framework' ),
					'param_name' 	=> 'pppage',
					'value' 		=> '8'
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Testimonial layout', 'tlg_framework' ),
					'param_name' 	=> 'layout',
					'value' 		=> array_flip(tlg_framework_get_testimonial_layouts()),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Color schema', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select the color schema. Leave empty to use default primary color', 'tlg_framework' ),
					'param_name' 	=> 'color',
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_testimonial_shortcode_vc' );
}