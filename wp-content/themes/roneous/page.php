<?php 
get_header();
the_post();
$page_title_args = array(
	'title'   	=> get_the_title(),
	'subtitle'  => get_post_meta( $post->ID, '_tlg_the_subtitle', true ),
	'layout' 	=> get_post_meta( $post->ID, '_tlg_page_title_layout', true ),
	'image'    	=> has_post_thumbnail() ? wp_get_attachment_image( get_post_thumbnail_id(), 'full', 0, array('class' => 'background-image') ) : false
);
echo roneous_get_the_page_title( $page_title_args );
?>
<section id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="container">
	    <div class="row">
	        <div class="col-sm-12 <?php roneous_the_page_class(); ?>">
	        	<?php the_content(); wp_link_pages(); comments_template(); ?>
	        </div>
	    </div>
	</div>
</section>
<?php get_footer();