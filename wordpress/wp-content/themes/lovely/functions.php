<?php
$theme_obj = wp_get_theme();
$theme_name = $theme_obj->get('Name');
$theme_version = $theme_obj->get('Version');

define('LOVELY_THEMENAME', $theme_name);
define('LOVELY_THEMEVERSION', $theme_version);
define('THEME_PATH', get_template_directory());
define('THEME_DIR', get_template_directory_uri());
define('STYLESHEET_PATH', get_stylesheet_directory());
define('STYLESHEET_DIR', get_stylesheet_directory_uri());

/**
 * Activates Theme Mode
 */
add_filter('ot_theme_mode', '__return_true');
add_filter( 'ot_show_pages', '__return_false' );
/**
 * Loads OptionTree
 */
require( trailingslashit(get_template_directory()) . 'option-tree/ot-loader.php' );
/**
 * Loads Theme Options
 */
if (is_admin()) {
    require( trailingslashit(get_template_directory()) . 'framework/waves_options/theme-options.php' );
    require( trailingslashit(get_template_directory()) . 'framework/waves_options/category-options.php' );
    require( trailingslashit(get_template_directory()) . 'framework/waves_options/post-options.php' );
    require( trailingslashit(get_template_directory()) . 'framework/waves_options/page-options.php' );
    require( trailingslashit(get_template_directory()) . 'framework/waves_options/user-options.php' );
    require_once (THEME_PATH . "/framework/waves_plugins/tgm-plugins.php");
    add_action('admin_print_scripts', 'lovely_admin_scripts');
    add_action('admin_print_styles', 'lovely_admin_styles');

    function lovely_admin_scripts() {
        wp_register_script('lovely-admin-js', THEME_DIR . '/framework/js/waves-admin.js');
        wp_enqueue_script('lovely-admin-js');
    }

    function lovely_admin_styles() {
        wp_register_style('lovely-admin-css', THEME_DIR . '/framework/css/waves-admin.css', false, '1.00', 'screen');
        wp_enqueue_style('lovely-admin-css');
    }

}

require_once (THEME_PATH . "/framework/theme_functions.php");
require_once (THEME_PATH . "/framework/blog_functions.php");
require_once (THEME_PATH . "/framework/waves_widget/widget_text.php");
require_once (THEME_PATH . "/framework/waves_widget/widget_post.php");
require_once (THEME_PATH . "/framework/waves_widget/widget_instagram.php");
require_once (THEME_PATH . "/framework/waves_widget/widget_social_tabs.php");
require_once (THEME_PATH . "/framework/theme_css.php");



/* ================================================================================== */
/*      Theme Supports
  /* ================================================================================== */

add_action('after_setup_theme', 'lovely_setup');
if (!function_exists('lovely_setup')) {

    function lovely_setup() {
        add_editor_style();
        add_theme_support('post-thumbnails');
        add_theme_support('post-formats', array('gallery', 'video', 'audio'));
        add_theme_support('title-tag');
        add_theme_support('automatic-feed-links');
        load_theme_textdomain('lovely', THEME_PATH . '/languages/');
        register_nav_menus(array('main' => esc_html__('Main Menu', 'lovely')));
        register_nav_menus(array('top' => esc_html__('Top Menu', 'lovely')));

        add_image_size('lovely_slider_img', 940, 530, true);
        add_image_size('lovely_slider_grid', 460, 480, true);
        add_image_size('lovely_blog_thumb', 620, 350, true);
        add_image_size('lovely_grid_thumb', 300, 200, true);
        add_image_size('lovely_list_thumb', 220, 140, true);
        add_image_size('lovely_oppo_thumb', 500, 530, true);
        add_image_size('lovely_video_post', 300, 380, true);
    }

}
if (!isset($content_width)) {
    $content_width = 960;
}



/* ================================================================================== */
/*      Enqueue Scripts
  /* ================================================================================== */

add_action('wp_enqueue_scripts', 'lovely_scripts');

function lovely_scripts() {
    wp_enqueue_style('lovely-bootstrap', THEME_DIR . '/assets/css/bootstrap.min.css');
    wp_enqueue_style('lovely-ionicons', THEME_DIR . '/assets/css/ionicons.min.css');
    wp_enqueue_style('lovely-style', STYLESHEET_DIR . '/style.css');
    wp_enqueue_style('lovely-responsive', THEME_DIR . '/assets/css/responsive.css');

    wp_enqueue_script('lovely-scripts', THEME_DIR . '/assets/js/scripts.js', array('jquery'), false, true);
    if (is_single() && comments_open()) {
        wp_enqueue_script('comment-reply');
    }
    wp_register_script('lovely-owl-carousel', THEME_DIR . '/assets/js/owl-carousel.min.js');
    wp_register_script('lovely-isotope', THEME_DIR . '/assets/js/jquery.waves-isotope.min.js');
    
    if(lovely_option('sidebar_affix')==='on'){
        wp_enqueue_script('lovely-theiastickysidebar', THEME_DIR . '/assets/js/theiaStickySidebar.js', false, false, true);
    }
    wp_enqueue_script('lovely-script', THEME_DIR . '/assets/js/waves-script.js');
}

/* ================================================================================== */
/*      Register Widget Sidebar
  /* ================================================================================== */

if (!function_exists('lovely_widgets_init')) {

    function lovely_widgets_init() {
        register_sidebar(array(
            'name' => 'Default sidebar',
            'id' => 'default-sidebar',
            'before_widget' => '<div class="widget-item"><aside class="widget %2$s" id="%1$s">',
            'after_widget' => '</aside></div>',
            'before_title' => '<h3 class="widget-title"><span>',
            'after_title' => '</span></h3>',
        ));
        /* footer sidebar */
        $footer = lovely_option('footer');
        if($footer == 'footer-3'){
            $grid = '1-2-3-4';
            foreach (explode('-', $grid) as $i) {
                register_sidebar(array(
                    'name' => esc_html__("Footer sidebar ", 'lovely') . $i,
                    'id' => "footer-sidebar-$i",
                    'description' => esc_html__('The footer sidebar widget area', 'lovely'),
                    'before_widget' => '<div class="widget %2$s" id="%1$s">',
                    'after_widget' => '</div>',
                    'before_title' => '<h3 class="widget-title"><span>',
                    'after_title' => '</span></h3>',
                ));
            }
        } else {            
            register_sidebar(array(
                'name' => esc_html__('Footer sidebar ', 'lovely'),
                'id' => "footer-sidebar",
                'description' => esc_html__('The footer sidebar widget area', 'lovely'),
                'before_widget' => '<div class="widget %2$s" id="%1$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widget-title"><span>',
                'after_title' => '</span></h3>',
            ));
        }
    }

}
add_action('widgets_init', 'lovely_widgets_init');
add_filter('widget_text', 'do_shortcode');



/* ================================================================================== */
/*      ThemeWaves Search Form Customize
  /* ================================================================================== */

function lovely_searchmenu() {
    $header_search = lovely_option('header_search');
    if( $header_search != 'off' ){
        $form = '<form method="get" class="searchform on-menu" action="' . esc_url(home_url('/')) . '" >';
        $form .= '<div class="input"><input type="text" value="' . get_search_query() . '" name="s" placeholder="' . esc_html__('Search', 'lovely') . '" /><i class="ion-search"></i></div>';
        $form .= '</form>';
        return $form;
    }
}

function lovely_searchform() {

    $form = '<form method="get" class="searchform" action="' . esc_url(home_url('/')) . '" >
    <div class="input">
    <input type="text" value="' . get_search_query() . '" name="s" placeholder="' . esc_html__('Keyword ...', 'lovely') . '" />
        <button type="submit" class="button-search"><i class="ion-ios-search-strong"></i></button>
    </div>
    </form>';

    return $form;
}

add_filter('get_search_form', 'lovely_searchform');

/* Exclude Category */

function lovely_exclude_widget_cats($args) {
    $categories = get_categories();
    $exclude = array();
    foreach ($categories as $category) {
        $options = get_option("taxonomy_" . $category->cat_ID);
        if (isset($options['featured']) && $options['featured']) {
            $exclude[] = $category->cat_ID;
        }
    }
    $args["exclude"] = $exclude;
    return $args;
}

add_filter("widget_categories_args", "lovely_exclude_widget_cats");

/* Wordpress Edit Gallery */
add_filter('use_default_gallery_style', '__return_false');
add_filter('wp_get_attachment_link', 'lovely_pretty_gallery', 10, 5);

function lovely_pretty_gallery($content, $id, $size = 'large', $permalink) {
    if (!$permalink)
        $content = preg_replace("/<a/", "<a rel=\"prettyPhoto[gallery]\"", $content, 1);
    $content = preg_replace("/<\/a/", "<div class=\"image-overlay\"></div></a", $content, 1);
    return $content;
}