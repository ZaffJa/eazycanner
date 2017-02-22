<footer class="footer-widget bg-white <?php echo ( !is_active_sidebar('footer1') && !is_active_sidebar('footer2') && !is_active_sidebar('footer3') && !is_active_sidebar('footer4') ) ? 'p0' : '' ?> ">
    <div class="large-container">
        <div class="row">
            <?php
                if( is_active_sidebar('footer1') && !( is_active_sidebar('footer2') ) && !( is_active_sidebar('footer3') ) && !( is_active_sidebar('footer4') ) ){
                    echo '<div class="col-sm-12">';
                        dynamic_sidebar('footer1');
                    echo '</div>';
                }
                if( is_active_sidebar('footer2') && !( is_active_sidebar('footer3') ) && !( is_active_sidebar('footer4') ) ){
                    echo '<div class="col-sm-6">';
                        dynamic_sidebar('footer1');
                    echo '</div><div class="col-sm-6">';
                        dynamic_sidebar('footer2');
                    echo '</div><div class="clear"></div>';
                }
                if( is_active_sidebar('footer3') && !( is_active_sidebar('footer4') ) ){
                    echo '<div class="col-md-4 col-sm-6">';
                        dynamic_sidebar('footer1');
                    echo '</div><div class="col-md-4 col-sm-6">';
                        dynamic_sidebar('footer2');
                    echo '</div><div class="col-md-4 col-sm-6">';
                        dynamic_sidebar('footer3');
                    echo '</div><div class="clear"></div>';
                }
                if( ( is_active_sidebar('footer4') ) ){
                    echo '<div class="col-md-3 col-sm-6">';
                        dynamic_sidebar('footer1');
                    echo '</div><div class="col-md-3 col-sm-6">';
                        dynamic_sidebar('footer2');
                    echo '</div><div class="col-md-3 col-sm-6">';
                        dynamic_sidebar('footer3');
                    echo '</div><div class="col-md-3 col-sm-6">';
                        dynamic_sidebar('footer4');
                    echo '</div><div class="clear"></div>';
                }
            ?>
        </div>
    </div>
    <?php if ( 'yes' == get_option( 'roneous_enable_copyright', 'yes' ) ) : ?>
    <div class="large-container sub-footer">
        <div class="row">
            <div class="col-sm-6">
                <span class="sub">
                    <?php echo wp_kses(htmlspecialchars_decode( get_option( 'roneous_footer_copyright', esc_html__( 'Modify this text in: Appearance > Customize > Footer', 'roneous' ) )), roneous_allowed_tags()); ?>
                </span>
            </div>
            <div class="col-sm-6 text-right">
                <ul class="list-inline social-list">
                    <?php echo roneous_footer_social_icons(); ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>
</footer>