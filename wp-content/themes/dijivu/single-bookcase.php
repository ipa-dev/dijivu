<?php if(is_user_logged_in()) { ?>
<?php get_header(); ?>
<?php global $user_ID; ?>
<?php
    $post_author_id = get_post_field( 'post_author', get_the_ID() );
    if($user_ID != $post_author_id) {
        $view = get_post_meta(get_the_ID(), 'view', true);
        $view++;
        update_post_meta(get_the_ID(), 'view', $view);
    }
?>
<?php $user_info = get_userdata($user_ID); ?>
<?php
    if($_GET['action'] == 'delete') {
        wp_delete_post(get_the_ID());
        header('Location: '.get_bloginfo('home').'/book-cases');
    }
?>
<div id="my_account">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_2_of_12">
                <?php get_sidebar('accnav'); ?>                                      
	        </div>
	        <div class="col span_10_of_12"> 
                <div id="acc_section">
                    <div class="section group">
                        <div class="col span_4_of_12">
                            <div class="book_case">
                                <div class="book_img">
                                    <?php
                                        $books = get_post_meta(get_the_ID(), 'books', true);
                                        $books_array = json_decode($books);
                                        //print_r($books_array);
                                        $i = 1;
                                    ?>
                                    <?php foreach($books_array as $book) { 
                                        if($i<=3) {
                                    ?>
                                    <?php
                                        $attr = array(
                                        	'class' => "book$i",
                                        	'alt'   => get_the_title($book),
                                        	'title' => get_the_title($book)
                                        );                                    
                                    ?>                                                                        
                                    <?php echo get_the_post_thumbnail($book, 'thumb_size_222_250', $attr); ?>
                                    <?php $i++; ?>
                                    <?php } } ?>
                                </div>
                            </div>
                        </div>
                        <div class="col span_8_of_12">
                            <p><strong><i class="fa fa-book"></i>&nbsp;&nbsp;Title: </strong><?php the_title(); ?></p>
                            <p><strong><i class="fa fa-link"></i>&nbsp;&nbsp;Link: </strong><a href="<?php bloginfo('url'); ?>/bookshelf/?bid=<?php echo get_the_ID(); ?>" target="_blank"><?php bloginfo('url'); ?>/bookshelf/<?php echo get_the_ID(); ?></a></p>
                            <p><strong><i class="fa fa-clock-o"></i>&nbsp;&nbsp;Create Time: </strong><?php the_time('Y-m-d H:i:s'); ?></p>
                            
                            <div id="qup" style="display: none;"><?php get_sidebar('bookcaseedit'); ?></div>
                            <a href="#qup" class="quick_up"><i class="fa fa-pencil"></i>&nbsp; &nbsp; &nbsp;Edit <?php the_title(); ?></a>
                            <a href="<?php the_permalink(); ?>/?action=delete" class="quick_up"><i class="fa fa-trash"></i>&nbsp; &nbsp; &nbsp;Delete <?php the_title(); ?></a>
                        </div>
                    </div>
                    <hr />              
                </div>                   
	        </div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>