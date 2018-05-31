<?php /* Template Name: Gallery Create Publication 2 Ajax */ ?>
<?php
    $subdomain = array_shift((explode('.', $_SERVER['HTTP_HOST'])));
?>
<?php
global $user_ID;
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['pub_id'])) {
        $post_arg = array(
            'ID' => $_POST['pub_id'],
            'post_title' => $_POST['pdf_name'],
            'post_content' => $_POST['pdf_des'],
            'post_type' => 'pub',
            'post_author' => $user_ID,
            'post_date' => date('Y-m-d H:i:s'),
            'comment_status' => 'closed',
            'post_status' => $_POST['status']
        );
        wp_update_post($post_arg);
        wp_set_post_terms($_POST['pub_id'], $_POST['cat'], 'pub_category');
        if ($subdomain != 'dijivu') { echo substr_replace(get_permalink($_POST['pub_id']), $subdomain.'.', strpos(get_permalink($_POST['pub_id']), '/') + 2, 0); }else echo get_permalink($_POST['pub_id']);
    } else {
        $post_arg = array(
            'post_title' => $_POST['pdf_name'],
            'post_content' => $_POST['pdf_des'],
            'post_type' => 'pub',
            'post_author' => $user_ID,
            'post_date' => date('Y-m-d H:i:s'),
            'comment_status' => 'closed',
            'post_status' => $_POST['status']
        );
        $new_post_id = wp_insert_post($post_arg);
        add_post_meta($new_post_id, 'fav', '');
        wp_set_post_terms($new_post_id, $_POST['cat'], 'pub_category');
        add_post_meta($new_post_id, 'upload_pdf', $_POST['upload_pdf']);
        if (isset($_POST['no_preview'])) {
            set_post_thumbnail($new_post_id, $_POST['img']);
        } else {
            $img = get_post_thumbnail_id($_POST['img']);
            if (empty($img)) {
                $img = $_POST['img'];
            }
            set_post_thumbnail($new_post_id, $img);
            add_post_meta($new_post_id, 'created_from_gallery', 1);
            add_post_meta($new_post_id, 'html', $_POST['preview_pdf']);
        }
        if (isset($_POST['template'])) {
            add_post_meta($new_post_id, 'template', $_POST['template']);
        }
        /*$html = '<p class="successMsg">Publication created successfully...</p><!--<p><iframe style="width:100%;height:500px" src="http://dijivu.coregensolution.com/pub-emb/?puid=  seamless="seamless" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" ></iframe></p>-->';
        $data = $new_post_id;
        $array = array();
        $array['html'] = $html;
        $array['data'] = get_permalink($new_post_id);
        echo json_encode($array);
        */
        if ($subdomain != 'dijivu') { echo substr_replace(get_permalink($new_post_id), $subdomain.'.', strpos(get_permalink($new_post_id), '/') + 2, 0); }else echo get_permalink($new_post_id);
    }
}
?>