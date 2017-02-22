<?php 
# Define theme folder URL
define( 'TLG_THEME_DIRECTORY', esc_url(trailingslashit(get_template_directory_uri())) );

# Including theme helpers
get_template_part( 'inc/helpers' );

# Including plugin activation & metaboxes
if( is_admin() ) {
	if ( !class_exists( 'TGM_Plugin_Activation' ) ) {
		get_template_part( 'inc/lib/class-tgm-plugin-activation' );
	}
	if( roneous_is_plugin_active( 'tlg_framework/index.php' ) ) {
		get_template_part( 'inc/metaboxes' );
		get_template_part( 'inc/importer/init' );
	}
}

# Including theme components
get_template_part( 'inc/setup' );
get_template_part( 'inc/menus' );
get_template_part( 'inc/sidebars' );
get_template_part( 'inc/filters' );
get_template_part( 'inc/scripts' );
if( roneous_is_plugin_active( 'tlg_framework/index.php' ) ) {
	get_template_part( 'inc/customizer' );
}

# Including WooCommerce Shop functions
if( class_exists('Woocommerce') ) {
	get_template_part( 'inc/shop');
}

# Including Visual Composer functions
if( function_exists('vc_set_as_theme') ) {
	get_template_part( 'visualcomposer/init' );
}

# Please use a child theme if you need to modify the theme functions
# BE WARNED! You can add code below here but it will be overwritten on theme update