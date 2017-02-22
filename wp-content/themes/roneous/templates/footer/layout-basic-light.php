<?php $logo_light = get_option('_tlg_custom_logo', TLG_THEME_DIRECTORY . 'assets/img/logo-dark.png'); ?>
<footer class="footer-basic bg-white">
	<div class="large-container">
		<div class="row">
			<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 text-center">
				<a href="<?php echo esc_url(home_url('/')); ?>">
					<img alt="<?php echo esc_attr(get_bloginfo('title')); ?>" class="image-xs mb32 fade-hover" src="<?php echo esc_url($logo_light); ?>" />
				</a>
				<?php if ( 'yes' == get_option( 'roneous_enable_copyright', 'yes' ) ) : ?>
				<h5 class="fade-75"><?php echo wp_kses(htmlspecialchars_decode( get_option( 'roneous_footer_copyright', esc_html__( 'Modify this text in: Appearance > Customize > Footer', 'roneous' ) )), roneous_allowed_tags()); ?></h5>
				<?php endif; ?>
				<ul class="list-inline social-list mb0"><?php echo roneous_footer_social_icons(); ?></ul>
			</div>
		</div>
	</div>
</footer>