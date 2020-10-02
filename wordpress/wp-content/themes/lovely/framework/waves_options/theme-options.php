<?php

/**
 * Initialize the custom Theme Options.
 */
add_action('init', 'lovely_theme_options');

/**
 * Build the custom settings & update OptionTree.
 *
 * @return    void
 * @since     2.0
 */
function lovely_theme_options() {

    /* OptionTree is not loaded yet, or this is not an admin request */
    if (!function_exists('ot_settings_id') || !is_admin())
        return false;

    /**
     * Get a copy of the saved settings array. 
     */
    $saved_settings = get_option(ot_settings_id(), array());

    $single_layout = array(
        array(
            'value' => 'with-sidebar',
            'label' => esc_html__('With sidebar', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_1.png'
        ),
        array(
            'value' => 'simple',
            'label' => esc_html__('Without Sidebar', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_2.png'
        ),
        array(
            'value' => 'full-width',
            'label' => esc_html__('Full Width', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_3.png'
        )
    );

    /**
     * Custom settings array that will eventually be 
     * passes to the OptionTree Settings API Class.
     */
    $custom_settings = array(
        'contextual_help' => array(
            'content' => array(
                array(
                    'id' => 'option_types_help',
                    'title' => esc_html__('Option Types', 'lovely'),
                    'content' => '<p>' . esc_html__('Help content goes here!', 'lovely') . '</p>'
                )
            ),
            'sidebar' => '<p>' . esc_html__('Sidebar content goes here!', 'lovely') . '</p>'
        ),
        'sections' => array(
            array(
                'id' => 'general',
                'title' => esc_html__('General', 'lovely')
            ),
            array(
                'id' => 'blog',
                'title' => esc_html__('Blog', 'lovely')
            ),
            array(
                'id' => 'color',
                'title' => esc_html__('Color', 'lovely')
            ),
            array(
                'id' => 'typography',
                'title' => esc_html__('Typography', 'lovely')
            ),
            array(
                'id' => 'footer',
                'title' => esc_html__('Footer', 'lovely')
            )
        ),
        'settings' => array(
            array(
                'id' => 'logo',
                'label' => esc_html__('Upload Logo', 'lovely'),
                'type' => 'upload',
                'std' => get_template_directory_uri() . '/assets/img/logo.png',
                'section' => 'general'
            ),
            array(
                'id' => 'favicon',
                'label' => esc_html__('Upload Favicon', 'lovely'),
                'type' => 'upload',
                'std' => get_template_directory_uri() . '/assets/img/favicon.png',
                'section' => 'general'
            ),
            array(
                'id' => 'header',
                'label' => esc_html__('Header Layout ?', 'lovely'),
                'std' => '',
                'type' => 'select',
                'choices'     => array( 
                    array(
                      'value'       => '',
                      'label'       => esc_html__( 'Layout 1', 'lovely' )
                    ),
                    array(
                      'value'       => 'header-2',
                      'label'       => esc_html__( 'Layout 2', 'lovely' )
                    ),
                    array(
                      'value'       => 'header-3',
                      'label'       => esc_html__( 'Layout 3', 'lovely' )
                    )
                ),
                'section' => 'general',
            ),
            array(
                'id' => 'header_social',
                'label' => esc_html__('Header Socials', 'lovely'),
                'std' => 'on',
                'type' => 'on-off',
                'section' => 'general',
                'condition'   => 'header:not()'
            ),
            array(
                'id' => 'header_ads',
                'label' => esc_html__('Header Ads', 'lovely'),
                'type' => 'upload',
                'std' => get_template_directory_uri() . '/assets/img/header_ads.png',
                'section' => 'general',
                'condition'   => 'header:is(header-3)'
            ),
            array(
                'id' => 'single_layout',
                'label' => esc_html__('Single Post Layout', 'lovely'),
                'desc' => esc_html__('Set the All Single Post Layouts and if you want to set the Specific Layout styles on another single then Each Post Single has option in Metabox (Check the Single Post while editing).', 'lovely'),
                'std' => 'with-sidebar',
                'type' => 'radio-image',
                'choices' => $single_layout,
                'section' => 'general'
            ),
            array(
                'id' => 'sidebar_affix',
                'label' => esc_html__('Sidebar Affix', 'lovely'),
                'desc' => esc_html__('If you set this on Sidebar areas will be affixed.', 'lovely'),
                'std' => 'off',
                'type' => 'on-off',
                'section' => 'general'
            ),
            array(
                'id' => 'sticky_nav',
                'label' => esc_html__('Sticky Navigation', 'lovely'),
                'std' => 'on',
                'type' => 'on-off',
                'section' => 'general'
            ),
            array(
                'id' => 'header_search',
                'label' => esc_html__('Header Search form', 'lovely'),
                'std' => 'on',
                'type' => 'on-off',
                'section' => 'general'
            ),
            array(
                'id' => 'share_button',
                'label' => esc_html__('Share Button', 'lovely'),
                'std' => 'on',
                'type' => 'on-off',
                'section' => 'general'
            ),
            array(
                'id' => 'custom_css',
                'label' => esc_html__('Custom CSS', 'lovely'),
                'desc' => esc_html__('Custom CSS section will give you able to insert your own CSS rules to apply on Lovely theme.', 'lovely'),
                'std' => '',
                'type' => 'css',
                'section' => 'general',
                'rows' => '15'
            ),
            array(
                'id' => 'layout',
                'label' => esc_html__('Blog Layout', 'lovely'),
                'desc' => esc_html__('This option will set the Wordpress Default Blog Posts Layouts. If you set the Static Pages on Settings -> Reading -> Posts Page then it will also works. Note: It will not Work if you set it on Page Single!', 'lovely'),
                'std' => 'simple-side',
                'type' => 'radio-image',
                'section' => 'blog'
            ),
            array(
                'id' => 'more_text',
                'label' => esc_html__('Insert Custom Read More', 'lovely'),
                'std' => 'Read more',
                'type' => 'text',
                'section' => 'blog'
            ),
            array(
                'id' => 'excerpt_count',
                'label' => esc_html__('Excerpt word count', 'lovely'),
                'std' => '0',
                'type' => 'text',
                'section' => 'blog'
            ),
            array(
                'id'          => 'header_color_desc',
                'label'       => esc_html__( 'Customize Header Area', 'lovely' ),
                'type'        => 'textblock-titled',
                'section'     => 'color',
            ),
            array(
                'id' => 'menu_bg',
                'label' => esc_html__('Menu background color', 'lovely'),
                'std' => '#151515',
                'type' => 'colorpicker',
                'section' => 'color'
            ),
            array(
                'id' => 'menu_hover',
                'label' => esc_html__('Menu hover, icon and submenu color', 'lovely'),
                'std' => '#999999',
                'type' => 'colorpicker',
                'section' => 'color'
            ),
            array(
                'id'          => 'general_color_desc',
                'label'       => esc_html__( 'Customize Content Area', 'lovely' ),
                'type'        => 'textblock-titled',
                'section'     => 'color',
            ),
            array(
                'id' => 'body_color',
                'label' => esc_html__('Body text color', 'lovely'),
                'std' => '#666666',
                'type' => 'colorpicker',
                'section' => 'color'
            ),
            array(
                'id' => 'heading_color',
                'label' => esc_html__('Heading tags color', 'lovely'),
                'std' => '#151515',
                'type' => 'colorpicker',
                'section' => 'color'
            ),
            array(
                'id' => 'meta_color',
                'label' => esc_html__('Meta text color', 'lovely'),
                'std' => '#999999',
                'type' => 'colorpicker',
                'section' => 'color'
            ),
            array(
                'id' => 'share_bg',
                'label' => esc_html__('Share icon background color', 'lovely'),
                'std' => '#cccccc',
                'type' => 'colorpicker',
                'section' => 'color'
            ),
            array(
                'id'          => 'footer_color_desc',
                'label'       => esc_html__( 'Customize Footer Area', 'lovely' ),
                'type'        => 'textblock-titled',
                'section'     => 'color',
            ),
            array(
                'id' => 'footer_bg',
                'label' => esc_html__('Footer background color', 'lovely'),
                'std' => '#151515',
                'type' => 'colorpicker',
                'section' => 'color'
            ),
            array(
                'id' => 'footer_color',
                'label' => esc_html__('Footer text color', 'lovely'),
                'std' => '#999999',
                'type' => 'colorpicker',
                'section' => 'color'
            ),
            array(
                'id' => 'body_font',
                'label' => esc_html__('Body font', 'lovely'),
                'std' => array('font-family' => 'droidsans', 'font-size' => '14px'),
                'type' => 'typography',
                'section' => 'typography'
            ),
            array(
                'id' => 'nav_font',
                'label' => esc_html__('Navigation font', 'lovely'),
                'std' => array('font-family' => 'droidsans', 'font-size' => '10px'),
                'type' => 'typography',
                'section' => 'typography'
            ),
            array(
                'id' => 'heading_font',
                'label' => esc_html__('Heading font', 'lovely'),
                'std' => array('font-family' => 'playfairdisplay', 'font-size' => '24px'),
                'type' => 'typography',
                'section' => 'typography'
            ),
            array(
                'id' => 'google_fonts',
                'label' => esc_html__('Google Fonts', 'lovely'),
                'desc' => esc_html__('Note: Your Selected Google fonts will be added on above Body Font & Heading Fonts list. If you want to change it then choose your comfortable font. If you are working on Cyrillic fonts then tick the Cyrillic. You can add more Google fonts.', 'lovely'),
                'std' => array(
                    array(
                        'family' => 'droidsans',
                        'variants' => array('regular'),
                        'subsets' => array('latin')
                    ),
                    array(
                        'family' => 'playfairdisplay',
                        'variants' => array('regular', '700'),
                        'subsets' => array('latin')
                    )
                ),
                'type' => 'google-fonts',
                'section' => 'typography'
            ),
            array(
                'id' => 'socials',
                'label' => esc_html__('Social Links', 'lovely'),
                'std' => '',
                'type' => 'social-links',
                'desc' => esc_html__('Those social icons will be displayed on Footer section of our theme.', 'lovely'),
                'section' => 'footer'
            ),
            array(
                'id' => 'footer',
                'label' => esc_html__('Footer Layout ?', 'lovely'),
                'std' => '',
                'type' => 'select',
                'choices'     => array( 
                    array(
                      'value'       => '',
                      'label'       => esc_html__( 'Layout 1', 'lovely' )
                    ),
                    array(
                      'value'       => 'footer-2',
                      'label'       => esc_html__( 'Layout 2', 'lovely' )
                    ),
                    array(
                      'value'       => 'footer-3',
                      'label'       => esc_html__( 'Layout 3', 'lovely' )
                    )
                ),
                'section' => 'footer',
            ),
            array(
                'id' => 'footer_logo',
                'label' => esc_html__('Upload Footer Logo', 'lovely'),
                'type' => 'upload',
                'std' => get_template_directory_uri() . '/assets/img/logo.png',
                'section' => 'footer',
                'condition'   => 'footer:is(footer-2)'
            ),
            array(
                'id' => 'copyright',
                'label' => esc_html__('Copyright text', 'lovely'),
                'std' => '&copy; 2016 - Beautiful. All Rights Reserved.',
                'type' => 'text',
                'section' => 'footer'
            ),
            array(
                'id' => 'footertext',
                'label' => esc_html__('Footer text', 'lovely'),
                'std' => 'Developed by <a href="'.esc_url('themewaves.com').'">ThemeWaves.com</a>',
                'type' => 'text',
                'section' => 'footer'
            ),
        )
    );

    /* allow settings to be filtered before saving */
    $custom_settings = apply_filters(ot_settings_id() . '_args', $custom_settings);

    /* settings are not the same update the DB */
    if ($saved_settings !== $custom_settings) {
        update_option(ot_settings_id(), $custom_settings);
    }

    /* Lets OptionTree know the UI Builder is being overridden */
    global $ot_has_custom_theme_options;
    $ot_has_custom_theme_options = true;
}

add_filter('ot_recognized_typography_fields', 'lovely_ot_typo');

function lovely_ot_typo() {
    return array('font-family', 'font-size');
}

add_filter('ot_radio_images', 'lovely_ot_radioimages');

function lovely_ot_radioimages() {
    return array(
        array(
            'value' => 'simple-side',
            'label' => esc_html__('Simple with sidebar', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_1.png'
        ),
        array(
            'value' => 'simple',
            'label' => esc_html__('Simple without sidebar', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_2.png'
        ),
        array(
            'value' => 'simple-full',
            'label' => esc_html__('Simple fullwidth', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_3.png'
        ),
        array(
            'value' => 'grid-side',
            'label' => esc_html__('Grid with Sidebar', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_4.png'
        ),
        array(
            'value' => 'grid',
            'label' => esc_html__('Grid without Sidebar', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_5.png'
        ),
        array(
            'value' => 'grid-full',
            'label' => esc_html__('Grid Fullwidth', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_6.png'
        ),
        array(
            'value' => 'list-side',
            'label' => esc_html__('List with sidebar', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_7.png'
        ),
        array(
            'value' => 'list',
            'label' => esc_html__('List without sidebar', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_8.png'
        ),
        array(
            'value' => 'list-full',
            'label' => esc_html__('List fullwidth', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_9.png'
        ),
        array(
            'value' => 'oppo-side',
            'label' => esc_html__('Opposite with sidebar', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_10.png'
        ),
        array(
            'value' => 'oppo',
            'label' => esc_html__('Opposite without sidebar', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_11.png'
        ),
        array(
            'value' => 'oppo-full',
            'label' => esc_html__('Opposite fullwidth', 'lovely'),
            'src' => THEME_DIR . '/assets/img/content_12.png'
        )
    );
}

add_filter('ot_social_links_settings', 'lovely_ot_socials_settings');

function lovely_ot_socials_settings() {
    return array(
        array(
            'id' => 'name',
            'label' => esc_html__('Title', 'lovely'),
            'desc' => esc_html__('Enter the name of the social website.', 'lovely'),
            'std' => '',
            'type' => 'text',
            'class' => 'option-tree-setting-title'
        ),
        array(
            'id' => 'subtext',
            'label' => esc_html__('Sub Text', 'lovely'),
            'desc' => esc_html__('Enter text.', 'lovely'),
            'type' => 'text'
        ),
        array(
            'id' => 'href',
            'label' => 'Link',
            'desc' => sprintf(esc_html__('Enter a link to the profile or page on the social website. Remember to add the %s part to the front of the link.', 'lovely'), '<code>http://</code>'),
            'type' => 'text',
        )
    );
}

add_filter('ot_type_social_links_defaults', 'lovely_ot_socials_defaults');

function lovely_ot_socials_defaults() {
    return array(
        array(
            'name' => 'Facebook',
            'subtext' => 'Like',
            'href' => 'facebook.com/themewaves'
        ),
        array(
            'name' => 'Twitter',
            'subtext' => 'Follow',
            'href' => 'twitter.com/themewaves'
        ),
        array(
            'name' => 'Instagram',
            'subtext' => 'Follow',
            'href' => 'instagram.com/themewavesteam'
        ),
        array(
            'name' => 'Pinterest',
            'subtext' => 'Follow',
            'href' => 'pinterest.com/themewaves'
        ),
        array(
            'name' => 'Google +',
            'subtext' => 'Follow',
            'href' => 'plus.google.com/118413943291702579986'
        ),
        array(
            'name' => 'Youtube',
            'subtext' => 'Subscribe',
            'href' => 'youtube.com/user/Themewaves'
        ),
    );
}

//ot_register_pages_array
function lovely_version_text() {
    return LOVELY_THEMENAME . ' - ' . LOVELY_THEMEVERSION;
}

add_filter('ot_header_version_text', 'lovely_version_text', 10, 2);

function lovely_logo_link() {
    return ('<a href="'.esc_url("themewaves.com/docs/lovely").'" target="_blank" title="'.esc_html__('Theme Documentation', 'lovely').'">'.esc_html__('Documentation', 'lovely').'</a>');
}

add_filter('ot_header_logo_link', 'lovely_logo_link', 10, 2);
