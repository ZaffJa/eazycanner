<?php 
/**
 * Theme helpers
 *
 * @package TLG Framework
 *
 */

add_filter( 'widget_text', 'do_shortcode' );

/**
    ADD THEME CUSTOMIZE MENU LINK
**/
if( !function_exists('tlg_framework_add_theme_options_link') ) {
	function tlg_framework_add_theme_options_link() {
		add_dashboard_page( 
			wp_get_theme()->get( 'Name' ) . ' '. esc_html__( 'Customize', 'tlg_framework' ), 
			wp_get_theme()->get( 'Name' ) . ' '. esc_html__( 'Customize', 'tlg_framework' ), 
			'edit_theme_options', 'customize.php' );
	}
	add_action ('admin_menu', 'tlg_framework_add_theme_options_link');
}

/**
    ADD IMAGE SIZE
**/
if( !function_exists('tlg_framework_add_image_size') ) {
	function tlg_framework_add_image_size() {
	    add_image_size( 'tlg_framework_thumbnail', 60, 60, true );
	}
	add_action( 'init', 'tlg_framework_add_image_size' );
}

/**
    ADD THUMBNAIL COLUMN IN ADMIN
**/
if( !function_exists('tlg_framework_add_thumbnail_column') ) {
	function tlg_framework_add_thumbnail_column( $cols ) {
	  	$cols['tlg_framework_post_thumb'] = esc_html__( 'Featured Image', 'tlg_framework' );
	  	return $cols;
	}
	add_filter('manage_posts_columns', 'tlg_framework_add_thumbnail_column', 5);
	add_filter('manage_pages_columns', 'tlg_framework_add_thumbnail_column', 5);
}
if( !function_exists('tlg_framework_display_thumbnail_column') ) {
	function tlg_framework_display_thumbnail_column( $col, $id ) {
		if( 'tlg_framework_post_thumb' == $col && function_exists('the_post_thumbnail') ) {
			echo the_post_thumbnail( 'tlg_framework_thumbnail' );
		}
	}
	add_action('manage_posts_custom_column', 'tlg_framework_display_thumbnail_column', 5, 2);
	add_action('manage_pages_custom_column', 'tlg_framework_display_thumbnail_column', 5, 2);
}

/**
    REQUEST SEARCH FILTER CLEANUP
**/
if( !function_exists('tlg_framework_request_filter') ) {
	function tlg_framework_request_filter( $query_vars ) {
	    if( isset( $_GET['s'] ) && empty( $_GET['s'] ) ) {
	        $query_vars['s'] = '';
	    }
	    return $query_vars;
	}
	add_filter( 'request', 'tlg_framework_request_filter' );
}

/**
	GET TITLE TAG
**/
if( !function_exists('tlg_framework_get_title_tag') ) {
	function tlg_framework_get_title_tag ( $title ) {
		// $title = 'The {color=#FFEB64}custom{/color} text';
		preg_match("/\{color=(.+?)\}(.+?)\{\/.+?\}/", $title, $matches);
		$value   = isset($matches[1]) ? $matches[1] : ''; // #FFEB64
		$content = isset($matches[2]) ? $matches[2] : ''; // custom
		if( $value && $content ) {
			$title = preg_replace( '|\{(.+?)\}(.+?\{/\1\})?|s', '', $title );
			$title = str_replace( $content, '<span style="color:'.$value.'!important;">'.$content.'</span>', $title );
		}
		return $title;
	}
}

/**
	ALLOWED HTML TAGS
**/
if( !function_exists('tlg_framework_allowed_tags') ) {
	function tlg_framework_allowed_tags() {
		return array( 'a' => array( 'href' => array(), 'title' => array(), 'class' => array(), 'target' => array() ), 'br' => array(), 'em' => array(), 'i' => array(), 'u' => array(), 'strong' => array(), 'p' => array( 'class' => array() ) );	
	}
}

/**
	RESIZE IMAGE
**/
if( !function_exists('tlg_framework_resize_image') ) {
    function tlg_framework_resize_image( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
    	if ( class_exists('Aq_Resize') ) {
    		$aq_resize = Aq_Resize::getInstance();
        	return $aq_resize->process( $url, $width, $height, $crop, $single, $upscale );
    	}
        return $url;
    }
}

/**
	HEX COLOR TO RGBA
**/
if( !function_exists('tlg_framework_hex2rgba') ) {
	function tlg_framework_hex2rgba($color, $opacity = false) {
		$default = 'rgb(0,0,0)';
		if(empty($color)) return $default;
	    if ($color[0] == '#' ) {
	    	$color = substr( $color, 1 );
	    }
	    if (strlen($color) == 6) {
	        $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
	    } elseif ( strlen( $color ) == 3 ) {
	        $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
	    } else return $default;
	    $rgb =  array_map('hexdec', $hex);
	    if( $opacity ) {
	    	if( abs($opacity) > 1 ) $opacity = 1.0;
	    	$output = 'rgba('.implode(",",$rgb).','.$opacity.')';
	    } else {
	    	$output = 'rgb('.implode(",",$rgb).')';
	    }
	    return $output;
	}
}

/**
	THE PAGE TITLE
**/
if( !function_exists( 'tlg_framework_get_the_page_title' ) ) {
	function tlg_framework_get_the_page_title( $args = array() ) {
		$output = $title = $subtitle = $image = $background = $size = $layout = false;
		extract( $args );
		$layout = $layout ? $layout : 'center';
		switch ( $layout ) {
			case 'center': $background = false; $image = false; $layout = 'center'; break;
			case 'center-large': $background = false; $image = false; $size = 'large'; $layout = 'center'; break;
			case 'center-bg': $background = 'image-bg overlay'; $layout = 'center'; break;
			case 'center-bg-large': $background = 'image-bg overlay'; $size = 'large'; $layout = 'center'; break;
			case 'center-parallax': $background = 'image-bg overlay parallax'; $layout = 'center'; break;
			case 'center-parallax-large': $background = 'image-bg overlay parallax'; $size = 'large'; $layout = 'center'; break;
			case 'left': $background = false; $image = false; $layout = 'left'; break;
			case 'left-large': $background = false; $image = false; $size = 'large'; $layout = 'left'; break;
			case 'left-bg': $background = 'image-bg overlay'; $layout = 'left'; break;
			case 'left-bg-large': $background = 'image-bg overlay'; $size = 'large'; $layout = 'left'; break;
			case 'left-parallax': $background = 'image-bg overlay parallax'; $layout = 'left'; break;
			case 'left-parallax-large': $background = 'image-bg overlay parallax'; $size = 'large'; $layout = 'left'; break;
			default: break;
		}
		if ( 'center' == $layout ) {
			$output = '<section class="page-title page-title-'.( 'large' == $size ? 'large-center' : 'center'  ).' '. esc_attr($background) .'">'.
							($image ? '<div class="background-content">'. $image .'</div>' : '').'
							<div class="container"><div class="row"><div class="col-sm-12 text-center">
					        	<h2 class="heading-title '.( 'large' == $size ? 'mb8' : 'mb0'  ).'">'. $title .'</h2>
					        	<p class="lead fade-color mb0">'. $subtitle .'</p>
							</div></div></div>'. tlg_framework_breadcrumbs() .'</section>';
		} elseif ( 'left' == $layout ) {
			$output = '<section class="page-title page-title-'.( 'large' == $size ? 'large' : 'basic'  ).' '. esc_attr($background) .'">'.
							($image ? '<div class="background-content">'. $image .'</div>' : '').'
							<div class="container"><div class="row">
								<div class="col-md-6">
					        		<h2 class="heading-title '.( 'large' == $size ? 'mb8' : 'mb0'  ).'">'. $title .'</h2>
					        		<p class="lead fade-color mb0">'. $subtitle .'</p>
								</div>
								<div class="col-md-6 text-right pt8">'. tlg_framework_breadcrumbs() .'</div>
							</div></div></section>';
		}
		return $output;
	}
}

/**
	BREADCRUMBS
**/
if( !function_exists('tlg_framework_breadcrumbs') ) { 
	function tlg_framework_breadcrumbs() {
		if ( is_front_page() || is_search() || 'no' == get_option( 'tlg_framework_show_breadcrumbs', 'yes' ) ) return;
		global $post;
		$post_type 	= get_post_type();
		$ancestors 	= array_reverse( get_post_ancestors( $post->ID ) );
		$before 	= '<ol class="breadcrumb breadcrumb-style">';
		$after 		= '</ol>';
		$home 		= '<li><a href="' . esc_url( home_url( "/" ) ) . '" class="home-link" rel="home">' . esc_html__( 'Home', 'tlg_framework' ) . '</a></li>';
		if( 'portfolio' == $post_type ) {
			$home  .= '<li class="active"><a href="' . esc_url( home_url( "/portfolio/" ) ) . '">' . esc_html__( 'Portfolio', 'tlg_framework' ) . '</a></li>';
		}
		if( 'team' == $post_type ) {
			$home  .= '<li class="active"><a href="' . esc_url( home_url( "/team/" ) ) . '">' . esc_html__( 'Team', 'tlg_framework' ) . '</a></li>';
		}
		if( 'product' == $post_type && !(is_archive()) ) {
			$home  .= '<li class="active"><a href="' . esc_url( get_permalink( woocommerce_get_page_id( 'shop' ) ) ) . '">' . esc_html__( 'Shop', 'tlg_framework' ) . '</a></li>';
		} elseif( 'product' == $post_type && is_archive() ) {
			$home  .= '<li class="active">' . esc_html__( 'Shop', 'tlg_framework' ) . '</li>';
		}
		$breadcrumb = '';
		if ( $ancestors ) {
			foreach ( $ancestors as $ancestor ) {
				$breadcrumb .= '<li><a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a></li>';
			}
		}
		if( tlg_framework_is_blog_page() && is_single() ) {
			$breadcrumb .= '<li><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html( get_option( 'blog_title', esc_html__( 'Our Blog', 'tlg_framework' ) ) ) . '</a></li><li class="active">' . esc_html( get_the_title( $post->ID ) ) . '</li>';
		} elseif( tlg_framework_is_blog_page() ) {
			$breadcrumb .= '<li class="active">' . esc_html( get_option( 'blog_title',__( 'Our Blog', 'tlg_framework' ) ) ) . '</li>';
		} elseif( is_post_type_archive('product') || is_archive() ) {
			// nothing
		} else {
			$breadcrumb .= '<li class="active">' . esc_html( get_the_title( $post->ID ) ) . '</li>';
		}
		if( 'team' == get_post_type() ) {
			rewind_posts();
		}
		return $before . $home . $breadcrumb . $after;
	}
}

/**
	CHECK BLOG PAGES
**/
if( !function_exists('tlg_framework_is_blog_page') ) {
	function tlg_framework_is_blog_page() {
	    global $post;
	    if ( ( is_home() || is_archive() || is_single() ) && 'post' == get_post_type($post) ) {
	    	return true;
	    }
	   	return false;
	}
}

/**
	PAGINATION
**/
if( !function_exists('tlg_framework_pagination') ) {
	function tlg_framework_pagination( $pages = '', $range = 2 ) {
		global $paged, $wp_query;
		$showitems 	= ($range * 2)+1;
		$output 	= '';
		if( empty($paged) ) {
			$paged = 1;
		}
		if( $pages == '' ) {
			$pages = $wp_query->max_num_pages;
			if( !$pages ) {
				$pages = 1;
			}
		}
		if( 1 != $pages ) {
			$output .= "<div class='text-center mt40'><ul class='pagination'>";
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) {
				$output .= "<li><a href='".esc_url(get_pagenum_link(1))."' aria-label='".__( 'Previous', 'tlg_roneous' )."'><span aria-hidden='true'>&laquo;</span></a></li> ";
			}
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
					$output .= ($paged == $i)? "<li class='active'><a href='".esc_url(get_pagenum_link($i))."'>".$i."</a></li> ":"<li><a href='".esc_url(get_pagenum_link($i))."'>".$i."</a></li> ";
				}
			}
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
				$output .= "<li><a href='".esc_url(get_pagenum_link($pages))."' aria-label='".__( 'Next', 'tlg_roneous' )."'><span aria-hidden='true'>&raquo;</span></a></li> ";
			}
			$output.= "</ul></div>";
		}
		return $output;
	}
}

/**
	PARSING GOOGLE FONTS
**/
if( !function_exists('tlg_framework_parsing_fonts') ) {
	function tlg_framework_parsing_fonts( $gg_font = false, $default_font = '', $default_weight = 400 ) {
		$font = array(
			'name' 		=> $default_font,
			'weight' 	=> $default_weight,
			'style' 	=> 'normal',
			'url' 		=> false,
			'family' 	=> $default_font.':'.$default_weight,
		);
		if ( $gg_font ) {
	        $parsing_font 	= explode( ':tlg:', $gg_font );
	        $font_style 	= $parsing_font[2];
	        if ( 'regular' == $font_style ) $font_style = '400';
	        if ( 'italic'  == $font_style ) $font_style = '400italic';
	        $font = array(
				'name' 			=> $parsing_font[0],
				'url' 			=> $parsing_font[1],
				'weight' 		=> intval( $font_style ),
				'style' 		=> strpos( $font_style, 'italic' ) ? 'italic' : 'normal',
				'family' 		=> $parsing_font[0].':'.$font_style,
			);
	    }
	    return $font;
	}
}

if( !function_exists('tlg_framework_fonts_url') ) {
	function tlg_framework_fonts_url( $fonts ) {
	    $fonts_url = '';
	    $font_families = array();

	    foreach ($fonts as $font) {
	    	$font_families[] = $font;
	    }

	    $query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

	    return esc_url_raw( $fonts_url );
	}
}

/**
	METADATA SOCIAL ICON FIELD 
**/
if( !function_exists('tlg_framework_social_icons_meta_field') ) {
	function tlg_framework_social_icons_meta_field( $field, $meta, $object_id, $object_type, $field_type_object ) {
		$icons = tlg_framework_get_social_icons();
		echo '<div class="tlg-icons"><div class="tlg-icons-wrapper">';
		foreach( $icons as $icon ) { $active = $meta == $icon ? ' active' : '';
			echo '<i class="icon '. $icon . $active .'" data-icon-class="'. $icon .'"></i>';
		}
		echo '</div>'.htmlspecialchars_decode($field_type_object->input( array( 'type' => 'text' ) )).'</div>';
		if ( isset($field->description) && $field->description ) echo '<p class="cmb_metabox_description">' . $field->description . '</p>';
	}
	add_filter( 'cmb2_render_tlg_social_icons', 'tlg_framework_social_icons_meta_field', 10, 5 );
}

/**
	Getting Instagram data
	Based on WP Instagram Widget
**/
if( !function_exists('tlg_framework_get_instagram') ) {
	function tlg_framework_get_instagram( $username ) {
		$username = strtolower( $username );
		$username = str_replace( '@', '', $username );
		if ( false === ( $instagram = get_transient( 'instagram-a5-'.sanitize_title_with_dashes( $username ) ) ) ) {
			$remote = wp_remote_get( 'http://instagram.com/'.trim( $username ) );
			if ( is_wp_error( $remote ) )
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'tlg_framework' ) );
			if ( 200 != wp_remote_retrieve_response_code( $remote ) )
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'tlg_framework' ) );
			$shards = explode( 'window._sharedData = ', $remote['body'] );
			$insta_json = isset($shards[1]) ? explode( ';</script>', $shards[1] ) : array();
			$insta_array = isset($insta_json[0]) ? json_decode( $insta_json[0], TRUE ) : false;
			if ( ! $insta_array )
				return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'tlg_framework' ) );
			if ( isset( $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'] ) ) {
				$images = $insta_array['entry_data']['ProfilePage'][0]['user']['media']['nodes'];
			} else {
				return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'tlg_framework' ) );
			}
			if ( ! is_array( $images ) )
				return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'tlg_framework' ) );
			$instagram = array();
			foreach ( $images as $image ) {
				$image['thumbnail_src'] = preg_replace( '/^https?\:/i', '', $image['thumbnail_src'] );
				$image['display_src'] = preg_replace( '/^https?\:/i', '', $image['display_src'] );
				// handle both types of CDN url
				if ( ( strpos( $image['thumbnail_src'], 's640x640' ) !== false ) ) {
					$image['thumbnail'] = str_replace( 's640x640', 's160x160', $image['thumbnail_src'] );
					$image['small'] = str_replace( 's640x640', 's320x320', $image['thumbnail_src'] );
				} else {
					$urlparts = wp_parse_url( $image['thumbnail_src'] );
					$pathparts = explode( '/', $urlparts['path'] );
					array_splice( $pathparts, 3, 0, array( 's160x160' ) );
					$image['thumbnail'] = '//' . $urlparts['host'] . implode( '/', $pathparts );
					$pathparts[3] = 's320x320';
					$image['small'] = '//' . $urlparts['host'] . implode( '/', $pathparts );
				}
				$image['large'] = $image['thumbnail_src'];
				if ( $image['is_video'] == true ) {
					$type = 'video';
				} else {
					$type = 'image';
				}
				$caption = esc_html__( 'Instagram Image', 'tlg_framework' );
				if ( ! empty( $image['caption'] ) ) {
					$caption = $image['caption'];
				}
				$instagram[] = array(
					'description'   => $caption,
					'link'		  	=> trailingslashit( '//instagram.com/p/' . $image['code'] ),
					'time'		  	=> $image['date'],
					'comments'	  	=> $image['comments']['count'],
					'likes'		 	=> $image['likes']['count'],
					'thumbnail'	 	=> $image['thumbnail'],
					'small'			=> $image['small'],
					'large'			=> $image['large'],
					'original'		=> $image['display_src'],
					'type'		  	=> $type
				);
			}
			// do not set an empty transient - should help catch private or empty accounts
			if ( ! empty( $instagram ) ) {
				$instagram = base64_encode( serialize( $instagram ) );
				set_transient( 'instagram-a5-'.sanitize_title_with_dashes( $username ), $instagram, apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS*2 ) );
			}
		}
		if ( ! empty( $instagram ) ) {
			return unserialize( base64_decode( $instagram ) );
		} else {
			return new WP_Error( 'no_images', esc_html__( 'Instagram did not return images.', 'tlg_framework' ) );
		}
	}
}

/**
	bbPress wp4 fix by Robin Wilson (http://www.rewweb.co.uk/bbpress-wp4-fix)

	bbpress is suffering from issues with themes and plugins following the release of wp4.
	one issue is that bbp-has-replies sets the 's' (search) variable even is there is no search (it the sets it to false).
	This seems to now be handled differently in WP4, and this causes WP v4.0 to tell s2Member (and other plugins) that  is_search() 
	is  TRUE , when actually it is not, in the case of bbPress. Presumably wp4 takes the existence of the 's' as meaning it is true, rather than
	examining it's value.
	This plugin re-writes bbp_has_replies to stop setting the 's' to false
**/
if( class_exists('bbPress') ) {

	if( !function_exists('tlg_framework_bbp_has_replies') ) {
		add_filter ('bbp_has_replies', 'tlg_framework_bbp_has_replies') ;
		
		function tlg_framework_bbp_has_replies( $args = '' ) {
			global $wp_rewrite;

			/** Defaults **************************************************************/

			// Other defaults
			$default_reply_search   = !empty( $_REQUEST['rs'] ) ? $_REQUEST['rs']    : false;
			$default_post_parent    = ( bbp_is_single_topic() ) ? bbp_get_topic_id() : 'any';
			$default_post_type      = ( bbp_is_single_topic() && bbp_show_lead_topic() ) ? bbp_get_reply_post_type() : array( bbp_get_topic_post_type(), bbp_get_reply_post_type() );
			$default_thread_replies = (bool) ( bbp_is_single_topic() && bbp_thread_replies() );

			// Default query args
			$default = array(
				'post_type'           => $default_post_type,         // Only replies
				'post_parent'         => $default_post_parent,       // Of this topic
				'posts_per_page'      => bbp_get_replies_per_page(), // This many
				'paged'               => bbp_get_paged(),            // On this page
				'orderby'             => 'date',                     // Sorted by date
				'order'               => 'ASC',                      // Oldest to newest
				'hierarchical'        => $default_thread_replies,    // Hierarchical replies
				'ignore_sticky_posts' => true,                       // Stickies not supported
				's'                   => $default_reply_search,      // Maybe search
			);
			//FIX to unset 's'
			if ($default['s'] == False) unset ($default['s']) ;

			// What are the default allowed statuses (based on user caps)
			if ( bbp_get_view_all() ) {

				// Default view=all statuses
				$post_statuses = array(
					bbp_get_public_status_id(),
					bbp_get_closed_status_id(),
					bbp_get_spam_status_id(),
					bbp_get_trash_status_id()
				);

				// Add support for private status
				if ( current_user_can( 'read_private_replies' ) ) {
					$post_statuses[] = bbp_get_private_status_id();
				}

				// Join post statuses together
				$default['post_status'] = implode( ',', $post_statuses );

			// Lean on the 'perm' query var value of 'readable' to provide statuses
			} else {
				$default['perm'] = 'readable';
			}

			/** Setup *****************************************************************/

			// Parse arguments against default values
			$r = bbp_parse_args( $args, $default, 'has_replies' );

			// Set posts_per_page value if replies are threaded
			$replies_per_page = $r['posts_per_page'];
			if ( true === $r['hierarchical'] ) {
				$r['posts_per_page'] = -1;
			}

			// Get bbPress
			$bbp = bbpress();

			// Call the query
			$bbp->reply_query = new WP_Query( $r );

			// Add pagination values to query object
			$bbp->reply_query->posts_per_page = $replies_per_page;
			$bbp->reply_query->paged          = $r['paged'];

			// Never home, regardless of what parse_query says
			$bbp->reply_query->is_home        = false;

			// Reset is_single if single topic
			if ( bbp_is_single_topic() ) {
				$bbp->reply_query->is_single = true;
			}

			// Only add reply to if query returned results
			if ( (int) $bbp->reply_query->found_posts ) {

				// Get reply to for each reply
				foreach ( $bbp->reply_query->posts as &$post ) {

					// Check for reply post type
					if ( bbp_get_reply_post_type() === $post->post_type ) {
						$reply_to = bbp_get_reply_to( $post->ID );

						// Make sure it's a reply to a reply
						if ( empty( $reply_to ) || ( bbp_get_reply_topic_id( $post->ID ) === $reply_to ) ) {
							$reply_to = 0;
						}

						// Add reply_to to the post object so we can walk it later
						$post->reply_to = $reply_to;
					}
				}
			}

			// Only add pagination if query returned results
			if ( (int) $bbp->reply_query->found_posts && (int) $bbp->reply_query->posts_per_page ) {

				// If pretty permalinks are enabled, make our pagination pretty
				if ( $wp_rewrite->using_permalinks() ) {

					// User's replies
					if ( bbp_is_single_user_replies() ) {
						$base = bbp_get_user_replies_created_url( bbp_get_displayed_user_id() );

					// Root profile page
					} elseif ( bbp_is_single_user() ) {
						$base = bbp_get_user_profile_url( bbp_get_displayed_user_id() );

					// Page or single post
					} elseif ( is_page() || is_single() ) {
						$base = get_permalink();

					// Single topic
					} else {
						$base = get_permalink( bbp_get_topic_id() );
					}

					$base = trailingslashit( $base ) . user_trailingslashit( $wp_rewrite->pagination_base . '/%#%/' );

				// Unpretty permalinks
				} else {
					$base = add_query_arg( 'paged', '%#%' );
				}

				// Figure out total pages
				if ( true === $r['hierarchical'] ) {
					$walker      = new BBP_Walker_Reply;
					$total_pages = ceil( (int) $walker->get_number_of_root_elements( $bbp->reply_query->posts ) / (int) $replies_per_page );
				} else {
					$total_pages = ceil( (int) $bbp->reply_query->found_posts / (int) $replies_per_page );

					// Add pagination to query object
					$bbp->reply_query->pagination_links = paginate_links( apply_filters( 'bbp_replies_pagination', array(
						'base'      => $base,
						'format'    => '',
						'total'     => $total_pages,
						'current'   => (int) $bbp->reply_query->paged,
						'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
						'next_text' => is_rtl() ? '&larr;' : '&rarr;',
						'mid_size'  => 1,
						'add_args'  => ( bbp_get_view_all() ) ? array( 'view' => 'all' ) : false
					) ) );

					// Remove first page from pagination
					if ( $wp_rewrite->using_permalinks() ) {
						$bbp->reply_query->pagination_links = str_replace( $wp_rewrite->pagination_base . '/1/', '', $bbp->reply_query->pagination_links );
					} else {
						$bbp->reply_query->pagination_links = str_replace( '&#038;paged=1', '', $bbp->reply_query->pagination_links );
					}
				}
			}

			// Return object
			return apply_filters( 'tlg_framework_bbp_has_replies', $bbp->reply_query->have_posts(), $bbp->reply_query );
		}
	}

	if( !function_exists('tlg_framework_bbp_has_topics') ) {
		add_filter ('bbp_has_topics', 'tlg_framework_bbp_has_topics') ;
		
		function tlg_framework_bbp_has_topics( $args = '' ) {
			global $wp_rewrite;

			/** Defaults **************************************************************/

			// Other defaults
			$default_topic_search  = !empty( $_REQUEST['ts'] ) ? $_REQUEST['ts'] : false;
			$default_show_stickies = (bool) ( bbp_is_single_forum() || bbp_is_topic_archive() ) && ( false === $default_topic_search );
			$default_post_parent   = bbp_is_single_forum() ? bbp_get_forum_id() : 'any';

			// Default argument array
			$default = array(
				'post_type'      => bbp_get_topic_post_type(), // Narrow query down to bbPress topics
				'post_parent'    => $default_post_parent,      // Forum ID
				'meta_key'       => '_bbp_last_active_time',   // Make sure topic has some last activity time
				'orderby'        => 'meta_value',              // 'meta_value', 'author', 'date', 'title', 'modified', 'parent', rand',
				'order'          => 'DESC',                    // 'ASC', 'DESC'
				'posts_per_page' => bbp_get_topics_per_page(), // Topics per page
				'paged'          => bbp_get_paged(),           // Page Number
				's'              => $default_topic_search,     // Topic Search
				'show_stickies'  => $default_show_stickies,    // Ignore sticky topics?
				'max_num_pages'  => false,                     // Maximum number of pages to show
			);
			//FIX to unset 's'
			if ($default['s'] == False) unset ($default['s']) ;
			
			
			// What are the default allowed statuses (based on user caps)
			if ( bbp_get_view_all() ) {

				// Default view=all statuses
				$post_statuses = array(
					bbp_get_public_status_id(),
					bbp_get_closed_status_id(),
					bbp_get_spam_status_id(),
					bbp_get_trash_status_id()
				);

				// Add support for private status
				if ( current_user_can( 'read_private_topics' ) ) {
					$post_statuses[] = bbp_get_private_status_id();
				}

				// Join post statuses together
				$default['post_status'] = implode( ',', $post_statuses );

			// Lean on the 'perm' query var value of 'readable' to provide statuses
			} else {
				$default['perm'] = 'readable';
			}

			// Maybe query for topic tags
			if ( bbp_is_topic_tag() ) {
				$default['term']     = bbp_get_topic_tag_slug();
				$default['taxonomy'] = bbp_get_topic_tag_tax_id();
			}

			/** Setup *****************************************************************/

			// Parse arguments against default values
			$r = bbp_parse_args( $args, $default, 'has_topics' );

			// Get bbPress
			$bbp = bbpress();

			// Call the query
			$bbp->topic_query = new WP_Query( $r );

			// Set post_parent back to 0 if originally set to 'any'
			if ( 'any' === $r['post_parent'] )
				$r['post_parent'] = 0;

			// Limited the number of pages shown
			if ( !empty( $r['max_num_pages'] ) )
				$bbp->topic_query->max_num_pages = $r['max_num_pages'];

			/** Stickies **************************************************************/

			// Put sticky posts at the top of the posts array
			if ( !empty( $r['show_stickies'] ) && $r['paged'] <= 1 ) {

				// Get super stickies and stickies in this forum
				$stickies = bbp_get_super_stickies();

				// Get stickies for current forum
				if ( !empty( $r['post_parent'] ) ) {
					$stickies = array_merge( $stickies, bbp_get_stickies( $r['post_parent'] ) );
				}

				// Remove any duplicate stickies
				$stickies = array_unique( $stickies );

				// We have stickies
				if ( is_array( $stickies ) && !empty( $stickies ) ) {

					// Start the offset at -1 so first sticky is at correct 0 offset
					$sticky_offset = -1;

					// Loop over topics and relocate stickies to the front.
					foreach ( $stickies as $sticky_index => $sticky_ID ) {

						// Get the post offset from the posts array
						$post_offsets = wp_filter_object_list( $bbp->topic_query->posts, array( 'ID' => $sticky_ID ), 'OR', 'ID' );

						// Continue if no post offsets
						if ( empty( $post_offsets ) ) {
							continue;
						}

						// Loop over posts in current query and splice them into position
						foreach ( array_keys( $post_offsets ) as $post_offset ) {
							$sticky_offset++;

							$sticky = $bbp->topic_query->posts[$post_offset];

							// Remove sticky from current position
							array_splice( $bbp->topic_query->posts, $post_offset, 1 );

							// Move to front, after other stickies
							array_splice( $bbp->topic_query->posts, $sticky_offset, 0, array( $sticky ) );

							// Cleanup
							unset( $stickies[$sticky_index] );
							unset( $sticky );
						}

						// Cleanup
						unset( $post_offsets );
					}

					// Cleanup
					unset( $sticky_offset );

					// If any posts have been excluded specifically, Ignore those that are sticky.
					if ( !empty( $stickies ) && !empty( $r['post__not_in'] ) ) {
						$stickies = array_diff( $stickies, $r['post__not_in'] );
					}

					// Fetch sticky posts that weren't in the query results
					if ( !empty( $stickies ) ) {

						// Query to use in get_posts to get sticky posts
						$sticky_query = array(
							'post_type'   => bbp_get_topic_post_type(),
							'post_parent' => 'any',
							'meta_key'    => '_bbp_last_active_time',
							'orderby'     => 'meta_value',
							'order'       => 'DESC',
							'include'     => $stickies
						);

						// Cleanup
						unset( $stickies );

						// Conditionally exclude private/hidden forum ID's
						$exclude_forum_ids = bbp_exclude_forum_ids( 'array' );
						if ( ! empty( $exclude_forum_ids ) ) {
							$sticky_query['post_parent__not_in'] = $exclude_forum_ids;
						}

						// What are the default allowed statuses (based on user caps)
						if ( bbp_get_view_all() ) {
							$sticky_query['post_status'] = $r['post_status'];

						// Lean on the 'perm' query var value of 'readable' to provide statuses
						} else {
							$sticky_query['post_status'] = $r['perm'];
						}

						// Get all stickies
						$sticky_posts = get_posts( $sticky_query );
						if ( !empty( $sticky_posts ) ) {

							// Get a count of the visible stickies
							$sticky_count = count( $sticky_posts );

							// Merge the stickies topics with the query topics .
							$bbp->topic_query->posts       = array_merge( $sticky_posts, $bbp->topic_query->posts );

							// Adjust loop and counts for new sticky positions
							$bbp->topic_query->found_posts = (int) $bbp->topic_query->found_posts + (int) $sticky_count;
							$bbp->topic_query->post_count  = (int) $bbp->topic_query->post_count  + (int) $sticky_count;

							// Cleanup
							unset( $sticky_posts );
						}
					}
				}
			}

			// If no limit to posts per page, set it to the current post_count
			if ( -1 === $r['posts_per_page'] )
				$r['posts_per_page'] = $bbp->topic_query->post_count;

			// Add pagination values to query object
			$bbp->topic_query->posts_per_page = $r['posts_per_page'];
			$bbp->topic_query->paged          = $r['paged'];

			// Only add pagination if query returned results
			if ( ( (int) $bbp->topic_query->post_count || (int) $bbp->topic_query->found_posts ) && (int) $bbp->topic_query->posts_per_page ) {

				// Limit the number of topics shown based on maximum allowed pages
				if ( ( !empty( $r['max_num_pages'] ) ) && $bbp->topic_query->found_posts > $bbp->topic_query->max_num_pages * $bbp->topic_query->post_count )
					$bbp->topic_query->found_posts = $bbp->topic_query->max_num_pages * $bbp->topic_query->post_count;

				// If pretty permalinks are enabled, make our pagination pretty
				if ( $wp_rewrite->using_permalinks() ) {

					// User's topics
					if ( bbp_is_single_user_topics() ) {
						$base = bbp_get_user_topics_created_url( bbp_get_displayed_user_id() );

					// User's favorites
					} elseif ( bbp_is_favorites() ) {
						$base = bbp_get_favorites_permalink( bbp_get_displayed_user_id() );

					// User's subscriptions
					} elseif ( bbp_is_subscriptions() ) {
						$base = bbp_get_subscriptions_permalink( bbp_get_displayed_user_id() );

					// Root profile page
					} elseif ( bbp_is_single_user() ) {
						$base = bbp_get_user_profile_url( bbp_get_displayed_user_id() );

					// View
					} elseif ( bbp_is_single_view() ) {
						$base = bbp_get_view_url();

					// Topic tag
					} elseif ( bbp_is_topic_tag() ) {
						$base = bbp_get_topic_tag_link();

					// Page or single post
					} elseif ( is_page() || is_single() ) {
						$base = get_permalink();

					// Forum archive
					} elseif ( bbp_is_forum_archive() ) {
						$base = bbp_get_forums_url();

					// Topic archive
					} elseif ( bbp_is_topic_archive() ) {
						$base = bbp_get_topics_url();

					// Default
					} else {
						$base = get_permalink( (int) $r['post_parent'] );
					}

					// Use pagination base
					$base = trailingslashit( $base ) . user_trailingslashit( $wp_rewrite->pagination_base . '/%#%/' );

				// Unpretty pagination
				} else {
					$base = add_query_arg( 'paged', '%#%' );
				}

				// Pagination settings with filter
				$bbp_topic_pagination = apply_filters( 'bbp_topic_pagination', array (
					'base'      => $base,
					'format'    => '',
					'total'     => $r['posts_per_page'] === $bbp->topic_query->found_posts ? 1 : ceil( (int) $bbp->topic_query->found_posts / (int) $r['posts_per_page'] ),
					'current'   => (int) $bbp->topic_query->paged,
					'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
					'next_text' => is_rtl() ? '&larr;' : '&rarr;',
					'mid_size'  => 1
				) );

				// Add pagination to query object
				$bbp->topic_query->pagination_links = paginate_links( $bbp_topic_pagination );

				// Remove first page from pagination
				$bbp->topic_query->pagination_links = str_replace( $wp_rewrite->pagination_base . "/1/'", "'", $bbp->topic_query->pagination_links );
			}

			// Return object
			return apply_filters( 'tlg_framework_bbp_has_topics', $bbp->topic_query->have_posts(), $bbp->topic_query );
		}
	}
}