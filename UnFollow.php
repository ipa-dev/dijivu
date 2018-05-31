<?php /* Template Name: Un Follow */ ?>
<?php if(is_user_logged_in()) { 
    global $user_ID;
    $u_id = $_GET['id'];
    $fav = get_user_meta($u_id, 'follow', true);
    $fav_arr = array();
    if(!empty($fav)) {
        $fav_arr = json_decode($fav);    
        $pos = array_search($user_ID, $fav_arr);
        unset($fav_arr[$pos]);
        update_user_meta($u_id, 'follow', json_encode($fav_arr));
        echo count(json_decode(get_user_meta($u_id, 'follow', true)));
    }
} else {
   header('Location: '.get_bloginfo('home').'/login'); 
}
?>