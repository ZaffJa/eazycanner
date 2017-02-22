<?php 
get_header();
the_post();
$page_title_args = array(
	'title'   	=> get_the_title(),
	'subtitle'  => get_post_meta( $post->ID, '_tlg_the_subtitle', true ),
	'layout' 	=> get_post_meta( $post->ID, '_tlg_page_title_layout', true ),
	'image'     => get_post_meta( $post->ID, '_tlg_title_bg_featured', true ) == 'yes' ? 
        ( has_post_thumbnail() ? wp_get_attachment_image( get_post_thumbnail_id(), 'full', 0, array('class' => 'background-image') ) : false ) :
        ( get_post_meta( $post->ID, '_tlg_title_bg_img', true ) ? '<img class="background-image" src="'.esc_url(get_post_meta( $post->ID, '_tlg_title_bg_img', true )).'" />' : false )
);
echo roneous_get_the_page_title( $page_title_args );
?>
<div class="tlg-page-wrapper">
	<a id="home" href="#"></a>
	<?php if( is_single() ) get_template_part( 'templates/post/inc', 'pagination'); ?>
	<?php the_content(); ?>
</div>
<?php get_footer();