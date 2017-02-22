<?php
/**
	DISPLAY SHORTCODE
**/		
if( !function_exists('tlg_framework_blog_shortcode') ) {
	function tlg_framework_blog_shortcode( $atts ) {
		# GET PARAMS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		extract( shortcode_atts( array(
			'layout' 		=> 'standard',
			'color' 		=> '',
			'pppage' 		=> '8',
			'filter' 		=> 'all',
			'pagination' 	=> 'no',
			'sticky' 		=> 'no',
			'orderby' 		=> 'date',
			'order' 		=> 'DESC'
		), $atts ) );
		# BUILD QUERY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		if( is_front_page() ) $paged = get_query_var( 'page' ) ? get_query_var( 'page' ) : 1;
		else $paged = get_query_var( 'paged' ) ? get_query_var( 'paged' ) : 1;
		$query_args = array(
			'post_type' 			=> 'post',
			'posts_per_page' 		=> $pppage,
			'paged' 				=> $paged,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'ignore_sticky_posts' 	=> 'no' == $sticky ? true : false,
		);
		if ( 'all' != $filter ) {
			if( function_exists( 'icl_object_id' ) ){
				$filter = (int) icl_object_id( $filter, 'category', true);
			}
			$query_args['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'id',
					'terms' => $filter
				)
			);
		}
		$tlg_query = new WP_Query( $query_args );
		# DISPLAY CONTENT - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		ob_start();
		$blog_id = uniqid( "blog-" );
		$custom_css = '';
		if ( $color ) {
			$custom_css = '<style type="text/css" id="tlg-custom-css-'.$blog_id.'">#'.$blog_id.' .tlg-likes-button .tlg-likes:hover i, #'.$blog_id.' .comments-link a:hover i, #'.$blog_id.' .comments-link a.active i, #'.$blog_id.' .entry-meta .comments-link a:hover i, #'.$blog_id.' .entry-meta .comments-link a.active i, #'.$blog_id.' .tlg-likes-button .tlg-likes.active i, #'.$blog_id.' .post-wrap .inner-left .month{background-color:'.$color.'!important;}#'.$blog_id.' .read-more a, #'.$blog_id.' .entry-meta a:hover{color:'.$color.';} #'.$blog_id.' .read-more a:hover{color:#28262b;}#'.$blog_id.' .bg-overlay:hover .bg-mask, #'.$blog_id.' .box-zoom .box-mask{background-color:'.tlg_framework_hex2rgba($color, 0.95).';}</style>';
			echo "<script type=\"text/javascript\">jQuery(document).ready(function(){jQuery('head').append('".$custom_css."');});</script>";
		}
		switch ( $layout ) {

			case 'grid-2col':
				echo '<div id="'.esc_attr($blog_id).'"><div class="row mb40 grid-blog">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						if( $tlg_query->current_post % 2 == 0 && $tlg_query->current_post ) echo '</div><div class="row mb40 grid-blog">';
						get_template_part( 'templates/post/inc', $layout );
					endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				echo '</div></div>';
				if( 'yes' == $pagination ) echo function_exists( 'tlg_framework_pagination' ) ? tlg_framework_pagination($tlg_query->max_num_pages) : posts_nav_link();
				break;

			case 'grid-3col':
				echo '<div id="'.esc_attr($blog_id).'"><div class="row mb40 grid-blog">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
						if( $tlg_query->current_post % 3 == 0 && $tlg_query->current_post ) echo '</div><div class="row mb40 grid-blog">';
						get_template_part( 'templates/post/inc', $layout );
					endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				echo '</div></div>';
				if( 'yes' == $pagination ) echo function_exists( 'tlg_framework_pagination' ) ? tlg_framework_pagination($tlg_query->max_num_pages) : posts_nav_link();
				break;

			case 'masonry-2col':
			case 'masonry-3col':
				echo '<div id="'.esc_attr($blog_id).'">';
				echo get_template_part( 'templates/post/inc', 'loader' ).'<div class="row masonry masonry-show mb40">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/post/inc', $layout ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				echo '</div><div class="row">';
				if( 'yes' == $pagination ) echo function_exists( 'tlg_framework_pagination' ) ? tlg_framework_pagination($tlg_query->max_num_pages) : posts_nav_link();
				echo '</div></div>';
				break;

			case 'masonry-sidebar-left':
				echo '<section id="'.esc_attr($blog_id).'" class="p0 sidebar-left"><div class="container"><div class="row">';
				get_sidebar();
				echo '<div id="main-content" class="col-md-9">';
				echo get_template_part( 'templates/post/inc', 'loader' ).'<div class="row masonry masonry-show mb40">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/post/inc', 'masonry-2col' ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				echo '</div><div class="row">';
				if( 'yes' == $pagination ) echo function_exists( 'tlg_framework_pagination' ) ? tlg_framework_pagination($tlg_query->max_num_pages) : posts_nav_link();
				echo '</div></div></div></div></section>';
				break;

			case 'masonry-sidebar-right':
				echo '<section id="'.esc_attr($blog_id).'" class="p0"><div class="container"><div class="row">';
				echo '<div id="main-content" class="col-md-9">';
				echo get_template_part( 'templates/post/inc', 'loader' ).'<div class="row masonry masonry-show mb40">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/post/inc', 'masonry-2col' ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				echo '</div><div class="row">';
				if( 'yes' == $pagination ) echo function_exists( 'tlg_framework_pagination' ) ? tlg_framework_pagination($tlg_query->max_num_pages) : posts_nav_link();
				echo '</div></div>';
				get_sidebar();
				echo '</div></div></section>';
				break;

			case 'sidebar-left':
				echo '<section id="'.esc_attr($blog_id).'" class="p0 sidebar-left"><div class="container"><div class="row">';
				get_sidebar();
				echo '<div id="main-content" class="col-md-9 mb-xs-24">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/post/content' ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
        		echo '<div class="row">';
				if( 'yes' == $pagination ) echo function_exists( 'tlg_framework_pagination' ) ? tlg_framework_pagination($tlg_query->max_num_pages) : posts_nav_link();
				echo '</div></div></div></div></section>';
				break;

			case 'sidebar-right':
				echo '<section id="'.esc_attr($blog_id).'" class="p0"><div class="container"><div class="row"><div id="main-content" class="col-md-9 mb-xs-24">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/post/content' ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
        		echo '<div class="row">';
				if( 'yes' == $pagination ) echo function_exists( 'tlg_framework_pagination' ) ? tlg_framework_pagination($tlg_query->max_num_pages) : posts_nav_link();
				echo '</div></div>';
				get_sidebar();
				echo '</div></div></section>';
				break;

			case 'grid-sidebar-left':
				echo '<section id="'.esc_attr($blog_id).'" class="p0 sidebar-left"><div class="container"><div class="row">';
				get_sidebar();
				echo '<div id="main-content" class="col-md-9 col-sm-12"><div class="row mb40">';
		    	if ( $tlg_query->have_posts() ) {
		    		while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
			    		if( $tlg_query->current_post % 2 == 0 && !( $tlg_query->current_post == 0 ) ) {
			    			echo '</div><div class="row mb40">';
			    		}
			    		get_template_part( 'templates/post/inc', 'grid-2col' );
			    	endwhile;	
		    	} else get_template_part( 'templates/post/content', 'none' );
				echo '</div><div class="row">';
			    if( 'yes' == $pagination ) echo function_exists( 'tlg_framework_pagination' ) ? tlg_framework_pagination($tlg_query->max_num_pages) : posts_nav_link();
			    echo '</div></div></div></div></section>';
				break;

			case 'grid-sidebar-right':
				echo '<section id="'.esc_attr($blog_id).'" class="p0"><div class="container"><div class="row"><div id="main-content" class="col-md-9 col-sm-12"><div class="row mb40">';
			    	if ( $tlg_query->have_posts() ) {
			    		while ( $tlg_query->have_posts() ) : $tlg_query->the_post();
				    		if( $tlg_query->current_post % 2 == 0 && !( $tlg_query->current_post == 0 ) ){
				    			echo '</div><div class="row mb40">';
				    		}
				    		get_template_part( 'templates/post/inc', 'grid-2col' );
				    	endwhile;	
			    	} else get_template_part( 'templates/post/content','none');
				echo '</div><div class="row">';
				if( 'yes' == $pagination ) echo function_exists( 'tlg_framework_pagination' ) ? tlg_framework_pagination($tlg_query->max_num_pages) : posts_nav_link();
				echo '</div></div>';
				get_sidebar();
				echo '</div></div></section>';
				break;

			case 'feed':
				echo '<div id="'.esc_attr($blog_id).'">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/post/inc', $layout ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				if( 'yes' == $pagination ) echo function_exists( 'tlg_framework_pagination' ) ? tlg_framework_pagination($tlg_query->max_num_pages) : posts_nav_link();
				echo '</div>';					
				break;

			case 'carousel':
				echo '<section id="'.esc_attr($blog_id).'" class="p0 bg-dark"><div class="blog-carousel four-columns">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/post/inc', 'carousel' ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				echo '</div></section>';
				break;
			case 'carousel-3col':
				echo '<section id="'.esc_attr($blog_id).'" class="p0 bg-dark"><div class="blog-carousel three-columns">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/post/inc', 'carousel' ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				echo '</div></section>';
				break;

			case 'carouseldetail':
				echo '<section id="'.esc_attr($blog_id).'" class="p0 text-left"><div class="blog-carousel blog-carousel-detail four-columns">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/post/inc', 'carouseldetail' ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				echo '</div></section>';
				break;
			case 'carouseldetail-3col':
				echo '<section id="'.esc_attr($blog_id).'" class="p0 text-left"><div class="blog-carousel blog-carousel-detail three-columns">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/post/inc', 'carouseldetail' ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				echo '</div></section>';
				break;

			case 'standard':
			default:
				echo '<div id="'.esc_attr($blog_id).'" class="row"><div class="col-md-12">';
				if ( $tlg_query->have_posts() ) {
					while ( $tlg_query->have_posts() ) : $tlg_query->the_post(); get_template_part( 'templates/post/content' ); endwhile;
				} else get_template_part( 'templates/post/content', 'none' );
				if( 'yes' == $pagination ) echo function_exists( 'tlg_framework_pagination' ) ? tlg_framework_pagination($tlg_query->max_num_pages) : posts_nav_link();
				echo '</div></div>';
				break;
		}
		wp_reset_postdata();
		# RETURN - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -	
		$output = ob_get_contents(); ob_end_clean();
		return $output;
	}
	add_shortcode( 'tlg_blog', 'tlg_framework_blog_shortcode' );
}

/**
	REGISTER SHORTCODE
**/	
if( !function_exists('tlg_framework_blog_shortcode_vc') ) {
	function tlg_framework_blog_shortcode_vc() {
		vc_map( array(
			'name' 			=> esc_html__( 'Blog', 'tlg_framework' ),
			'description' 	=> esc_html__( 'Adds blog feeds to your page', 'tlg_framework' ),
			'icon' 			=> 'tlg_vc_icon_blog',
			'base' 			=> 'tlg_blog',
			'category' 		=> wp_get_theme()->get( 'Name' ) . ' ' . esc_html__( 'WordPress Theme', 'tlg_framework' ),
			'params' 		=> array(
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Blog layout', 'tlg_framework' ),
					'param_name' 	=> 'layout',
					'value' 		=> array( esc_html__( 'Standard', 'tlg_framework' ) => 'standard' ) + array_flip(tlg_framework_get_blog_layouts()),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'tlg_number',
					'heading' 		=> esc_html__( 'Number of posts to show', 'tlg_framework' ),
					'param_name' 	=> 'pppage',
					'holder' 		=> 'div',
					'min' 			=> -1,
					'value' 		=> '8',
					'description' 	=> esc_html__('Enter \'-1\' to show all posts', 'tlg_framework'),
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
					'heading' 		=> esc_html__( 'Show pagination?', 'tlg_framework' ),
					'param_name' 	=> 'pagination',
					'value' 		=> array(
						esc_html__( 'No', 'tlg_framework' ) 	=> 'no',
						esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes'
					),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Show sticky posts?', 'tlg_framework' ),
					'param_name' 	=> 'sticky',
					'value' 		=> array(
						esc_html__( 'No', 'tlg_framework' ) 	=> 'no',
						esc_html__( 'Yes', 'tlg_framework' ) 	=> 'yes'
					),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order by', 'tlg_framework' ),
					'param_name' 	=> 'orderby',
					'value' 		=> array(
						esc_html__( 'Date', 'tlg_framework' ) 			=> 'date',
						esc_html__( 'ID', 'tlg_framework' ) 				=> 'ID',
						esc_html__( 'Most Commented', 'tlg_framework' ) 	=> 'comment_count'
					),
					'admin_label' 	=> true,
				),
				array(
					'type' 			=> 'dropdown',
					'heading' 		=> esc_html__( 'Order', 'tlg_framework' ),
					'param_name' 	=> 'order',
					'value' 		=> array(
						esc_html__( 'Descending', 'tlg_framework' ) 	=> 'DESC',
						esc_html__( 'Ascending', 'tlg_framework' ) 	=> 'ASC',
					),
					'admin_label' 	=> true,
				),
			)
		) );
	}
	add_action( 'vc_before_init', 'tlg_framework_blog_shortcode_vc' );
}