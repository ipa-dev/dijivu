<?php /* Template Name: Quick Upload */ ?>
<?php get_header(); ?>
<style>
#header, #footer, #copy {
    display: none;
}
</style>
<div id="quick_upload">
    <form id="pdf_upload" action="" method="post" enctype="multipart/form-data">
        <p><input type="file" name="upload_pdf" accept="application/pdf" /></p>
        <p>
            <select name="status">
                <option value="private">Private</option>
                <option value="publish">Publish</option>
            </select>
        </p>
        <p><input type="submit" name="upload" value="Upload" /></p>                       
    </form>
    <div class="progress"><div class="bar"></div ></div>
    <div class="percent">0%</div >        
    <div id="status"></div>
</div>
<?php
if(isset($_POST['pdf_details_sub'])) {
    $my_post = array(
        'ID'           => $_POST['pub_id'],
        'post_title'   => $_POST['pdf_name'],
        'post_content' => $_POST['pdf_des'],
    );
    wp_update_post( $my_post );
}                     
global $user_ID;
if(isset($_POST['upload'])) {
$pdf_file_exts = array("pdf");
$pdf_file_name = preg_replace("/[\s]+/", "", $_FILES['upload_pdf']['name']);
$pdf_file_name_array = explode(".", $_FILES['upload_pdf']['name']);
$pdf_file_name_org = $pdf_file_name_array[0];
$uploaded_pdf_file_exts = end(explode(".", $_FILES['upload_pdf']['name']));
?>        
<p class="successMsg up_com" style="display: none;">Upload Completed Succesfully</p>
<div id="upload_details" style="display: none;">
    <form id="pdf_upload_details" method="post" action="">
        <p><label>Title: </label><br /><input name="pdf_name" type="text" value="<?php echo $pdf_file_name_org; ?>" placeholder="Title" required="required" /></p>
        <p><label>Description: </label><br /><textarea name="pdf_des" required="required"></textarea></p>
        <input type="hidden" name="pub_id" value="<?php echo $new_post_id; ?>" />
        <p><input type="submit" name="pdf_details_sub" value="Submit" /></p>
    </form>
</div>
<?php
    if (($_FILES['upload']["size"] < 4000000) && in_array($uploaded_pdf_file_exts, $pdf_file_exts)){
        $date = date('Ymd');
        $time = time();
        $filename = $date.'_'.$time.'_'.($pdf_file_name);
        $upload_dir = wp_upload_dir();
        $uploaddir = $upload_dir['basedir'].'/ebooks/';
        $file = $uploaddir . $date.'_'.$time.'_'.($pdf_file_name);
        if (move_uploaded_file($_FILES['upload_pdf']['tmp_name'], $file)) {       
            $post_arg = array(
                'post_title'    => $pdf_file_name_org,
                'post_content'  => '',
                'post_type'     => 'pub',
                'post_author'   => $user_ID,
                'post_date'     => date('Y-m-d H:i:s'),
                'comment_status' => 'closed',
                'post_status'   => $_POST['status']
            );
            $new_post_id = wp_insert_post( $post_arg );
            add_post_meta($new_post_id, 'upload_pdf', $filename);
        }
    }
}
?>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    jQuery(document).ready(function() {
        var bar = jQuery('.bar');
        var percent = jQuery('.percent');
        var status = jQuery('#status');
        jQuery('form#pdf_upload').ajaxForm({
            beforeSend: function() {
                status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            success: function() {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);
                jQuery('.up_com').show();
                jQuery('#quick_upload').hide();
                jQuery('#upload_details').show();
            },
            complete: function(xhr) {
                status.html(xhr.responseText);
                //window.location.href = window.location.href + "?status=upload_complete";
            }
        });
    });
    jQuery(document).ready(function() {
        jQuery('form#upload_details').ajaxForm({
            beforeSend: function() {
            },
            success: function() {
                jQuery.fancybox.close();
            },
            complete: function(xhr) {
            }
        });
    });
</script>
<?php get_footer(); ?>