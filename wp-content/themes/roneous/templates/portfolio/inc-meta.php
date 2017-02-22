<?php 
$clientName = get_post_meta( $post->ID, '_tlg_portfolio_client', 1 ); 
$clientUrl = get_post_meta( $post->ID, '_tlg_portfolio_client_url', 1 );
$clientDate = get_post_meta( $post->ID, '_tlg_portfolio_date', 1 );
$clientShowDate = get_post_meta( $post->ID, '_tlg_portfolio_show_date', 1 );
$clientShowCategory = get_post_meta( $post->ID, '_tlg_portfolio_show_cat', 1 );
$clientShowClient = get_post_meta( $post->ID, '_tlg_portfolio_show_client', 1 );

$clientAttribute_1_Name = get_post_meta( $post->ID, '_tlg_portfolio_attribute_1', 1 );
$clientAttribute_1_Value = get_post_meta( $post->ID, '_tlg_portfolio_attribute_1_value', 1 );
$clientAttribute_1_Show = get_post_meta( $post->ID, '_tlg_portfolio_attribute_1_show', 1 );

$clientAttribute_2_Name = get_post_meta( $post->ID, '_tlg_portfolio_attribute_2', 1 );
$clientAttribute_2_Value = get_post_meta( $post->ID, '_tlg_portfolio_attribute_2_value', 1 );
$clientAttribute_2_Show = get_post_meta( $post->ID, '_tlg_portfolio_attribute_2_show', 1 );

$clientAttribute_3_Name = get_post_meta( $post->ID, '_tlg_portfolio_attribute_3', 1 );
$clientAttribute_3_Value = get_post_meta( $post->ID, '_tlg_portfolio_attribute_3_value', 1 );
$clientAttribute_3_Show = get_post_meta( $post->ID, '_tlg_portfolio_attribute_3_show', 1 );

$clientAttribute_4_Name = get_post_meta( $post->ID, '_tlg_portfolio_attribute_4', 1 );
$clientAttribute_4_Value = get_post_meta( $post->ID, '_tlg_portfolio_attribute_4_value', 1 );
$clientAttribute_4_Show = get_post_meta( $post->ID, '_tlg_portfolio_attribute_4_show', 1 );
?>
<div class="mt32 border-line-top">
    <div class="pull-left">
        <?php
        echo $clientAttribute_1_Show && $clientAttribute_1_Name ? '<p><strong>'.esc_attr( $clientAttribute_1_Name ).':</strong> '.esc_attr( $clientAttribute_1_Value ).'</p>' : '';
        echo $clientAttribute_2_Show && $clientAttribute_2_Name ? '<p><strong>'.esc_attr( $clientAttribute_2_Name ).':</strong> '.esc_attr( $clientAttribute_2_Value ).'</p>' : '';
        echo $clientShowClient && $clientName ? '<p><strong>'.esc_html__( 'Client', 'roneous' ).'</strong>: '.($clientUrl ? '<a target="_blank" href="'.esc_url($clientUrl).'">' : '') .esc_attr( $clientName ). ($clientUrl ? '</a>' : '').'</p>' : '';
        echo roneous_like_display( 'round' );
        get_template_part( 'templates/post/inc', 'sharing' );
        ?>
    </div>
    <div class="pull-right">
        <?php
        echo $clientAttribute_3_Show && $clientAttribute_3_Name ? '<p><strong>'.esc_attr( $clientAttribute_3_Name ).':</strong> '.esc_attr( $clientAttribute_3_Value ).'</p>' : '';
        echo $clientAttribute_4_Show && $clientAttribute_4_Name ? '<p><strong>'.esc_attr( $clientAttribute_4_Name ).':</strong> '.esc_attr( $clientAttribute_4_Value ).'</p>' : '';
        echo $clientShowDate ? '<p><strong>'.esc_html__( 'Release Date', 'roneous' ).':</strong> '.( $clientDate ? date("F j, Y", $clientDate) : get_the_date() ).'</p>' : '';
        echo $clientShowCategory ? '<p><strong>'.esc_html__( 'Category', 'roneous' ).':</strong> '.get_the_term_list( $post->ID, 'portfolio_category', '', '', '' ).'</p>' : '';
        ?>
    </div>
</div>