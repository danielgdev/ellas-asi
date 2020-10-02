<?php
global $lovely_categoryOptions;
$lovely_categoryOptions = Array(
    Array(
         'name' => 'featured',
         'title' => esc_html__('is Featured ?', 'lovely'),
         'type' => 'checkbox',
         'description' => '',
         'std' => ''
    ),
);
function lovely_category_meta_add($metaArray) {
    foreach ($metaArray as $meta) {
        $val = $meta["std"];
        $output = '<div class="form-field type-'.esc_attr($meta['type']).'">';
            $output .= '<label for="term_meta[' . esc_attr($meta['name']) . ']">' . esc_html($meta['title']) . '</label>';
            switch ($meta['type']) {
                case 'text':
                    $output .= '<input name="term_meta[' . esc_attr($meta['name']) . ']" type="text" value="' . esc_attr($val) . '" />';
                    break;
                case 'checkbox':
                    $output .= '<input type="hidden" name="term_meta['.esc_attr($meta['name']).']" value="0"/>';
                    $output .= '<input type="checkbox" class="yesno" name="term_meta['.esc_attr($meta['name']).']" value="1"'.checked($val, 1, false).' />';           
                    break;
                case 'radio':
                    foreach($meta['options'] as $meta_option){              
                        $output .= '<div class="radio-images">';
                            $output .= '<p><input type="radio" name="term_meta[' . esc_attr($meta['name']) . ']" value="' . esc_attr( $meta_option['value'] ) . '"' . checked( $val, $meta_option['value'], false ) . ' class="option-tree-ui-radio option-tree-ui-images" /><label>' . esc_attr( $meta_option['label'] ) . '</label></p>';
                            $output .= '<img src="' . esc_url( $meta_option['src'] ) . '" alt="' . esc_attr( $meta_option['label'] ) .'" title="' . esc_attr( $meta_option['label'] ) .'" class="radio-image ' . ( $val == $meta_option['value'] ? ' radio-image-selected' : '' ) . '" />';
                        $output .= '</div>';
                    }
                    break;
            }
            $output .= '<br /><p>' . esc_html($meta['description']) . '</p>';
        $output .= '</div>';
        echo balanceTags($output);
    }
}
function lovely_category_meta_edit($metaArray, $id) {
    $options = get_option("taxonomy_$id");
    $output = '';
    foreach ($metaArray as $meta) {
        $val = isset($options[$meta['name']]) ? esc_attr($options[$meta['name']]) : '';
        $output .= '<tr class="form-field type-'.esc_attr($meta['type']).'">';
            $output .= '<th scope="row" valign="top"><label for="term_meta[' . esc_attr($meta['name']) . ']">' . esc_html($meta['title']) . '</label></th>';
            $output .= '<td class="form-field type-'.esc_attr($meta['type']).'">';
                switch ($meta['type']) {
                    case 'text':
                        $output .= '<input name="term_meta[' . esc_attr($meta['name']) . ']" type="text" value="' . esc_attr($val) . '" />';
                        break;
                    case 'checkbox':
                        $output .= '<input type="hidden" name="term_meta['.esc_attr($meta['name']).']" value="0"/>';
                        $output .= '<input type="checkbox" class="yesno" name="term_meta['.esc_attr($meta['name']).']" value="1"'.checked($val, 1, false).' />';           
                        break;
                    case 'radio':
                        foreach ($meta['options'] as $meta_option) {
                            $checked=$meta_option['value'] == $val ? 'checked ' : '';                  
                            $output .= '<div class="radio-images">';
                                $output .= '<p><input type="radio" name="term_meta[' . esc_attr($meta['name']) . ']" value="' . esc_attr( $meta_option['value'] ) . '"' . checked( $val, $meta_option['value'], false ) . ' class="option-tree-ui-radio option-tree-ui-images" /><label>' . esc_attr( $meta_option['label'] ) . '</label></p>';
                                $output .= '<img src="' . esc_url( $meta_option['src'] ) . '" alt="' . esc_attr( $meta_option['label'] ) .'" title="' . esc_attr( $meta_option['label'] ) .'" class="radio-image ' . ( $val == $meta_option['value'] ? ' radio-image-selected' : '' ) . '" />';
                            $output .= '</div>';
                        }
                        break;
                }
                $output .= '<br /><span class="description">' . esc_html($meta['description']) . '</span>';
            $output .= '</td>';
        $output .= '</tr>';
    }
    echo balanceTags($output);
}
$taxonomyName = 'category';
add_action($taxonomyName . '_add_form_fields', 'lovely_category_add',        10, 2);
add_action('created_' . $taxonomyName,         'lovely_save_category_meta', 10, 2);
add_action($taxonomyName . '_edit_form_fields','lovely_category_edit',       10, 2);
add_action('edited_' . $taxonomyName,          'lovely_save_category_meta', 10, 2);
function lovely_category_add($tag) {
    global $lovely_categoryOptions;
    $id = isset($tag) && isset($tag->term_id) ? $tag->term_id : '';
    lovely_category_meta_add($lovely_categoryOptions, $id);
}
function lovely_category_edit($tag) {
    global $lovely_categoryOptions;
    $id = isset($tag) && isset($tag->term_id) ? $tag->term_id : '';
    lovely_category_meta_edit($lovely_categoryOptions, $id);
}
function lovely_save_category_meta($id) {
    if (isset($_POST['term_meta'])) {
        $keys = array_keys($_POST['term_meta']);
        foreach ($keys as $key) {
            if (isset($_POST['term_meta'][$key])) {
                $term_meta[$key] = $_POST['term_meta'][$key];
            }
        }
        if (isset($_POST['term_meta_category_bg'])) {
            $term_meta['category_bg'] = $_POST['term_meta_category_bg'];
        }
        update_option("taxonomy_$id", $term_meta);
    } else if (isset($_POST['term_meta_category_bg'])) {
        $term_meta['category_bg'] = $_POST['term_meta_category_bg'];
        update_option("taxonomy_$id", $term_meta);
    }
}