<?php
/**
	DISPLAY SHORTCODE
**/
if( !function_exists('tlg_framework_team_shortcode') ) {
	function tlg_framework_team_shortcode( $atts ) {
		# GET PARAMS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 		
		extract( shortcode_atts( array(
			'type' 		=> 'large',
			'pppage' 	=> '999',
			'filter' 	=> 'all',
			'layout' 	=> 'grid'
		), $atts ) );
		# BUILD QUERY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
		$query_args = array(
			'post_type' 		=> 'team',
			'posts_per_page' 	=> $pppage
		);
		if ( 'all' != $filter ) {
			if( function_exists( 'icl_object_id' ) ) {
				$filter = (int) icl_object_id( $filter, 'team_category', true );
			}
			$query_args['tax_query'] = array( array(
				'taxonomy' 	=> 'team_category',
				'field' 	=> 'id',
				'terms' 	=> $filter
			) );
		}
		$tlg_query = new WP_Query( $query_args );
		# DISPLAY CONTENT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		ob_start();
		if ( $tlg_query->have_posts() ) {
			switch ( $layout ) {

				case 'animate':
					echo '<div class="row">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/team/inc', 'animate');
	    				if( ($tlg_query->current_post + 1) % 3 == 0 ) echo '</div><div class="row mb80 mb-xs-24">';
					endwhile;
					echo '</div>';
					break;

				case 'fullwidth':
					echo '<div class="row">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/team/inc', 'fullwidth');
						if( ($tlg_query->current_post + 1) % 3 == 0 ) echo '</div><div class="row">';
					endwhile;
					echo '</div>';
					break;

				case 'standard':
				default:
					echo '<div class="row">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						get_template_part( 'templates/team/inc', 'standard');
						if( ($tlg_query->current_post + 1) % 3 == 0 ) echo '</div><div class="row">';
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
	add_shortcode( 'tlg_team', 'tlg_framework_team_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_team_shortcode_vc') ) {
	function tlg_framework_team_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Team', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Add your team to the page.', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_team',
			'base' 			=> 'tlg_team',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Number of posts to show', 'tlg_framework' ),
					'param_name' 	=> 'pppage',
					'value' 		=> '8'
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Team layout', 'tlg_framework' ),
					'param_name' 	=> 'layout',
					'value' 		=> array_flip(tlg_framework_get_team_layouts()),
					'admin_label' 	=> true,
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_team_shortcode_vc');
}