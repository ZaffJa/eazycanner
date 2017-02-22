<?php
$prev = get_previous_post();
$next = get_next_post();
$prev_link = $prev ? get_permalink($prev->ID) : false;
$next_link = $next ? get_permalink($next->ID) : false;
$prev_title = $prev ? get_the_title($prev->ID) : false;
$next_title = $next ? get_the_title($next->ID) : false;
$prev_date = $prev ? ( get_post_meta($prev->ID, '_tlg_portfolio_date', 1) ? date("d F Y", get_post_meta($prev->ID, '_tlg_portfolio_date', 1)) : mysql2date('d F Y', $prev->post_date, false) ) : false;
$next_date = $next ? ( get_post_meta($next->ID, '_tlg_portfolio_date', 1) ? date("d F Y", get_post_meta($next->ID, '_tlg_portfolio_date', 1)) : mysql2date('d F Y', $next->post_date, false) ) : false;
?>
<div class="page-nav mobile-hide">
	<?php if( $prev_link ) : ?>
		<a class="nav-prev" href="<?php echo esc_url($prev_link); ?>">
			<div class="nav-control"><i class="ti-angle-left"></i></div>
			<div class="nav-title">
				<div class="nav-name"><?php echo esc_attr( $prev_title ); ?></div>
				<div class="subtitle"><?php echo esc_attr( $prev_date ); ?></div>
			</div>
		</a>
	<?php endif; ?>
	<?php if( $next_link ) : ?>
		<a class="nav-next" href="<?php echo esc_url($next_link); ?>">
			<div class="nav-control"><i class="ti-angle-right"></i></div>
			<div class="nav-title">
				<div class="nav-name"><?php echo esc_attr( $next_title ); ?></div>
				<div class="subtitle"><?php echo esc_attr( $next_date ); ?></div>
			</div>
		</a>
	<?php endif; ?>
</div>