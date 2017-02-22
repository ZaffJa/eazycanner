<?php
if ( has_post_thumbnail() ) {
	echo '<div class="shadow-caption mb16">';
	the_post_thumbnail( 'full', array( 'class' => 'mb0' ) );
	echo '<div class="shadow-caption-overlay"><div class="shadow-caption-inner">';
}
echo '<blockquote class="blockquote blockquote-link dark-hover-a pb0 m0">'.get_the_content().'</blockquote>';
if ( has_post_thumbnail() ) {
	echo '</div></div></div>';
}