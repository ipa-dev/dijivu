<?php /* Template Name: Statistics */ ?>
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
                <ul class="tab-links">
                    <li class="active"><a href="#tab1">Lifetime Statistics</a></li>
                    <li><a href="#tab2">Publication Statistics</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab1" class="tab active">
                        <h1>Lifetime Statistics</h1>
                        <h2>User Statistics:</h2>
                        <div class="section group">
                            <div class="col span_4_of_12">
                                <div class="stat_box">
                                    <h1>1</h1>
                                    <p>Homepage Views</p>
                                </div>
                            </div>
                            <div class="col span_4_of_12">
                                <div class="stat_box">
                                    <?php
                                        $fol = get_user_meta($user_ID, 'follow', true);
                                        $fol_arr = array();
                                        $fol_arr = json_decode($fol);
                                    ?>
                                    <h1><?php echo count($fol_arr); ?></h1>
                                    <p>Followers</p>
                                </div>
                            </div>
                            <div class="col span_4_of_12">
                                <div class="stat_box">
                                    <?php
                                        $args = array(
                                            'post_type' => 'bookcase',
                                            'posts_per_page' => -1,
                                            'author' => $user_ID
                                        );
                                        $the_query = new WP_Query( $args );
                                    ?>
                                    <h1><?php echo $the_query->found_posts; ?></h1>
                                    <p>Bookcase View</p>
                                </div>
                            </div>
                        </div>
                        <h2>Publication Statistics:</h2>
                        <div class="section group">
                            <div class="col span_4_of_12">
                                <div class="stat_box">
                                    <h1>1</h1>
                                    <p>Read</p>
                                </div>
                            </div>
                            <div class="col span_4_of_12">
                                <div class="stat_box">
                                    <?php
                                        $args = array(
                                            'post_type' => 'pub',
                                            'posts_per_page' => -1,
                                            'post_status' => 'publish',
                                            'meta_query' => array(
                                                array(
                                                    'key' => 'fav',
                                                    'value' => $user_ID,
                                                    'compare' => 'LIKE'
                                                )
                                            )
                                        );
                                        $the_query = new WP_Query( $args );
                                    ?>
                                    <h1><?php echo $the_query->found_posts; ?></h1>
                                    <p>Favorite</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab2" class="tab">
                        <h1>Publication Statistics</h1>
                    </div>
                </div>                
                </div>                   
	        </div>
	    </div>
	</div>
</div>
<script>
jQuery(document).ready(function() {
    jQuery('.tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
 
        // Show/Hide Tabs
        jQuery(currentAttrValue).show().siblings().hide();
 
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
 
        e.preventDefault();
    });
});
</script>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>