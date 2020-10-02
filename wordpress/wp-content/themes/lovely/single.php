<?php get_header(); ?>
<?php the_post();
lovely_seen_add();

$layout = get_post_meta($post->ID, 'single_layout', true);
if(empty($layout)){
    $layout = lovely_option('single_layout', 'with-sidebar');
}

$atts['img_size'] = 'lovely_blog_thumb';
$width = ' col-md-8';
if($layout == 'full-width'){
    $atts['img_size'] = 'lovely_slider_img';
    $width = ' col-md-12';
}
$format = get_post_format() == "" ? "standard" : get_post_format();
$media = lovely_entry_media($format, $atts);
?>
<div class="row"> 
    <div class="content-area <?php echo esc_attr($layout.$width);?>">
        <article <?php post_class('single'); ?>>
            <?php 
                echo '<div class="entry-cats">'.lovely_cats().'</div>';
                echo '<h1 class="entry-title">'.get_the_title().'</h1>';
                echo '<div class="entry-date tw-meta">'.get_the_time(get_option('date_format')).' / <span class="entry-author">'.esc_html__('By', 'lovely').'&nbsp;';
                the_author_posts_link();  
                echo '</span></div>';
                echo balanceTags($media);
            ?>                    
            <div class="entry-content">
                <?php the_content(); ?>
                <?php wp_link_pages(); ?>
                <div class="clearfix"></div>
            </div>
            <?php 
                echo get_the_tag_list(('<div class="entry-tags tw-meta"><h5>'.esc_html__('Tags', 'lovely').':</h5>'), '', '</div>');
                $post_image = lovely_image('full', true);
                echo '<div class="entry-share clearfix">';
                    if(lovely_option('share_button')==='on'){
                        echo '<a class="facebook-share" href="' . esc_url(get_permalink()) . '" title="Share this"><i class="ion-social-facebook"></i><span>'.esc_html(lovely_facebook_count(get_permalink())).'</span></a>';
                        echo '<a class="pinterest-share" href="' . esc_url(get_permalink()) . '" title="Pin It" data-image="' . esc_attr($post_image['url']) . '"><i class="ion-social-pinterest"></i><span>'.esc_html(lovely_pinterest_count(get_permalink())).'</span></a>';
                        echo '<a class="twitter-share" href="' . esc_url(get_permalink()) . '" title="Tweet" data-title="' . esc_attr(get_the_title()) . '" data-id="'.esc_attr(get_the_id()).'" data-ajaxurl="'.esc_url(home_url('/')).'"><i class="ion-social-twitter"></i><span>'.esc_html(lovely_twitter_count(get_the_id())).'</span></a>';
                    }
                    echo lovely_comment_count();
                echo '</div>';
            ?>
        </article>
        <?php 
            $prev = get_adjacent_post(false,'',true) ;
            $next = get_adjacent_post(false,'',false) ;
        ?>
        <div class="nextprev-postlink">
            <div class="row">
                <div class="col-md-6">
                <?php if ( isset($prev->ID) ):
                $pid = $prev->ID;
                $img = wp_get_attachment_image_src( get_post_thumbnail_id($pid), 'thumbnail' );
                if($img['0']){
                    $thumb = '<div class="post-thumb"><div style="background-image: url('.esc_url($img['0']).')"></div></div>';
                }else{
                    $pformat = get_post_format( $pid ) == "" ? "standard" : get_post_format( $pid );
                    $thumb = '<div class="post-thumb format-icon '.esc_attr($pformat).'"></div>';
                } ?>
                    <div class="prev-post-link">
                        <a href="<?php echo esc_url(get_permalink( $pid )); ?>" title="<?php echo get_the_title( $pid );?>"><?php echo ($thumb .'<h4>'.get_the_title( $pid ).'</h4><span class="tw-meta"><i class="ion-ios-arrow-thin-left"></i>'.esc_html__('Previous Article', 'lovely').'</span>'); ?></a>
                    </div>
                <?php endif;
                if ( isset($next->ID) ):
                    $pid = $next->ID;
                    $img = wp_get_attachment_image_src( get_post_thumbnail_id($pid), 'thumbnail' );
                    if($img['0']){
                        $thumb = '<div class="post-thumb"><div style="background-image: url('.esc_url($img['0']).')"></div></div>';
                    }else{
                        $pformat = get_post_format( $pid ) == "" ? "standard" : get_post_format( $pid );
                        $thumb = '<div class="post-thumb format-icon '.esc_attr($pformat).'"></div>';
                    } ?>
                    </div>
                    <div class="col-md-6">
                        <div class="next-post-link">
                            <a href="<?php echo esc_url(get_permalink( $pid )); ?>"><?php echo ($thumb .'<h4>'.get_the_title( $pid ).'</h4><span class="tw-meta">'.esc_html__('Next Article', 'lovely').'<i class="ion-ios-arrow-thin-right"></i></span>'); ?></a>
                        </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
        <?php lovely_author(); ?>
        <?php comments_template('', true); ?>
    </div>
    <?php if($layout == 'with-sidebar'){ get_sidebar(); }?>
</div>
<?php get_footer();