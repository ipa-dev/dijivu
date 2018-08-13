<?php /* Template Name: Gallery Edit Publication Ajax 2 */ ?>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    /*$text_arr = array();
    $text_arr1 = array();
    $text_arr = $_POST['preview_pdf'];*/

    /*require_once (dirname(__FILE__).'/html2pdf/vendor/autoload.php');
    $html2pdf = new HTML2PDF('P','A4','en');

    foreach ($text_arr as $text) {
        $text = stripslashes($text);
        //echo '<pre>'.$text.'</pre>';
        if (get_magic_quotes_gpc()) {
            $text = stripslashes($text);
        } else {
            $text = $text;
        }
        $content .= '<page style="background-color: #000000;">'.$text.'</page>';
        array_push($text_arr1, utf8_encode($text));
    }

    $html2pdf->WriteHTML($content);
    $upload_dir = wp_upload_dir();
    $writePath = $upload_dir['basedir'].'/ebooks/';
    $date = date('Ymd');
    $time = time();
    $pdfName =$date.'_'.$time.'_'.'GalleryPDF.pdf';
    $html2pdf->Output($writePath.$pdfName,'F');*/

    /*if(!empty($text_arr)) {
        $html = '<html><head></head><body style="margin: 0;">';
        foreach ($text_arr as $text) {
            $get_image = wp_get_attachment_image_src($text, 'full');
            $html .= '<div style="position: relative; width: 100%; height: 100%; page-break-inside: avoid;"><img style="width: 100%;" src="'.$get_image[0].'"/></div>';
        }
        $html .= '</body></html>';

        //echo '<pre>'.$html.'</pre>';

        $upload_dir = wp_upload_dir();
        $writePath = $upload_dir['basedir'].'/ebooks/';
        $date = date('Ymd');
        $time = time();
        $htmlName = $date.'_'.$time.'_'.'GalleryPDF.html';

        $myfile = fopen($writePath.$htmlName, "w") or die("Unable to open file!");
        fwrite($myfile, $html);
        fclose($myfile);

        $pdfName = $date.'_'.$time.'_'.'GalleryPDF.pdf';
        $htmlName1 = $writePath.$htmlName;
        $pdfName1 = $writePath.$pdfName;
        $cmd = "wkhtmltopdf -T 0 -B 0 -L 0 -R 0 $htmlName1 $pdfName1";
        exec($cmd, $output);
        //echo $output;
        //echo '<div style="display: none;">'.$cmd.'</div>';
    }*/

    $id_arr = array();
    $id_arr = $_POST['preview_pdf'];

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
        $imgSource = wp_get_attachment_url( $id );
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
        <input type="hidden" name="img" value="<?php echo $_POST['img']; ?>" />
        <input type="hidden" name="preview_pdf" value='<?php echo json_encode($id_arr); ?>' />
        <p><input class="submit_button" type="submit" name="upload" value="Upload" /></p>                       
    </form>
    <div id="Editloading" style="text-align: center; display: none;">
        <img src="<?php bloginfo('template_directory'); ?>/images/loading_spinner.gif"/>
    </div>
<script>
jQuery(document).ready(function() {
    jQuery('#pdf_upload').submit(function(event) {
        jQuery('#pdf_upload').hide();
        jQuery('#Editloading').show();
        event.preventDefault();
        var formData = {
            'upload_pdf' : jQuery('input[name=upload_pdf]').val(),
            'pdf_name' : jQuery('input[name=pdf_name]').val(),
            'pdf_des' : jQuery('textarea[name=pdf_des]').val(),
            'status' : jQuery('select[name=status]').val(),
            'cat' : jQuery('select[name=cat]').val(),
            'img' : '<?php echo $id_arr[0]; ?>',
            'preview_pdf' : jQuery('input[name=preview_pdf]').val()
        };
        jQuery.ajax({
          url: "<?php bloginfo('url'); ?>/gallery-create-publication-2-ajax/",
          data: formData,
          type: 'POST',
          success: function(response){
            //jQuery('#quick_upload').html(response);
            location.href = response;
          }
        });
    });
});
</script>
</div>
<?php } ?>