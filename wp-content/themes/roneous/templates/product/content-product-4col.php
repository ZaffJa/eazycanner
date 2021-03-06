<?php
global $product;
if ( !$product || !$product->is_visible() ) return;
?>
<div <?php post_class('col-md-3 col-sm-4 masonry-item col-xs-12'); ?>>
    <div class="image-box shop-outer-title text-center">
    	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
        <?php
        /**
         * woocommerce_before_shop_loop_item_title hook
         *
         * @hooked woocommerce_show_product_loop_sale_flash - 10
         * @hooked woocommerce_template_loop_product_thumbnail - 10
         */
        do_action( 'woocommerce_before_shop_loop_item_title' );
        the_title('<h5 class="mb0">', '</h5>');
        ?>
        <span class="display-block mb16"><?php woocommerce_template_loop_price(); ?></span>
        <?php
		/**
		 * woocommerce_after_shop_loop_item hook
		 *
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' );
    	?>
    </div>
</div>