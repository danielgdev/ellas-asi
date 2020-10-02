<?php

if (comments_open ()) { ?>
    <div class="entry-comments" id="comments"><?php
            if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])){
                die('Please do not load this page directly. Thanks!');
            }elseif (post_password_required ()) { ?>
                <p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'lovely'); ?></p><?php
            }else{
            
                if (have_comments ()) { ?>
                    <div class="comment-title"><h4 class="np-title-line">
                        <?php printf(
                            _n(esc_html__('1 Comment', 'lovely'),
                            '%1$s ' . esc_html__('Comments', 'lovely'),
                            get_comments_number()),
                            number_format_i18n(get_comments_number())
                            ); ?>                        
                    </h4></div>
                    <div class="comment-list clearfix">
                        <?php wp_list_comments(array('style' => 'div', 'callback' => 'lovely_comment')); ?>
                    </div>
                    <div class="navigation">
                        <div class="left"><?php previous_comments_link() ?></div>
                        <div class="right"><?php next_comments_link() ?></div>
                    </div><?php
                }


                $fields[ 'comment_notes_before' ]=$fields[ 'comment_notes_after' ] = '';
                $fields[ 'label_submit' ] = esc_html__('Post comment', 'lovely');
                $fields[ 'comment_field' ] = 
                    '<p class="comment-form-comment">'.
                        '<textarea name="comment" placeholder="'.esc_html__('Your message', 'lovely').'" id="comment" class="required" rows="7" tabindex="4"></textarea>'.
                    '</p>';
                $fields[ 'title_reply' ] = esc_html__('Leave a Reply', 'lovely');
                $fields[ 'title_reply_to' ] = esc_html__('Leave a Reply to %s', 'lovely');

                comment_form($fields);
            }
        ?>
    </div><?php
}