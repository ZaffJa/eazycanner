<?php
/**
	DISPLAY SHORTCODE
**/	
if( !function_exists('tlg_framework_portfolio_shortcode') ) {
	function tlg_framework_portfolio_shortcode( $atts ) {
		# GET PARAMS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -		
		extract( shortcode_atts( array(
			'layout' => 'grid-2col',
			'color' => '',
			'pppage' => '8',
			'show_filter' => 'Yes',
			'filter' => 'all'
		), $atts ) );
		# BUILD QUERY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		$query_args = array(
			'post_type' => 'portfolio',
			'posts_per_page' => $pppage
		);
		if ( 'all' != $filter ) {
			if( function_exists( 'icl_object_id' ) ) {
				$filter = (int)icl_object_id( $filter, 'portfolio_category', true);
			}
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'portfolio_category',
					'field' => 'id',
					'terms' => $filter
				)
			);
		}
		$tlg_query = new WP_Query( $query_args );
		if( 'all' == $filter ) {
			$cats = get_categories( 'taxonomy=portfolio_category' );
		} else {
			$cats = get_categories( 'taxonomy=portfolio_category&exclude='. $filter .'&child_of='. $filter );
		}
		# DISPLAY CONTENT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 		
		ob_start();
		if ( $tlg_query->have_posts() ) {
			$custom_css 			= '';
			$project_id 			= uniqid( "project-" );
			$project_filter 		= '<div class="row pb24"><div class="col-sm-12 text-center"><ul class="filters mb0" data-project-id="'.esc_attr($project_id).'"></ul></div></div>';
			$project_filter_full 	= '<div class="center-absolute"><ul class="filters center-absolute-inner box-shadow mb0" data-project-id="'.esc_attr($project_id).'"></ul></div>';
			if ( $color ) {
				$custom_css = '<style type="text/css" id="tlg-custom-css-'.$project_id.'">#'.$project_id.' .box-zoom .box-mask{background-color:'.tlg_framework_hex2rgba($color, 0.95).'!important;}</style>';
				echo "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
			}
			switch ( $layout ) {

				case 'masonry-2col':
				case 'masonry-3col':
				case 'masonry-4col':
				case 'zoom-masonry-2col':
				case 'zoom-masonry-3col':
				case 'zoom-masonry-4col':
					echo '<section class="projects"><div class="container">';
			    	echo 'Yes' == $show_filter ? $project_filter : ''; get_template_part( 'templates/post/inc', 'loader' ); 
			    	echo '<div id="'.esc_attr($project_id).'" data-id="'.esc_attr($project_id).'" class="row masonry masonry-show project-content project-masonry">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/portfolio/inc', $layout ); endwhile;
					echo '</div></div></section>';
					break;

				case 'full-masonry-2col':
				case 'full-masonry-3col':
				case 'full-masonry-4col':
				case 'zoom-full-masonry-2col':
				case 'zoom-full-masonry-3col':
				case 'zoom-full-masonry-4col':
					echo '<section class="projects p0">';
			    	echo 'Yes' == $show_filter ? $project_filter_full : ''; get_template_part( 'templates/post/inc', 'loader' );
			    	echo '<div id="'.esc_attr($project_id).'" data-id="'.esc_attr($project_id).'" class="row project-content project-full">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/portfolio/inc', $layout ); endwhile;
					echo '</div></section>';
					break;

				case 'grid-2col':
				case 'grid-3col':
				case 'grid-4col':
				case 'zoom-grid-2col':
				case 'zoom-grid-3col':
				case 'zoom-grid-4col':
					echo '<section class="projects"><div class="container">';
			    	echo 'Yes' == $show_filter ? $project_filter : ''; get_template_part( 'templates/post/inc', 'loader' ); 
			    	echo '<div id="'.esc_attr($project_id).'" data-id="'.esc_attr($project_id).'" class="row project-content">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/portfolio/inc', $layout ); endwhile;
					echo '</div></div></section>';
					break;

				case 'full-grid-2col':
				case 'full-grid-3col':
				case 'full-grid-4col':
				case 'zoom-full-grid-2col':
				case 'zoom-full-grid-3col':
				case 'zoom-full-grid-4col':
					echo '<section class="projects p0">';
			    	echo 'Yes' == $show_filter ? $project_filter_full : ''; get_template_part( 'templates/post/inc', 'loader' ); 
			    	echo '<div id="'.esc_attr($project_id).'" data-id="'.esc_attr($project_id).'" class="row project-content project-full">';
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/portfolio/inc', $layout ); endwhile;
					echo '</div></section>';
					break;

				case 'parallax-large':
				case 'parallax-small':
				case 'parallax':
				default:
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/portfolio/inc', $layout ); endwhile;
					break;
			}
		} else get_template_part( 'templates/post/content', 'none' );
		wp_reset_postdata();
		# RETURN - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		$output = ob_get_contents(); ob_end_clean();
		return $output;
	}
	add_shortcode( 'tlg_portfolio', 'tlg_framework_portfolio_shortcode' );
}

/**
	REGISTER SHORTCODE
**/
if( !function_exists('tlg_framework_portfolio_shortcode_vc') ) {
	function tlg_framework_portfolio_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Portfolio', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds portfolio feeds', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_portfolio',
			'base' 			=> 'tlg_portfolio',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' 			=> 'textfield',
					'heading' 		=> esc_html__( 'Number of posts to show', 'tlg_framework' ),
					'param_name' 	=> 'pppage',
					'value' 		=> '8',
					'description' 	=> esc_html__('Enter \'-1\' to show all posts', 'tlg_framework'),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Portfolio layout', 'tlg_framework' ),
					'param_name' 	=> 'layout',
					'value' 		=> array_flip(tlg_framework_get_portfolio_layouts()),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'colorpicker',
					'heading' 		=> esc_html__( 'Color schema', 'tlg_framework' ),
					'description' 	=> esc_html__( 'Select the color schema. Leave empty to use default primary color', 'tlg_framework' ),
					'param_name' 	=> 'color',
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Show filters?', 'tlg_framework' ),
					'param_name' 	=> 'show_filter',
					'value' 		=> array( esc_html__( 'Yes', 'tlg_framework' ), esc_html__( 'No', 'tlg_framework' ) ),
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_portfolio_shortcode_vc' );
}