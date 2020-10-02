<?php
if (have_posts()) {
    global $lovely_options;    
    $atts = $lovely_options;    
    $atts['img_size'] = 'lovely_oppo_thumb';

    echo '<div class="oppo-blog">';
    $i = 0;
    while (have_posts()) { the_post(); $i++; 
        $lovely_options['post__not_in'][]=$post->ID;?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php 
            echo '<div class="entry-post clearfix">';            
            $media = lovely_standard_media($post, $atts);
            echo ($i % 2) != 0 ? balanceTags($media) : '';
            echo '<div class="entry-content">';
                echo '<div class="entry-cats">'.lovely_cats().'</div>';
                echo '<h2 class="entry-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h2>';  
                echo '<div class="entry-date tw-meta">'.get_the_time(get_option('date_format')).'</div>';
                ob_start();
                lovely_blogcontent($atts);
                $blogcontent = ob_get_clean();
                if(!empty($blogcontent)){
                        echo balanceTags($blogcontent);
                        if ((!(bool) preg_match('/<!--more(.*?)?-->/', $post->post_content) || !empty($atts['excerpt_count'])) && !empty($atts['more_text'])){
                            echo '<p class="more-link tw-hover tw-meta"><a href="'.esc_url(get_permalink()).'"><span>'.esc_html($atts['more_text']).'</span><i class="ion-ios-arrow-thin-right"></i></a></p>';
                        }
                }
                if($atts['layout'] == 'oppo-full'){
                    $post_image = lovely_image('full', true);
                    if(lovely_option('share_button')==='on'){
                        echo '<div class="entry-share">';
                            echo '<a class="facebook-share" href="' . esc_url(get_permalink()) . '" title="Share this"><i class="ion-social-facebook"></i><span>'.esc_html(lovely_facebook_count(get_permalink())).'</span></a>';
                            echo '<a class="pinterest-share" href="' . esc_url(get_permalink()) . '" title="Pin It" data-image="' . esc_attr($post_image['url']) . '"><i class="ion-social-pinterest"></i><span>'.esc_html(lovely_pinterest_count(get_permalink())).'</span></a>';
                            echo '<a class="twitter-share" href="' . esc_url(get_permalink()) . '" title="Tweet" data-title="' . esc_attr(get_the_title()) . '" data-id="'.esc_attr(get_the_id()).'" data-ajaxurl="'.esc_url(home_url('/')).'"><i class="ion-social-twitter"></i><span>'.esc_html(lovely_twitter_count(get_the_id())).'</span></a>';
                            if (comments_open()) {
                                $comment_count = get_comments_number('0', '1', '%');
                                echo "<a href='" . esc_url(get_comments_link()) . "' title='" . esc_attr__('comments', 'lovely') . "' class='comment-count'><i class='ion-chatbubbles'></i><span>" . esc_html($comment_count) . "</span></a>";
                            }
                        echo '</div>';
                    }
                }
            echo '</div>';
            echo ($i % 2) == 0 ? balanceTags($media) : '';
            echo '</div>';
            ?>
        </article><?php
    }
    echo '</div>';
    lovely_pagination();
}   
