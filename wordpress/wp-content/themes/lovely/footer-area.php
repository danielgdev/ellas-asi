<div class="bottom-area">
    <?php if(!dynamic_sidebar("footer-sidebar")) ?>
</div>
<footer class="footer-area">
    <div class="footer-socials">
        <div class="container">
            <?php echo lovely_footer_socials(true); ?>
        </div>
    </div>
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