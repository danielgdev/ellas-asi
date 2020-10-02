<?php
/**
 * Initialize the custom Meta Boxes. 
 */
add_action( 'admin_init', 'lovely_page_options' );

/**
 * Meta Boxes demo code.
 *
 * You can find all the available option types in theme-options.php.
 *
 * @return    void
 * @since     2.3.0
 */
function lovely_page_options(){
    $feature = array(
        array(
          'value'   => '',
          'label'   => esc_html__( 'None', 'lovely' ),
          'src'     => THEME_DIR . '/assets/img/slider_empty.png'
        ),
        array(
          'value'   => 'post',
          'label'   => esc_html__( 'Feature Post', 'lovely' ),
          'src'     => THEME_DIR . '/assets/img/slider_1.png'
        ),
        array(
          'value'   => 'slider',
          'label'   => esc_html__( 'Simple Slider', 'lovely' ),
          'src'     => THEME_DIR . '/assets/img/slider_2.png'
        ),
        array(
          'value'   => 'grid',
          'label'   => esc_html__( 'Grid Posts', 'lovely' ),
          'src'     => THEME_DIR . '/assets/img/slider_3.png'
        ),
        array(
          'value'   => 'fancy',
          'label'   => esc_html__( 'Fancy Box', 'lovely' ),
          'src'     => THEME_DIR . '/assets/img/slider_4.png'
        ),
        array(
          'value'   => 'shortcode',
          'label'   => esc_html__( 'Shortcode', 'lovely' ),
          'src'     => THEME_DIR . '/assets/img/slider_5.png'
        )
    );
  
  /**
   * Create a custom meta boxes array that we pass to 
   * the OptionTree Meta Box API Class.
   */
  $my_meta_box = array(
    'id'          => 'page_options',
    'title'       => esc_html__( 'Page options', 'lovely' ),
    'desc'        => '',
    'pages'       => array( 'page' ),
    'context'     => 'normal',
    'priority'    => 'high',
    'fields'      => array(
        array(
            'id' => 'feature',
            'label' => esc_html__('Feature area', 'lovely'),
            'desc' => esc_html__('If you want to display Feature area on Top of Page then use this option. ', 'lovely'),
            'std' => '',
            'choices' => $feature,
            'type' => 'radio-image',
        ),
        array(
            'id' => 'feature_per_page',
            'label' => esc_html__('Featured post count', 'lovely'),
            'std' => '3',
            'type' => 'text',
            'section' => 'general',
            'condition'   => 'feature:is(slider)'
        ),
        array(
            'id' => 'featured_cat',
            'label' => esc_html__('Featured category ( on slider )', 'lovely'),
            'std' => '',
            'type' => 'category-select',
            'section' => 'general',
            'condition'   => 'feature:not(),feature:not(shortcode)',
            'operator'    => 'and',
        ),
        array(
            'id' => 'shortcode',
            'label' => esc_html__('Shortcode', 'lovely'),
            'desc' => 'You need to insert Revolution slider or Layerslider shortcodes here. Any slider or another plugin shortcodes will work.',
            'std' => '',
            'type' => 'text',
            'section' => 'general',
            'condition'   => 'feature:is(shortcode)'
        ),
        array(
            'id' => 'template',
            'label' => esc_html__('Page Template', 'lovely'),
            'std' => '',
            'desc' => 'Please choose the Blog Page or Fullwidth then extra options will help you build awesome Blog Styles.',
            'type' => 'select',
            'choices'     => array( 
                array(
                  'value'       => '',
                  'label'       => esc_html__( 'Default', 'lovely' )
                ),
                array(
                  'value'       => 'with-sidebar',
                  'label'       => esc_html__( 'With sidebar', 'lovely' )
                ),
                array(
                  'value'       => 'full-width',
                  'label'       => esc_html__( 'Full width', 'lovely' )
                ),
                array(
                  'value'       => 'blog',
                  'label'       => esc_html__( 'Blog page', 'lovely' )
                )
            ),
            'section' => 'general'
        ),
        array(
            'id' => 'layout',
            'label' => esc_html__('Blog Layout', 'lovely'),
            'desc' => esc_html__('Please choose the how Blog Posts will be displayed.', 'lovely'),
            'std' => '',
            'type' => 'radio-image',
            'section' => 'general',
            'condition'   => 'template:is(blog)'
        ),
        array(
            'id' => 'cats',
            'label' => esc_html__('Choose the Categories', 'lovely'),
            'type' => 'category-checkbox',
            'section' => 'general',
            'condition'   => 'template:is(blog)'
        ),
        array(
            'id' => 'more_text',
            'label' => esc_html__('Insert Custom Read More', 'lovely'),
            'std' => '',
            'type' => 'text',
            'section' => 'general',
            'condition'   => 'template:is(blog)'
        ),
        array(
            'id' => 'posts_per_page',
            'label' => esc_html__('How much Blog Posts will Display?', 'lovely'),
            'std' => '',
            'type' => 'text',
            'section' => 'general',
            'condition'   => 'template:is(blog)'
        ),
        array(
            'id' => 'excerpt_count0',
            'label' => esc_html__('Excerpt word count on Featured opposite post', 'lovely'),
            'std' => '26',
            'type' => 'text',
            'section' => 'general',
            'condition'   => 'template:is(blog),layout:contains(oppo)'
        ),
        array(
            'id' => 'excerpt_count',
            'label' => esc_html__('Excerpt word count', 'lovely'),
            'std' => '',
            'type' => 'text',
            'section' => 'general',
            'condition'   => 'template:is(blog)'
        ),
        array(
            'id' => 'popular_posts',
            'label' => esc_html__('Display Popular posts?', 'lovely'),
            'std' => '',
            'type' => 'select',
            'choices'     => array( 
                array(
                  'value'       => '',
                  'label'       => esc_html__( 'No', 'lovely' )
                ),
                array(
                  'value'       => '3',
                  'label'       => esc_html__( 'Layout: 3 columns', 'lovely' )
                ),
                array(
                  'value'       => '4',
                  'label'       => esc_html__( 'Layout: 4 columns', 'lovely' )
                ),
                array(
                  'value'       => 'video',
                  'label'       => esc_html__( 'Recent video posts', 'lovely' )
                )
            ),
            'section' => 'general',
            'condition'   => 'template:is(blog)'
        ),
    )
  );
  
  /**
   * Register our meta boxes using the 
   * ot_register_meta_box() function.
   */
  if ( function_exists( 'ot_register_meta_box' ) )
    ot_register_meta_box( $my_meta_box );

}