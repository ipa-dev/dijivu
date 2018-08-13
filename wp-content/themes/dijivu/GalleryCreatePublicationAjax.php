<?php /* Template Name: Gallery Create Publication Ajax */ ?>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $id_arr = array();
    $id_arr = $_POST['id_arr'];
    
    require_once(TEMPLATEPATH.'/fpdf/fpdf.php');

    $pdf = new FPDF('P','pt','Letter');
    // THESE VARS WILL BE SET DYNAMICALLY
    $pdf->SetTitle('',1);
    $pdf->SetAuthor('',1);
    $pdf->SetSubject('',1);
    $pdf->SetCompression(1);
    
    // LETTER size pages
    // UNIT IS POINTS, 72 PTS = 1 INCH
    $pageW = 612 - 36; // 8.5 inches wide with .25 margin left and right
    $pageH = 792 - 36; // 11 inches tall with .25 margin top and bottom
    $fixedMargin = 18; // .25 inch
    $threshold = $pageW / $pageH;
    
    // IF IMAGE W÷H IS UNDER THRESHOLD, CONSTRAIN THE HEIGHT
    // IF IMAGE W÷H IS OVER THRESHOLD, CONSTRAIN THE WIDTH
    
    $upload_dir = wp_upload_dir();
    $writePath = $upload_dir['basedir'].'/ebooks/';
    
    function sizeImage($thisImage) {
       global $pageW,$pageH,$fixedMargin,$threshold;
    
       list($thisW,$thisH) = getimagesize($thisImage);
        
        if($thisW<=$pageW && $thisH<=$pageH){
           // DO NOT RESIZE IMAGE, JUST CENTER IT HORIZONTALLY
            $newLeftMargin = centerMe($thisW);
            $leftMargin = $newLeftMargin;
          return array('leftMargin' => $leftMargin, 'width' => $thisW);
        } else {
            $thisThreshold = $thisW / $thisH;
          if($thisThreshold>=$threshold) {
             $width = $pageW;
             $leftMargin = $fixedMargin;
          } else {
             $thisMultiplier = $pageH / $thisH;
             $width = $thisW * $thisMultiplier;
             $width = round($width, 0, PHP_ROUND_HALF_DOWN);
             // CENTER ON PAGE IF NOT FULL WIDTH
             $newLeftMargin = centerMe($width);
             $leftMargin = $newLeftMargin;
          }
          return array('leftMargin' => $leftMargin, 'width' => $width);
       }
    }
    
    function centerMe($thisWidth){
       global $pageW;
       $newMargin = ($pageW - $thisWidth) / 2;
       $newMargin = round($newMargin, 0, PHP_ROUND_HALF_DOWN);
       return $newMargin;
    }
    
    // THIS VAR WILL BE POPULATED DYNAMICALLY BUT HARD CORDED FOR THIS EXAMPLE
    $imageLIST = array();
    
    foreach($id_arr as $id) {
        $imgSource = wp_get_attachment_url( get_post_thumbnail_id($id) );
        array_push($imageLIST, $imgSource);
    }
    
    foreach ($imageLIST as $value) {
       $currentImage = $value;
       $reSized = sizeImage($currentImage);
       $width = $reSized['width'];
        $leftMargin = $reSized['leftMargin'];
       $pdf->AddPage();
       $pdf->Image($currentImage,$leftMargin,18,$width);
    
    } // LOOP
    $date = date('Ymd');
    $time = time();
    $pdfName =$date.'_'.$time.'_'.'GalleryPDF.pdf';
    $pdf->Output($writePath.$pdfName,'F');  
?>
<div id="quick_upload">
    <form id="pdf_upload" action="" method="post" enctype="multipart/form-data">
        <p style="display: none;"><label>Upload File: </label><input type="hidden" value="<?php echo $pdfName; ?>" name="upload_pdf" required="required" /></p>
        <p><label>Title *: </label><input name="pdf_name" type="text" value="" placeholder="Title" required="required" /></p>
        <p><label>Description *: </label><textarea name="pdf_des" required="required"></textarea></p>
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
    <!--
    <form id="preview_edit">  
        <?php
            //$img_array = json_encode($id_arr);
        ?>
        <input type='hidden' value='<?php //echo encripted($img_array); ?>' name='img_ids' />  
        <?php //if(isset($_POST['template_assigned'])) { ?><p><input class="submit_button" type="submit" name="edit" value="Preview & Edit" /></p><?php //} ?>
    </form>
    -->    
<script>
jQuery(document).ready(function() {
    jQuery('#pdf_upload').submit(function(event) {
        event.preventDefault();
        var formData = {
            'upload_pdf' : jQuery('input[name=upload_pdf]').val(),
            'pdf_name' : jQuery('input[name=pdf_name]').val(),
            'pdf_des' : jQuery('textarea[name=pdf_des]').val(),
            'status' : jQuery('select[name=status]').val(),
            'cat' : jQuery('select[name=cat]').val(),
            'img' : '<?php echo get_post_thumbnail_id($id_arr[0]); ?>',
            'no_preview': 1
        };
        jQuery.ajax({
          url: "<?php bloginfo('url'); ?>/gallery-create-publication-2-ajax/",
          data: formData,
          //dataType: "json",
          type: 'POST',
          success: function(response){
            //var json = jQuery.parseJSON(response);
            //jQuery('#quick_upload').html(response);
            //jQuery('#quick_upload').html(response.html);
            location.href = response;
          }
        });
    });
    /*
    jQuery('#preview_edit').submit(function(event) {
        event.preventDefault();
        var formData = {
            'img_ids' : jQuery('input[name=img_ids]').val(),
        };
        jQuery.ajax({
          url: "/gallery-edit-publication-ajax/",
          data: formData,
          type: 'POST',
          success: function(response){
            jQuery('#quick_upload').html(response);
          }
        });
    });
    */    
});
</script>
</div>
<?php } ?>