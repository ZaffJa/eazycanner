<?php
/**
 * Theme Customizer
 *
 * @package TLG Theme
 *
 */

include_once( ABSPATH . 'wp-includes/class-wp-customize-control.php' );

class Roneous_Customize_Textarea_Control extends WP_Customize_Control {
    public $type = 'textarea';
    public function render_content() {
    ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <textarea rows="3" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
        </label>
    <?php
    }
}

class Roneous_Customize_Range_Control extends WP_Customize_Control {
    public $type = 'range';
    public function render_content() {
    ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <input <?php $this->link(); ?> name="<?php echo esc_html( roneous_sanitize_title($this->label) ); ?>" type="range" min="<?php echo esc_attr($this->choices['min']); ?>" max="<?php echo esc_attr($this->choices['max']); ?>" step="<?php echo esc_attr($this->choices['step']); ?>" value="<?php echo intval( $this->value() ); ?>" class="tlg-range" onchange="printValue('<?php echo esc_html( roneous_sanitize_title($this->label) ); ?>')" />
            <input type="text" name="<?php echo esc_html( roneous_sanitize_title($this->label) ); ?>" class="tlg-range-output" value="<?php echo intval( $this->value() ); ?>" disabled/>
        </label>
    <?php
    }
}

if( !function_exists('roneous_register_options') ) {
    function roneous_register_options( $wp_customize ) {
        $prefix             = 'roneous_';
        $footer_layouts     = tlg_framework_get_footer_options();
        $header_layouts     = tlg_framework_get_header_options();
        $font_options       = tlg_framework_get_font_options();
        $social_list        = tlg_framework_get_social_icons();
        $portfolio_layouts  = tlg_framework_get_portfolio_layouts();
        $blog_layouts       = tlg_framework_get_blog_layouts();
        $page_titles        = tlg_framework_get_page_title_options();
        $shop_layouts       = tlg_framework_get_shop_layouts();
        $single_layouts     = tlg_framework_get_single_layouts();
        $site_layouts       = tlg_framework_get_site_layouts();
        $yesno_options      = array( 'yes' => esc_html__( 'Yes', 'roneous' ), 'no' => esc_html__( 'No', 'roneous' ) );
        foreach( $social_list as $icon ) $social_options[$icon]  = ucfirst(str_replace('ti-', '', $icon));

# SITE IDENTITY - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_setting( $prefix .'site_layout', array( 'default' => 'normal-layout', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'site_layout', array( 'priority' => 1, 'label' => esc_html__( 'Site Layout', 'roneous' ), 'type' => 'select', 'section' => 'title_tagline', 'settings'=> $prefix .'site_layout', 'choices' => $site_layouts ));
        
# COLORS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_setting( $prefix .'color_text', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#565656', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_text', array( 'priority' => 1, 'label' => esc_html__( 'Text Color', 'roneous' ), 'section' => 'colors', 'settings' => $prefix .'color_text' )));
        $wp_customize->add_setting( $prefix .'color_primary', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#0cb4ce', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_primary', array( 'priority' => 2, 'label' => esc_html__( 'Primary Color', 'roneous' ), 'section' => 'colors', 'settings' => $prefix .'color_primary' )));
        $wp_customize->add_setting( $prefix .'color_dark', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#28262b', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_dark', array( 'priority' => 3, 'label' => esc_html__( 'Dark Color', 'roneous' ), 'section' => 'colors', 'settings' => $prefix .'color_dark' )));
        $wp_customize->add_setting( $prefix .'color_bg_dark', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#1c1d1f', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_bg_dark', array( 'priority' => 4, 'label' => esc_html__( 'Background Dark Color', 'roneous' ), 'section' => 'colors', 'settings' => $prefix .'color_bg_dark' )));
        $wp_customize->add_setting( $prefix .'color_bg_graydark', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#393939', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_bg_graydark', array( 'priority' => 4, 'label' => esc_html__( 'Background Gray Dark Color', 'roneous' ), 'section' => 'colors', 'settings' => $prefix .'color_bg_graydark' )));
        $wp_customize->add_setting( $prefix .'color_secondary', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#f7f7f7', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_secondary', array( 'priority' => 6, 'label' => esc_html__( 'Background Secondary Color', 'roneous' ), 'section' => 'colors', 'settings' => $prefix .'color_secondary' )));
        $wp_customize->add_setting( $prefix .'color_menu_badge', array( 'capability' => 'edit_theme_options', 'type' => 'option', 'default' => '#8fae1b', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $prefix .'color_menu_badge', array( 'priority' => 999, 'label' => esc_html__( 'Menu Badge Color', 'roneous' ), 'section' => 'colors', 'settings' => $prefix .'color_menu_badge' )));
        
# FONTS & CSS - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'styling_section', array( 'title' => esc_html__( 'Fonts & CSS', 'roneous' ), 'priority' => 211 ));
        $wp_customize->add_setting( $prefix .'font', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'font', array( 'priority' => 1, 'label' => esc_html__( 'Body Font', 'roneous' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'font', 'choices' => $font_options ));
        $wp_customize->add_setting( $prefix .'header_font', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'header_font', array( 'priority' => 2, 'label' => esc_html__( 'Heading Font', 'roneous' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'header_font', 'choices' => $font_options ));
        $wp_customize->add_setting( $prefix .'menu_font', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'menu_font', array( 'priority' => 3, 'label' => esc_html__( 'Menu Font', 'roneous' ), 'type' => 'select', 'section' => 'styling_section', 'settings'=> $prefix .'menu_font', 'choices' => $font_options ));
        $wp_customize->add_setting( $prefix .'custom_css', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( new Roneous_Customize_Textarea_Control( $wp_customize, $prefix .'custom_css', array( 'priority' => 4, 'label' => esc_html__( 'Custom CSS', 'roneous' ), 'section' => 'styling_section', 'settings' => $prefix .'custom_css' )));

# HEADER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'header_section', array( 'title' => esc_html__( 'Header', 'roneous' ), 'priority' => 212 ));
        $wp_customize->add_setting( $prefix .'custom_logo', array( 'default' => TLG_THEME_DIRECTORY . 'assets/img/logo-dark.png', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'custom_logo', array( 'priority' => 1, 'label' => esc_html__( 'Logo', 'roneous' ), 'section' => 'header_section', 'settings' => $prefix .'custom_logo' )));
        $wp_customize->add_setting( $prefix .'custom_logo_light', array( 'default' => TLG_THEME_DIRECTORY . 'assets/img/logo-light.png', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'custom_logo_light', array( 'priority' => 2, 'label' => esc_html__( 'Logo Light', 'roneous' ), 'section' => 'header_section', 'settings' => $prefix .'custom_logo_light' )));
        $wp_customize->add_setting( $prefix .'menu_height', array( 'default' => '64', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize', ));
        $wp_customize->add_control( new Roneous_Customize_Range_Control( $wp_customize, $prefix .'menu_height', array( 'priority' => 4, 'label' => esc_html__( 'Menu Height (default: 64px)', 'roneous' ), 'section' => 'header_section', 'settings' => $prefix .'menu_height', 'choices' => array('min' => '55', 'max' => '110', 'step' => '1') )));
        $wp_customize->add_setting( $prefix .'menu_right_space', array( 'default' => '32', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize', ));
        $wp_customize->add_control( new Roneous_Customize_Range_Control( $wp_customize, $prefix .'menu_right_space', array( 'priority' => 5, 'label' => esc_html__( 'Menu Right Spacing (default: 32px)', 'roneous' ), 'section' => 'header_section', 'settings' => $prefix .'menu_right_space', 'choices' => array('min' => '32', 'max' => '150', 'step' => '1') )));
        $wp_customize->add_setting( $prefix .'menu_column_width', array( 'default' => '230', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize', ));
        $wp_customize->add_control( new Roneous_Customize_Range_Control( $wp_customize, $prefix .'menu_column_width', array( 'priority' => 6, 'label' => esc_html__( 'Menu Column Width (default: 230px)', 'roneous' ), 'section' => 'header_section', 'settings' => $prefix .'menu_column_width', 'choices' => array('min' => '200', 'max' => '350', 'step' => '1') )));
        $wp_customize->add_setting( $prefix .'menu_vertical_width', array( 'default' => '280', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize', ));
        $wp_customize->add_control( new Roneous_Customize_Range_Control( $wp_customize, $prefix .'menu_vertical_width', array( 'priority' => 7, 'label' => esc_html__( 'Menu Vertical Width (default: 280px)', 'roneous' ), 'section' => 'header_section', 'settings' => $prefix .'menu_vertical_width', 'choices' => array('min' => '200', 'max' => '900', 'step' => '1') )));
        $wp_customize->add_setting( $prefix .'header_layout', array( 'default' => 'standard', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'header_layout', array( 'priority' => 8, 'label' => esc_html__( 'Header Layout', 'roneous' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_layout', 'choices' => $header_layouts ));
        $wp_customize->add_setting( $prefix .'header_search', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'header_search', array( 'priority' => 9, 'label' => esc_html__( 'Show Header Search?', 'roneous' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_search', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'header_cart', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'header_cart', array( 'priority' => 10, 'label' => esc_html__( 'Show Header Cart?', 'roneous' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_cart', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'header_language', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'header_language', array( 'priority' => 11, 'label' => esc_html__( 'Show Header Language? (require WPML plugin)', 'roneous' ), 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_language', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'header_mobile', array( 'default' => esc_html__( '+0123456789', 'roneous' ), 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'header_mobile', array( 'priority' => 12, 'label' => esc_html__( 'Header Mobile Number', 'roneous' ), 'section' => 'header_section', 'settings'=> $prefix .'header_mobile' ));
        $wp_customize->add_setting( $prefix .'header_email', array( 'default' => esc_html__( 'hello@yourmail.com', 'roneous' ), 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'header_email', array( 'priority' => 13, 'label' => esc_html__( 'Header Email Address', 'roneous' ), 'section' => 'header_section', 'settings'=> $prefix .'header_email' ));
        for( $i = 1; $i < 11; $i++ ) {
            $wp_customize->add_setting( $prefix .'header_social_icon_' . $i, array( 'default' => 'none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
            $wp_customize->add_control( $prefix .'header_social_icon_' . $i, array( 'priority' => (14 + $i + $i), 'label' => esc_html__( 'Header Social Icon ', 'roneous' ) . $i, 'type' => 'select', 'section' => 'header_section', 'settings'=> $prefix .'header_social_icon_' . $i, 'choices' => $social_options ));
            $wp_customize->add_setting( $prefix .'header_social_url_' . $i, array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
            $wp_customize->add_control( $prefix .'header_social_url_' . $i, array( 'priority' => (15 + $i + $i), 'label' => esc_html__( 'Header Social URL ', 'roneous' ) . $i, 'section' => 'header_section', 'settings'=> $prefix .'header_social_url_' . $i ));
        }

# FOOTER - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'footer_section', array( 'title' => esc_html__( 'Footer', 'roneous' ), 'priority' => 213 ));
        $wp_customize->add_setting( $prefix .'footer_layout', array( 'default' => 'standard', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'footer_layout', array( 'priority' => 1, 'label' => esc_html__( 'Footer Layout', 'roneous' ), 'type' => 'select', 'section' => 'footer_section', 'settings'=> $prefix .'footer_layout', 'choices' => $footer_layouts ));
        $wp_customize->add_setting( $prefix .'enable_copyright', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_copyright', array( 'priority' => 2, 'label' => esc_html__( 'Enable Footer Copyright?', 'roneous' ), 'type' => 'select', 'section' => 'footer_section', 'settings'=> $prefix .'enable_copyright', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'footer_copyright', array( 'default' => esc_html__( 'Modify this text in: Appearance > Customize > Footer', 'roneous' ), 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'footer_copyright', array( 'priority' => 3, 'label' => esc_html__( 'Footer Copyright Text', 'roneous' ), 'section' => 'footer_section', 'settings'=> $prefix .'footer_copyright' ));
        for( $i = 1; $i < 11; $i++ ) {
            $wp_customize->add_setting( $prefix .'footer_social_icon_' . $i, array( 'default' => 'none', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
            $wp_customize->add_control( $prefix .'footer_social_icon_' . $i, array( 'priority' => (4 + $i + $i), 'label' => esc_html__( 'Footer Social Icon ', 'roneous' ) . $i, 'type' => 'select', 'section' => 'footer_section', 'settings'=> $prefix .'footer_social_icon_' . $i, 'choices' => $social_options ));
            $wp_customize->add_setting( $prefix .'footer_social_url_' . $i, array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
            $wp_customize->add_control( $prefix .'footer_social_url_' . $i, array( 'priority' => (5 + $i + $i), 'label' => esc_html__( 'Footer Social URL ', 'roneous' ) . $i, 'section' => 'footer_section', 'settings'=> $prefix .'footer_social_url_' . $i ));
        }

# BLOG - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'blog_section', array( 'title' => esc_html__( 'Blog', 'roneous' ), 'priority' => 214 ));
        $wp_customize->add_setting( $prefix .'post_layout', array( 'default' => 'sidebar-right', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'post_layout', array( 'priority' => 1, 'label' => esc_html__( 'Single Layout', 'roneous' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'post_layout', 'choices' => $single_layouts ));
        $wp_customize->add_setting( $prefix .'blog_layout', array( 'default' => 'sidebar-right', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_layout', array( 'priority' => 2, 'label' => esc_html__( 'Archives Layout', 'roneous' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_layout', 'choices' => $blog_layouts ));
        $wp_customize->add_setting( $prefix .'blog_header_layout', array( 'default' => 'center', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_header_layout', array( 'priority' => 3, 'label' => esc_html__( 'Blog Title Layout', 'roneous' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_header_layout', 'choices' => $page_titles ));
        $wp_customize->add_setting( $prefix .'blog_title', array( 'default' => esc_html__( 'Our Blog', 'roneous' ), 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_title', array( 'priority' => 4, 'label' => esc_html__( 'Blog Title', 'roneous' ), 'section' => 'blog_section', 'settings'=> $prefix .'blog_title' ));
        $wp_customize->add_setting( $prefix .'blog_subtitle', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_subtitle', array( 'priority' => 5, 'label' => esc_html__( 'Blog Subtitle', 'roneous' ), 'section' => 'blog_section', 'settings'=> $prefix .'blog_subtitle' ));
        $wp_customize->add_setting( $prefix .'blog_header_image', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'blog_header_image', array( 'priority' => 6, 'label' => esc_html__( 'Blog Header Background', 'roneous' ), 'section' => 'blog_section', 'settings' => $prefix .'blog_header_image' )));
        $wp_customize->add_setting( $prefix .'blog_show_feature', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_show_feature', array( 'priority' => 7, 'label' => esc_html__( 'Show feature image on single post?', 'roneous' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_show_feature', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'blog_enable_pagination', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'blog_enable_pagination', array( 'priority' => 8, 'label' => esc_html__( 'Enable Single Pagination?', 'roneous' ), 'type' => 'select', 'section' => 'blog_section', 'settings'=> $prefix .'blog_enable_pagination', 'choices' => $yesno_options ));

# PORTFOLIO - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'portfolio_section', array( 'title' => esc_html__( 'Portfolio', 'roneous' ), 'priority' => 215, 'description' => wp_kses( __( '* When you make change on \'Portfolio URL slug\', please make sure to refresh the permalinks by going to <a target="_blank" href="options-permalink.php">Settings > Permalinks</a> and click on the \'Save Changes\' button. Otherwise, the change will do not work properly.', 'roneous' ), roneous_allowed_tags() ) ));
        $wp_customize->add_setting( 'tlg_framework_portfolio_slug', array( 'default' => 'portfolio', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_portfolio_slug', array( 'priority' => 1, 'label' => esc_html__( '* Portfolio URL slug', 'roneous' ), 'section' => 'portfolio_section', 'settings'=> 'tlg_framework_portfolio_slug' ));
        $wp_customize->add_setting( $prefix .'portfolio_layout', array( 'default' => 'full-grid-4col', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_layout', array( 'priority' => 2, 'label' => esc_html__( 'Archives Layout', 'roneous' ), 'type' => 'select', 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_layout', 'choices' => $portfolio_layouts ));
        $wp_customize->add_setting( $prefix .'portfolio_header_layout', array( 'default' => 'center', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_header_layout', array( 'priority' => 3, 'label' => esc_html__( 'Portfolio Title Layout', 'roneous' ), 'type' => 'select', 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_header_layout', 'choices' => $page_titles ));
        $wp_customize->add_setting( $prefix .'portfolio_title', array( 'default' => esc_html__( 'Our Portfolio', 'roneous' ), 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_title', array( 'priority' => 4, 'label' => esc_html__( 'Portfolio Title', 'roneous' ), 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_title' ));
        $wp_customize->add_setting( $prefix .'portfolio_subtitle', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_subtitle', array( 'priority' => 5, 'label' => esc_html__( 'Portfolio Subtitle', 'roneous' ), 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_subtitle' ));
        $wp_customize->add_setting( $prefix .'portfolio_header_image', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'portfolio_header_image', array( 'priority' => 6, 'label' => esc_html__( 'Portfolio Header Background', 'roneous' ), 'section' => 'portfolio_section', 'settings' => $prefix .'portfolio_header_image' )));
        $wp_customize->add_setting( $prefix .'portfolio_enable_pagination', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'portfolio_enable_pagination', array( 'priority' => 7, 'label' => esc_html__( 'Enable Single Pagination?', 'roneous' ), 'type' => 'select', 'section' => 'portfolio_section', 'settings'=> $prefix .'portfolio_enable_pagination', 'choices' => $yesno_options ));

# SHOP - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'shop_section', array( 'title' => esc_html__( 'Shop', 'roneous' ), 'priority' => 216 ));
        $wp_customize->add_setting( $prefix .'shop_ppp', array( 'default' => 9, 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_ppp', array( 'priority' => 1, 'label' => esc_html__( 'Number of Products per Page', 'roneous' ), 'section' => 'shop_section', 'settings'=> $prefix .'shop_ppp' ));
        $wp_customize->add_setting( $prefix .'shop_layout', array( 'default' => 'sidebar-right', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_layout', array( 'priority' => 2, 'label' => esc_html__( 'Archives Layout', 'roneous' ), 'type' => 'select', 'section' => 'shop_section', 'settings'=> $prefix .'shop_layout', 'choices' => $shop_layouts ));
        $wp_customize->add_setting( $prefix .'shop_header_layout', array( 'default' => 'center', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_header_layout', array( 'priority' => 3, 'label' => esc_html__( 'Shop Title Layout', 'roneous' ), 'type' => 'select', 'section' => 'shop_section', 'settings'=> $prefix .'shop_header_layout', 'choices' => $page_titles ));
        $wp_customize->add_setting( $prefix .'shop_title', array( 'default' => esc_html__( 'Our Shop', 'roneous' ), 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_title', array( 'priority' => 4, 'label' => esc_html__( 'Shop Title', 'roneous' ), 'section' => 'shop_section', 'settings'=> $prefix .'shop_title' ));
        $wp_customize->add_setting( $prefix .'shop_subtitle', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_subtitle', array( 'priority' => 5, 'label' => esc_html__( 'Shop Subtitle', 'roneous' ), 'section' => 'shop_section', 'settings'=> $prefix .'shop_subtitle' ));
        $wp_customize->add_setting( $prefix .'shop_header_image', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize', ));
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $prefix .'shop_header_image', array( 'priority' => 6, 'label' => esc_html__( 'Shop Header Background', 'roneous' ), 'section' => 'shop_section', 'settings' => $prefix .'shop_header_image' )));
        $wp_customize->add_setting( $prefix .'shop_enable_pagination', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'shop_enable_pagination', array( 'priority' => 7, 'label' => esc_html__( 'Enable Single Pagination?', 'roneous' ), 'type' => 'select', 'section' => 'shop_section', 'settings'=> $prefix .'shop_enable_pagination', 'choices' => $yesno_options ));

# SYSTEM - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 
        $wp_customize->add_section( 'system_section', array( 'title' => esc_html__( 'System', 'roneous' ), 'priority' => 217, 'description' => wp_kses( __( '* As per Google announcement, usage of the Google Maps now requires a key. Please see the <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key#get-an-api-key">Google Maps APIs documentation</a> to get a key and add it to the field below.', 'roneous' ), roneous_allowed_tags() ) ));
        $wp_customize->add_setting( 'tlg_framework_gmaps_key', array( 'default' => '', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_gmaps_key', array( 'priority' => 0, 'label' => esc_html__( '* Google Maps API key', 'roneous' ), 'section' => 'system_section', 'settings'=> 'tlg_framework_gmaps_key' ));
        $wp_customize->add_setting( $prefix .'enable_preloader', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_preloader', array( 'priority' => 0, 'label' => esc_html__( 'Enable Preloader?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_preloader', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_portfolio', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_portfolio', array( 'priority' => 1, 'label' => esc_html__( 'Enable Portfolio?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_portfolio', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_team', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_team', array( 'priority' => 2, 'label' => esc_html__( 'Enable Team Members?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_team', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_client', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_client', array( 'priority' => 3, 'label' => esc_html__( 'Enable Clients?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_client', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_testimonial', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_testimonial', array( 'priority' => 4, 'label' => esc_html__( 'Enable Testimonials?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_testimonial', 'choices' => $yesno_options ));
        $wp_customize->add_setting( 'tlg_framework_show_breadcrumbs', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( 'tlg_framework_show_breadcrumbs', array( 'priority' => 5, 'label' => esc_html__( 'Enable Breadcrumbs?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> 'tlg_framework_show_breadcrumbs', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_scroll_top', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_scroll_top', array( 'priority' => 6, 'label' => esc_html__( 'Enable Scroll To Top button?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_scroll_top', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_search_filter', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_search_filter', array( 'priority' => 7, 'label' => esc_html__( 'Exclude Pages from Search Results?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_search_filter', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'auto_vc_page', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'auto_vc_page', array( 'priority' => 8, 'label' => esc_html__( 'Auto activate Visual Composer for Page?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'auto_vc_page', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'auto_vc_post', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'auto_vc_post', array( 'priority' => 9, 'label' => esc_html__( 'Auto activate Visual Composer for Post?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'auto_vc_post', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'auto_vc_portfolio', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'auto_vc_portfolio', array( 'priority' => 10, 'label' => esc_html__( 'Auto activate Visual Composer for Portfolio?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'auto_vc_portfolio', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'auto_vc_product', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'auto_vc_product', array( 'priority' => 11, 'label' => esc_html__( 'Auto activate Visual Composer for Product?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'auto_vc_product', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_default_vc_shortcode', array( 'default' => 'no', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_default_vc_shortcode', array( 'priority' => 12, 'label' => esc_html__( 'Enable Visual Composer Default Shortcode?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_default_vc_shortcode', 'choices' => $yesno_options ));
        $wp_customize->add_setting( $prefix .'enable_default_wc_shortcode', array( 'default' => 'yes', 'capability' => 'edit_theme_options', 'type' => 'option', 'sanitize_callback' => 'roneous_sanitize' ));
        $wp_customize->add_control( $prefix .'enable_default_wc_shortcode', array( 'priority' => 12, 'label' => esc_html__( 'Enable WooCommerce Default Shortcode?', 'roneous' ), 'type' => 'select', 'section' => 'system_section', 'settings'=> $prefix .'enable_default_wc_shortcode', 'choices' => $yesno_options ));

    }
    add_action( 'customize_register', 'roneous_register_options' );
}