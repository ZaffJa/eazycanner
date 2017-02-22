<?php global $post; ?>
<div class="nav-container">
    <nav class="bg-dark">
    	<?php get_template_part( 'templates/header/inc', 'top-center' ); ?>
        <div class="nav-bar">
            <div class="module left visible-sm visible-xs inline-block">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img class="logo logo-light" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url(get_option('roneous_custom_logo_light', TLG_THEME_DIRECTORY . 'assets/img/logo-light.png')); ?>" />
                    <img class="logo logo-dark" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url(get_option('roneous_custom_logo', TLG_THEME_DIRECTORY . 'assets/img/logo-dark.png')); ?>" />
                </a>
            </div>
            <div class="module widget-wrap mobile-toggle right visible-sm visible-xs">
                <i class="ti-menu"></i>
            </div>
            <div class="row">
                <div class="text-left col-lg-1 module-group">
                    <?php
                    if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_cart', 1 ))) && 
                        'yes' == get_option( 'roneous_header_cart', 'yes' ) && class_exists( 'Woocommerce' ) ) {
                        get_template_part( 'templates/header/inc', 'cart' );
                    }
                    ?>
                </div>
                <div class="text-center col-lg-10 module-group">
                    <div class="module text-left">
                        <?php
                        wp_nav_menu( 
                            array(
                                'theme_location'    => 'primary',
                                'depth'             => 3,
                                'container'         => false,
                                'container_class'   => false,
                                'menu_class'        => 'menu',
                                'fallback_cb'       => 'Roneous_Nav_Walker::fallback',
                                'walker'            => new Roneous_Nav_Walker()
                            )
                        );
                        ?>
                    </div>
                </div>
                <div class="text-right col-lg-1 module-group right">
                    <?php
                    if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_language', 1 ))) && 
                        'yes' == get_option( 'roneous_header_language', 'yes' ) && function_exists( 'icl_get_languages' ) ) {
                        get_template_part( 'templates/header/inc', 'language' );
                    }
                    if( (!isset($post->ID) || (isset($post->ID) && !get_post_meta( $post->ID, '_tlg_menu_hide_search', 1 ))) && 
                        'yes' == get_option( 'roneous_header_search', 'yes' ) ) {
                        get_template_part( 'templates/header/inc', 'search' );
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>
</div>