<?php /* Template Name: Reset Password Template */ ?>
<?php get_header(); ?>
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
                <?php
                	$key = $_GET['action'];
                	if(isset($_POST['Submit']) && !empty($key)){
                	    $user = get_user_by( 'email', $key );
                        $pwd = $_POST['pwd1'];
                		//$user_data = $wpdb->get_row($wpdb->prepare("SELECT ID  FROM $wpdb->users WHERE user_email = %s", $key));
                		wp_set_password( $pwd, $user->ID );
                		header("Location: ".get_bloginfo('home')."/thank-you/?action=".encripted('resetpassword'));
                	}
                ?>
               <div class="woocommerce">
                    <div class="col2-set" id="customer_login">
                    <div class="col-1" style="margin: 0 auto; float: none;">
                    <form id="joinus" method="post" class="login" action="">
                        <p class="form-row form-row-wide">
        					<label for="reg_password"><?php _e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
        					<input type="password" name="pwd1" id="pw1" placeholder="" required="required" />
        				</p>
                        <p class="form-row form-row-wide">
                    		<label for="reg_password"><?php _e( 'Varify Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                    		<input type="password" id="pw2" name="pwd2" class="input-text" oninput="validatePass(document.getElementById('pw1'), this);" onfocus="validatePass(document.getElementById('pw1'), this);" required="required" />
                    	</p>                        
                        <p class="form-row">
                            <input type="submit" name="Submit" id="Submit" value="Reset" />
                        </p>
                    </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery('#reset').validate({
             rules: {
                pwd1: {
					required: true,
					minlength: 8,
                    hasLower: true,
                    hasUpper: true,
                    hasDigital: true,
                    hasSpecial: true
				},
				pwd2: {
					required: true,
					minlength: 8,
					equalTo: "#pwd1"
				}
             },
             messages: {
            }
        });
    });
</script>
<?php get_footer(); ?>