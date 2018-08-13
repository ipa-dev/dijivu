<?php 







 





 /* Template Name: Gallery My Account 1 */ ?>
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
                    <div id="qup" style="display: none;"><?php get_sidebar('quickupload') ?></div>
                    <a href="#qup" id="quick_upload" class="quick_up" style="display: none;"><i class="fa fa-cloud-upload"></i>&nbsp; &nbsp; &nbsp;Quick Upload</a>
                    <div id="drop">
                        <?php
                            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                            $args = array(
                                'post_type' => 'pub',
                                'posts_per_page' => -1,
                                'author' => $user_ID,
                                'paged' => $paged
                            );
                            $the_query = new WP_Query( $args );
                            if ( $the_query->have_posts() ) :
                            while ( $the_query->have_posts() ) : $the_query->the_post();
                        ?>
                            <?php
                                $image = get_post_meta(get_the_ID(), 'upload_pdf_image', true);
                            ?>
                            <div class="metro-tile"><a href="<?php the_permalink(); ?>" target="_blank"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/ebooks/<?php echo $image; ?>" /></a></div>
                       <?php
                            endwhile;
                            endif;
                            wp_reset_postdata();
                        ?>
                        <div style="clear: both;"></div>
                        <div class="drag"><i class="fa fa-arrows-alt"></i></div>
                    </div>	
                </div>                   
	        </div>
	    </div>
	</div>
</div>
<script>
jQuery(document).ready(function() {
   jQuery('.metro-tile').draggable({
    start: function( event, ui ) {
          jQuery(this).addClass('drag_class'); 
     }
   }); 
});
jQuery(document).ready(function() {
   jQuery('#drop').on(
        'dragover',
        function(e) {
            e.preventDefault();
            e.stopPropagation();
            dragover(e.originalEvent.dataTransfer.files);
        }
    )
    jQuery('#drop').on(
        'dragenter',
        function(e) {
            e.preventDefault();
            e.stopPropagation();
        }
    )
    jQuery('#drop').on(
        'drop',
        function(e){
            if(e.originalEvent.dataTransfer){
                if(e.originalEvent.dataTransfer.files.length) {
                    e.preventDefault();
                    e.stopPropagation();
                    /*UPLOAD FILES HERE*/
                    upload(e.originalEvent.dataTransfer.files);
                }   
            }
        }
    );
    function dragover(files){
        jQuery('#drop').css('border', '1px dashed #CCCCCC');
        jQuery('.metro-tile').hide();
        jQuery('#drop .drag').show();
    } 
    function dragrelease(files){
        jQuery('.metro-tile').show();
        jQuery('#drop .drag').hide();
    } 
    function upload(files){
        if(files[0].type == 'application/pdf') {
            //alert('Upload '+files.length+' File(s).');
            //jQuery('#quick_upload').trigger("click");
            jQuery('#drop .drag').hide();     
            jQuery('.metro-tile').show();      
            jQuery('#drop').css('border', 'none');
            jQuery("#quick_upload input[type='file']").prop("files", files);
            //jQuery("#quick_upload").fancybox({}).trigger('click'); 
            jQuery.fancybox.open( {
                content: jQuery("#quick_upload"),
                width  : '70%',
                height  : '90%',
                autoSize : false,
            });
        } else {
            alert('Please Upload Only PDF');
            jQuery('#drop .drag').hide();     
            jQuery('.metro-tile').show(); 
            jQuery('#drop').css('border', 'none'); 
        }
    }
});
</script>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>