<?php if(is_user_logged_in()) { ?>
<div id="quick_upload">
    <form id="pdf_upload" action="<?php bloginfo('url'); ?>/create-publication-from-pdf-file/" method="post" enctype="multipart/form-data">
        <p><label>Upload File: </label><input type="file" name="upload_pdf" accept="application/pdf" required="required" /></p>
        <p><label>Title: </label><input name="pdf_name" type="text" value="" placeholder="Title" required="required" /></p>
        <p><label>Description: </label><textarea name="pdf_des" required="required"></textarea></p>
        <p>
            <label>Select Status: </label>
            <select name="status">
                <option value="private1">Private</option>
                <option value="publish">Publish</option>
            </select>
        </p>
        <p>
            <label>Category: </label>
            <select name="cat">
                <?php
                    $taxonomy = 'pub_category';
                    $tax_terms = get_terms($taxonomy, array(
                        'hide_empty' => 0,
                        'parent' => 0,
                        'orderby' => 'slug',                                                        
                    ));
                ?>
                <?php
                    foreach ($tax_terms as $tax_term) {
                    echo '<optgroup label="'.$tax_term->name.'">';
                    $terms = get_terms($taxonomy, array('parent' => $tax_term->term_id, 'orderby' => 'slug', 'hide_empty' => 0));
                    foreach ($terms as $term) {
                        echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
                    }
                    echo '</optgroup>';
                    }
                ?>
            </select>
        </p>
        <p><input class="submit_button" type="submit" name="upload" value="Upload" /></p>                       
    </form>
    <div style="display: none;" class="progress"><div class="bar"></div ></div>
    <div style="display: none;" class="percent">0%</div > 
    <div style="display: none; text-align: center; font-size: 50px;" class="processing"><i class="fa fa-spinner fa-pulse"></i></div >       
    <div id="status"></div>
</div>
<?php

?>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    jQuery(document).ready(function() {
        var bar = jQuery('.bar');
        var percent = jQuery('.percent');
        var status = jQuery('#status');
        jQuery('form#pdf_upload').ajaxForm({
            beforeSend: function() {
                jQuery('#pdf_upload').hide();
                jQuery('.progress').show();
                jQuery('.percent').show();
                jQuery('.submit_button').hide();
                status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                if(percentComplete <= 99) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal)
                    percent.html(percentVal);                    
                } else {
                    jQuery('.progress').hide();
                    jQuery('.percent').hide();
                    jQuery('.processing').show();
                }
            },
            success: function() {
                var percentVal = '100%';
                bar.width(percentVal);
                percent.html(percentVal);
                jQuery.fancybox.close();
            },
            complete: function(xhr) {
                status.html(xhr.responseText);
                jQuery('.up_com').show();
                jQuery('#quick_upload').hide();
                jQuery('#upload_details').show();
                window.location.href = window.location.href + "?status=upload_complete";
            }
        });
    });
</script>
<!--<script>
    jQuery(document).ready(function() {
        jQuery('#pdf_upload').submit(function(event) {
            jQuery('#pdf_upload').hide();
            jQuery('.processing').show();
            event.preventDefault();
            var formData = {
                'upload_pdf' : jQuery('input[name=upload_pdf]').val(),
                'pdf_name' : jQuery('input[name=pdf_name]').val(),
                'pdf_des' : jQuery('textarea[name=pdf_des]').val(),
                'status' : jQuery('select[name=status]').val(),
                'cat' : jQuery('select[name=cat]').val(),
            };
            jQuery.ajax({
                url: "<?php /*bloginfo('url'); */?>/create-publication-from-pdf-file/",
                data: formData,
                type: 'POST',
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(response){
                    jQuery('.processing').show();
                    jQuery('#quick_upload').html(response);
                    //location.href = response;
                }
            });
        });
    });
</script>-->
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>