<?php /* Template Name: Followers My Account */ ?>
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
                    <h1><?php the_title(); ?></h1>
                    <?php
                        $fol = get_user_meta($user_ID, 'follow', true);
                        $fol_arr = array();
                        $fol_arr = json_decode($fol);
                    ?>
                    <?php if ( ! empty( $fol ) ) { ?>
                    <div id="follow_user">
                    <div class="section group">
                        <?php foreach ( $fol_arr as $user ) { ?>
            	        <div class="col span_3_of_12"> 
                            <div class="user_info">
                                <a href="#">
                                <?php echo get_image_size_100_100($user); ?>
                                <?php $user_info = get_userdata($user); ?>
                                <p><?php echo $user_info->display_name; ?></p>
                                </a>
                            </div>
                        </div>
                        <?php } ?>
                     </div>
                     </div>
                     <?php } ?>
                </div>                    
	        </div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>