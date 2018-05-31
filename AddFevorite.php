<?php /* Template Name: Favorite add */ ?>
<?php if(is_user_logged_in()) { 
    global $user_ID;
    $post_id = $_GET['id'];
    $fav = get_post_meta($post_id, 'fav', true);
    $fav_arr = array();
    if(empty($fav)) {
        $fav_arr[0] = $user_ID;
    }
    else {
        $fav_arr = json_decode($fav); 
        array_push($fav_arr, $user_ID);
    }
    update_post_meta($post_id, 'fav', json_encode($fav_arr));
    //echo json_encode($fav_arr);
} else {
   header('Location: '.get_bloginfo('home').'/login'); 
}
?>