<?php
/**
 * Theme Helper
 *
 * @package TLG Theme
 *
 */

/**
	REGISTER REQUIRED PLUGINS
**/
if( !function_exists('roneous_register_required_plugins') ) {
	function roneous_register_required_plugins() {
		$plugins = array(
			array( 
				'name' => esc_html__( 'TLG Framework', 'roneous' ), // The plugin name.
				'slug' => 'tlg_framework', // The plugin slug.
				'source' => get_template_directory() . '/plugins/tlg_framework.zip', // The plugin source.
				'required' => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'version' => '1.1.1', // If set, the active plugin must be this version or higher.
			),
			array( 
				'name' => esc_html__( 'Visual Composer', 'roneous' ), // The plugin name.
				'slug' => 'js_composer', // The plugin slug.
				'source' => get_template_directory() . '/plugins/js_composer.zip', // The plugin source.
				'required' => true, // If false, the plugin is only 'recommended' instead of required.
				'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'version' => '5.0.1', // If set, the active plugin must be this version or higher.
			),
			array( 
				'name' => esc_html__( 'Revolution Slider', 'roneous' ), // The plugin name.
				'slug' => 'revslider', // The plugin slug.
				'source' => get_template_directory() . '/plugins/revslider.zip', // The plugin source.
				'required' => false, // If false, the plugin is only 'recommended' instead of required.
				'force_activation' => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
				'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
				'version' => '5.3.0.2', // If set, the active plugin must be this version or higher.
			),
			// Plugins from the WordPress Repository
			array( 
				'name' => esc_html__( 'Contact Form 7', 'roneous' ), 
				'slug' => 'contact-form-7', 
				'required' => false,
				'force_activation' => false,
				'force_deactivation' => false,
			),
			array( 
				'name' => esc_html__( 'WooCommerce', 'roneous' ), 
				'slug' => 'woocommerce', 
				'required' => false,
				'force_activation' => false,
				'force_deactivation' => false,
			),
		);
		tgmpa( $plugins, array( 'is_automatic' => true ) );
	}
	add_action( 'tgmpa_register', 'roneous_register_required_plugins' );
}

/**
	CHECK IF PLUGINS IS ACTIVATED
**/
if( !function_exists( 'roneous_is_plugin_active' ) ) {
	function roneous_is_plugin_active( $plugin ) {
		include_once( ABSPATH . '/wp-admin/includes/plugin.php' );
		$activated = is_plugin_active( $plugin );
	    if( ! $activated ) {
	    	$activated = is_plugin_active_for_network( $plugin );
	    }
	    return $activated;
	}
}
	

/**
	THE PAGE TITLE
**/
if( !function_exists( 'roneous_get_the_page_title' ) ) {
	function roneous_get_the_page_title( $args = array() ) {
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
							</div></div></div>'. roneous_breadcrumbs() .'</section>';
		} elseif ( 'left' == $layout ) {
			$output = '<section class="page-title page-title-'.( 'large' == $size ? 'large' : 'basic'  ).' '. esc_attr($background) .'">'.
							($image ? '<div class="background-content">'. $image .'</div>' : '').'
							<div class="container"><div class="row">
								<div class="col-md-6">
					        		<h2 class="heading-title '.( 'large' == $size ? 'mb8' : 'mb0'  ).'">'. $title .'</h2>
					        		<p class="lead fade-color mb0">'. $subtitle .'</p>
								</div>
								<div class="col-md-6 text-right pt8">'. roneous_breadcrumbs() .'</div>
							</div></div></section>';
		}
		return $output;
	}
}


/**
	GET BODY LAYOUT
**/
if( !function_exists('roneous_get_body_layout') ) {
	function roneous_get_body_layout() {
		global $post;
		$layout = isset( $_GET['layout'] ) ? $_GET['layout'] : false;
		if( $layout ) {
			if( 'boxed' ==  $layout || 'boxed-layout' ==  $layout ) $layout = 'boxed-layout';
			elseif( 'border' ==  $layout || 'border-layout' ==  $layout ) $layout = 'border-layout';
			else $layout = 'normal-layout';
		} else {
			$layout = isset( $post->ID ) ? get_post_meta( $post->ID, '_tlg_layout_override', 1 ) : false;
			if( ! $layout || 'default' == $layout ) {
				$layout = get_option( 'roneous_site_layout', 'normal-layout' );
			}
		}
		return $layout;
	}
}

/**
	GET HEADER LAYOUT
**/
if( !function_exists('roneous_get_header_layout') ) {
	function roneous_get_header_layout() {
		global $post;

		$header = isset ($_GET['nav'] ) ? $_GET['nav'] : false;
		if( $header ) return $header;

		if( is_home() || is_archive() || is_search() || ! isset( $post->ID ) ) {
			return get_option( 'roneous_header_layout', 'standard' );
		}

		$header = isset( $post->ID ) ? get_post_meta( $post->ID, '_tlg_header_override', 1 ) : false;
		if( ! $header || 'default' == $header ) {
			$header = get_option( 'roneous_header_layout', 'standard' );
		}
		return $header;	
	}
}

/**
	GET FOOTER LAYOUT
**/
if( !function_exists('roneous_get_footer_layout') ) {
	function roneous_get_footer_layout() {
		global $post;
		if( ! isset( $post->ID ) ) {
			return get_option( 'roneous_footer_layout', 'standard' );
		}
		$footer = isset( $post->ID ) ? get_post_meta( $post->ID, '_tlg_footer_override', 1 ) : false;
		if( ! $footer || 'default' == $footer ) {
			$footer = get_option( 'roneous_footer_layout', 'standard' );
		}
		return $footer;	
	}
}

/**
	GET POSTS CATEGORY
**/
if( !function_exists('roneous_get_posts_category') ) {
	function roneous_get_posts_category( $taxonomy = 'category' ) {
		$cats = array( esc_html__( 'Show all categories', 'roneous' ) => 'all' );
		$post_cats = get_categories( array( 'orderby' => 'name', 'hide_empty' => 0, 'hierarchical' => 1, 'taxonomy' => $taxonomy ) );
		if( is_array( $post_cats ) && count( $post_cats ) ) {
			foreach( $post_cats as $cat ) {
				if ( isset( $cat->name ) && isset( $cat->term_id ) ) {
					$cats[$cat->name] = $cat->term_id;
				}
			}
		}
		return $cats;
	}
}

/**
	PARSING GOOGLE FONTS
**/
if( !function_exists('roneous_parsing_fonts') ) {
	function roneous_parsing_fonts( $gg_font = false, $default_font = '', $default_weight = 400 ) {
		$font = array(
			'name' 		=> $default_font,
			'weight' 	=> $default_weight,
			'style' 	=> 'normal',
			'url' 		=> false,
			'family' 	=> $default_font.':'.$default_weight.',100,300,400,600,700',
		);
		if ( $gg_font ) {
	        $parsing_font 	= explode( ':tlg:', $gg_font );
	        $font_style 	= $parsing_font[2];
	        if ( 'regular' == $font_style ) $font_style = '400';
	        if ( 'italic'  == $font_style ) $font_style = '400italic';
	        $font = array(
				'name' 		=> $parsing_font[0],
				'url' 		=> $parsing_font[1],
				'weight' 	=> intval( $font_style ),
				'style' 	=> strpos( $font_style, 'italic' ) ? 'italic' : 'normal',
				'family' 	=> $parsing_font[0].':'.$font_style.',100,300,400,600,700',
			);
	    }
	    return $font;
	}
}

/**
	SANITIZE CUSTOMIZER OPTION
**/
if( !function_exists('roneous_sanitize') ) {
    function roneous_sanitize( $input ) {
        return force_balance_tags( $input );
    }
}

/**
	SANITIZE TITLE
**/
if( !function_exists( 'roneous_sanitize_title' ) ) {
	function roneous_sanitize_title($string) {
		$string = strtolower(str_replace(' ', '-', $string));
		$string = preg_replace('/[^A-Za-z\-]/', '', $string);
		return preg_replace('/-+/', '-', $string);
	}
}

/**
	CHECK BLOG PAGES
**/
if( !function_exists('roneous_is_blog_page') ) {
	function roneous_is_blog_page() {
	    global $post;
	    if ( ( is_home() || is_archive() || is_single() ) && 'post' == get_post_type($post) ) {
	    	return true;
	    }
	   	return false;
	}
}

/**
	GET PAGE CLASS
**/
if( !function_exists('roneous_the_page_class') ) {
	function roneous_the_page_class() {
	    echo !roneous_is_shop_page() ? esc_attr( 'post-content' ) : esc_attr( 'shop-content'.(roneous_is_cart_empty() ? ' text-center' : '') );
	}
}

/**
	CHECK SHOP PAGES
**/
if( !function_exists('roneous_is_shop_page') ) {
	function roneous_is_shop_page() {
	    if( class_exists('Woocommerce') ) {
		    if ( is_shop() || is_product_category() || is_product_tag() || is_product() || is_cart() || is_checkout() || is_account_page() || is_wc_endpoint_url() || is_woocommerce() ) {
		    	return true;
		    }
		}
	   	return false;
	}
}

/**
	CHECK CART EMPTY
**/
if( !function_exists('roneous_is_cart_empty') ) {
	function roneous_is_cart_empty() {
	    if( class_exists('Woocommerce') ) {
	    	global $woocommerce;
		    if( is_cart() && !$woocommerce->cart->get_cart_contents_count() ) return true;
		}
	   	return false;
	}
}

/**
	ALLOWED HTML TAGS
**/
if( !function_exists('roneous_allowed_tags') ) {
	function roneous_allowed_tags() {
		return array( 'a' => array( 'href' => array(), 'title' => array(), 'class' => array(), 'target' => array() ), 'br' => array(), 'em' => array(), 'i' => array(), 'u' => array(), 'strong' => array(), 'p' => array( 'class' => array() ) );	
	}
}

/**
	DISPLAY HEADER SOCIAL ICONS
**/
if( !function_exists('roneous_header_social_icons') ) { 
	function roneous_header_social_icons() {
		$output = false;
		for( $i = 1; $i < 11; $i++ ) {
			if( get_option("roneous_header_social_url_$i") ) {
				$output .= '<li><a href="' . esc_url(get_option("roneous_header_social_url_$i")) . '" target="_blank">'.
						   '<i class="' . esc_attr(get_option("roneous_header_social_icon_$i")) . '"></i></a></li>';
			}
		} 
		return $output;
	}
}

/**
	DISPLAY FOOTER SOCIAL ICONS
**/
if( !function_exists('roneous_footer_social_icons') ) { 
	function roneous_footer_social_icons() {
		$output = false;
		for( $i = 1; $i < 11; $i++ ) {
			if( get_option("roneous_footer_social_url_$i") ) {
				$output .= '<li><a href="' . esc_url(get_option("roneous_footer_social_url_$i")) . '" target="_blank">'.
						   '<i class="' . esc_attr(get_option("roneous_footer_social_icon_$i")) . '"></i></a></li>';
			}
		} 
		return $output;
	}
}

/**
	PORTFOLIO UNLIMITED
**/
if( !function_exists( 'roneous_portfolio_unlimited' ) ) {
	function roneous_portfolio_unlimited( $query ) {
	    if ( !is_admin() && $query->is_main_query() && ( is_post_type_archive('portfolio') || is_tax('portfolio_category') ) ) {
	        $query->set( 'posts_per_page', '-1' );
	    }    
	    return;
	}
	add_action( 'pre_get_posts', 'roneous_portfolio_unlimited' );
}

/**
	PORTFOLIO TAXONOMY TERMS
**/
if( !function_exists( 'roneous_the_terms' ) ) {
	function roneous_the_terms( $cat, $sep, $value, $args = array() ) {	
		global $post;
		$terms = get_the_terms( $post->ID, $cat, '', $sep, '' );
		if( is_array($terms) ) {
			foreach( $terms as $term ) {
				$args[] = $value;	
			}
			$terms = array_map( 'roneous_get_term_name', $terms, $args );
			return implode( $sep, $terms);
		}
	}
}

/**
	PORTFOLIO GET TAXONOMY TERMS
**/
if( !function_exists('roneous_get_term_name') ) {
	function roneous_get_term_name( $term, $value ) { 
		if( 'slug' == $value ) {
			return $term->slug;
		} elseif( 'link' == $value ) {
			return '<a href="'.get_term_link( $term, 'portfolio_category' ).'">'.$term->name.'</a>';
		} else {
			return $term->name; 
		}
	}
}


/**
	BREADCRUMBS
**/
if( !function_exists('roneous_breadcrumbs') ) { 
	function roneous_breadcrumbs() {
		if ( is_front_page() || is_search() || 'no' == get_option( 'tlg_framework_show_breadcrumbs', 'yes' ) ) return;
		global $post;
		$post_type 	= get_post_type();
		$ancestors 	= array_reverse( get_post_ancestors( $post->ID ) );
		$before 	= '<ol class="breadcrumb breadcrumb-style">';
		$after 		= '</ol>';
		$home 		= '<li><a href="' . esc_url( home_url( "/" ) ) . '" class="home-link" rel="home">' . esc_html__( 'Home', 'roneous' ) . '</a></li>';
		if( 'portfolio' == $post_type ) {
			$home  .= '<li class="active"><a href="' . esc_url( home_url( "/portfolio/" ) ) . '">' . esc_html__( 'Portfolio', 'roneous' ) . '</a></li>';
		}
		if( 'team' == $post_type ) {
			$home  .= '<li class="active"><a href="' . esc_url( home_url( "/team/" ) ) . '">' . esc_html__( 'Team', 'roneous' ) . '</a></li>';
		}
		if( 'product' == $post_type && !(is_archive()) ) {
			$home  .= '<li class="active"><a href="' . esc_url( get_permalink( woocommerce_get_page_id( 'shop' ) ) ) . '">' . esc_html__( 'Shop', 'roneous' ) . '</a></li>';
		} elseif( 'product' == $post_type && is_archive() ) {
			$home  .= '<li class="active">' . esc_html__( 'Shop', 'roneous' ) . '</li>';
		}
		$breadcrumb = '';
		if ( $ancestors ) {
			foreach ( $ancestors as $ancestor ) {
				$breadcrumb .= '<li><a href="' . esc_url( get_permalink( $ancestor ) ) . '">' . esc_html( get_the_title( $ancestor ) ) . '</a></li>';
			}
		}
		if( roneous_is_blog_page() && is_single() ) {
			$breadcrumb .= '<li><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html( get_option( 'blog_title', esc_html__( 'Our Blog', 'roneous' ) ) ) . '</a></li><li class="active">' . esc_html( get_the_title( $post->ID ) ) . '</li>';
		} elseif( roneous_is_blog_page() ) {
			$breadcrumb .= '<li class="active">' . get_option( 'blog_title', esc_html__( 'Our Blog', 'roneous' ) ) . '</li>';
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
	PAGINATION
**/
if( !function_exists('roneous_pagination') ) {
	function roneous_pagination( $pages = '', $range = 2 ) {
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
				$output .= "<li><a href='".esc_url(get_pagenum_link(1))."' aria-label='". esc_html__( 'Previous', 'roneous' ) ."'><span aria-hidden='true'>&laquo;</span></a></li> ";
			}
			for ($i=1; $i <= $pages; $i++) {
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
					$output .= ($paged == $i)? "<li class='active'><a href='".esc_url(get_pagenum_link($i))."'>".$i."</a></li> ":"<li><a href='".esc_url(get_pagenum_link($i))."'>".$i."</a></li> ";
				}
			}
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) {
				$output .= "<li><a href='".esc_url(get_pagenum_link($pages))."' aria-label='". esc_html__( 'Next', 'roneous' ) ."'><span aria-hidden='true'>&raquo;</span></a></li> ";
			}
			$output.= "</ul></div>";
		}
		return $output;
	}
}

/**
	COMMENTS
**/
if( !function_exists('roneous_comment') ) {
	function roneous_comment( $comment, $args, $depth ) { 
		$GLOBALS['comment'] = $comment; ?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
			<div class="entry-data mb24">
				<figure class="entry-data-author">
					<?php echo get_avatar( $comment->comment_author_email, 40 ); ?>
				</figure>
				<div class="entry-data-summary">
					<span class="inline-block author-name"><?php echo get_comment_author_link() ?></span>
					<div class="display-block">
						<span class="inline-block"><?php echo get_comment_date( 'M d, Y' ) ?></span>
						<span class="middot-divider"></span>
						<span class="inline-block"><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
					</div>
				</div>
			</div>
			<div class="comment-content">
				<?php echo wpautop( get_comment_text() ); ?>
				<?php if ( $comment->comment_approved == '0' ) : ?>
				<p><em><?php esc_html_e( 'Your comment is awaiting moderation.', 'roneous' ) ?></em></p>
				<?php endif; ?>	
			</div>
		<?php
	}
}

/**
	RESIZE IMAGE
**/
if( !function_exists('roneous_resize_image') ) {
    function roneous_resize_image( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
    	if ( class_exists('Aq_Resize') ) {
    		$aq_resize = Aq_Resize::getInstance();
        	return $aq_resize->process( $url, $width, $height, $crop, $single, $upscale );
    	}
        return $url;
    }
}

/**
	LIKES
**/
if( !function_exists('roneous_like_setup') ) {
	function roneous_like_setup( $post_id ) {
        if( !is_numeric( $post_id ) ) return;
        add_post_meta( $post_id, '_tlg_likes', '0', true );
    }
    add_action( 'publish_post', 'roneous_like_setup' );
}
if( !function_exists('roneous_like_ajax_call') ) {
	function roneous_like_ajax_call( $post_id ) {
	    if( isset( $_POST['likes_id'] ) ) {
	        $post_id = str_replace( 'tlg-likes-', '', $_POST['likes_id'] );
	        echo roneous_get_like_count( $post_id, 'update' );
	    } else {
	        $post_id = str_replace( 'tlg-likes-', '', $_POST['post_id'] );
	        echo roneous_get_like_count( $post_id, 'get' );
	    }
	    exit;
	}
	add_action( 'wp_ajax_tlg-likes', 'roneous_like_ajax_call' );
	add_action( 'wp_ajax_nopriv_tlg-likes', 'roneous_like_ajax_call' );
}
if( !function_exists('roneous_get_like_count') ) {
    function roneous_get_like_count( $post_id, $action = 'get' ) {
        if( !is_numeric( $post_id ) ) return;
        switch( $action ) {
            case 'get':
                $likes = get_post_meta( $post_id, '_tlg_likes', true );
                if( !$likes ) {
                    $likes = 0;
                    add_post_meta( $post_id, '_tlg_likes', $likes, true );
                }
                $like_cap = esc_html__( ' like', 'roneous' );
                if ( $likes > 1 ) {
                	$like_cap = esc_html__( ' likes', 'roneous' );
                }
                return '<i class="ti-heart"></i><span class="like-share-name">'. $likes . '<span>' . $like_cap . '</span></span>';
                break;
            case 'update':
                $likes = get_post_meta( $post_id, '_tlg_likes', true );
                if( isset( $_COOKIE['tlg_likes_'. $post_id] ) ) return $likes;
                $likes++;
                update_post_meta( $post_id, '_tlg_likes', $likes );
                setcookie( 'tlg_likes_'. $post_id, $post_id, time()*20, '/' );
                $like_cap = esc_html__( ' like', 'roneous' );
                if ( $likes > 1 ) {
                	$like_cap = esc_html__( ' likes', 'roneous' );
                }
                return '<i class="ti-heart"></i><span class="like-share-name">'. $likes  . '<span>' . $like_cap . '</span></span>';
                break;
        }
    }
}
if( !function_exists('roneous_like_display') ) {
    function roneous_like_display( $type = 'normal' ) {
        global $post;
        $post_id = $post->ID;
        $class = 'tlg-likes';
        $title = '';
        if( isset($_COOKIE['tlg_likes_'. $post_id]) ) {
            $class = 'tlg-likes active';
            $title = esc_html__( 'You already like this', 'roneous' );
        } ?>
        <div class="tlg-likes-button inline-block tlg-likes-<?php echo esc_attr($type) ?>">
        	<a href="#" class="<?php echo esc_attr($class) ?>" id="tlg-likes-<?php echo esc_attr($post_id) ?>" title="<?php echo esc_attr($title) ?>">
        		<?php echo roneous_get_like_count( $post_id ); ?>
        	</a>
        </div>
        <?php
    }
}