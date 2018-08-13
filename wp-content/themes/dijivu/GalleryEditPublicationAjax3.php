<?php /* Template Name: Gallery Edit Publication Ajax 3 */ ?>
<?php
    $subdomain = array_shift((explode('.', $_SERVER['HTTP_HOST'])));
?>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
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

    global $user_ID;
    $post_arg = array(
        'post_title'    => 'No Name',
        'post_content'  => '',
        'post_type'     => 'pub',
        'post_author'   => $user_ID,
        'post_date'     => date('Y-m-d H:i:s'),
        'comment_status' => 'closed',
        'post_status'   => 'draft'
    );
    $new_post_id = wp_insert_post( $post_arg );
    add_post_meta($new_post_id, 'fav', '');
    add_post_meta($new_post_id, 'upload_pdf', $pdfName);
    set_post_thumbnail( $new_post_id , $id_arr[0] );
    add_post_meta($new_post_id, 'created_from_gallery', 1);
    add_post_meta($new_post_id, 'html', json_encode($id_arr));
    if(isset($_POST['template_id'])) {
        add_post_meta($new_post_id, 'template', $_POST['template_id']);
    }

    ?>
    <div id="quick_upload">
    <p class="successMsg">Publication created successfully...</p>
    <p><iframe style="width:100%;height:500px" src="<?php bloginfo('url'); ?>/pub-emb/?puid=<?php echo $new_post_id; ?>"  seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" ></iframe></p>
        <form id="pdf_upload" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?php echo $new_post_id; ?>" name="pub_id" required="required" />
            <a style="float: left;" class="submit_button" onclick="EditButton();" href="javascript:void(0);">Edit</a>
            <input style="float: right;" class="submit_button" type="submit" name="upload" value="Done" />
        </form>
    </div>

    <script>
        jQuery('#pdf_upload').submit(function(event) {
            jQuery('#pdf_upload').hide();
            jQuery('#Editloading').show();
            event.preventDefault();
            var formData = {
                'pub_id' : jQuery('input[name=pub_id]').val(),
            };
            jQuery.ajax({
                url: "<?php if ($subdomain != 'dijivu') { echo substr_replace(get_bloginfo('url'), $subdomain.'.', strpos(get_bloginfo('url'), '/') + 2, 0); }else echo get_bloginfo('url'); ?>/gallery-edit-publication-ajax-4/",
                data: formData,
                type: 'POST',
                success: function(response){
                    jQuery('#quick_share').html(response);
                    jQuery('#Editloading').hide();
                }
            });
        });
    </script>
<?php } ?>