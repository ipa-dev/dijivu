<?php /* Template Name: Edit Publication Gallery */ ?>
<?php if(is_user_logged_in()) { ?>
<?php get_header(); ?>
<div style="display: none;" id="temp_data"></div>

<!--<script>
tinymce.init({
    selector:'textarea.tm',
    height : "350",
    menubar: "edit format view",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace visualblocks code fullscreen",
        "insertdatetime media table contextmenu paste imagetools layer",
        "textcolor"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor | add_button | change_bg",
    imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
    content_css: [
        '//www.tinymce.com/css/codepen.min.css',
        '<?php /*bloginfo('template_directory'); */?>/css/tinyMCE.css'
    ],
    setup: function (editor) {
        editor.addButton('add_button', {
            text: 'Add button',
            icon: false,
            /*onclick: function () {
             editor.insertContent('&nbsp;<div style="display: inline-block; padding: 10px 20px; font-size: 16px; border-radius: 10px; color: #ffffff; background: #0A246A;">Add text Here</div>&nbsp;');
             }*/
            onclick : function() {
                //console.log(editor);
                editor.windowManager.open({
                    title: 'Add button',
                    body: [
                        {type: 'textbox', name: 'source', label: 'Source'},
                        {type: 'textbox', name: 'link', label: 'Link'},
                        {type: 'colorpicker', name: 'color', label: 'Select Button Color'},
                    ],
                    onsubmit: function(e) {
                        //console.log(e);
                        editor.focus();
                        editor.selection.setContent('&nbsp;<a href="' + e.data.link + '" style="display: inline-block; padding: 10px 20px; font-size: 16px; border-radius: 10px; color: #ffffff; text-decoration: none; background:' + e.data.color + ';">' + e.data.source + '</a>&nbsp;');
                    }
                });
            }
        });
        /*editor.addButton('change_bg', {
         text: 'Change BG From Selected ',
         icon: false,
         onclick: function () {
         console.log(editor);
         }
         });*/
    },
    relative_urls: false,
    //extended_valid_elements:'script[language|type|src]',
    remove_script_host: false
});
</script>-->
<?php global $user_ID; ?>
<?php $user_info = get_userdata($user_ID); ?>
<div id="my_account">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_2_of_12">
                <?php get_sidebar('accnav'); ?>                                      
	        </div>
	        <div class="col span_10_of_12">                
                <div id="acc_section">
                    <?php if(isset($_POST['done'])) { ?>
                    <?php
                    /*$text_arr = $_POST['preview_pdf'];

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
                    exec($cmd, $output);*/

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
                        <p><label>Title: </label><input name="pdf_name" type="text" value="<?php echo get_the_title($_GET['pid']); ?>" placeholder="Title" required="required" /></p>
                        <p><label>Description: </label><textarea name="pdf_des" required="required"><?php $pub_cont = get_post($_GET['pid']); echo $pub_cont->post_content; ?></textarea></p>
                        <p>
                            <label>Select Status: </label>
                            <select name="status">
                                <option<?php if(get_post_status($_GET['pid']) == 'private1') { echo ' selected="selected"'; } ?> value="private1">Private</option>
                                <option<?php if(get_post_status($_GET['pid']) == 'publish') { echo ' selected="selected"'; } ?> value="publish">Publish</option>
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
                                $term_array = wp_get_post_terms($_GET['pid'], 'pub_category');
                                ?>
                                <?php
                                foreach ($tax_terms as $tax_term) {
                                    echo '<optgroup label="'.$tax_term->name.'">';
                                    $terms = get_terms($taxonomy, array('parent' => $tax_term->term_id, 'orderby' => 'slug', 'hide_empty' => 0));
                                    foreach ($terms as $term) {
                                        foreach($term_array as $post_term) {
                                            if($post_term->term_id == $term->term_id) {
                                                echo '<option selected="selected" value="'.$term->term_id.'">'.$term->name.'</option>';
                                            } else {
                                                echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
                                            }
                                        }
                                    }
                                    echo '</optgroup>';
                                }
                                ?>
                            </select>
                        </p>
                        <input type="hidden" name="preview_pdf" value='<?php echo json_encode($id_arr); ?>' />
                        <input type="hidden" name="img" value="<?php echo $id_arr[0]; ?>" />
                        
                        <input style="float: left;" class="submit_button" type="submit" name="upload" value="Update" />                      
                    </form>
                    <?php } elseif(isset($_POST['upload'])) {  ?>
                    <?php
                    $post_arg = array(
                        'ID' => $_GET['pid'],
                        'post_title'    => $_POST['pdf_name'],
                        'post_content'  => $_POST['pdf_des'],
                        'post_type'     => 'pub',
                        'post_author'   => $user_ID,
                        'post_date'     => date('Y-m-d H:i:s'),
                        'comment_status' => 'closed',
                        'post_status' => $_POST['status']
                    );
                    $new_post_id = $_GET['pid'];
                    wp_update_post( $post_arg );
                    update_post_meta($new_post_id, 'fav', '');
                    update_post_meta($new_post_id, 'upload_pdf', $_POST['upload_pdf']);                
                    wp_set_post_terms( $new_post_id, $_POST['cat'], 'pub_category' );
                    update_post_meta($new_post_id, 'created_from_gallery', 1);
                    update_post_meta($new_post_id, 'html', $_POST['preview_pdf']);
                    set_post_thumbnail( $new_post_id , $_POST['img'] );
                    ?>
                    <p class="successMsg">Publication updated successfully...</p>
                    <p><iframe style='width:100%;height:500px' src='<?php bloginfo('url'); ?>/pub-emb/?puid=<?php echo $new_post_id; ?>'  seamless='seamless' scrolling='no' frameborder='0' allowtransparency='true' allowfullscreen='true' ></iframe></p>
                    <a style="float: left;" class="submit_button" href="<?php bloginfo('url'); ?>/edit-pub-gallery/?pid=<?php echo $_GET['pid']; ?>">Edit</a>
                    <?php } elseif(isset($_POST['delete'])) { 
                        wp_delete_post( $_GET['pid'] );
                        header('Location: '.get_bloginfo('home').'/my-account');
                    } else { ?>
                    <?php
                        $html_array = array();
                        $html_array = json_decode(get_post_meta($_GET['pid'], 'html', true));
                    ?>
                    <form id="preview_done" method="post" action="" enctype="multipart/form-data">
                        <div class="bxslider_preview_edit" style="margin-bottom: 10px;">
                            <?php $i = 1; ?>
                            <?php foreach($html_array as $img) { ?>
                                <?php
                                    $get_image = wp_get_attachment_image_src($img, 'full');
                                    $height = (($get_image[2]/$get_image[1])*228) + 25;
                                ?>
                                <?php //$imgSource = $b64image = base64_encode(file_get_contents(wp_get_attachment_url( get_post_thumbnail_id($img) ))); //data:image/jpeg;base64, ?>
                            <div class="preview_img_edit_wrapper" style="height: <?php echo $height; ?>px;">
                                <?php echo 'Page: '.$i; ?><br>
                                <div class="preview_img_edit">
                                    <?php
                                    $imageJSON = str_replace('data:text/json;charset=utf-8,', '', urldecode(get_post_meta($img, 'image_json', true)));
                                    $imageJSON1 = get_post_meta($img, 'image_json', true);
                                    if(empty(get_post_meta($img, 'image_json', true))) {
                                        $imageJSON = '';
                                        $imageJSON1 = $get_image[0];
                                    }
                                    ?>
                                    <div style="display: none;" id="JSONdata<?php echo $i; ?>"><?php echo $imageJSON; ?></div>
                                    <div data-id="<?php echo $i; ?>">
                                        <img id="edit-me<?php echo $i; ?>" class="img-responsive" src="<?php echo $get_image[0]; ?>" />
                                        <img class="dummyImg dummy<?php echo $i; ?>" src="<?php echo $get_image[0]; ?>" />
                                    </div>
                                    <div class="preview_img_hover">Click Image to edit</div>
                                </div>
                                <!--<div>
    <textarea class="tm" name="preview_pdf[]"><img style="position: absolute; top: 0; left: 0; width: 100%; height: auto; z-index: -10;" src="<?php /*echo $imgSource; */?>" /><div style="position: absolute; top: 0; left: 0; z-index: 9999; width: 100%; height: 100%;"></div></textarea>
</div>-->
                                <input class='preview_pdf_<?php echo $i; ?>' type='hidden' name='preview_pdf[]' value='<?php echo $img; ?>'>
                                <script>
                                    var editorStateJSON<?php echo $i; ?> = jQuery('#JSONdata<?php echo $i; ?>').text();
                                    jQuery('#JSONdata<?php echo $i; ?>').text('');
                                    var myPixie<?php echo $i; ?> = Pixie.setOptions({
                                        onSaveButtonClick: function() {
                                            myPixie<?php echo $i; ?>.save('jpeg', 10);
                                        },
                                        onSave: function(data, img) {
                                            jQuery('#preview_done').hide();
                                            jQuery('#Editloading').show();
                                            setTimeout(function(){
                                                var image_json = jQuery('#temp_data').text();
                                                jQuery('#temp_data').text('');
                                                //console.log(image_json);
                                                jQuery.ajax({
                                                    type: 'POST',
                                                    url: "<?php bloginfo('url'); ?>/save-image-ajax",
                                                    data: { imgData: data, image_json: image_json },
                                                }).success(function(response) {
                                                    var json_obj = jQuery.parseJSON(response);
                                                    var counter = parseInt(jQuery(img).parent().attr('data-id'));
                                                    jQuery('.dummy'+counter).attr('src', json_obj['img']);
                                                    jQuery('#JSONdata<?php echo $i; ?>').text(image_json);
                                                    jQuery(img).attr('src', image_json);
                                                    jQuery('.preview_pdf_'+counter).val(json_obj['id']);
                                                    jQuery('#Editloading').hide();
                                                    jQuery('#preview_done').show();
                                                });
                                            },1000);
                                        },
                                        <?php if(!empty(get_post_meta($img, 'image_json', true))) { ?>
                                        onLoad: function(container, rootScope, window) {
                                            //console.log(rootScope.history);
                                            if (rootScope.history) {
                                                //rootScope.history.load(JSON.parse(editorStateJSON<?php //echo $i; ?>));
                                                rootScope.started = true;
                                            }
                                        }
                                        <?php } ?>
                                    });
                                    //myPixie<?php echo $i; ?>.enableInteractiveMode();
                                    jQuery('#edit-me<?php echo $i; ?>').on('click', function(e) {
                                        <?php if(!empty(get_post_meta($img, 'image_json', true))) { ?>
                                        myPixie<?php echo $i; ?>.open({
                                            url: e.target.src,
                                            image: e.target
                                        });
                                        <?php } else { ?>
                                        myPixie<?php echo $i; ?>.open({
                                            url: e.target.src,
                                            image: e.target
                                        });
                                        <?php } ?>
                                    });
                                </script>
                            </div>
                                <?php $i++; ?>
                            <?php } ?>
                            <div style="clear: both;"></div>
                        </div>
                    <input style="float: left;" class="submit_button" type="submit" value="Done" name="done" />
                    </form>
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
                    <?php } ?>
                    <form id="delete" method="post" action="">
                        <input class="submit_button" type="submit" name="delete" value="Delete" style="float: right;" />
                    </form>
                    <div style="clear: both;"></div>
                </div>                   
	        </div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>