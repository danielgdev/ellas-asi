<?php get_header();
global $lovely_options;
$lovely_options['layout'] = lovely_option("layout", "simple-side");
$lovely_options['more_text'] = lovely_option("more_text", "Read more");
$lovely_options['excerpt_count'] = lovely_option("excerpt_count");
$lovely_options['pagination'] = "simple";

$full = array('simple', 'grid', 'list', 'simple-full', 'grid-full', 'list-full');
$grid = array('grid', 'grid-side', 'grid-full');
$list = array('list', 'list-side', 'list-full');

$width = ' col-md-8';
if(in_array($lovely_options['layout'], $full)){
    if(in_array($lovely_options['layout'], array('simple-full', 'grid-full', 'list-full'))){
        $width = ' col-md-12';        
    }
}
?>
<div class="row"> 
    <div class="content-area <?php echo esc_attr($lovely_options['layout'].$width);?>">
        <?php 
        if(in_array($lovely_options['layout'], $grid)){
            get_template_part("content", "grid");
        } elseif(in_array($lovely_options['layout'], $list)){
            get_template_part("content", "list");
        } else {
            get_template_part("content");
        }        
        ?>
    </div>
    <?php 
        if(!in_array($lovely_options['layout'], $full)){
            get_sidebar();
        }
    ?>
</div>
<?php get_footer();