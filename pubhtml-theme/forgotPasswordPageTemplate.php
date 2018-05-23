<?php /* Template Name: Forgot Password Template */ ?>
<?php get_header(); ?>
<?php
global $wpdb, $user_ID;
if (empty($user_ID)) {
	if(isset($_POST['forgot'])){
		$user_login = $_POST['emailid'];
		$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID, user_login, user_email, user_activation_key FROM $wpdb->users WHERE user_login = %s", $user_login));
		if(!empty($user_data)){
			$from = get_option('admin_email');
			$headers = "From: $from \n";
			$subject = "Reset Password";
            $headers .= "MIME-Version: 1.0\n"; 
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $useremail = $user_data->user_email;
            $useremail_encripted = encripted($useremail);
            $reseturl = get_bloginfo('url');
			$emailmsg = "Please click on the following link to reset your password <a href='$reseturl/reset-password/?action=$useremail_encripted'>Reset Password</a>"; 
			wp_mail( $useremail, $subject, $emailmsg, $headers );
			$sucess= 'Please check your registered email and click on the reset password link.';
			header("Location: ".get_bloginfo('home')."/thank-you/?action=".encripted('forgotpassword'));
		}
	}
} else {
	header('Location:'.get_bloginfo('home').'/forgot-password');
}
?>
<div id="title">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12"> 
                <h1><span><?php the_title(); ?></span></h1>                
	        </div>
	    </div>
	</div>
</div>
<div id="content">
    <div class="maincontent noPadding">
        <div class="section group">
            <div class="col span_12_of_12">
                <form id="joinus" class="login" action="" method="post">
                    <div class="section group">
                        <div class="col span_12_of_12">
            				<label for="email"><?php _e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
            				<input type="email" name="emailid" placeholder="" required="required" />
                        </div>
                    </div>
                    <div class="section group">
                        <div class="col span_12_of_12">
                            <input type="submit" name="forgot" value="Submit" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>