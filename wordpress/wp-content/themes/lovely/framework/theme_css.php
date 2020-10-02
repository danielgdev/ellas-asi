<?php

function lovely_option_styles(){
    $fonts = get_theme_mod( 'ot_google_fonts', array() );

    $bodyFont=lovely_option('body_font');
    $navfont=  lovely_option('nav_font');
    $headingFont = lovely_option('heading_font');
    
    $menuBg = lovely_option('menu_bg');
    $menuHover = lovely_option('menu_hover');
    $bodyColor = lovely_option('body_color');
    $headingColor = lovely_option('heading_color');
    $metaColor = lovely_option('meta_color');
    $shareBg = lovely_option('share_bg');
    $footerBg = lovely_option('footer_bg');
    $footerColor = lovely_option('footer_color');
    ?>
    <style type="text/css" id="lovely-css">
        <?php 
            if( !empty($bodyFont['font-family']) ){
                echo 'body{'.
                        'font-family:'.esc_attr($fonts[$bodyFont['font-family']]['family']).', "Helvetica Neue", Helvetica, sans-serif;'.
                        (!empty($bodyFont['font-size']) ? ('font-size:'.esc_attr($bodyFont['font-size']).';') : '').
                '}';
            }
            if( !empty($navfont['font-family']) ){
                echo '.tw-menu .sf-menu{'.
                        'font-family:'.esc_attr($fonts[$navfont['font-family']]['family']).', "Helvetica Neue", Helvetica, sans-serif;'.
                        (!empty($navfont['font-size']) ? ('font-size:'.esc_attr($navfont['font-size']).';') : '').
                '}';
            }
            if( !empty($headingFont['font-family']) ){
                echo 'h1,h2,h3,h4,h5,h6,.entry-title,blockquote{'.
                        'font-family:'.esc_attr($fonts[$headingFont['font-family']]['family']).', "Helvetica Neue", Helvetica, sans-serif;'.
                '}';
            }
            if( !empty($headingFont['font-size']) ){
                echo '.entry-title{'.
                       'font-size:'.esc_attr($headingFont['font-size']).';'.
                '}';
            }       
            if( !empty($bodyColor) ){
                echo 'body{'.
                       'color:'.esc_attr($bodyColor).';'.
                '}';
            }       
            if( !empty($menuBg) ){
                echo '.tw-menu-container, .searchform.on-menu{'.
                       'background-color:'.esc_attr($menuBg).';'.
                '}';
                echo '.sf-menu ul{'.
                        'background-color:rgba('.esc_attr(lovely_hex2rgb($menuBg)).',.98);'.
                '}';
            }
            if( !empty($menuHover) ){
                echo '.sf-menu ul, .sf-menu > li > a:hover, .searchform.on-menu i, .header-2 .social-icons a,'.
                    '.sf-mobile-menu > .menu-item-has-children:before, .sf-menu > .menu-item-has-children:after{'.
                       'color:'.esc_attr($menuHover).';'.
                '}';
            }       
            if( !empty($headingColor) ){
                echo 'h1, h2, h3, h4, h5, h6,'.
                    '.entry-cats{'.
                       'color:'.esc_attr($headingColor).';'.
                '}';
            }       
            if( !empty($metaColor) ){
                echo '.tw-meta, .entry-share span{'.
                       'color:'.esc_attr($metaColor).';'.
                '}';
            }       
            if( !empty($shareBg) ){
                echo '.entry-share i{'.
                       'background-color:'.esc_attr($shareBg).';'.
                '}';
            }       
            if( !empty($footerBg) ){
                echo '.footer-area{'.
                       'background-color:'.esc_attr($footerBg).';'.
                '}';
            }    
            if( !empty($footerColor) ){
                echo '.tw-footer, .tw-footer a, .footer-area .entry-share span{'.
                       'color:'.esc_attr($footerColor).';'.
                '}';
            }       
        ?>
       <?php echo lovely_option('custom_css');?>
    </style><?php
}
add_action('wp_head', 'lovely_option_styles', 100);