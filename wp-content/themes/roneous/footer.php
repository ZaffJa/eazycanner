		<?php get_template_part( 'templates/footer/layout', roneous_get_footer_layout() ); ?>
		<?php if ( 'yes' == get_option('roneous_enable_scroll_top', 'yes') ) : ?>
			<div class="back-to-top"><i class="ti-angle-up"></i></div>
		<?php endif; ?>
	</div><!--END: main-container-->
	<?php wp_footer(); ?>
</body>
</html>