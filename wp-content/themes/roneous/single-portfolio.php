<?php
get_header();
the_post();
$page_title_args = array(
    'title'     => get_the_title( $post->ID ) ? get_the_title( $post->ID ) : get_option( 'roneous_portfolio_title', esc_html__( 'Our Portfolio', 'roneous' ) ),
    'subtitle'  => get_post_meta( $post->ID, '_tlg_the_subtitle', true ),
    'layout'    => get_post_meta( $post->ID, '_tlg_page_title_layout', true ),
    'image'     => get_post_meta( $post->ID, '_tlg_title_bg_featured', true ) == 'yes' ? 
        ( has_post_thumbnail() ? wp_get_attachment_image( get_post_thumbnail_id(), 'full', 0, array('class' => 'background-image') ) : false ) :
        ( get_post_meta( $post->ID, '_tlg_title_bg_img', true ) ? '<img class="background-image" src="'.esc_url(get_post_meta( $post->ID, '_tlg_title_bg_img', true )).'" />' : false )
);
echo roneous_get_the_page_title( $page_title_args );
?>
<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php 
    if( 'yes' == get_option( 'roneous_portfolio_enable_pagination', 'yes' ) ) { 
        get_template_part( 'templates/post/inc', 'pagination');
    }
    ?>
    <div class="container">
        <div class="row">
            <?php the_content(); wp_link_pages(); ?>
            <?php get_template_part( 'templates/portfolio/inc', 'meta'); ?>
        </div>
    </div>
</section>
<?php get_footer();