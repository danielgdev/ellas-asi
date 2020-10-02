<?php
function lovely_option($index, $default = '') {
      return ot_get_option($index, $default);
}
function lovely_favicon() {
    if(!function_exists('has_site_icon')||!has_site_icon()){
        $favicon = lovely_option('favicon');
        if(!empty($favicon)){
            echo '<link rel="shortcut icon" href="' . esc_url($favicon).'"/>';
        }
    }
}

// Print menu
//=======================================================
function lovely_menu() {
    wp_nav_menu(array(
        'container' => false,
        'menu_id' => '',
        'menu_class' => 'sf-menu',
        'fallback_cb' => 'lovely_nomenu',
        'theme_location' => 'main'
    ));
}
function lovely_top_menu(){
    wp_nav_menu(array(
        'container' => false,
        'menu_class' => 'sf-menu',
        'fallback_cb' => 'lovely_nomenu',
        'theme_location' => 'top'
    ));
}

function lovely_nomenu() {
    echo "<ul class='sf-menu'>";
        $howmany = 5;
        $pages=wp_list_pages(array('title_li'=>'','echo'=>0));
        preg_match_all('/(<li.*?>)(.*?)<\/li>/i', $pages, $matches);
        if(!empty($matches[0])){echo implode("\n", array_slice($matches[0],0,5));}
    echo "</ul>";
}
function lovely_mobilemenu($loc = 'main') {
    wp_nav_menu(array(
        'container' => false,
        'menu_id' => '',
        'menu_class' => 'sf-mobile-menu clearfix',
        'fallback_cb' => 'lovely_nomobile',
        'theme_location' => $loc)
    );
}

function lovely_nomobile() {
    echo "<ul class='clearfix'>";
    wp_list_pages(array('title_li' => ''));
    echo "</ul>";
}


// Print logo
//=======================================================
function lovely_logo() {
    $logo = lovely_option("logo");
    echo '<div class="tw-logo">';
        if ( !empty($logo) ) {
            echo '<a class="logo" href="' . esc_url(home_url('/')) . '">';
                echo '<img class="logo-img" src="' . esc_url($logo) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
            echo '</a>';
        } else {
            echo '<h1 class="site-name"><a class="logo" href="' . esc_url(home_url('/')) . '">';
                    bloginfo('name');
            echo '</a></h1>';
        }
    echo '</div>';
}

// ThemeWaves Pagination
//=======================================================
function lovely_pagination() { ?>
    <div class="tw-pagination tw-hover tw-meta clearfix">
        <div class="older"><?php next_posts_link('<span>'.esc_html__( 'Older Posts', 'lovely').'</span><i class="ion-ios-arrow-thin-right"></i>' ); ?></div>
        <div class="newer"><?php previous_posts_link('<span>'.esc_html__( 'Newer Posts', 'lovely').'</span><i class="ion-ios-arrow-thin-left"></i>'); ?></div>
    </div>
<?php }

function lovely_get_image_by_id($id,$url=false,$size='full'){
    $lrg_img=wp_get_attachment_image_src($id,$size);
    $output='';
    if(isset($lrg_img[0])){
        if($url){
            $output.=$lrg_img[0];
        }else{
            $output.='<img src="'.esc_url($lrg_img[0]).'" />';
        }
    }
    return $output;
}

if (!function_exists('lovely_image')) {
    function lovely_image($size = 'full', $returnURL = false) {
        global $post;
        $attachment = get_post(get_post_thumbnail_id($post->ID));
        if(!empty($attachment)){
            if ($returnURL) {
                $lrg_img = wp_get_attachment_image_src($attachment->ID, $size);
                $url = $lrg_img[0];
                $alt0 = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
                $alt = empty($alt0)?$attachment->post_title:$alt0;
                $img['url'] = $url;
                $img['alt'] = $alt;
                return $img;
            } else {
                return get_the_post_thumbnail($post->ID,$size);
            }
        }
    }
}

if (!function_exists('lovely_author')) {
    function lovely_author(){ ?>
        <div class="tw-author">
            <div class="author-box">
                <?php
                $tw_author_email = get_the_author_meta('email');
                echo get_avatar($tw_author_email, $size = '120');
                ?>
                <h3><?php
                    if (is_author()){
                        the_author();
                    }else{
                        the_author_posts_link();
                    } ?>
                </h3>
                <?php
                echo '<span class="tw-meta">'.esc_html__('writer', 'lovely').'</span>';
                echo '<p>';
                    $description = get_the_author_meta('description');
                    if ($description != '')
                        echo esc_html($description);
                    else
                        esc_html_e('The author didnt add any Information to his profile yet', 'lovely');
                echo '</p>';
                $socials = get_the_author_meta('user_social');
                if(!empty($socials)){
                    echo '<div class="entry-share">';
                    $social_links=explode("\n",$socials);
                    foreach($social_links as $social_link){
                        $icon = lovely_social_icon(esc_url($social_link));
                        echo '<a href="'.esc_url($social_link).'"><i class="'.esc_attr($icon).'"></i></a>';
                    }
                    echo '</div>';
                } ?>
            </div>
        </div><?php
    }
}

if (!function_exists('lovely_comment_form')) {
    function lovely_comment_form($fields) {
        global $id, $post_id;
        if (null === $post_id)
            $post_id = $id;
        else
            $id = $post_id;

        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ( $req ? " aria-required='true'" : '' );

        $fields = array(
            'author' => '<p class="comment-form-author">' .
            '<input id="author" name="author" placeholder="' . esc_html__('Name *', 'lovely') . '" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' />' . '</p>',
            'email' => '<p class="comment-form-email">' .
            '<input id="email" name="email" placeholder="' . esc_html__('Email *', 'lovely') . '" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' />' . '</p>',
            'url' => '<p class="comment-form-url">' .
            '<input id="url" name="url" placeholder="' . esc_html__('Website', 'lovely') . '" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" />' . '</p><div class="clearfix"></div>',
        );
        return $fields;
    }
    add_filter('comment_form_default_fields', 'lovely_comment_form');
}

if (!function_exists('lovely_comment')) {
    function lovely_comment($comment, $args, $depth){
        $GLOBALS['comment'] = $comment;?>
        <div <?php comment_class();?> id="comment-<?php comment_ID(); ?>">
            <div class="comment-author">
                <?php echo get_avatar($comment, $size = '60'); ?>
            </div>
            <div class="comment-text">
                <h3 class="author"><?php echo get_comment_author_link(); ?></h3>
                <span class="entry-date tw-meta"><?php echo get_comment_date('F j, Y'); ?></span>
                <?php comment_text() ?>
                <p class="reply tw-meta"><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
            </div><?php
    }
}

if (!function_exists('lovely_comment_count')) {
    function lovely_comment_count() {
        if (comments_open()) {
            $comment_count = get_comments_number('0', '1', '%');
            if ($comment_count == 0) {
                $comment_trans = esc_html__('no comment', 'lovely');
            } elseif ($comment_count == 1) {
                $comment_trans = esc_html__('1 comment', 'lovely');
            } else {
                $comment_trans = $comment_count . ' ' . esc_html__('comments', 'lovely');
            }
            return "<a href='" . esc_url(get_comments_link()) . "' title='" . esc_attr($comment_trans) . "' class='comment-count'><i class='ion-chatbubbles'></i><span>" . esc_html($comment_trans) . "</span></a>";
        }
    }
}
if(!function_exists('lovely_facebook_count')){
    function lovely_facebook_count($url){
        $contents=false;
        try {
            $contents = wp_remote_get('http://graph.facebook.com/?id='.$url);
        } catch(Exception $e) {
            return 0;
        }
        if(is_array($contents)&&isset($contents['body'])) {
                $json = json_decode($contents['body']);
                return isset($json->share->share_count) ? $json->share->share_count : 0;
        } else {
                return 0;
        }
    }
}
if(!function_exists('lovely_pinterest_count')){
    function lovely_pinterest_count($url){
        $contents=false;
        try {
            $contents = wp_remote_get('http://widgets.pinterest.com/v1/urls/count.json?source=6&url='.$url);
        } catch(Exception $e) {
            return 0;
        }
        if(is_array($contents)&&isset($contents['body'])) {
                $contents['body']=str_replace(array('receiveCount(',')'),'',$contents['body']);
                $json = json_decode($contents['body']);
                return isset($json->count) ? $json->count : 0;
        } else {
                return 0;
        }
    }
}
if(!function_exists('lovely_twitter_count')){
    function lovely_twitter_count($pid){    
        $tweet = get_post_meta($pid,'post_tweet',true);
        return empty($tweet)?'0':$tweet;
    }
}
if (isset($_REQUEST['tweet_pid'])) {
    $pid = intval($_REQUEST['tweet_pid']);
    update_post_meta($pid, 'post_tweet', lovely_twitter_count($pid)+1);
    die;
}
function lovely_cats($sep = ', '){
    $cats = '';
    foreach((get_the_category()) as $category) {
        $options = get_option("taxonomy_".$category->cat_ID);
        if (!isset($options['featured']) || !$options['featured']) {
            $cats .= '<a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( 'View all posts in %s', 'lovely' ), $category->name ) . '" ' . '>'  . $category->name.'</a><span>'.$sep.'</span>';
        }
    }
    return $cats;
}

if (!function_exists('lovely_post_share')) {
    function lovely_post_share() {
        $output = '<div class="tw_post_sharebox clearfix">';
            $output .= '<span class="share-text">'.esc_html__('Share this Post', 'lovely').'</span>';
            $post_title = get_the_title();
            $output .= '<div class="sharebox-icons">';
                $output .= '<div class="googleplus-share"><a href="' . esc_url(get_permalink()) . '" title="Share this"><i class="ion-social-googleplus"></i></a></div>';
                $output .= '<div class="twitter-share"><a href="' . esc_url(get_permalink()) . '" title="Tweet" data-title="' . esc_attr($post_title) . '"><i class="ion-social-twitter"></i></a></div>';
                $output .= '<div class="facebook-share"><a href="' . esc_url(get_permalink()) . '" title="Share this"><i class="ion-social-facebook"></i></a></div>';
            $output .= '</div>';
        $output .= '</div>';
        echo balanceTags($output);
    }
}

function lovely_social_link($social){
    if(!empty($social['href']) && !empty($social['name'])){
        $icon = lovely_social_icon(esc_url($social['href']));
        return '<a title="'.esc_attr($social['name']).'" href="'.esc_url($social['href']).'"><i class="'.esc_attr($icon).'"></i></a>';
    }    
}

function lovely_social_name($url){
    if(strpos($url,'twitter.com')) { return 'twitter';}
    if(strpos($url,'linkedin.com')){ return 'linkedin';}
    if(strpos($url,'facebook.com')){ return 'facebook';}
    if(strpos($url,'delicious.com')){ return 'delicious';}
    if(strpos($url,'codepen.io')){ return 'codepen';}
    if(strpos($url,'github.com')){ return 'github';}
    if(strpos($url,'wordpress.org')||strpos($url,'wordpress.com')){ return 'wordpress';}
    if(strpos($url,'youtube.com')){ return 'youtube';}
    if(strpos($url,'behance.net')){ return 'behance';}
    if(strpos($url,'pinterest.com')){ return 'pinterest';}
    if(strpos($url,'foursquare.com')){ return 'foursquare';}
    if(strpos($url,'soundcloud.com')){ return 'soundcloud';}
    if(strpos($url,'dribbble.com')){ return 'dribbble';}
    if(strpos($url,'instagram.com')){ return 'instagram';}
    if(strpos($url,'plus.google')){ return 'googleplus';}
    if(strpos($url,'vine.co')){ return 'vine';}
    if(strpos($url,'twitch.tv')){ return 'twitch';}
    if(strpos($url,'tumblr.com')){ return 'tumblr';}
    if(strpos($url,'trello.com')){ return 'trello';}
    if(strpos($url,'spotify.com')){ return 'spotify';}
    
    return 'link';
}
function lovely_social_icon($url){
    if(strpos($url,'twitter.com')) { return 'ion-social-twitter';}
    if(strpos($url,'linkedin.com')){ return 'ion-social-linkedin';}
    if(strpos($url,'facebook.com')){ return 'ion-social-facebook';}
//    if(strpos($url,'delicious.com')){ return 'fa-delicious';}
    if(strpos($url,'codepen.io')){ return 'ion-social-codepen';}
    if(strpos($url,'github.com')){ return 'ion-social-github';}
    if(strpos($url,'wordpress.org')||strpos($url,'wordpress.com')){ return 'ion-social-wordpress';}
    if(strpos($url,'youtube.com')){ return 'ion-social-youtube';}
//    if(strpos($url,'behance.net')){ return 'fa-behance';}
    if(strpos($url,'pinterest.com')){ return 'ion-social-pinterest';}
    if(strpos($url,'foursquare.com')){ return 'ion-social-foursquare';}
//    if(strpos($url,'soundcloud.com')){ return 'fa-soundcloud';}
    if(strpos($url,'dribbble.com')){ return 'ion-social-dribbble';}
    if(strpos($url,'instagram.com')){ return 'ion-social-instagram';}
    if(strpos($url,'plus.google')){ return 'ion-social-googleplus';}
//    if(strpos($url,'vine.co')){ return 'fa-vine';}
    if(strpos($url,'twitch.tv')){ return 'ion-social-twitch';}
    if(strpos($url,'tumblr.com')){ return 'ion-social-tumblr';}
    if(strpos($url,'apple.com')){ return 'ion-social-apple';}
    if(strpos($url,'google.com')){ return 'ion-social-android';}
    if(strpos($url,'microsoft.com')){ return 'ion-social-windows';}
//    if(strpos($url,'spotify.com')){ return 'fa-spotify';}
    
    return 'ion-link';
}
function lovely_social_name_from_url($social_link,$option){
    return trim(str_replace(array_merge(array('https:','http:','www.','/'),$option), '',$social_link));
}
function lovely_social_button($social_link,$settings){
    ob_start();
        $permalink=get_the_permalink();
        $social_name=lovely_social_name($social_link);
        if(empty($settings['speed'])){
            switch($social_name){
                case'facebook':{ ?>
                    <div id="fb-root"></div>
                    <script>
                        (function(d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s); js.id = id;
                            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                    </script>
                    <div class="fb-like" data-href="<?php echo esc_url($social_link); ?>" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div><?php
                    break;
                }
                case'twitter':{
                    $twt_via=lovely_social_name_from_url($social_link,array('twitter.com')); ?>
                    <a href="https://twitter.com/<?php echo esc_attr($twt_via); ?>" class="twitter-follow-button" data-show-count="false"><?php esc_attr_e('Follow ','lovely'); echo esc_attr('@'.$twt_via); ?></a>
                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script><?php
                    break;
                }
                case'instagram':{
                    $insta_name=lovely_social_name_from_url($social_link,array('instagram.com'));
                    if(isset($settings['instagram_follow_id'])&&!empty($settings['instagram_follow_id'])){ ?>
                        <span class="ig-follow" data-id="<?php echo esc_attr($settings['instagram_follow_id']); ?>" data-handle="<?php echo esc_attr($insta_name); ?>" data-count="true" data-size="small" data-username="true"></span>
                        <script>(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.src="//x.instagramfollowbutton.com/follow.js";s.parentNode.insertBefore(g,s);}(document,"script"));</script><?php
                    }else{
                        esc_html_e("Set Instagramm Follow ID !!!",'lovely');
                    }
                    break;
                }
                case'pinterest':{ ?>
                    <a data-pin-do="buttonFollow" href="<?php echo esc_url($social_link); ?>"><?php echo esc_html__('Follow','lovely'); ?></a>
                    <script async defer src="//assets.pinterest.com/js/pinit.js"></script><?php
                    break;
                }
                case'googleplus':{ ?>
                    <script src="https://apis.google.com/js/platform.js" async defer></script>
                    <div class="g-follow" data-annotation="bubble" data-height="20" data-href="<?php echo esc_url($social_link); ?>" data-rel="author"></div><?php
                    break;
                }
                case'youtube':{
                    $ydata=' data-channelid="'.lovely_social_name_from_url($social_link,array('youtube.com','channel')).'"';
                    if(strpos($social_link,'/user/')){
                        $ydata=' data-channel="'.lovely_social_name_from_url($social_link,array('youtube.com','user')).'"';
                    }
                    $ybtn='<div class="g-ytsubscribe"'.$ydata.' data-layout="default" data-count="default"></div>'; ?>
                    <script src="https://apis.google.com/js/platform.js"></script><?php
                    echo wp_kses($ybtn,array('div' => array('class' => array(),'data-channelid' => array(),'data-channel' => array(),'data-layout' => array(),'data-count' => array())));
                    break;
                }
                default :{
                    echo '<a href="'.esc_url($social_link).'">'.esc_html($social_name).'</a>';
                }
            }
        }else{
            $imgSrc='';
            switch($social_name){
                case'facebook'  :{$imgSrc='tab-facebook.png';break;}
                case'twitter'   :{$imgSrc='tab-twitter.png';break;}
                case'instagram' :{$imgSrc='tab-instagram.png';break;}
                case'pinterest' :{$imgSrc='tab-pinterest.png';break;}
                case'googleplus':{$imgSrc='tab-google.png';break;}
                case'youtube'   :{$imgSrc='tab-youtube.png';break;}
                default         :{$imgSrc='tab-link.png';break;}
            }
            echo '<a href="'.esc_url($social_link).'" target="_blank"><img src="'.esc_url(THEME_DIR.'/assets/img/'.$imgSrc).'" /></a>';
        }
    return ob_get_clean();
}
function lovely_social_icons(){
    $socials = lovely_option("socials");
    if(!empty($socials)){
        $output = '<div class="social-icons">';
        foreach($socials as $social){ $output .= lovely_social_link($social); }
        $output .= '</div>';
        return $output;
    }
}

function lovely_footer_socials($sub = false){
    $socials = lovely_option("socials");
    if(!empty($socials)){
        $output = '<div class="entry-share clearfix">';
        if($sub){
            foreach($socials as $social){ 
                if(!empty($social['href']) && !empty($social['name'])){
                    $icon = lovely_social_icon(esc_url($social['href']));
                    $text = !empty($social['subtext'])  ? ('</span><span>'.esc_attr($social['subtext'])) : '';
                    $output .= '<div class="social-item"><a class="tw-meta" href="'.esc_url($social['href']).'"><i class="'.esc_attr($icon).'"></i><span>'.esc_attr($social['name']).$text.'</span></a></div>';
                }     
            }
        } else {
            foreach($socials as $social){ 
                if(!empty($social['href']) && !empty($social['name'])){
                    $icon = lovely_social_icon(esc_url($social['href']));
                    $output .= '<div class="social-item"><a class="tw-meta '.str_replace('ion-', '', esc_attr($icon)).'" href="'.esc_url($social['href']).'"><i class="'.esc_attr($icon).'"></i><span>'.esc_attr($social['name']).'</span></a></div>';
                }     
            }
        }
        
        $output .= '</div>';
        return $output;
    }
}

function lovely_popular_posts() {
    global $post;
    $popular = get_post_meta($post->ID, 'popular_posts', true);
    if ($popular == '3' || $popular == '4' ||$popular == 'video' ) {
        $q['posts_per_page'] = 3;
        $q['ignore_sticky_posts'] = 1;
        
        $class = '';
        if($popular == 'video'){
            $q['tax_query'] = array( array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => array('post-format-video'),
                'operator' => 'IN'
            ) );
            $q['posts_per_page'] = 4;
            $width = 'col-md-3';
            $icon = $title = '';
            $class = ' latest-video-posts';
            $play = '<a href="%permalink%"><i class="ion-play"></i></a>';
        } else {
            $play = ''; 
            $q['orderby'] = 'meta_value_num';
            $q['meta_key'] = 'post_seen';
            $width = 'col-md-4';
            $icon = '<a href="%permalink%"><i class="ion-android-add"></i></a>';
            $title = '<h3 class="widget-title">'.esc_html__('Popular posts', 'lovely').'</h3>';
        }
        $output = '<div class="tw-popular-posts'.$class.'">'.$title;                
        $output .= '<div class="row">';        
        if ($popular == '4'){
            $q['posts_per_page'] = 4;
            $width = 'col-md-3';
            $icon = '';
        }
        query_posts($q);
        while (have_posts()){
            the_post();
            $output .= '<div class="popular-item ' . $width . '">';
            if (has_post_thumbnail($post->ID)) {
                $thumb = $popular == '4' ? ('<a href="' . get_permalink() . '">' . lovely_image('lovely_grid_thumb') . '</a>') : ($popular == 'video' ? lovely_image('lovely_video_post') : lovely_image('lovely_grid_thumb'));   
                $output .= '<div class="popular-thumb">' . $thumb;
            } else {
                $output .= '<div class="popular-thumb no-thumb">';
            }
            $output .= '<div class="popular-content tw-middle">';
            $output .= '<div class="entry-content">';
            $output .= '<h2 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
            $output .= '<span class="entry-date tw-meta">' . get_the_time(get_option('date_format')) . '</span>'.str_replace('%permalink%',get_permalink(),$icon);
            $output .= '</div>';
            $output .= '</div>'.str_replace('%permalink%',get_permalink(),$play);
            $output .= '</div>';
            $output .= '</div>';
        }
        $output .= '</div></div>';
        wp_reset_query();
        return $output;
    }
}
function lovely_related_posts() {
    global $post;
    
    $categories = get_the_category($post->ID);
    
    if ($categories) {
        $category_ids = array();

	foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
	
	$args = array(
		'category__in'     => $category_ids,
		'post__not_in'     => array($post->ID),
		'posts_per_page'   => 3, // Number of related posts that will be shown.
		'ignore_sticky_posts' => 1,
		'orderby' => 'rand'
	);
        $atts['img_size'] = 'recent_post';
        $my_query = new wp_query( $args );
	if( $my_query->have_posts() ) { ?>
            <div class="related-posts">
                <h4 class="np-title-line"><?php esc_html_e('Related posts', 'lovely'); ?></h4>
                <div class="row">
		<?php while( $my_query->have_posts() ) {
			$my_query->the_post();?>
                        <div class="col-md-4">
                            <div class="related-item">
                                <h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                                <span class="entry-date"><?php the_time( get_option('date_format') ); ?></span>
                                <?php 
                                    if(!($thumb = lovely_standard_media($post, $atts))){
                                        $pformat = get_post_format() == "" ? "standard" : get_post_format();
                                        $thumb = '<div class="entry-media"><div class="format-icon '.esc_attr($pformat).'"></div></div>';
                                    }
                                    echo balanceTags($thumb);
                                ?>
                            </div>
                        </div>
		<?php
		}
		echo '</div>';
            echo '</div>';
	}
        wp_reset_query();
    }
}

function lovely_seen_add(){
    global $post;
    $seen = get_post_meta($post->ID,'post_seen',true);
    $seen = intval($seen)+1;
    update_post_meta($post->ID,'post_seen',$seen);
}
function lovely_seen_count(){
    global $post;
    $seen = get_post_meta($post->ID,'post_seen',true);
    return (empty($seen)?0:$seen);    
}

// Hex To RGB
function lovely_hex2rgb($hex) {
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    $rgb = array($r, $g, $b);
    return implode(",", $rgb); // returns the rgb values separated by commas
}