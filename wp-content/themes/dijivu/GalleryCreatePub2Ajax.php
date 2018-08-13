<?php
/* Template Name: Create Publication from PDF file */
global $user_ID;
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $pdf_file_exts = array("pdf");
    $pdf_file_name = preg_replace("/[\s]+/", "", $_FILES['upload_pdf']['name']);
    $pdf_file_name_array = explode(".", $_FILES['upload_pdf']['name']);
    $pdf_file_name_org = $pdf_file_name_array[0];
    $uploaded_pdf_file_exts = end(explode(".", $_FILES['upload_pdf']['name']));

    if (($_FILES['upload_pdf']["size"] < 40000000) && in_array($uploaded_pdf_file_exts, $pdf_file_exts)){
        echo 'aa';

        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');

        global $user_ID;

        $date = date('Ymd');
        $time = time();
        $filename = $date.'_'.$time.'_'.($pdf_file_name);
        $upload_dir = wp_upload_dir();
        $uploaddir = $upload_dir['basedir'].'/ebooks/';
        $file = $uploaddir . $date.'_'.$time.'_'.($pdf_file_name);
        if (move_uploaded_file($_FILES['upload_pdf']['tmp_name'], $file)) {
            $post_arg = array(
                'post_title'    => $_POST['pdf_name'],
                'post_content'  => $_POST['pdf_des'],
                'post_type'     => 'pub',
                'post_author'   => $user_ID,
                'post_date'     => date('Y-m-d H:i:s'),
                'comment_status' => 'closed',
                'post_status'   => $_POST['status']
            );
            $new_post_id = wp_insert_post( $post_arg );
            add_post_meta($new_post_id, 'fav', '');
            add_post_meta($new_post_id, 'upload_pdf', $filename);

            wp_set_post_terms( $new_post_id, $_POST['cat'], 'pub_category' );
            $im = new imagick( $file );
            $num_pages = $im->getNumberImages();

            $page_num = get_field('pages', get_user_meta($user_ID, 'plan', true));

            /*
            if($num_pages > $page_num && $page_num != 0) {
                wp_delete_post($new_post_id, 'true');
                header('Location: '.get_bloginfo('home').'/my-account/?status=upload_failed_page');
            }
            */

            $im->clear();
            $im->destroy();
            $img_array = array();
            $newfile = $file.'[0]';
            $img = new imagick( $newfile );
            //$img->setImageColorspace(Imagick::COLORSPACE_CMYK);
            $img->setImageCompressionQuality(100);
            $img->setResolution(222, 150);
            $img->setCompressionQuality(50);
            $img->setImageFormat('jpg');
            //$img->flattenImages();
            $thumb = $uploaddir.$new_post_id.'_thumb.jpg';
            $img->writeImage($thumb);
            $image = get_bloginfo('url').'/wp-content/uploads/ebooks/'.$new_post_id.'_thumb.jpg';
            media_sideload_image( $image, $new_post_id );
            $attachments = get_posts(array('numberposts' => '1', 'post_parent' => $new_post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC'));
            if(sizeof($attachments) > 0){
                set_post_thumbnail($new_post_id, $attachments[0]->ID);
            }
            $img_var = $new_post_id.'_thumb'.$i.'.jpg';
            add_post_meta($new_post_id, 'upload_pdf_image', $img_var);
            $img->clear();
            $img->destroy();
            /*
            for($i=0; $i<$num_pages; $i++) {
                $newfile = $file.'['.$i.']';
                $img = new imagick( $newfile );
                $img->setImageColorspace(Imagick::COLORSPACE_CMYK);
                $img->setImageCompressionQuality(100);
                $img->setResolution(1000, 1000);
                $img->setCompressionQuality(95);
                $img->setImageFormat('jpg');
                $img->flattenImages();
                $thumb = $uploaddir.$new_post_id.'_thumb'.$i.'.jpg';
                $img->writeImage($thumb);
                $img_array[$i] = $new_post_id.'_thumb'.$i.'.jpg';
                $img->clear();
                $img->destroy();
            }
            add_post_meta($new_post_id, 'upload_pdf_images', json_encode($img_array));*/
            //$file_url = get_bloginfo('url').'/wp-content/uploads/ebooks/'.$new_post_id.'_thumb0.jpg';
            //media_sideload_image($file_url, $new_post_id);
        }
    }
}
?>