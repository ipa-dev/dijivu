<?php /* Template Name: Follow add */ ?>
<?php if(is_user_logged_in()) { 
    global $user_ID;
    $u_id = $_GET['id'];
    $fav = get_user_meta($u_id, 'follow', true);
    $fav_arr = array();
    $fav_arr = json_decode($fav); 
    if(empty($fav_arr)) {
        $fav_arr[0] = $user_ID;
    }
    else {
        array_push($fav_arr, $user_ID);
    }
    update_user_meta($u_id, 'follow', json_encode($fav_arr));
    //echo json_encode($fav_arr);
    return count(json_decode(get_user_meta($u_id, 'follow', true)));
} else {
   header('Location: '.get_bloginfo('home').'/login'); 
}
?>