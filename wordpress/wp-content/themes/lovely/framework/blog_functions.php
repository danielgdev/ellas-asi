<?php

/* ================================================================================== */
/*      Blog Shortcode
  /* ================================================================================== */

function lovely_standard_media($post, $atts) {
    if (has_post_thumbnail($post->ID)) {
        $output = '<div class="entry-media">';
        $output .= '<div class="tw-thumbnail">';
        $output .= lovely_image($atts['img_size']);
        if (is_single($post)) {
            $img = lovely_image('full', true);
            $output .= '<div class="image-overlay tw-middle"><div class="image-overlay-inner">';
            $output .= '<a href="' . esc_url($img['url']) . '" rel="prettyPhoto[' . esc_attr($post->ID) . ']" title="' . esc_attr(get_the_title()) . '" class="overlay-icon">';
            $output .= '</a></div></div>';
        } else {
            $output .= '<div class="image-overlay tw-middle"><div class="image-overlay-inner">';
            $output .= '<a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '" class="overlay-icon">';
            $output .= '</a></div></div>';
        }
        $output .= '</div>';
        $output .= '</div>';
        return $output;
    }
}

function lovely_entry_media($format, $atts) {
    global $post;
    $output = '';
    if (!is_single() && has_post_thumbnail($post->ID)) {
        return lovely_standard_media($post, $atts);
    }
    switch ($format) {

        case 'gallery':
            $images = explode(',', get_post_meta($post->ID, 'gallery_images', true));
            if ($images) {
                wp_enqueue_script('lovely-owl-carousel');
                $output .= '<div class="entry-media">';
                $output .= '<div class="owl-carousel">';
                foreach ($images as $image) {
                    $img = wp_get_attachment_image_src($image, $atts['img_size']);
                    $desc = get_post_field('post_excerpt', $image);
                    $output .= '<div>';
                    $output .= '<img src="' . esc_url($img[0]) . '"' . ($desc ? ' title="' . $desc . '"' : '') . ' />';
                    $output .= '</div>';
                }
                $output .= '</div>';
                $output .= '</div>';
                break;
            } else {
                $output = lovely_standard_media($post, $atts);
                break;
            }

        case 'video':

            $embed = get_post_meta($post->ID, 'video_embed', true);

            if (wp_oembed_get($embed)) {
                $output .= '<div class="entry-media">';
                $output .= wp_oembed_get($embed);
                $output .= '</div>';
                break;
            } elseif (!empty($embed)) {
                $output .= '<div class="entry-media">';
                $output .= apply_filters("the_content", htmlspecialchars_decode($embed));
                $output .= '</div>';
                break;
            } else {
                $output = lovely_standard_media($post, $atts);
                break;
            }

        case 'audio':

            $mp3 = get_post_meta($post->ID, 'audio_mp3', true);
            $embed = get_post_meta($post->ID, 'audio_embed', true);
            if ($mp3) {
                $output .= '<div class="entry-media">';
                $output .= apply_filters("the_content", '[audio src="' . esc_url($mp3) . '"]');
                $output .= '</div>';
                break;
            } elseif (wp_oembed_get($embed)) {
                $output .= '<div class="entry-media">';
                $output .= wp_oembed_get($embed);
                $output .= '</div>';
                break;
            } elseif (!empty($embed)) {
                $output .= '<div class="entry-media">';
                $output .= apply_filters("the_content", htmlspecialchars_decode($embed));
                $output .= '</div>';
                break;
            } else {
                $output = lovely_standard_media($post, $atts);
                break;
            }

        default :
            $output = lovely_standard_media($post, $atts);
    }
    return $output;
}

function lovely_blogcontent($atts) {
    global $more;
    $more = 0;
    if (has_excerpt()) {
        the_excerpt();
    } else if (!empty($atts['excerpt_count'])) {
        echo apply_filters("the_content", lovely_excerpt(strip_shortcodes(get_the_content()), $atts['excerpt_count']));
    } else {
        the_content($atts['more_text']);
    }
}

function lovely_excerpt($str, $length) {
    $str = explode(" ", strip_tags($str));
    return implode(" ", array_slice($str, 0, $length));
}

add_filter('the_content_more_link', 'lovely_read_more_link', 10, 2);

function lovely_read_more_link($output, $read_more_text) {
    $output = '<p class="more-link tw-hover tw-meta"><a href="' . esc_url(get_permalink()) . '"><span>' . $read_more_text . '</span><i class="ion-ios-arrow-thin-right"></i></a></p>';
    return $output;
}
