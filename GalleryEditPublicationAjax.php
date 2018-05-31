<?php /* Template Name: Gallery Edit Publication Ajax */ ?>
<?php
    $subdomain = array_shift((explode('.', $_SERVER['HTTP_HOST'])));
?>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $img_id_array = array();
    $img_id_array = $_POST['id_arr'];
?>
<div id="quick_share1" style="height:100%;">
    <div style="display: none;" id="temp_data"></div>
    <form id="preview_done" method="post" action="" enctype="multipart/form-data" style="height:100%;">
        <div class="bxslider_preview_edit" style="margin-bottom: 10px;height:89%;">
            <?php $i = 1; ?>
            <?php foreach($img_id_array as $img) { ?>
                <!--<h2 style="text-align: center;"><?php /*echo 'Page '.$i; */?></h2>-->
                <?php
                $imgSource = wp_get_attachment_image_src( get_post_thumbnail_id($img) );
                $imgSource1 = wp_get_attachment_image_src( get_post_thumbnail_id($img), 'full' );
                $height = (($imgSource1[2]/$imgSource1[1])*228) + 25;
                $width = ($imgSource1[1]/$imgSource1[2])*228;
                ?>
                <?php //$imgSource = $b64image = base64_encode(file_get_contents(wp_get_attachment_url( get_post_thumbnail_id($img) ))); //data:image/jpeg;base64, ?>
                <div class="preview_img_edit_wrapper" style="height:100%;">
                <!--<div class="preview_img_edit_wrapper" style="height: <?php echo $height; ?>px;">-->
                    <?php echo 'Page: '.$i; ?><br>
                    <div class="preview_img_edit">
                        <div data-id="<?php echo $i; ?>" style="height:100%;">
                            <img id="edit-me" class="img-responsive" src="<?php echo $imgSource1[0]; ?>" />
                            <img class="dummyImg dummy<?php echo $i; ?>" src="<?php echo $imgSource1[0]; ?>" />
                        </div>
                        <div class="preview_img_hover">Click Image to edit</div>
                    </div>
                    <!--<div>
    <textarea class="tm" name="preview_pdf[]"><img style="position: absolute; top: 0; left: 0; width: 100%; height: auto; z-index: -10;" src="<?php /*echo $imgSource; */?>" /><div style="position: absolute; top: 0; left: 0; z-index: 9999; width: 100%; height: 100%;"></div></textarea>
</div>-->
                    <input class='preview_pdf_<?php echo $i; ?>' type='hidden' name='preview_pdf[]' value='<?php echo get_post_thumbnail_id($img); ?>'>
                </div>
                <?php $i++; ?>
            <?php } ?>
            <div style="clear: both;"></div>
        </div>
        <div style="text-align: center; margin: 20px 0;"><input class="submit_button" type="submit" value="Done" name="done" /></div>
    </form>
</div>
<div id="quick_share2"></div>
<div id="Editloading" style="text-align: center; display: none;">
    <img src="<?php bloginfo('template_directory'); ?>/images/loading_spinner.gif"/>
</div>
<script>
/*jQuery('.bxslider_preview_edit').bxSlider({
    pager: true,
    controls: false
});*/
</script>
<style>
    textarea.tm {
        margin: 0 auto;
        width: 80%;
    }
</style>
<script>
jQuery(document).ready(function() {
    jQuery('#preview_done').submit(function(event) {
        jQuery('#preview_done').hide();
        jQuery('#Editloading').show();
        event.preventDefault();
        tinyMCE.triggerSave();
        var arr = [];
        jQuery('input[name^="preview_pdf"]').each(function() {
            var valid;
            valid = jQuery(this).val();
            arr.push(valid);
        });
        var template_id = <?php echo $_POST['template_id']; ?>;
        var formData = {
            'preview_pdf' : arr,
            'template_id' : template_id
        };
        jQuery.ajax({
          url: "<?php if ($subdomain != 'dijivu') { echo substr_replace(get_bloginfo('url'), $subdomain.'.', strpos(get_bloginfo('url'), '/') + 2, 0); }else echo get_bloginfo('url'); ?>/gallery-edit-publication-ajax-3/",
          data: formData,
          type: 'POST',
          success: function(response){
            jQuery('#quick_share2').html(response);
              jQuery('#quick_share1').hide();
              jQuery('#quick_share2').show();
              jQuery('#preview_done').show();
              jQuery('#Editloading').hide();
          }
        });
    });
});
</script>
<script>
    function EditButton() {
        jQuery('#Editloading').show();
        jQuery('#quick_share1').show();
        jQuery('#quick_share2').hide();
        jQuery('#Editloading').hide();
    }
</script>
<?php } ?>
