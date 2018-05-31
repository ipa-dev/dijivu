<?php /* Template Name: Login Template */ ?>
<?php ob_start(); ?>
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
                if(isset($_POST['logina'])){                      
                global $wpdb;
                    $username = $wpdb->escape($_POST['email_id']);
					$pwd = $wpdb->escape($_POST['pwd']);
					$user_status = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->users WHERE user_login = %s", $username));
                    if($user_status[0]->user_status == 2){
						$login_data = array();
						$login_data['user_login'] = $username;
						$login_data['user_password'] = $pwd;
                        if(isset($_POST['rememberme'])) {
                            $login_data['remember'] = 'true';
                        } else {
                            $login_data['remember'] = 'false';   
                        }
                        //$login_count = get_locked_counter();
                        //if($login_count < 2){
                            $user_verify = wp_signon( $login_data, true );
                            if ( is_wp_error($user_verify) ){
                                $errorCode = 3;
                                //update_locked_counter();
							} else {
                                header('Location: '.get_bloginfo('home').'/my-account');
                                exit();
							}
                        /*} else {
                            $errorCode = 4;
                        }*/
					} else {
						$errorCode = 1; // invalid login details
					}        
                }
                ?>
                <?php if($errorCode == 1){ ?>
                    <div class="errorMsg">You have not activated your account. Please check your email inbox to activate account.</div>
                <?php } ?>
                <?php if($errorCode == 2){ ?>
                    <div class="errorMsg">Verification failed...Please try again.</div>
                <?php } ?>
                <?php if($errorCode == 3){ ?>
                    <div class="errorMsg">Incorrect login details...Please try again.</div>
                <?php } ?>
                <?php if($errorCode == 4){ ?>
                    <div class="errorMsg">You have had your 3 failed attempts at logging in and now are banned for 10 minutes. Try again later!</div>
                <?php } ?>
                    <form id="joinus" class="login" action="" method="POST">
                        <div class="section group">
                            <div class="col span_12_of_12">
            				    <label for="username"><?php _e( 'Username or email address' ); ?> <span class="required">*</span></label>
            				    <input type="email" name="email_id" placeholder="Email Address" value="" required="required" />
                            </div>
                        </div>
                        <div class="section group">
                            <div class="col span_12_of_12">
            				    <label for="password"><?php _e( 'Password' ); ?> <span class="required">*</span></label>
            				    <input type="password" name="pwd" placeholder="Password" value="" required="required" />
                            </div>
                        </div>
                        <div class="section group">
                            <div class="col span_12_of_12">
            				<?php wp_nonce_field( 'custom-login' ); ?>
            				    <input type="submit" name="logina" value="Login" />
            				    <label for="rememberme" class="inline">
            					<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me' ); ?>
                            </div>
                        </div>
                        <div class="section group">
                            <div class="col span_6_of_12">
            				    <a href="<?php bloginfo('url') ?>/forgot-password">Forgot Password?</a>
                            </div>
                            <div class="col span_6_of_12">
                                <a href="<?php bloginfo('url') ?>/registration">Register new account</a>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>