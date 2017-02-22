<?php 
$team_url = get_post_meta( $post->ID, '_tlg_team_url', 1 );
$team_about = get_post_meta( $post->ID, '_tlg_team_about', 1 );
$team_position = get_post_meta( $post->ID, '_tlg_team_position', 1 );
?>
<div class="col-sm-4 text-center mb40 mb-xs-24">
	<div class="image-box image-round inner-title hover-reveal text-center mb0">
        <?php the_post_thumbnail('full'); ?>
        <div class="title">
        	<h5 class="uppercase mb0">
            <?php
            if( !filter_var( $team_url, FILTER_VALIDATE_URL ) === false || $team_url == '#' ) {
                echo '<a class="link-light-title" href="'. esc_url($team_url) .'">'.get_the_title().'</a>';
            } else {
                echo get_the_title();
            }
            ?>
            </h5>
            <?php echo $team_position ? '<span>'.esc_attr( $team_position ).'</span>' : ''; ?>
            <?php echo $team_about ? '<div class="content mb8">'.esc_attr( $team_about ).'</div>' : ''; ?>
            <?php get_template_part( 'templates/team/inc', 'social' ); ?>
        </div>
    </div>
</div>