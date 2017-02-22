<div class="show-xs">
	<?php get_template_part( 'templates/header/layout', 'standard-no-top' ); ?>
</div>
<div class="nav-container vertical-menu hide-xs">
	<nav class="absolute transparent side-menu">
		<div class="nav-bar">
			<div class="module left">
				<a href="<?php echo esc_url(home_url('/')); ?>">
				    <img class="logo logo-light" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url(get_option('roneous_custom_logo_light', TLG_THEME_DIRECTORY . 'assets/img/logo-light.png')); ?>" />
                    <img class="logo logo-dark" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url(get_option('roneous_custom_logo', TLG_THEME_DIRECTORY . 'assets/img/logo-dark.png')); ?>" />
				</a>
			</div>
			<div class="module widget-wrap offcanvas-toggle right"><i class="ti-menu"></i></div>
		</div>
		<div class="offcanvas-container text-center">
			<div class="close-nav"><a href="#"><i class="ti-close"></i></a></div>
			<div class="vertical-top bg-white above pt40 pb24">
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<img class="image-xs mb40 mb-xs-24" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url(get_option('roneous_custom_logo', TLG_THEME_DIRECTORY . 'assets/img/logo-dark.png')); ?>" />
				</a>
			</div>
			<div class="vertical-alignment text-center">
				<?php
			    wp_nav_menu(
			    	array(
				        'theme_location'    => 'primary',
				        'depth'             => 3,
				        'container'         => false,
				        'container_class'   => false,
				        'menu_class'        => 'mb40 mb-xs-24 offcanvas-menu',
				        'fallback_cb'       => 'Roneous_Nav_Walker::fallback',
				        'walker'            => new Roneous_Nav_Walker()
			        )
			    );
				?>
			</div>
			<div class="vertical-bottom bg-white above pt24 pb24">
				<?php if ( 'yes' == get_option( 'roneous_enable_copyright', 'yes' ) ) : ?>
					<div class="heading-font sm-text"><?php echo wpautop(wp_kses(htmlspecialchars_decode( get_option( 'roneous_footer_copyright', esc_html__( 'Modify this text in: Appearance > Customize > Footer', 'roneous' ) )), roneous_allowed_tags())); ?></div>
				<?php endif; ?>
				<ul class="list-inline social-list"><?php echo roneous_header_social_icons(); ?></ul>
			</div>
		</div>
	</nav>
</div>