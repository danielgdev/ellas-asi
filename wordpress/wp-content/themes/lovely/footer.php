</div>
<!-- End Lovely Container -->
<?php 
    $header = lovely_option('footer');
    get_template_part('footer-area', substr($header, -1));
?>    
</div>
<?php wp_footer(); ?>
</body>
</html>