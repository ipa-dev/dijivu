<?php /* Template Name: Book Cases */ ?>
<?php if(is_user_logged_in()) { ?>
<?php get_header(); ?>
<?php global $user_ID; ?>
<?php $user_info = get_userdata($user_ID); ?>
<div id="my_account">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_2_of_12">
                <?php get_sidebar('accnav'); ?>                                      
	        </div>
	        <div class="col span_10_of_12"> 
                <div id="acc_section">
                <div id="qup" style="display: none;"><?php get_sidebar('bookcase') ?></div>
                <a href="#qup" class="quick_up"><i class="fa fa-cloud-upload"></i>&nbsp; &nbsp; &nbsp;Add new Bookcase</a>
                <h1>My Bookcases</h1>
                <?php
                    $args = array(
                        'post_type' => 'bookcase',
                        'posts_per_page' => -1,
                        'author' => $user_ID
                    );
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) :
                ?>
                <div id="case" class="inner book">
                    <div class="section group">
                        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                        <div class="col span_3_of_12">
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
                                <div class="book_hover"><a href="<?php the_permalink(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                            </div>
                            <p><?php the_title(); ?></p>
                            <p><?php echo $i-1; ?> Books.</p>                    
            	        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php wp_pagenavi( array( 'query' => $the_query ) ); ?>
                    
                </div>
                <?php
                    endif;
                    wp_reset_postdata();
                ?>
                </div>                   
	        </div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>