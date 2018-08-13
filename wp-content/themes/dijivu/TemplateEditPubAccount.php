<?php /* Template Name: Edit Publication */ ?>
<?php if(is_user_logged_in()) { ?>
<?php get_header(); ?>
<!-- Color Picker -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/colorpicker.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/eye.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/utils.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/layout.js?ver=1.0.2"></script>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/colorpicker.css" type="text/css" />
<link rel="stylesheet" media="screen" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/layout.css" />
<?php global $user_ID; ?>
<?php $user_info = get_userdata($user_ID); ?>
<div id="my_account">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_2_of_12">
                <?php get_sidebar('accnav'); ?>                                      
	        </div>
	        <div class="col span_10_of_12"> 
                <?php
                    if(isset($_POST['update'])) {
                        $post_arg = array(
                            'ID' => $_POST['pid'],
                            'post_title'    => $_POST['pdf_name'],
                            'post_content'  => $_POST['pdf_des'],
                            'post_status'   => $_POST['status']
                        );
                        wp_update_post( $post_arg );
                        wp_set_post_terms( $_POST['pid'], $_POST['cat'], 'pub_category' );
                        update_post_meta($_POST['pid'], 'bg-color', $_POST['bg-color']);
                                    
                        require_once(ABSPATH . "wp-admin" . '/includes/image.php'); 
                        require_once(ABSPATH . "wp-admin" . '/includes/file.php'); 
                        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
                        
                        $image = $_FILES['bg-img'];
                        if ($image['size']) {
                            if ( preg_match('/(jpg|jpeg|png|gif)$/', $image['type']) ) {       
                                $override = array('test_form' => false);
                                $file1 = wp_handle_upload( $image, $override );
                                $attachment = array(
                                    'post_title' => $image['name'],
                                    'post_content' => '',
                                    'post_type' => 'attachment',
                                    'post_mime_type' => $image['type'],
                                    'guid' => $file1['url']
                                ); 
                                $attach_id = wp_insert_attachment( $attachment, $file1[ 'file' ]);
                                $attach_data = wp_generate_attachment_metadata( $attach_id, $file1['file'] );
                                wp_update_attachment_metadata( $attach_id, $attach_data );
                                update_post_meta($_POST['pid'], 'bg-img', $attach_id);   
                            } else {       
                                wp_die('No image was uploaded.');     
                                }   
                        }
                    }
                    if(isset($_POST['delete'])) {
                        wp_delete_post( $_POST['pid'] );
                        header('Location: '.get_bloginfo('home').'/my-account');
                    }
                ?>
                <div id="acc_section">
                    <form id="pdf_upload" action="" method="post" enctype="multipart/form-data">
                        <p><label>Title: </label><input name="pdf_name" type="text" value="<?php echo get_the_title($_GET['pid']); ?>" placeholder="Title" required="required" /></p>
                        <p><label>Description: </label><textarea name="pdf_des" required="required"><?php $pub_cont = get_post($_GET['pid']); echo $pub_cont->post_content; ?></textarea></p>
                        <p>
                            <label>Select Status: </label>
                            <select name="status">
                                <option<?php if(get_post_status($_GET['pid']) == 'private1') { echo ' selected="selected"'; } ?> value="private1">Private</option>
                                <option<?php if(get_post_status($_GET['pid']) == 'publish') { echo ' selected="selected"'; } ?> value="publish">Publish</option>
                            </select>
                        </p>
                        <p>
                            <label>Category: </label>
                            <select name="cat">
                                <?php
                                    $taxonomy = 'pub_category';
                                    $tax_terms = get_terms($taxonomy, array(
                                        'hide_empty' => 0,
                                        'parent' => 0,
                                        'orderby' => 'slug',                                                        
                                    ));
                                    $term_array = wp_get_post_terms($_GET['pid'], 'pub_category');
                                ?>
                                <?php
                                    foreach ($tax_terms as $tax_term) {
                                    echo '<optgroup label="'.$tax_term->name.'">';
                                    $terms = get_terms($taxonomy, array('parent' => $tax_term->term_id, 'orderby' => 'slug', 'hide_empty' => 0));
                                    foreach ($terms as $term) {
                                        foreach($term_array as $post_term) {
                                            if($post_term->term_id == $term->term_id) {
                                                echo '<option selected="selected" value="'.$term->term_id.'">'.$term->name.'</option>';
                                            } else {
                                                echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';  
                                            }   
                                        }
                                    }
                                    echo '</optgroup>';
                                    }
                                ?>
                            </select>
                        </p>
                        <?php if(get_field('color', get_user_meta($user_ID, 'plan', true)) == 1) { ?>
                        <p>
                            <?php
                                $bg_col = get_post_meta($_GET['pid'], 'bg-color', true);
                                if(empty($bg_col)) {
                                    $bg_col = '#0000ff';
                                }
                            ?>
                            <label>Background Color:</label>
                            <div id="colorSelector"><div style="background-color: <?php echo $bg_col; ?>"></div></div>
                            <input type="hidden" name="bg-color" value="<?php echo $bg_col; ?>" />
                            <script>
                                jQuery('#colorSelector').ColorPicker({
                                	color: '<?php echo $bg_col; ?>',
                                	onShow: function (colpkr) {
                                		jQuery(colpkr).fadeIn(500);
                                		return false;
                                	},
                                	onHide: function (colpkr) {
                                		jQuery(colpkr).fadeOut(500);
                                		return false;
                                	},
                                	onChange: function (hsb, hex, rgb) {
                                		jQuery('#colorSelector div').css('backgroundColor', '#' + hex);
                                        jQuery('input[name="bg-color"]').val('#' + hex);
                                	}
                                });
                            </script>
                        </p>
                        <?php } ?>
                        <?php if(get_field('bg', get_user_meta($user_ID, 'plan', true)) == 1) { ?>
                        <p>
                            <label>Background Image:</label>
                            <input type="file" value="" name="bg-img" />
                        </p>
                        <?php } ?>
                        <input type="hidden" name="pid" value="<?php echo $_GET['pid']; ?>" />
                        <p><input class="submit_button" type="submit" name="update" value="Update" /><input class="submit_button" type="submit" name="delete" value="Delete" style="float: right;" /></p>                       
                    </form>
                </div>                   
	        </div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>