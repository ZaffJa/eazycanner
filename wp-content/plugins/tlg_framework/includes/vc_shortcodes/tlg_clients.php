<?php
/**
	DISPLAY SHORTCODE
**/		
if( !function_exists('tlg_framework_clients_shortcode') ) {
	function tlg_framework_clients_shortcode( $atts ) {
		# GET PARAMS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 		
		extract( shortcode_atts( array(
			'pppage' => '8',
			'filter' => 'all',
			'layout' => 'standard'
		), $atts ) );
		# BUILD QUERY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
		$query_args = array(
			'post_type' => 'client',
			'posts_per_page' => $pppage
		);
		if ( 'all' != $filter ) {
			if( function_exists( 'icl_object_id' ) ){
				$filter = (int)icl_object_id( $filter, 'client_category', true);
			}
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'client_category',
					'field' => 'id',
					'terms' => $filter
				)
			);
		}
		$tlg_query = new WP_Query( $query_args );
		# DISPLAY CONTENT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 		
		ob_start();
		if ( $tlg_query->have_posts() ) {
			switch ( $layout ) {
				case 'carousel':
					echo '<ul class="logo-carousel-owl">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/client/inc', 'carousel' ); endwhile;
					echo '</ul>';
					break;

				case 'carousel-auto':
					echo '<div class="logo-carousel"><ul class="slides">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/client/inc', 'carousel' ); endwhile;
					echo '</ul></div>';
					break;

				case 'standard':
				default:
					echo '<div class="logo-standard row">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/client/inc', 'standard');
						if( ($tlg_query->current_post + 1) % 4 == 0 ) echo '</div><div class="logo-standard row">';
					endwhile;
					echo '</div>';
					break;
			}
		} else get_template_part( 'templates/post/content', 'none' );
		wp_reset_postdata();
		# RETURN - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 			
		$output = ob_get_contents(); ob_end_clean();
		return $output;
	}
	add_shortcode( 'tlg_clients', 'tlg_framework_clients_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_clients_shortcode_vc') ) {
	function tlg_framework_clients_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Clients', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds client contents', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_client',
			'base' 			=> 'tlg_clients',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
			'params' => array(
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__('Number of posts to show', 'tlg_framework'),
					'param_name' 	=> 'pppage',
					'value' 		=> '8',
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__('Client layout', 'tlg_framework'),
					'param_name' 	=> 'layout',
					'value' 		=> array_flip(tlg_framework_get_client_layouts()),
					'admin_label' 	=> true,
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_clients_shortcode_vc');
}