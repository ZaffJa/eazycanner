<?php
global $post;
$url[] = '';
$url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
?>
<div class="ssc-share-wrap">
    <div class="clearfix relative">
        <a href="#" class="ssc-share-toogle">
            <i class="ti-share"></i>
            <span class="like-share-name"><?php esc_html_e( 'Share', 'roneous' ) ?></span>
        </a>
        <ul class="ssc-share-group">
            <li class="facebook-ssc-share" id="facebook-ssc"><a rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()) ?>&amp;t=<?php echo htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') ?>"><i class="ti-facebook"></i><span id="facebook-count">0</span></a></li>
            <li class="twitter-ssc-share" id="twitter-ssc"><a rel="nofollow" href="http://twitter.com/share?text=<?php echo htmlspecialchars(urlencode(html_entity_decode(the_title_attribute( array( 'echo' => 0, 'post' => $post->ID ) ), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') ?>&amp;url=<?php echo urlencode(get_permalink()) ?>"><i class="ti-twitter-alt"></i><span id="twitter-count">0</span></a></li>
            <li class="googleplus-ssc-share" id="googleplus-ssc"><a rel="nofollow" href="https://plus.google.com/share?url=<?php echo urlencode(get_permalink()) ?>"><i class="ti-google"></i><span id="googleplus-count">0</span></a></li>
            <li class="linkedin-ssc-share" id="linkedin-ssc"><a rel="nofollow" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(get_permalink()) ?>&amp;title=<?php echo htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') ?>&amp;source=<?php echo esc_url( home_url( '/' )) ?>"><i class="ti-linkedin"></i><span id="linkedin-count">0</span></a></li>
            <li class="pinterest-ssc-share" id="pinterest-ssc"><a rel="nofollow" href="http://pinterest.com/pin/create/bookmarklet/?url=<?php echo urlencode(get_permalink()) ?>&amp;media=<?php echo esc_url($url[0]); ?>&amp;description=<?php echo htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') ?>"><i class="ti-pinterest"></i><span id="pinterest-count">0</span></a></li>
        </ul>
    </div>
</div>