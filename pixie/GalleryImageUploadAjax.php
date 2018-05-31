<?php /* Template Name: Gallery Image Upload Ajax */ ?>
<?php
global $user_ID;
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $name = 'Gallery Image at '.date("Y-m-d : H:i:sa");
	$post = array(
        'post_title' => $name,
        'post_type' => 'pub_gallery_img',
        'post_status' => 'publish',
        'post_content' => '',
        'post_author' => $user_ID                            
    ); 
    $new_ad = wp_insert_post( $post ); 
    
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    
    $image = $_FILES['file'];  
    if ($image['size']) {
        if ( preg_match('/(jpg|jpeg|png|gif)$/', $image['type']) ) {       
            $override = array('test_form' => false);  
            $file = wp_handle_upload( $image, $override );
            $attachment = array(
                'post_title' => $image['name'],
                'post_content' => '',
                'post_type' => 'attachment',
                'post_mime_type' => $image['type'],
                'guid' => $file['url']
            ); 
            $attach_id = wp_insert_attachment( $attachment,$file[ 'file' ] );
            wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata( $attach_id, $file['file'] ) );   
            set_post_thumbnail( $new_ad , $attach_id);  
            echo($_POST['index']);   
        } else {      
            wp_die('No image was uploaded.');     
        }   
    }    
}
?>