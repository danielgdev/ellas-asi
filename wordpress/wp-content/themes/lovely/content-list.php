<?php
if (have_posts()) {
    global $lovely_options;    
    $atts = $lovely_options;
    
    $atts['img_size'] = 'lovely_list_thumb';

    echo '<div class="list-blog">';
    while (have_posts()) { the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <?php
            $media = lovely_standard_media($post, $atts);
            if($media){
                echo '<div class="entry-post">';
            } else {
                echo '<div class="entry-post no-media">';
            }                           
            
                $atts['more_text'] = false;
                ob_start();
                    lovely_blogcontent($atts);
                $blogcontent = ob_get_clean();
                echo balanceTags($media);
                echo '<div class="entry-cats">'.lovely_cats().'</div>';
                echo '<h2 class="entry-title"><a href="'.esc_url(get_permalink()).'">'.get_the_title().'</a></h2>';                    

                if(!empty($blogcontent)){
                    echo '<div class="entry-content clearfix">';
                        echo balanceTags($blogcontent);
                        echo '<div class="entry-date tw-meta">'.get_the_time(get_option('date_format')).'</div>';
                    echo '</div>';
                }
            echo '</div>';
            ?>
        </article><?php
    }
    echo '</div>';
    lovely_pagination();
}   
