<?php
$post_type = isset($_GET['post_type']) ? $_GET['post_type'] : false;
if ( 'product' == $post_type ) {
	get_template_part( 'woocommerce' );
} else {
	get_header();
	global $wp_query;
	$results 			= $wp_query->found_posts;
	$search_term 		= get_search_query();
	$page_title_args 	= array(
		'title'   	=> esc_html__( 'Search Results for: ', 'roneous' ) . ( $search_term ? $search_term : esc_html__( 'Empty', 'roneous' ) ), 
		'subtitle'  => $search_term ? esc_html__( 'Found ' ,'roneous' ) . $results . ( '1' == $results ? esc_html__(' Item', 'roneous') : esc_html__( ' Items', 'roneous' ) ) : '',
		'layout' 	=> get_option( 'roneous_blog_header_layout', 'center' ),
	);
	echo roneous_get_the_page_title( $page_title_args );
	if( $search_term ) {
		get_template_part( 'templates/post/layout', 'search' );
	} else { ?>
		<section class="search-wrap">
			<div class="container">
				<?php get_template_part( 'templates/post/content', 'none' ); ?>
			</div>
		</section><?php
	}
	get_footer();
}