/**
 * Created by hungphongbk on 4/15/16.
 */
jQuery(document).ready(function($) {
    $(document).on("click", ".upload_image_button", function() {
        jQuery.data(document.body, 'prevElement', $(this).prev());

        window.send_to_editor = function(html) {
            var imgurl = jQuery(html).attr('src');
            console.log(imgurl);
            var inputText = jQuery.data(document.body, 'prevElement');

            if(inputText != undefined && inputText != '')
            {
                inputText.val(imgurl);
            }

            tb_remove();
        };

        tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
        return false;
    });
});