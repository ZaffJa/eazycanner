<?php
$header_mobile 	= get_option('roneous_header_mobile', esc_html__( '+0123456789', 'roneous' ) );
$header_email 	= get_option('roneous_header_email', esc_html__( 'hello@yourmail.com', 'roneous' ) );
?>	
<div class="nav-utility">
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
	<div class="module right">
		<ul class="list-inline social-list mb24">
            <?php echo roneous_header_social_icons(); ?>
        </ul>
    </div>
</div>