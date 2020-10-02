<?php
get_header();
?>

<div class="row">
    <div class="content-area col-md-12">
        <div class="entry-content error-404">
            <span class="error-title"><?php esc_html_e('404', 'lovely');?></span>
            <span><?php esc_html_e('Page not found!', 'lovely');?></span>
            <?php echo '<p class="more-link tw-meta"><a href="'.esc_url(home_url('/')).'">'.esc_html__('Back Home', 'lovely').'</a></p>'; ?>
        </div>
    </div>
</div>

<?php
get_footer();