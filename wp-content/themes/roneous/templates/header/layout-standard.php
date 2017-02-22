<div class="nav-container">
    <nav>
        <?php get_template_part( 'templates/header/inc', 'top' ); ?>
        <div class="nav-bar">
            <div class="module left">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img class="logo logo-light" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url(get_option('roneous_custom_logo_light', TLG_THEME_DIRECTORY . 'assets/img/logo-light.png')); ?>" />
                    <img class="logo logo-dark" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url(get_option('roneous_custom_logo', TLG_THEME_DIRECTORY . 'assets/img/logo-dark.png')); ?>" />
                </a>
            </div>
            <div class="module widget-wrap mobile-toggle right visible-sm visible-xs">
                <i class="ti-menu"></i>
            </div>
            <div class="module-group right">
                <div class="module left">
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
				<?php get_template_part( 'templates/header/inc', 'icons' ); ?>
            </div>
        </div>
    </nav>
</div>