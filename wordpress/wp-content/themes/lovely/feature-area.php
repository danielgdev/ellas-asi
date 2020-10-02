<?php
if (is_page()) {
    global $lovely_options;
    $feature = get_post_meta($post->ID, 'feature', true);
    $feat_cat = get_post_meta($post->ID, 'featured_cat', true);
    $cats = get_post_meta($post->ID, 'cats', true);
    $query['ignore_sticky_posts'] = 1;
    if(!empty($feat_cat)){
        $query['cat'] = $feat_cat;
    }elseif(!empty($cats)){
        $query['tax_query'] = Array(Array(
                'taxonomy' => 'category',
                'terms' => $cats,
                'field' => 'id'
            )
        );
    }
    if ($feature == "shortcode") {
        $start = '<div class="container">';
        $end = '</div>';
        $slider_shortcode = get_post_meta($post->ID, 'shortcode', true);
        if(lovely_option('header') == 'header-2'){
            $start = $end = '';
        } ?>
        <div class="feature-area">
            <?php echo ($start); ?>
                    <div class="feature-slider">
                        <?php  echo $slider_shortcode ? do_shortcode($slider_shortcode) : esc_html('Shortcode is Null'); ?>
                    </div>
            <?php echo ($end); ?>
        </div>
        <?php
    } elseif ($feature == "fancy") {
        $start1 = '<div class="post-content tw-middle">';
        $end1 = '</div>';
        $start = '<div class="container">';
        $end = '</div>';
        $img_size = 'lovely_slider_img';
        if(lovely_option('header') == 'header-2'){
            $start = $end = '';
            $start1 = '<div class="post-content"><div class="container tw-middle">';
            $end1 = '</div></div>';
            $img_size = 'full';
        }
        ?>
        <div class="feature-area">
            <?php echo ($start); ?>
                <div>
                    <div class="feature-posts">
                        <?php 
                        $fi = 1;
                        $query['showposts'] = '3';
                        $feat_query = new WP_Query( $query ); ?>
                        <?php if ($feat_query->have_posts()) : while ($feat_query->have_posts()) : $feat_query->the_post(); $lovely_options['post__not_in'][]=$post->ID;
                            $img = lovely_image($img_size, true); ?>
                            <div class="post-item<?php echo esc_attr($fi == 1 ? ' active' : ''); $fi = 0;?>">
                                <div class="feature-bg" style="background-image:url(<?php echo esc_url($img['url']);?>);"></div>
                                <?php echo ($start1);?>
                                    <div class="entry-content">
                                        <h2 class="entry-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                                        <p class="more-link tw-hover tw-meta"><a href="<?php echo esc_url(get_permalink());?>"><span><?php echo lovely_option("more_text", "Read more");?></span><i class="ion-ios-arrow-thin-right"></i></a></p>
                                    </div>
                                <?php echo ($end1);?>
                            </div>
                        <?php endwhile; endif; wp_reset_query();?>
                    </div>
                </div>
            <?php echo ($end); ?>
        </div>
        <?php
    } elseif ($feature == "post") {
        ?>
        <div class="feature-area">
            <div class="container">
                    <?php 
                    $query['showposts'] = '1';
                    $feat_query = new WP_Query( $query ); ?>
                    <?php if ($feat_query->have_posts()) : while ($feat_query->have_posts()) : $feat_query->the_post(); $lovely_options['post__not_in'][]=$post->ID;?>
                        <div class="feature-post">
                            <?php echo lovely_image('lovely_slider_img');?>   
                            <div class="entry-content">
                                <div class="entry-cats"><?php echo lovely_cats(); ?></div>
                                <h2 class="entry-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <div class="entry-date tw-meta"><span><?php the_time( get_option('date_format') ); ?></span> / <span class="entry-author"><?php esc_html_e('By', 'lovely').'&nbsp;'?>
                                <?php the_author_posts_link(); ?></span></div>
                                <?php $atts['more_text'] = lovely_option("more_text", "Read more"); echo lovely_blogcontent($atts); ?>
                            </div>
                            <?php 
                            $post_image = lovely_image('full', true);
                            echo '<div class="entry-share">';
                                if(lovely_option('share_button')==='on'){
                                    echo '<a class="facebook-share" href="' . esc_url(get_permalink()) . '" title="Share this"><i class="ion-social-facebook"></i><span>'.esc_html(lovely_facebook_count(get_permalink())).'</span></a>';
                                    echo '<a class="pinterest-share" href="' . esc_url(get_permalink()) . '" title="Pin It" data-image="' . esc_attr($post_image['url']) . '"><i class="ion-social-pinterest"></i><span>'.esc_html(lovely_pinterest_count(get_permalink())).'</span></a>';
                                    echo '<a class="twitter-share" href="' . esc_url(get_permalink()) . '" title="Tweet" data-title="' . esc_attr(get_the_title()) . '" data-id="'.esc_attr(get_the_id()).'" data-ajaxurl="'.esc_url(home_url('/')).'"><i class="ion-social-twitter"></i><span>'.esc_html(lovely_twitter_count(get_the_id())).'</span></a>';
                                }
                                echo lovely_comment_count();
                            echo '</div>';
                            ?>
                        </div>
                    <?php endwhile; endif; wp_reset_query();?>
            </div>
        </div>
        <?php
    } elseif ($feature == "slider") {
        $number = get_post_meta($post->ID, 'feature_per_page', true);
        $query['showposts'] = $number;
        wp_enqueue_script('lovely-owl-carousel');
        ?>
        <div class="feature-area">
            <div class="container">
                <div>
                    <div class="owl-carousel">
                    <?php $feat_query = new WP_Query( $query ); ?>
                    <?php if ($feat_query->have_posts()) : while ($feat_query->have_posts()) : $feat_query->the_post();
                        $lovely_options['post__not_in'][]=$post->ID;                    
                    ?>
                        <div class="feature-item tw-middle" style="background-image:url(<?php $image = lovely_image('lovely_slider_img', true); echo esc_url($image['url']); ?>);">
                                <div class="feature-content">
                                    <div class="entry-content">
                                            <div class="entry-cats"><?php echo lovely_cats(); ?></div>
                                            <h2 class="entry-title"><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                                            <div class="entry-date tw-meta"><span><?php the_time( get_option('date_format') ); ?></span> / <span class="entry-author"><?php esc_html_e('By', 'lovely').'&nbsp;'?>
                                            <?php the_author_posts_link(); ?></span></div>
                                            <div class="more-link tw-hover tw-meta"><a href="<?php echo esc_url(get_permalink());?>"><span><?php echo lovely_option("more_text", "Read more");?></span><i class="ion-ios-arrow-thin-right"></i></a></div>
                                    </div>
                                </div>
                        </div>
                    <?php endwhile; endif; wp_reset_query();?>
                    </div>  
                </div>
            </div>
        </div>
        <?php
    } elseif ($feature == "grid") { ?>
        <div class="feature-area">
            <div class="container">
            <div class="grid-posts">
                <?php $post1 = $post2 = $post3 = $post4 = $post5 = '';
                $query['showposts'] = '5';
                $feat_query = new WP_Query( $query ); ?>
                <?php if ($feat_query->have_posts()) : 
                        $i = 0;
                        while ($feat_query->have_posts()) : $feat_query->the_post(); $lovely_options['post__not_in'][]=$post->ID;
                        $i++;
                        $dynVar='post'.$i;
                        if($i===1){
                            $$dynVar = '<div class="feature-item">';
                                $$dynVar .= lovely_image('lovely_slider_grid');
                                $$dynVar .= '<div class="feature-content">';
                                    $$dynVar .= '<div class="entry-content">';
                                        $$dynVar .= '<div class="entry-cats">'.lovely_cats().'</div>';
                                        $$dynVar .= '<h2 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
                                        $$dynVar .= '<span class="entry-date tw-meta">'.get_the_time( get_option('date_format') ).'</span>';
                                    $$dynVar .= '</div>';
                                $$dynVar .= '</div>';
                            $$dynVar .= '</div>';
                        } else {
                            $$dynVar = '<div class="grid-item">';
                                $$dynVar .= '<div class="grid-thumb"><a href="'.get_permalink().'">';
                                    $$dynVar .= lovely_image('lovely_list_thumb');
                                $$dynVar .= '</a></div>';
                                $$dynVar .= '<div class="grid-content">';
                                    $$dynVar .= '<h2 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
                                    $$dynVar .= '<span class="entry-date tw-meta">'.get_the_time( get_option('date_format') ).'</span>';
                                $$dynVar .= '</div>';
                            $$dynVar .= '</div>';
                        }                        
                        ?>
                        
                <?php endwhile; endif; wp_reset_query();?>
                <div class="row">
                    <div class="col-md-3 clearfix">
                        <?php echo balanceTags($post2.$post4); ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo balanceTags($post1); ?>
                    </div>
                    <div class="col-md-3 clearfix">
                        <?php echo balanceTags($post3.$post5); ?>
                    </div>
                </div>
            </div>
            </div>
        </div>
    <?php
    }
    if(get_post_meta($post->ID, 'template', true) == 'blog'){
        $query['cat'] = '';
        $oppo = array('oppo', 'oppo-side', 'oppo-full');
        $readmore = get_post_meta($post->ID, 'more_text', true);
        $lovely_options['more_text'] = !empty($readmore) ? $readmore : lovely_option("more_text", "Read more");
        $lovely_options['excerpt_count'] = get_post_meta($post->ID, 'excerpt_count0', true);
        $lovely_options['layout'] = 'oppo-full';
        if(in_array(get_post_meta($post->ID, 'layout', true), $oppo)){
            $query['showposts'] = '2';
            if (!empty($lovely_options['post__not_in'])){
                $query['post__not_in'] = $lovely_options['post__not_in'];
            }
            query_posts($query); ?>
            <div class="oppo-full">
                <div class="container">
                    <?php get_template_part("content", "oppo"); ?>
                </div>
            </div>
            <?php 
            wp_reset_query();
            $popular = lovely_popular_posts();
            if($popular){
                echo '<div class="container">'.$popular.'</div>';
            }
        }
    }    
} elseif(is_category()){
    $title = single_cat_title("", false);
    $subtitle = esc_html__('Browsing category', 'lovely');
} elseif(is_search()){ 
    $title = get_search_query();
    $subtitle = esc_html__('Search results for', 'lovely');
} elseif (is_archive()) {
    if (is_day()) {
        $subtitle = esc_html__("Daily Archives", 'lovely');
        $title = get_the_date();
    } elseif (is_month()) {
        $subtitle = esc_html__("Monthly Archives", 'lovely');
        $title = get_the_date("F Y");
    } elseif (is_year()) {
        $subtitle = esc_html__("Yearly Archives", 'lovely');
        $title = get_the_date("Y");
    } elseif(is_author()){
        $userdata = get_userdata($author);
        $subtitle = esc_html__("Author Archives", 'lovely');
        $title = $userdata->display_name;
    } else {
        $title = esc_html__("Blog Archives", 'lovely');
        $subtitle = '';
    }
}

if(!empty($title)){ ?>
    <div class="feature-area">
        <div class="container">
            <div class="feature-title">
                <span class="tw-meta"><?php echo esc_html($subtitle);?></span>
                <h1><?php echo esc_html($title); ?></h1>
            </div>
        </div>
    </div>
<?php }