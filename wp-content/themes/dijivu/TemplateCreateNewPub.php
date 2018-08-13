<?php /* Template Name: Create New Publication */ ?>
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
                    <h1>Choose Template:</h1>
                    <?php
                        $args = array(
                            'post_type' => 'template',
                            'posts_per_page' => -1,
                            'post_status' => 'publish'
                        );
                        $the_query = new WP_Query( $args );
                        if ( $the_query->have_posts() ) :
                    ?>
                    <div class="template">
                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <a class="quick_up" href="<?php the_permalink(''); ?>"><?php the_field('icon'); ?> <?php the_title(); ?></a>
                    <?php endwhile; ?>
                    </div>
                    <?php
                        endif;
                        wp_reset_postdata();
                    ?>                    
                </div>                   
	        </div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>