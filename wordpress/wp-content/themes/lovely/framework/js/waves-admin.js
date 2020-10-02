jQuery(document).ready(function(){
    "use strict";
    
    jQuery('.form-field .radio-images').each(function(){
        jQuery(this).click( function() {
                jQuery(this).closest('.type-radio').find('img.radio-image').removeClass('radio-image-selected');
                jQuery(this).find('img.radio-image').toggleClass('radio-image-selected');
                jQuery(this).find('.option-tree-ui-radio').prop('checked', true);
        });
    });
    
    
});
function showHidePostFormatField(){
    "use strict";
    var $CFrmt=jQuery('#post-formats-select input:radio:checked');
    if($CFrmt.length){
        jQuery('#page_options .ot-metabox-nav [href="#setting_'+$CFrmt.val().replace("0", "general")+'"]').click();  
    }
}
jQuery(window).load(function(){
    "use strict";
    /* Post format */
    showHidePostFormatField();
    jQuery('#post-formats-select input').change(showHidePostFormatField);
});