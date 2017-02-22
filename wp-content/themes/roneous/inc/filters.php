<?php
/**
 * Theme Filter
 *
 * @package TLG Theme
 *
 */

/**
	BODY CLASSES
**/
if( !function_exists('roneous_body_classes') ) {
	function roneous_body_classes( $classes ) {
		$classes[] = roneous_get_body_layout();
		if ( 'yes' == get_option( 'roneous_enable_preloader', 'no' ) ) {
			$classes[] = 'loading';
		}
		return $classes;
	}
	add_filter( 'body_class', 'roneous_body_classes' );
}

/**
	REMOVE WHITESPACE FROM EXPERT
**/
if( !function_exists('roneous_excerpt_length') ) {
	function roneous_excerpt_trim( $excerpt ) {
	    return preg_replace( '~^(\s*(?:&nbsp;)?)*~i', '', $excerpt );
	}
	add_filter( 'get_the_excerpt', 'roneous_excerpt_trim', 999 );
}

/**
	EXPERT DEFAULT MORE
**/
if( !function_exists('roneous_excerpt_more') ) {
	function roneous_excerpt_more( $more ) {
		return esc_html__( '...', 'roneous' );
	}
	add_filter( 'excerpt_more', 'roneous_excerpt_more' );
}

/**
	EXPERT DEFAULT LENGTH
**/
if( !function_exists('roneous_excerpt_length') ) {
	function roneous_excerpt_length( $length ) {
		return 16;
	}
	add_filter( 'excerpt_length', 'roneous_excerpt_length', 999 );
}


/**
	REMOVE MORE LINK
**/
if( !function_exists('roneous_remove_more_link_scroll') ) { 
	function roneous_remove_more_link_scroll( $link ) {
		return preg_replace( '|#more-[0-9]+|', '', $link );
	}
	add_filter( 'the_content_more_link', 'roneous_remove_more_link_scroll' );
}

/**
	ADD CLEARFIX TO END CONTENT
**/
if( !function_exists('roneous_add_clearfix') ) { 
	function roneous_add_clearfix( $content ) { 
		if( is_single() ) {
	   		$content .= '<div class="clearfix"></div>';
		}
	    return $content;
	}
	add_filter( 'the_content', 'roneous_add_clearfix' );
}

/**
	NAV MENU SELECTED
**/
if( !function_exists('roneous_wp_nav_menu_args') ) {
	function roneous_wp_nav_menu_args( $args = '' ) {
		global $post;
		if( isset($post->ID) ) {
			$selected_menu_id = get_post_meta( $post->ID, '_tlg_menu_override', 1 );
			if( $selected_menu_id ) {
				$args['theme_location'] = false;
				$args['menu'] = $selected_menu_id;
			}
		}
		return $args;
	}
	add_filter( 'wp_nav_menu_args', 'roneous_wp_nav_menu_args' );
}

/**
	SEARCH FILTER FOR POST ONLY
**/
if( !function_exists('roneous_search_filter') && 'yes' == get_option( 'roneous_enable_search_filter', 'yes' ) ) { 
	function roneous_search_filter( $query ) {
		if ( $query->is_search ) {
			$query->set( 'post_type', array('post', 'product') );
		}
		return $query;
	}
	add_filter('pre_get_posts','roneous_search_filter');
}

/**
	FIX FOR EASY GOOGLE FONT PLUGIN USERS
**/
if( !function_exists('roneous_force_styles') ) { 
	function roneous_force_styles( $force_styles ) {
	    return true;
	}
	add_filter( 'tt_font_force_styles', 'roneous_force_styles' );
}

/**
	CUSTOM MEDIA GALLERY STYLE
**/
if( !function_exists('roneous_add_gallery_settings') ) { 
	function roneous_add_gallery_settings() { ?>
		<script type="text/html" id="tmpl-tlg_gallery-setting">
			<label class="setting">
				<span><?php esc_html_e('Layout', 'roneous'); ?></span>
				<select data-setting="layout">
					<option value="default"><?php esc_html_e( '(default layout)', 'roneous' ); ?></option>
					<option value="fullwidth"><?php esc_html_e( 'Fullwidth', 'roneous' ); ?></option>
					<option value="slider"><?php esc_html_e( 'Slider', 'roneous' ); ?></option>
					<option value="slider-padding"><?php esc_html_e( 'Slider padding', 'roneous' ); ?></option>
					<option value="slider-thumb"><?php esc_html_e( 'Slider thumbnail', 'roneous' ); ?></option>
					<option value="lightbox"><?php esc_html_e( 'Lightbox', 'roneous' ); ?></option>
					<option value="lightbox-fullwidth"><?php esc_html_e( 'Lightbox fullwidth', 'roneous' ); ?></option>
					<option value="masonry"><?php esc_html_e( 'Lightbox masonry', 'roneous' ); ?></option>
					<option value="masonry-grid"><?php esc_html_e( 'Lightbox masonry grid', 'roneous' ); ?></option>
				</select>
			</label>
		</script>
		<script>
			jQuery(document).ready(function() {
				jQuery.extend(wp.media.gallery.defaults, { layout: 'default' });
				wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
					template: function(view) {
					  return wp.media.template('gallery-settings')(view) + wp.media.template('tlg_gallery-setting')(view);
					}
				});
			});
		</script>
	<?php
	}
	add_action( 'print_media_templates', 'roneous_add_gallery_settings' );
}

/**
	CUSTOM POST GALLERY STYLE
**/
if( !function_exists('roneous_post_gallery') ) {
	function roneous_post_gallery( $output, $attr) {
		global $post, $wp_locale;
	    static $instance = 0; $instance++;
	    extract(shortcode_atts(array(
	        'order'      => 'ASC',
	        'orderby'    => 'menu_order ID',
	        'id'         => $post->ID,
	        'itemtag'    => 'div',
	        'icontag'    => 'dt',
	        'captiontag' => 'dd',
	        'columns'    => 3,
	        'size'       => 'large',
	        'include'    => '',
	        'exclude'    => '',
	        'layout'     => ''
	    ), $attr));
	    $output = $image = '';
	    if ( 'RAND' == $order ) $orderby = 'none';
	    if ( !empty($include) ) {
	        $include = preg_replace( '/[^0-9,]+/', '', $include );
	        $_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	        $attachments = array();
	        foreach ( $_attachments as $key => $val ) $attachments[$val->ID] = $_attachments[$key];
	    } elseif ( empty($exclude) ) {
	    	$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	    } else {
	        $exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
	        $attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	    }
	    if ( empty($attachments) ) return '';
	    switch ($layout) {
	    	case 'slider':
	    		$output = '<div class="clearfix mt16"><ul class="carousel-one-item carousel-olw-nav slides post-slider">';
	    		foreach ( $attachments as $id => $attachment ) {
	    			$url = wp_get_attachment_image_src($id, 'full');
	    			if ( isset($url[0]) && $url[0] ) {
						$image = roneous_resize_image($url[0], 1280, 900, true);
		    		    $output .= $image ? '<li><img src="'. esc_url($image) .'" alt="'.esc_html__( 'gallery-item', 'roneous' ).'" /></li>' : '';
	    			}
	    		}
		    	$output .= '</ul></div>';
	    		break;

	    	case 'slider-padding':
	    		$output = '<div class="clearfix mt16"><ul class="carousel-padding-item slides">';
	    		foreach ( $attachments as $id => $attachment ) {
	    			$url = wp_get_attachment_image_src($id, 'full');
	    			if ( isset($url[0]) && $url[0] ) {
						$image = roneous_resize_image($url[0], 900, 600, true);
	    		    	$output .= $image ? '<li><a href="'. esc_url($url[0]) .'" data-lightbox="true">
	    		    		<div class="bg-overlay">
	    		    			<img src="'. esc_url($image) .'" alt="'.esc_html__( 'gallery-item', 'roneous' ).'" />
	    		    			<div class="bg-mask mask-white"><i class="ti-plus"></i></div>
	    		    		</div></a></li>' : '';
	    			}
	    		}
	    		$output .= '</ul></div>';
	    		break;

	    	case 'slider-thumb':
	    		$output = '<div class="clearfix slider-thumb mt16"><ul class="slides">';
	    		foreach ( $attachments as $id => $attachment ) {
	    			$url = wp_get_attachment_image_src($id, 'full');
	    			if ( isset($url[0]) && $url[0] ) {
						$image = roneous_resize_image($url[0], 1280, 900, true);
	    		    	$output .= $image ? '<li><img src="'. esc_url($image) .'" alt="'.esc_html__( 'gallery-item', 'roneous' ).'" /></li>' : '';
	    			}
	    		} 
		    	$output .= '</ul></div>';
	    		break;

	    	case 'lightbox':
	    		$output = '<div class="lightbox-gallery mt16 '.( 3 == $columns ? 'third-thumbs' : ( 2 == $columns ? 'half-thumbs' : '' ) ).'" data-gallery-title="'. esc_attr(get_the_title()) .'"><ul>';
		    	foreach ( $attachments as $id => $attachment ) {
		    		$url = wp_get_attachment_image_src($id, 'full');
		    		if ( isset($url[0]) && $url[0] ) {
						$image = roneous_resize_image($url[0], 900, 600, true);
		    	    	$output .= $image ? '<li><a href="'. esc_url($url[0]) .'" data-lightbox="true">'.
		    	    	        '<div class="bg-overlay">
	    	    	        		<img src="'. esc_url($image) .'" alt="'.esc_html__( 'gallery-item', 'roneous' ).'" />
	    	    	        		<div class="bg-mask mask-white"><i class="ti-plus"></i></div>
	    	    	        	</div></a></li>' : '';
		    	    }
		    	}
		    	$output .= '</ul></div>';
	    		break;

	    	case 'lightbox-fullwidth':
	    		$output = '<div class="lightbox-gallery lightbox-fullwidth mt16 '.( 3 == $columns ? 'third-thumbs' : ( 2 == $columns ? 'half-thumbs' : '' ) ).'" data-gallery-title="'. esc_attr(get_the_title()) .'"><ul>';
		    	foreach ( $attachments as $id => $attachment ) {
		    		$url = wp_get_attachment_image_src($id, 'full');
		    		if ( isset($url[0]) && $url[0] ) {
						$image = roneous_resize_image($url[0], 900, 600, true);
		    	    	$output .= $image ? '<li><a href="'. esc_url($url[0]) .'" data-lightbox="true">'.
		    	    	        '<div class="bg-overlay">
		    	    	        	<img src="'. esc_url($image) .'" alt="'.esc_html__( 'gallery-item', 'roneous' ).'" />
		    	    	        	<div class="bg-mask mask-white"><i class="ti-plus"></i></div>
	    	    	        	</div>
		    	    	        </a></li>' : '';
		    	    }
		    	}
		    	$output .= '</ul></div>';
	    		break;

	    	case 'masonry':
	    		$output = '<div><ul class="row masonry masonry-show project-content project-masonry-full" data-gallery-title="'. esc_attr(get_the_title()) .'">';
		    	foreach ( $attachments as $id => $attachment ) {
		    		$url = wp_get_attachment_image_src($id, 'full');
		    		if ( isset($url[0]) && $url[0] ) {
		    	    	$output .= '<li class="col-md-4 col-sm-6 masonry-item project"><a href="'. esc_url($url[0]) .'" data-lightbox="true">
										<div class="image-box hover-block text-center">
										    <img src="'. esc_url($url[0]) .'" alt="'.esc_html__( 'gallery-item', 'roneous' ).'" />
										    <div class="hover-state pointer"><i class="color-white ms-text ti-plus"></i></div>
										</div>
									</a></li>';
		    	    }
		    	}
		    	$output .= '</ul></div>';
	    		break;

	    	case 'masonry-grid':
	    		$output = '<div><ul class="row masonry masonry-show project-content project-masonry-full" data-gallery-title="'. esc_attr(get_the_title()) .'">';
		    	foreach ( $attachments as $id => $attachment ) {
		    		$url = wp_get_attachment_image_src($id, 'full');
		    		if ( isset($url[0]) && $url[0] ) {
		    			$image = roneous_resize_image($url[0], 600, 600, true);
		    	    	$output .= $image ? 
		    	    				'<li class="col-md-3 col-sm-6 masonry-item project"><a href="'. esc_url($url[0]) .'" data-lightbox="true">
										<div class="image-box hover-block text-center">
										    <img src="'. esc_url($image) .'" alt="'.esc_html__( 'gallery-item', 'roneous' ).'" />
										    <div class="hover-state"><h4><i class="ti-plus"></i></h4></div>
										</div>
									</a></li>' : '';
		    	    }
		    	}
		    	$output .= '</ul></div>';
	    		break;

	    	case 'fullwidth':
		    	foreach ( $attachments as $id => $attachment ) {
		    		$url = wp_get_attachment_image_src($id, 'full');
		    	    $output .= isset($url[0]) && $url[0] ? '<figure><img src="'. esc_url($url[0]) .'" alt="'.esc_html__( 'gallery-item', 'roneous' ).'" /></figure>' : '';
		    	}
	    		break;
	    	
	    	default:
	    		if ( is_feed() ) {
			        $output = "\n";
			        foreach ( $attachments as $id => $attachment ) {
			            $output .= wp_get_attachment_link($id, $size, true) . "\n";
			        }
			    }
	    		break;
	    }
	    return $output;
	}
	add_filter( 'post_gallery', 'roneous_post_gallery', 10, 2 );
}