<?php
class lovely_social_tabs_widget extends WP_Widget {
    function __construct(){
        $widget_ops = array('classname' => 'socialtabswidget', 'description' => esc_html__('Displays your social profile.','lovely'));
        parent::__construct(false, esc_html__('Lovely: Social Tabs','lovely'), $widget_ops);
    }
    function widget($args, $instance){
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        echo ($before_widget);
            if ($title){echo balanceTags($before_title . $title . $after_title);}
            $tabs=$contents='';
            $i=0;
            if(!empty($instance['social'])){
                $social_links=explode("\n",$instance['social']);
                foreach($social_links as $social_link){
                    if(!empty($social_link)){
                        $i++;
                        $tabs.='<li role="presentation"><a href="#" role="tab" data-toggle="tab"><i class="'.lovely_social_icon($social_link).'"></i></a></li>';
                        $contents.='<div role="tabpanel" class="tab-pane">'.lovely_social_button($social_link,$instance).'</div>';
                    }
                }
            } ?>
            <div class="lovely-social-tabs">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs entry-share <?php echo esc_attr('tab-count-'.$i); ?>" role="tablist"><?php echo balanceTags($tabs); ?></ul>
                <!-- Tab panes -->
                <div class="tab-content"><?php echo balanceTags($contents); ?></div>
            </div><?php
        echo ($after_widget);
    }
    function update($new_instance, $old_instance){
        $instance = $old_instance;
        $instance = $new_instance;
        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['speed'] = ! empty( $new_instance['speed'] );
        return $instance;
    }
    function form($instance){ ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','lovely'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo isset($instance['title']) ? $instance['title'] : ''; ?>"  />
        </p>
        <p>
            <input id="<?php echo esc_attr($this->get_field_id('speed')); ?>" name="<?php echo esc_attr($this->get_field_name('speed')); ?>" type="checkbox"<?php if(isset($instance['speed'])){checked($instance['speed']);} ?> />&nbsp;<label for="<?php echo esc_attr($this->get_field_id('speed')); ?>"><?php esc_html_e('Save Site Speed', 'lovely'); ?></label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('instagram_follow_id')); ?>"><?php esc_html_e('Instagram Follow ID:','lovely'); ?></label>
            <div><?php echo wp_kses(sprintf(__('Go to <a href="%s" target="_blank">instafollowbutton.com</a> and click Get Yours then copy <strong>data-id</strong> from <strong>HTML</strong> section','lovely'),esc_url('instafollowbutton.com')),array('a' => array('href' => array(),'target' => array()),'strong'=>array())); ?></div>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('instagram_follow_id')); ?>" name="<?php echo esc_attr($this->get_field_name('instagram_follow_id')); ?>" value="<?php echo isset($instance['instagram_follow_id']) ? $instance['instagram_follow_id'] : ''; ?>"  />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('social')); ?>"><?php echo esc_html__('Enter social links. Example:facebook.com/themewaves. NOTE: Divide value sets with linebreak "Enter"', 'lovely'); ?>:</label>
            <textarea class="widefat" rows="20" id="<?php echo esc_attr($this->get_field_id('social')); ?>" name="<?php echo esc_attr($this->get_field_name('social')); ?>"><?php echo isset($instance['social']) ? $instance['social'] : ''; ?></textarea>
        </p><?php
    }
}

add_action('widgets_init', create_function('', 'return register_widget("lovely_social_tabs_widget");'));