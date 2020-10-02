<div class="bottom-area footer-3">
    <div class="container">
        <div class="row">
            <?php
            $i = 1;
            while($i <= 4){
                echo '<div class="col-md-3">';
                    if(!dynamic_sidebar("footer-sidebar-$i")){
                        echo '<div class="widget">';
                            echo '<h3 class="widget-title">';
                                printf(esc_html__('Footer sidebar %s','lovely'),esc_attr($i));
                            echo '</h3>';
                            echo wp_kses(sprintf(__('There is no widget. You should add your widgets into <strong>Footer sidebar %s</strong> sidebar area on <strong>Appearance => Widgets</strong> of your dashboard.','lovely'),esc_attr($i)),array('strong' => array()));
                        echo '</div>';
                    }
                echo '</div>';
                $i++;
            }
            ?>
        </div>
    </div>
</div>
<footer class="footer-area footer-3">
    <!-- Start Container -->
    <div class="container">
        <div class="tw-footer clearfix">
        <?php 
            $copyright = lovely_option("copyright");
            $footertext = lovely_option("footertext");
            if(!empty($copyright)){
                echo '<p class="copyright">'.$copyright.'</p>';
            }
            if(!empty($footertext)){
                echo '<p class="footer-text">'.$footertext.'</p>';
            }
        ?>
        </div>
    </div>
    <!-- End Container -->
</footer>