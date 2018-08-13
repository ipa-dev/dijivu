<?php /* Template Name: Favorite remove */ ?>
<?php if(is_user_logged_in()) { 
    global $user_ID;
    $post_id = $_GET['id'];
    $fav = get_post_meta($post_id, 'fav', true);
    $fav_arr = array();
    if(!empty($fav)) {    
        $fav_arr = json_decode($fav);    
        $pos = array_search($user_ID, $fav_arr);
        unset($fav_arr[$pos]);
        $json_data = json_encode($fav_arr);
        update_post_meta($post_id, 'fav', $json_data);
    }
} else {
   header('Location: '.get_bloginfo('home').'/login'); 
}
?>