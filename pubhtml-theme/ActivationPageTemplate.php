<?php /* Template Name: Activation Template */ ?>
<?php get_header(); ?>
<div id="title">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12"> 
                <h1><?php the_title(); ?></h1>                
	        </div>
	    </div>
	</div>
</div>
<div id="content">
    <div class="maincontent noPadding">
        <div class="section group">
            <div class="col span_12_of_12">
                <?php if(!is_user_logged_in()){ 
                    global $wpdb;
                    $user_status = 2;
                    $key = $_GET['key'];
                    $wpdb->update($wpdb->users, array('user_status' => $user_status), array('user_activation_key' => $key));
                    $query_string = "SELECT * FROM {$wpdb->prefix}users WHERE user_activation_key = '".$key."';";
                    $results = $wpdb->get_results( $query_string, OBJECT );
                    $to1 = $results[0]->user_email;
		    $from1 = get_option('admin_email');
		    $headers1 = 'From: '.$from1. "\r\n";
                    $headers1 .= "MIME-Version: 1.0\n"; 
                    $headers1 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		    $subject1 = "Account Activated"; 
		    $msg1 = '<p class="successMsg"><strong>Congratulations</strong><br /><br />Your account has been activated. Click here to <strong><a href="'.get_bloginfo('home').'/login">Sign In</a></strong></p>'; 
		    wp_mail( $to1, $subject1, $msg1, $headers1 );
		    echo "Account activated";
                 } ?>   
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>