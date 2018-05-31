<?php /* Template Name: Edit Profile */ ?>
<?php if(is_user_logged_in()) { ?>
<?php get_header(); ?>
<?php global $user_ID; ?>
<div id="my_account">
	<div class="maincontent">
	    <div class="section group">
            <div class="col span_2_of_12">
                <?php get_sidebar('accnav'); ?>                                      
	        </div>
	        <div class="col span_10_of_12">
                <?php
                    if(isset($_POST['register'])){
                            global $wpdb;
                            if(!empty($_POST['pw1'])) {
                                $new_user_id = wp_update_user(
                                    array(
                                        'ID'                => $user_ID,
                                        'user_login'		=> $_POST['email_id'],
                                        'user_pass'			=> $_POST['pw1'],
                                        'user_email'		=> $_POST['email_id'],
                                        'first_name'		=> $_POST['fname'],
                                        'last_name'         => $_POST['lname'],
                                        'user_nicename'     => $_POST['email_id'],
                                    )
                                );
                            } else {
                                $new_user_id = wp_update_user(
                                    array(
                                        'ID'                => $user_ID,
                                        'user_login'		=> $_POST['email_id'],
                                        'user_email'		=> $_POST['email_id'],
                                        'first_name'		=> $_POST['fname'],
                                        'last_name'         => $_POST['lname'],
                                        'user_nicename'     => $_POST['email_id'],
                                    )
                                );                                        
                            }
                            update_user_meta( $new_user_id, 'country', sanitize_text_field( $_POST['country'] ) ); 
                            update_user_meta( $new_user_id, 'city', sanitize_text_field( $_POST['city'] ) );   
                            update_user_meta( $new_user_id, 'state', sanitize_text_field( $_POST['state'] ) );
                            update_user_meta( $new_user_id, 'postcode', sanitize_text_field( $_POST['zip'] ) );           
                            
                            require_once(ABSPATH . "wp-admin" . '/includes/image.php'); 
                            require_once(ABSPATH . "wp-admin" . '/includes/file.php'); 
                            require_once(ABSPATH . "wp-admin" . '/includes/media.php');
                            
                            $keys = array_keys($_FILES);
                            foreach ( $_FILES as $image ) {   // if a files was upload   
                            if ($image['size']) {     // if it is an image     
                                if ( preg_match('/(jpg|jpeg|png|gif)$/', $image['type']) ) {       
                                    $override = array('test_form' => false);       // save the file, and store an array, containing its location in $file       
                                    $file = wp_handle_upload( $image, $override );
                                    $attachment = array(
                                        'post_title' => $image['name'],
                                        'post_content' => '',
                                        'post_type' => 'attachment',
                                        'post_mime_type' => $image['type'],
                                        'guid' => $file['url']
                                    ); 
                                    $attach_id = wp_insert_attachment( $attachment, $file[ 'file' ]);
                                    $attach_data = wp_generate_attachment_metadata( $attach_id, $file['file'] );
                                    wp_update_attachment_metadata( $attach_id, $attach_data );
                                     
                                    //add_user_meta($new_user_id, 'profile_pic', $attach_id); 
                                    update_user_meta($user_ID, 'avatar', $attach_id);    
                                } else {       // Not an image.        
                                    // Die and let the user know that they made a mistake.       
                                    wp_die('No image was uploaded.');     
                                    }   
                                }  
                            } // end of foreach 
                            //header("Location: ".get_bloginfo('home')."/my-account/");
                            ?>
                                <p class="successMsg">Profile Updated</p>
                            <?php
                        }
                ?>
                <?php $user_info = get_userdata($user_ID); ?>
                <form id="acc_section" class="registration" action="" method="post" enctype="multipart/form-data">
                    <h1><?php the_title(); ?></h1>
                    <div class="section group">
                        <div class="col span_6_of_12">
                        	<label for="reg_billing_first_name"><?php _e( 'First name' ); ?> <span class="required">*</span></label>
                        	<input type="text" name="fname" placeholder="" value="<?php echo $user_info->first_name; ?>" required="required" />
                        </div>
                        <div class="col span_6_of_12">
                	       <label for="reg_billing_last_name"><?php _e( 'Last name' ); ?> <span class="required">*</span></label>
                	       <input type="text" name="lname" placeholder="" value="<?php echo $user_info->last_name; ?>" required="required" />
                        </div>
                    </div>
                    <div class="section group">
                        <div class="col span_12_of_12">
                            <label for="address"><?php _e( 'Country' ); ?> <span class="required">*</span></label>
                            <select class="country" required="required" name="country" data-constraints="@Required @Country">
                                <option>Select Country</option>
                                <?php 
                                    $url = TEMPLATEPATH.'/countries.xml';
                                    $xml = simplexml_load_file($url);
                                    foreach($xml->country as $country) {
                                ?>
                                <option <?php
                                            if($country['code'] == get_user_meta( $user_ID, 'country', true)) {
                                                echo 'selected="selected"';
                                            }
                                        ?> value="<?php echo $country['code']; ?>"><?php echo $country; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="section group">
                        <div class="col span_12_of_12">
                    		<label for="city"><?php _e( 'City' ); ?> <span class="required">*</span></label>
                            <input type="text" name="city" value="<?php echo get_user_meta( $user_ID, 'city', true); ?>" />
                        </div>
                    </div>
                    <div class="section group">
                        <div class="col span_12_of_12">
                            <label for="address"><?php _e( 'State/Province/County' ); ?> <span class="required">*</span></label>
                            <input type="text" name="state" value="<?php echo get_user_meta( $user_ID, 'state', true); ?>" />
                        </div>
                    </div>
                    <div class="section group">
                        <div class="col span_12_of_12">
                            <label for="zip"><?php _e( 'Postcode / Zip' ); ?> <span class="required">*</span></label>
                            <input type="text" name="zip" value="<?php echo get_user_meta( $user_ID, 'postcode', true); ?>" />
                        </div>
                    </div>
                    <div class="section group">
                        <div class="col span_12_of_12">
            				<label for="reg_email"><?php _e( 'Email address' ); ?> <span class="required">*</span></label>
            				<input type="text" name="email_id" id="e1" placeholder="" required="required" value="<?php echo $user_info->user_email; ?>" />
                        </div>
                    </div>
                    <div class="section group">
                        <div class="col span_12_of_12">
            				<label for="reg_email"><?php _e( 'Varify Email address' ); ?> <span class="required">*</span></label>
            				<input type="text" name="email_id1" id="e2" placeholder="" required="required" value="<?php echo $user_info->user_email; ?>" oninput="validateEmail(document.getElementById('e1'), this);" onfocus="validateEmail(document.getElementById('e1'), this);" />
                        </div>
                    </div>
                    <div class="section group">
                        <div class="col span_12_of_12">
        					<label for="reg_password"><?php _e( 'Password' ); ?></label>
        					<input type="password" name="pw1" id="pw1" placeholder="" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" />
                        </div>
                    </div>
                    <div class="section group">
                        <div class="col span_12_of_12">
                    		<label for="reg_password"><?php _e( 'Varify Password' ); ?></label>
                    		<input type="password" id="pw2" name="pw2" class="input-text" oninput="validatePass(document.getElementById('pw1'), this);" onfocus="validatePass(document.getElementById('pw1'), this);" />
                        </div>
                    </div>
                    <div class="section group">
                        <div class="col span_12_of_12">
                            <div class="proImgBig">
                                <?php echo get_image_size_100_100($user_ID); ?>
                            </div>
                    		<label for="avatar"><?php _e( 'Profile Picture' ); ?> <span class="required">*</span></label>
                    		<input id="upload" type="file" name="avatar" required="required"/>
                            <input type="hidden" name="MAX_FILE_SIZE" value="500" />
                        </div>
                    </div>
                    <div class="section group">
                        <div class="col span_12_of_12">
                            <input type="submit" name="register" value="Update" class="submit-button" />
                        </div>
                    </div>
                </form>                       
	        </div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>