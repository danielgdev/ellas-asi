<?php
class lovely_text_widget extends WP_Widget {
    
    function __construct() {
        $widget_ops = array('classname' => 'tw-text-widget', 'description' => 'Lovely text widget.');
        parent::__construct(false, 'Lovely: Text', $widget_ops);
    }
    
    function widget($args, $instance) {
        global $post;
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);

        if (isset($before_widget))
            echo ($before_widget);
        if ($title != '')
            echo balanceTags($args['before_title'] . $title . $args['after_title']);
        
        echo '<div class="textwidget">' . ( !empty( $instance['filter'] ) ? wpautop( $instance['text'] ) : $instance['text'] ) . '</div>';
        
        if (isset($after_widget))
            echo ($after_widget);
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        if ( current_user_can('unfiltered_html') )
                $instance['text'] =  $new_instance['text'];
        else
                $instance['text'] = wp_kses_post( stripslashes( $new_instance['text'] ) );
        $instance['filter'] = ! empty( $new_instance['filter'] );
        return $instance;
    }

    function form($instance) {
        //Output admin widget options form
        extract(shortcode_atts(array(
                    'title' => '',
                    'text' => '',
                    'filter' => 0
                        ), $instance));
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'lovely');?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($title); ?>"  />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('text')); ?>"><?php esc_html_e('Content:', 'lovely');?></label>
            <textarea class="widefat" rows="16" cols="20" id="<?php echo esc_attr($this->get_field_id('text')); ?>" name="<?php echo esc_attr($this->get_field_name('text')); ?>"><?php echo esc_textarea( $text ); ?></textarea>
        </p>
        <p><input id="<?php echo esc_attr($this->get_field_id('filter')); ?>" name="<?php echo esc_attr($this->get_field_name('filter')); ?>" type="checkbox"<?php checked( $filter ); ?> />&nbsp;<label for="<?php echo esc_attr($this->get_field_id('filter')); ?>"><?php esc_html_e('Automatically add paragraphs', 'lovely'); ?></label></p>            
            <?php
    }
}
add_action('widgets_init', create_function('', 'return register_widget("lovely_text_widget");'));