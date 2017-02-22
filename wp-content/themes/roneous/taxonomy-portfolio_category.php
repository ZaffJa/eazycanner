<?php 
get_header();
$page_title_args = array(
	'title'   	=> get_option( 'roneous_portfolio_title', esc_html__( 'Our portfolio', 'roneous' ) ), 
	'subtitle'  => get_option( 'roneous_portfolio_subtitle', '' ),
	'layout' 	=> get_option( 'roneous_portfolio_header_layout', 'center' ),
	'image'    	=> get_option( 'roneous_portfolio_header_image' ) ? '<img src="'. get_option( 'roneous_portfolio_header_image' ) .'" alt="'.esc_html__( 'page-header', 'roneous' ).'" class="background-image" />' : false
);
echo roneous_get_the_page_title( $page_title_args );
get_template_part( 'templates/portfolio/layout', get_option( 'roneous_portfolio_layout', 'full-grid-4col' ) );
get_footer();