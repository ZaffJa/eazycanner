<?php
/**
 * Theme Woocommerce
 *
 * @package TLG Theme
 *
 */

/**
	UPDATE CART IN HEADER
**/
if( ! function_exists( 'roneous_woocommerce_update_cart' ) ) {
	function roneous_woocommerce_update_cart( $cartInfo ) {
		global $woocommerce;
		ob_start(); ?>
		<a href="<?php echo esc_url($woocommerce->cart->get_cart_url()); ?>" class="cart-icon">
	        <i class="ti-bag"></i>
	        <span class="label number"><span class="tlg-count"><?php echo htmlspecialchars_decode($woocommerce->cart->get_cart_contents_count()); ?></span></span>
	        <span class="title"><?php esc_html_e( 'Shopping Cart', 'roneous' ); ?></span>
	    </a>
		<?php
		$cartInfo['a.cart-icon'] = ob_get_clean();
		return $cartInfo;
	}
	add_filter('add_to_cart_fragments', 'roneous_woocommerce_update_cart');
}

/**
	NUMBER OF PRODUCTS PER PAGE
**/
if( ! function_exists( 'roneous_woocommerce_ppp' ) ) {
	function roneous_woocommerce_ppp() {
		return get_option( 'roneous_shop_ppp', 9 );
	}
	add_filter( 'loop_shop_per_page', 'roneous_woocommerce_ppp', 20 );
}

/**
	WOOCOMMERCE SHARE
**/
if( ! function_exists( 'roneous_woocommerce_share' ) ) {
	function roneous_woocommerce_share() {
		echo '<div class="mt32">';
		get_template_part( 'templates/post/inc', 'sharing' );
		echo '</div>';
	}
	add_action( 'woocommerce_share', 'roneous_woocommerce_share' );
}