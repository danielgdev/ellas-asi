<?php
if (have_posts()) {
    global $lovely_options;    
    $atts = $lovely_options;
    
    $atts['img_size'] = 'lovely_grid_thumb';
    $width = 'col-md-6';
    $column = 2;
    if($lovely_options['layout'] == 'grid-full'){
        $width = 'col-md-4';
        $column = 3;
    }
    
    $i = 0;
    echo '<div class="grid-blog clearfix">';
    echo '<div class="row">';
    while (have_posts()) { the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class($width); ?>>
            <?php 
            $format = get_post_format();
            $media = lovely_entry_media($format, $atts);          

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
            ?>
        </article><?php
        $i++;
        if ($i % $column == 0) {
            echo '<div class="blog-divider"></div>';
        }
    }
    echo '</div>';
    echo '</div>';
    lovely_pagination();
}   
