<?php global $woocommerce; ?>
<div class="module widget-wrap cart-widget-wrap left">
    <a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" class="cart-icon">
        <i class="ti-bag"></i>
        <span class="label number"><span class="tlg-count"><?php echo htmlspecialchars_decode($woocommerce->cart->get_cart_contents_count()); ?></span></span>
        <span class="title"><?php esc_html_e( 'Shopping Cart', 'roneous' ); ?></span>
    </a>
    <div class="widget-inner">
        <div class="widget">
            <div class="cart-header">
                <div class="cart-header-content">
                    <?php
                    if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) the_widget( 'WC_Widget_Cart', 'title=Cart' );
                    else the_widget( 'WooCommerce_Widget_Cart', 'title=Cart' );
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>