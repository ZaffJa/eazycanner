<div class="show-sm">
	<?php get_template_part( 'templates/header/layout', 'standard-no-top-dark' ); ?>
</div>
<div class="nav-container left-menu vertical-menu hide-sm">
	<nav class="absolute transparent side-menu height-full">
		<div class="text-center bg-dark pl-32 pr-32 height-full">
			<div class="vertical-top bg-dark above pt40 pb24">
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<img class="image-xs mb40 mb-xs-24" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url(get_option('roneous_custom_logo_light', TLG_THEME_DIRECTORY . 'assets/img/logo-light.png')); ?>" />
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
			<div class="vertical-bottom bg-dark above pt24 pb24">
				<?php if ( 'yes' == get_option( 'roneous_enable_copyright', 'yes' ) ) : ?>
					<div class="heading-font sm-text"><?php echo wpautop(wp_kses(htmlspecialchars_decode( get_option( 'roneous_footer_copyright', esc_html__( 'Modify this text in: Appearance > Customize > Footer', 'roneous' ) )), roneous_allowed_tags())); ?></div>
				<?php endif; ?>
				<ul class="list-inline social-list"><?php echo roneous_header_social_icons(); ?></ul>
			</div>
		</div>
	</nav>
</div>