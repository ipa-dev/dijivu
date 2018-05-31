<?php /* Template Name: Gallery My Account 2 */ ?>
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
                                <div id="left-events">
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
                                    <div class="metro-tile diji_share_<?php echo get_the_ID(); ?>" data-id="<?php echo get_the_ID(); ?>"><a href="<?php the_permalink(); ?>" target="_blank"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/ebooks/<?php echo $image; ?>" /></a></div>
                               <?php
                                    endwhile;
                                    endif;
                                    wp_reset_postdata();
                                ?>	
                                </div>
                            </div>
                            <div class="col span_4_of_12 matchheight">
                                <div class="share_drop">
                                    <div id="right-events" class="share_drop_div"><a href="javascript:void(0);" class="gallery_share"><i class="fa fa-share-alt"></i>Share</a></div>
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
          url: "<?php bloginfo('url'); ?>/gallery-share-ajax/",
          data: {"id_arr": arr},
          type: 'POST',
          success: function(response){
            jQuery('#quick_share').html(response);
            jQuery.fancybox.open( {
                content: jQuery("#quick_share"),
                width  : '70%',
                height  : '20%',
                autoSize : false,
                closeBtn: true,
            });
            jQuery(parent).css('border', '1px solid #4cbac7');
            jQuery(current_obj)
            	 .html('<i class="fa fa-check"></i>Shared')
                 .attr('title','Shared')
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
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>