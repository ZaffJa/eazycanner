<?php
$quote = get_the_content();
if ( !has_post_thumbnail() ) {
	$prefix = '<blockquote>'; 
	$sufix = '</blockquote>';
	if ( strpos($quote, 'blockquote') !== false ) $prefix = $sufix = '';
	echo $prefix.$quote.$sufix;
} else {
	$prefix = '<blockquote class="blockquote blockquote-link blockquote-quote pb0 m0">'; 
	$sufix = '</blockquote>';
	if ( strpos($quote, 'blockquote') !== false ) {
		$prefix = $sufix = '';
		$quote = str_replace('<blockquote>', '<blockquote class="blockquote blockquote-link blockquote-quote pb0 m0">', $quote);
	}
	echo '<div class="shadow-caption mb16">';
	the_post_thumbnail( 'full', array( 'class' => 'mb0' ) );
	echo '<div class="shadow-caption-overlay"><div class="shadow-caption-inner">'.$prefix.$quote.$sufix.'</div></div></div>';
}