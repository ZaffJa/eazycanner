<?php $languages = icl_get_languages( 'skip_missing=0&orderby=code' ); ?>
<?php if( !empty( $languages ) ) : ?>
    <div class="module widget-wrap language left">
        <ul class="menu">
            <li class="has-dropdown">
                <a href="#"><?php echo ICL_LANGUAGE_NAME; ?></a>
                <ul><?php foreach( $languages as $l ) echo '<li><a href="'.esc_url($l['url']).'">'.$l['native_name'].'</a></li>'; ?></ul>
            </li>
        </ul>
    </div>
<?php endif;