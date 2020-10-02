<?php get_header(); ?>

<div class="row">
    <div class="content-area col-md-8">
        <?php
        if (have_posts ()) {
            $lovely_options['more_text'] = lovely_option("more_text", "Read more");
            $lovely_options['excerpt_count'] = 15;
            $lovely_options['pagination'] = "simple";
            get_template_part('content-list');
        } else { ?>
                <div class="search-result">
                    <h3><?php esc_html_e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'lovely');?></h3>
                    <?php get_search_form(); ?>
                    <br/>

                    <div class="error-msg"><p><?php esc_html_e('For best search results, mind the following suggestions:', 'lovely');?></p>
                        <ul class="borderlist">
                            <li><?php esc_html_e('Always double check your spelling.', 'lovely');?></li>
                            <li><?php esc_html_e('Try similar keywords, for example: tablet instead of laptop.', 'lovely');?></li>
                            <li><?php esc_html_e('Try using more than one keyword.', 'lovely');?></li>
                        </ul>
                    </div>
                </div><?php
        } ?>
    </div>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>