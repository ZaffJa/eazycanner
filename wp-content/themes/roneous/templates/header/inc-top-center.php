<?php
$header_mobile 	= get_option('roneous_header_mobile', esc_html__( '+0123456789', 'roneous' ) );
$header_email 	= get_option('roneous_header_email', esc_html__( 'hello@yourmail.com', 'roneous' ) );
?>	
<div class="nav-utility big-utility">
	<div class="row">
		<div class="text-left col-sm-4">
			<?php if( $header_mobile ) : ?>
			    <div class="module left"><i class="ti-mobile">&nbsp;</i>
			        <span class="sub"><?php echo wp_kses($header_mobile, roneous_allowed_tags()); ?></span>
			    </div>
		    <?php endif; ?>
		    <?php if( $header_email ) : ?>
			    <div class="module left"><i class="ti-email">&nbsp;</i>
			        <span class="sub"><?php echo wp_kses($header_email, roneous_allowed_tags()); ?></span>
			    </div>
		    <?php endif; ?>
		</div>
		<div class="text-center col-sm-4">
			<a href="<?php echo esc_url(home_url('/')); ?>">
                <img class="logo logo-light" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url(get_option('roneous_custom_logo_light', TLG_THEME_DIRECTORY . 'assets/img/logo-light.png')); ?>" />
                <img class="logo logo-dark" alt="<?php echo esc_attr(get_bloginfo('title')); ?>" src="<?php echo esc_url(get_option('roneous_custom_logo', TLG_THEME_DIRECTORY . 'assets/img/logo-dark.png')); ?>" />
            </a>
		</div>
		<div class="text-right col-sm-4">
			<div class="module">
				<ul class="list-inline social-list mb24">
		            <?php echo roneous_header_social_icons(); ?>
		        </ul>
		    </div>
		</div>
	</div>
</div>