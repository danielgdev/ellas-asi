<?php
if (have_posts()) {
    global $lovely_options;
    $atts = $lovely_options;   
    
    $atts['img_size'] = 'lovely_blog_thumb';
    if($lovely_options['layout'] == 'simple-full'){
        $atts['img_size'] = 'lovely_slider_img';
    }
    
    while (have_posts()) { the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php 
            $format = get_post_format();
            $media = lovely_entry_media($format, $atts);
            
            echo '<div class="entry-post">';                
               
                    ob_start();
                        lovely_blogcontent($atts);
                    $blogcontent = ob_get_clean();
                    echo '<div class="entry-cats">'.lovely_cats().'</div>';
                    echo '<h2 class="entry-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h2>';
                    echo '<div class="entry-date tw-meta"><span>'.get_the_time(get_option('date_format')).'</span> / <span class="entry-author">'.esc_html__('By', 'lovely').'&nbsp;';
                    the_author_posts_link();  
                    echo '</span></div>';
                    echo balanceTags($media);
                    if(!empty($blogcontent)){
                        echo '<div class="entry-content clearfix">';
                            echo balanceTags($blogcontent);
                            if ((!(bool) preg_match('/<!--more(.*?)?-->/', $post->post_content) || !empty($atts['excerpt_count'])) && !empty($atts['more_text'])){
                                echo '<p class="more-link tw-hover tw-meta"><a href="'.esc_url(get_permalink()).'"><span>'.esc_html($atts['more_text']).'</span><i class="ion-ios-arrow-thin-right"></i></a></p>';
                            }
                        echo '</div>';
                    }
                    $post_image = lovely_image('full', true);
                    if(lovely_option('share_button')==='on'){
                        echo '<div class="entry-share">';
                            echo '<a class="facebook-share" href="' . esc_url(get_permalink()) . '" title="Share this"><i class="ion-social-facebook"></i><span>'.esc_html(lovely_facebook_count(get_permalink())).'</span></a>';
                            echo '<a class="pinterest-share" href="' . esc_url(get_permalink()) . '" title="Pin It" data-image="' . esc_attr($post_image['url']) . '"><i class="ion-social-pinterest"></i><span>'.esc_html(lovely_pinterest_count(get_permalink())).'</span></a>';
                            echo '<a class="twitter-share" href="' . esc_url(get_permalink()) . '" title="Tweet" data-title="' . esc_attr(get_the_title()) . '" data-id="'.esc_attr(get_the_id()).'" data-ajaxurl="'.esc_url(home_url('/')).'"><i class="ion-social-twitter"></i><span>'.esc_html(lovely_twitter_count(get_the_id())).'</span></a>';
                            echo lovely_comment_count();
                        echo '</div>';
                    }
                    
            echo '</div>';
            ?>
        </article><?php
    }
    lovely_pagination();
}   