<?php /* Template Name: Gallery My Account 3 */ ?>
<?php if(is_user_logged_in()) { ?>
<?php get_header(); ?>
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
                        <div class="section group">
                            <div class="col span_8_of_12 matchheight">
                                <div id="dragAndDropFiles" class="uploadArea">
                                	<h1>Drop Images Here to Upload into Gallery</h1>
                                </div>
                                <form name="demoFiler" id="demoFiler" enctype="multipart/form-data">
                                <p style="display: none;"><input type="file" name="multiUpload" id="multiUpload" multiple="multiple" /></p>
                                <p><input type="submit" name="submitHandler" id="submitHandler" value="Upload" class="buttonUpload" /></p>
                                </form>
                                <div class="progressBar">
                                	<div class="status"></div>
                                </div>
                                <div id="left-events">
                                <?php
                                    //$paged = get_query_var('paged') ? get_query_var('paged') : 1;
                                    $args = array(
                                        'post_type' => 'pub_gallery_img',
                                        'posts_per_page' => -1,
                                        'author' => $user_ID
                                    );
                                    $the_query = new WP_Query( $args );
                                    if ( $the_query->have_posts() ) :
                                    while ( $the_query->have_posts() ) : $the_query->the_post();
                                ?>
                                    <div class="metro-tile diji_share_<?php echo get_the_ID(); ?>" data-id="<?php echo get_the_ID(); ?>">
                                        <a href="javascript:void(0)"><?php the_post_thumbnail('thumb_size_200_185'); ?></a>
                                        <a href="javascript:void(0)" onclick="galleryDelete(<?php echo get_the_ID(); ?>)" class="metro-tile-delete"><i class="fa fa-trash"></i></a>
                                    </div>
                               <?php
                                    endwhile;
                                    endif;
                                    wp_reset_postdata();
                                ?>	
                                </div>
                            </div>
                            <div class="col span_4_of_12 matchheight">
                                <div class="share_drop">
                                    <div id="right-events" class="share_drop_div"><h1>Drop Images Here to Create Publication</h1><a href="javascript:void(0);" class="gallery_share"><i class="fa fa-share-alt"></i>Create Publication</a></div>
                                </div>
                            </div>
                        </div>
                    </div>                   
	        </div>
	    </div>
	</div>
</div>
<div id="quick_share" style="display: none;"></div>
<script>
    jQuery('.share_drop div a.gallery_share').click(function() {
        jQuery(this)
            .html('<i class="fa fa-spinner fa-pulse"></i>Loading')
            .attr('title','Loading')
        ;
        var current_obj = jQuery(this);
        var parent = jQuery(this).parent();
        var arr = [];
        jQuery(parent).children('.metro-tile').each(function() {
            var valid;
            valid = jQuery(this).attr('data-id');
            arr.push(valid);
        });
        jQuery.ajax({
          url: "<?php bloginfo('url'); ?>/gallery-create-publication-ajax/",
          data: {"id_arr": arr},
          type: 'POST',
          success: function(response){
            jQuery('#quick_share').html(response);
            jQuery.fancybox.open( {
                content: jQuery("#quick_share"),
                width  : '70%',
                height  : '90%',
                autoSize : false,
                closeBtn: true
            });
            jQuery(parent).css('border', '1px solid #4cbac7');
            jQuery(current_obj)
            	 .html('<i class="fa fa-check"></i>Publication Created')
                 .attr('title','Publication Created')
                 .unbind('click')
            ;
          }
        });
    });
</script>
<!-- Dragula -->
<script src='<?php bloginfo('template_directory'); ?>/js/dragula.js'></script>
<script src='<?php bloginfo('template_directory'); ?>/js/example.min.js'></script>
<link href='<?php bloginfo('template_directory'); ?>/css/dragula.css' rel='stylesheet' type='text/css' />
<!-- Multiple Image Upload -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/multiupload.js"></script>
<script type="text/javascript">
var config = {
	support : "image/jpg,image/png,image/bmp,image/jpeg,image/gif",		// Valid file formats
	form: "demoFiler",					// Form ID
	dragArea: "dragAndDropFiles",		// Upload Area ID
	uploadUrl: "<?php bloginfo('url'); ?>/gallery-image-upload-ajax",				// Server side upload url
    refreshUrl: "<?php bloginfo('url'); ?>/gallery-content-refresh-ajax",
    Url: "<?php bloginfo('template_directory'); ?>"
}
jQuery(document).ready(function(){
	initMultiUploader(config);
});
</script>
<script>
function galleryDelete(galleryId) {
    jQuery.ajax({
      url: "<?php bloginfo('url'); ?>/gallery-delete-ajax/",
      data: {"galleryId": galleryId},
      type: 'POST',
      success: function(response){
        jQuery.ajax("<?php bloginfo('url'); ?>/gallery-content-refresh-ajax", {
           type: "POST",
           success: function (data) {
               jQuery("#left-events").html(data);
           } 
        });
      }
    });
}
</script>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>