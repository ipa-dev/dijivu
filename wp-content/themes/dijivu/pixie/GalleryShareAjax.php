<?php /* Template Name: Gallery Share Ajax */ ?>
<?php
    $id_arr = array();
    $id_arr = $_POST['id_arr'];
?>
<div id="share">
    <div class="section group">
        <div class="col span_2_of_12">            
            <label><strong>Share On:</strong></label>
        </div>
        <div class="col span_10_of_12">
            <div class="share_emb">
                <?php 
                    $en_id = encripted(json_encode($id_arr));            
                	$permalink = get_bloginfo('url')."/gallery-view/?gid=".$en_id;
                    $image = get_post_meta($id_arr[0], 'upload_pdf_image', true);
                	$featured_image = get_bloginfo('url')."/wp-content/uploads/ebooks/".$image;
                ?>
                <a href="http://www.facebook.com/sharer.php?u=<?php echo $permalink; ?>&amp;images=<?php echo $featured_image; ?>" class="facebook" target="_blank"><i class="fa fa-facebook"></i>Facebook</a>
                <a href="https://twitter.com/share?url=<?php echo $permalink; ?>" class="twitter" target="_blank"><i class="fa fa-twitter"></i>Twitter</a>
                <a href="https://plus.google.com/share?url=<?php echo $permalink; ?>" class="gplus" target="_blank"><i class="fa fa-google-plus"></i>Google Plus</a>
                <a href="http://www.addthis.com/bookmark.php?v=15&winname=addthis&s=more&url=<?php echo $permalink; ?>" class="addthis" target="_blank"><i class="fa fa-plus"></i>More</a>
            </div>
        </div>
    </div>
</div>