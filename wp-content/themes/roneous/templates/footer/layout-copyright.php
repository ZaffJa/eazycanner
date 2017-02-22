<footer class="footer-widget bg-dark p0">
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