<?php
get_header();
$template = get_post_meta($post->ID, 'template', true);
if ($template == 'blog') {
    global $lovely_options;
    $layout = get_post_meta($post->ID, 'layout', true);
    $readmore = get_post_meta($post->ID, 'more_text', true);
    $excerpt = get_post_meta($post->ID, 'excerpt_count', true);

    $lovely_options['layout'] = !empty($layout) ? $layout : lovely_option("layout", "simple-side");
    $lovely_options['more_text'] = !empty($readmore) ? $readmore : lovely_option("more_text", "Read more");
    $lovely_options['excerpt_count'] = $excerpt;

    $full = array('simple', 'grid', 'list', 'oppo', 'simple-full', 'grid-full', 'list-full', 'oppo-full');
    $grid = array('grid', 'grid-side', 'grid-full');
    $oppo = array('oppo', 'oppo-side', 'oppo-full');
    $list = array('list', 'list-side', 'list-full');

    $width = ' col-md-8';
    if (in_array($lovely_options['layout'], $full)) {
        if (in_array($lovely_options['layout'], array('simple-full', 'grid-full', 'list-full', 'oppo-full'))) {
            $width = ' col-md-12';
        }
    }

    $query = Array(
        'post_type' => 'post',
    );

    if (!empty($lovely_options['post__not_in'])) {
        $query['post__not_in'] = $lovely_options['post__not_in'];
        unset($lovely_options['post__not_in']);
    }

    $posts_per_page = get_post_meta($post->ID, 'posts_per_page', true);
    if (!empty($posts_per_page)) {
        $query['posts_per_page'] = $posts_per_page;
    }

    $cats = get_post_meta($post->ID, 'cats', true);
    if (!empty($cats)) {
        $query['tax_query'] = Array(Array(
                'taxonomy' => 'category',
                'terms' => $cats,
                'field' => 'id'
            )
        );
    }

    $paged = get_query_var( 'page');
    if(!$paged){
        $paged = get_query_var( 'paged');
    }
    $query['paged'] = $paged; ?>

    <div class="row"> 
        <div class="content-area <?php echo esc_attr($lovely_options['layout'] . $width); ?>">
            <?php
            query_posts($query);
            if (in_array($lovely_options['layout'], $grid)) {
                get_template_part("content", "grid");
            } elseif (in_array($lovely_options['layout'], $list)) {
                get_template_part("content", "list");
            } elseif (in_array($lovely_options['layout'], $oppo)) {
                get_template_part("content", "oppo");
            } else {
                get_template_part("content");
            }
            wp_reset_query();
            ?>
        </div>
        <?php
        if (!in_array($lovely_options['layout'], $full)) {
            get_sidebar();
        }
        ?>
    </div>
    <?php
    if(!in_array($lovely_options['layout'], $oppo)){
        echo lovely_popular_posts();
    }
} else {
    $img_size = 'lovely_blog_thumb';
    $width = 'col-md-8 default-page';
    if ($template == 'full-width') {
        $img_size = 'lovely_slider_img';
        $width = 'col-md-12';
    } elseif ($template == 'with-sidebar') {
        $width = 'col-md-8';
    }
    the_post(); ?>
    <div class="row">
        <div class="content-area <?php echo esc_attr($width); ?>">
            <article <?php post_class(); ?>>
                <?php
                echo '<h2 class="page-title">' . get_the_title() . '</h2>';
                if (has_post_thumbnail($post->ID)) {
                    echo '<div class="entry-media">';
                    echo lovely_image($img_size);
                    echo '</div>';
                }
                ?>                    
                <div class="page-content">
                    <?php the_content(); ?>
                    <?php wp_link_pages(); ?>
                    <div class="clearfix"></div>
                </div>
            </article>
            <?php comments_template('', true); ?>
        </div>
        <?php 
            if($template == 'with-sidebar'){
                get_sidebar();
            }
        ?>
    </div>
<?php 
}
get_footer();