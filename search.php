<?php get_header(); ?>
<div id="">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12"> 
                <h1>Search Results: &quot;<span><?php echo get_search_query(); ?></span>&quot;</h1>                         
	        </div>
	    </div>
        <?php
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => 'pub',
                's' => $_GET['s'],
                'posts_per_page' => 12,
                'paged' => $paged,
                'post_status' => 'publish'
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) :
        ?>
        <div id="case">
            <div class="section group">
                <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="col span_3_of_12">
                    <div class="case_book">
                        <div class="book_img">
                            <?php the_post_thumbnail('thumb_size_222_150'); ?>
                            <div class="book_hover"><a href="<?php the_permalink(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                        </div>
                    </div>
                    <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
                    <?php
                        $author_id = get_the_author_ID();
                        $user_info = get_userdata($author_id);
                    ?>
                    <small><a href="<?php bloginfo('url'); ?>/user/uid=<?php echo $author_id; ?>"><?php echo $user_info->display_name; ?></a></small> 
                    <p class="case_content"><?php echo content(15, get_the_ID()); ?></p>                     
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
<?php get_footer(); ?>