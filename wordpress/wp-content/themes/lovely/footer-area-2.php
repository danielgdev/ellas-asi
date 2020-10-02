<div class="bottom-area">
    <?php if(!dynamic_sidebar("footer-sidebar")) ?>
</div>
<footer class="footer-area footer-2">
    <div class="footer-socials">
        <div class="container">
            <?php echo lovely_footer_socials(); ?>
        </div>
    </div>
    <!-- Start Container -->
    <div class="container">
        <div class="tw-footer clearfix">
        <?php 
            $logo = lovely_option("footer_logo");
            if ( !empty($logo) ) {
                echo '<div class="footer-logo">';
                    echo '<a class="logo" href="' . esc_url(home_url('/')) . '">';
                        echo '<img class="logo-img" src="' . esc_url($logo) . '" alt="' . esc_attr(get_bloginfo('name')) . '"/>';
                    echo '</a>';
                echo '</div>';
            }
        
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