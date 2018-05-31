<?php /* Template Name: Billing */ ?>
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
                <table id="dataTable">
                    <thead>
                        <tr>
                            <th>Rent ID</th>
                            <th>Period</th>
                            <th>Price</th>
                            <th>Rent State</th>
                            <th>Renting Time</th>
                            <th>Expiration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--                        
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        -->
                    </tbody>
                </table>
                </div>                   
	        </div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>