<div class="sidebar-area col-md-4">
    <div class="sidebar-inner clearfix">
        <?php
        if(!dynamic_sidebar('default-sidebar')) {
            echo wp_kses(__('There is no widget. You should add your widgets into <strong>Default</strong> sidebar area on <strong>Appearance => Widgets</strong> of your dashboard. <br/><br/>','lovely'),array('strong'=>array(),'br'=>array())); ?>
            <aside id="archives" class="widget">
                <div class="tw-widget-title-container">
                    <h3 class="widget-title"><?php esc_html_e('Archives', 'lovely'); ?></h3>
                    <span class="tw-title-border"></span>
                </div>
                <ul class="side-nav">
                    <?php wp_get_archives(array('type' => 'monthly')); ?>
                </ul>
            </aside>
        <?php } ?>
    </div>
</div>