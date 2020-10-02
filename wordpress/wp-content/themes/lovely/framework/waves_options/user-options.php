<?php
add_action('show_user_profile', 'lovely_user_profile_edit');
add_action('edit_user_profile', 'lovely_user_profile_edit');
function lovely_user_profile_edit($user) {
  $social = !empty($user->user_social) ? $user->user_social : '';
  echo '<h3>Themewaves option</h3>';
  echo '<table class="form-table">';
  echo '<tbody><tr class="user-description-wrap">';
  echo '<th><label for="description">'.esc_html__('User Socials', 'lovely').'</label></th>';
    echo '<td><textarea name="user_social" id="user_social" rows="5" cols="30">'.esc_html($social).'</textarea>';
    echo '<p class="description">'.esc_html__('Enter social links. Example:facebook.com/themewaves. NOTE: Divide value sets with linebreak "Enter":', 'lovely').'</p></td>';
  echo '</tr></tbody></table>';
}

add_action('personal_options_update', 'lovely_user_profile_update');
add_action('edit_user_profile_update', 'lovely_user_profile_update');
function lovely_user_profile_update($user_id) {
  update_user_meta($user_id, 'user_social', wp_kses_post( $_POST['user_social'] ));
}