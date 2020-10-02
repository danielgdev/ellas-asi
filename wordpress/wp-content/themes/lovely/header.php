<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8"> <![endif]-->
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <?php lovely_favicon(); ?>
        <!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
        <?php wp_head(); ?>
    </head>
    <?php
        $sticky_nav = lovely_option('sticky_nav');
        $body_class = $sticky_nav != 'off' ? '' : 'menu-locked';
    ?>
    <body <?php body_class(esc_attr($body_class)); ?>>
        <?php
        $header = lovely_option('header');
        ?>
        <div class="tw-mobile-menu<?php if($header==='header-2'){ echo ' right-side';} ?>"><i class="ion-ios-close-empty"></i>
            <nav><?php lovely_mobilemenu(); ?></nav>
        </div>
        <div class="theme-layout">
            <?php
                get_template_part('header-area', substr($header, -1));
                get_template_part('feature', 'area'); 
            ?>
            <!-- Start Main -->
            <div class="lovely-container container">