<div class="post-wrap mb64">
	<div class="inner-wrap border-none p0">
		<div class="inner-left">
			<div class="day"><?php echo get_the_time('d') ?></div>
			<div class="month"><?php echo get_the_time('M') ?></div>
		</div>
		<div class="inner-right">
		    <?php
		    get_template_part( 'templates/post/inc', 'header' );
			the_excerpt();
			?>
			<div class="overflow-hidden">
				<div class="pull-left">
					<span class="read-more"><a href="<?php the_permalink(); ?>"><span data-hover="<?php esc_html_e( 'Read More', 'roneous' ); ?>"><?php esc_html_e( 'Read More', 'roneous' ); ?></span></a></span>
				</div>
				<div class="pull-right">
					<?php echo roneous_like_display(); ?>
				</div>
			</div>
		</div>
	</div>
</div>