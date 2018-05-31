<?php /* Template Name: Save Image Ajax */ ?>
<?php
$data = file_get_contents($_REQUEST['imgData']);

$upload_dir = wp_upload_dir();
$writePath = $upload_dir['basedir'].'/ebooks/';
$date = date('Ymd');
$time = time();
$imageName = $date.'_'.$time.'_'.'image.jpg';

$imageTotalLength = $writePath.$imageName;

file_put_contents($imageTotalLength, $data);

//$file = get_bloginfo('url').'/wp-content/uploads/ebooks/'.$imageName;

require_once(ABSPATH . "wp-admin" . '/includes/image.php');
require_once(ABSPATH . "wp-admin" . '/includes/file.php');
require_once(ABSPATH . "wp-admin" . '/includes/media.php');

$attachment = array(
    'guid'           => $imageTotalLength,
    'post_mime_type' => 'image/jpeg',
    'post_title'     => $imageName,
    'post_content'   => '',
    'post_status'    => 'inherit'
);
$image_id = wp_insert_attachment($attachment, $imageTotalLength);
wp_update_attachment_metadata( $image_id, wp_generate_attachment_metadata( $image_id, $imageTotalLength ) );
add_post_meta($image_id, 'image_json', $_POST['image_json']);

$image_array = array();
$image_array['id'] = $image_id;
$get_image = wp_get_attachment_image_src($image_id, 'full');
$image_array['img'] = $get_image[0];
echo json_encode($image_array);
//echo '<img style="width: 100%;" src="'.$file.'">';
?>
