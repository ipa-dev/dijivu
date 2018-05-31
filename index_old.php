<?php get_header(); ?>
<div id="banner">
	<div class="maincontent noPadding">
	    <div class="section group">
	        <div class="col span_12_of_12 noMargin"> 
                <?php echo do_shortcode('[rev_slider home1]'); ?>                         
	        </div>
	    </div>
	</div>
</div>
<div id="how">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12"> 
                <?php
                    $args = array(
                        'page_id' => '299',
                        'post_status' => 'publish'
                    );
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                ?>
                <h1><?php the_title(); ?></h1>  
                <?php the_content(); ?>
                <?php
                    endwhile;
                    endif;
                    wp_reset_postdata();
                ?>                      
	        </div>
	    </div>
	    <div class="section group">
            <?php
                $args = array(
                    'post_type' => 'how',
                    'post_status' => 'publish',
                    'posts_per_page' => 4
                );
                $the_query = new WP_Query( $args );
                if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ) : $the_query->the_post();
            ?>
	        <div class="col span_3_of_12">  
                <div class="how_box matchheight">
                    <?php the_post_thumbnail('image_size_83_83'); ?>
                    <h2><?php the_title(); ?></h2> 
                    <?php the_content(); ?> 
                    <img class="how_box_arrow" src="<?php bloginfo('template_directory'); ?>/images/why_box_bg.png" />  
                </div>                    
	        </div>
            <?php
                endwhile;
                endif;
                wp_reset_postdata();
            ?>
	    </div>
	</div>
</div>
<!--<div id="why">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12">
                <?php
                    $args = array(
                        'page_id' => '287',
                        'post_status' => 'publish'
                    );
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) :
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                ?>
                <h1><?php the_title(); ?></h1>
                <div><?php the_content(); ?></div>
                <?php
                    endwhile;
                    endif;
                    wp_reset_postdata();
                ?>                                   
	        </div>
	    </div>
	</div>
</div> -->
<div id="case">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12">    
                <h1>Digital Publisher Case Studies</h1>  
                <h2>Learn Latest & Stunning Features with our Examples</h2>                    
	        </div>
	    </div>
        <?php
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => 'pub',
                'posts_per_page' => 12,
                'post_status' => 'publish',
                'meta_query' => array(array('key' => 'featured', 'value' => 1, 'type' => 'NUMERIC', 'compare' => '=')),
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) :
        ?>
        <div class="section group">
        <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
            <div class="col span_3_of_12 matchheight">
                <div class="case_book">
                    <div class="book_img">
                        <?php the_post_thumbnail('thumb_size_222_150'); ?>
                        <div class="book_hover"><a href="<?php the_permalink(); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p><a href="<?php the_permalink(); ?>"><?php if(get_post_status(get_the_ID()) == 'private1') { echo 'Private: '; } ?><?php the_title(); ?></a></p>                      
	        </div>
        <?php endwhile; ?>
        </div>
        <?php
            endif;
            wp_reset_postdata();
        ?>
	    <!--
        <div class="section group">
	        <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book1.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>CLINIQUE</p>                      
	        </div>
            <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book2.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>Boden</p>                      
	        </div>
            <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book3.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>ERIN</p>                      
	        </div>
            <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book4.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>blu</p>                      
	        </div>
         </div>
         <div class="section group">
            <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book5.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>CLINIQUE</p>                      
	        </div>
            <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book6.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>Boden</p>                      
	        </div>
            <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book7.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>ERIN</p>                      
	        </div>
            <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book8.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>blu</p>                      
	        </div>
         </div>
         <div class="section group">
            <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book9.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>CLINIQUE</p>                      
	        </div>
            <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book10.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>Boden</p>                      
	        </div>
            <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book11.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>ERIN</p>                      
	        </div>
            <div class="col span_3_of_12">
                <div class="case_book">
                    <div class="book_img">
                        <img src="<?php bloginfo('template_directory'); ?>/images/book12.jpg" />
                        <div class="book_hover"><a href="#"><img src="<?php bloginfo('template_directory'); ?>/images/book_view.png" /></a></div>
                    </div>
                </div>
                <p>blu</p>                      
	        </div>
         </div>
	    </div>
        -->
	</div>
</div>

<div id="digital">
    <?php
        $args = array(
            'page_id' => '294',
            'post_status' => 'publish'
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post();
    ?>
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12"> 
                <h1><?php the_title(); ?></h1>                         
	        </div>
	    </div>
	    <div class="section group">
	        <div class="col span_6_of_12">  
                <?php the_post_thumbnail('full'); ?>                   
	        </div>
	        <div class="col span_6_of_12"> 
                <?php the_content(); ?>
                <a class="read_more" href="<?php the_permalink(); ?>">Read More</a>                     
	        </div>
	    </div>
	</div>
    <?php
        endwhile;
        endif;
        wp_reset_postdata();
    ?>
</div>
<!--<div id="trust">
    <?php
        $args = array(
            'page_id' => '313',
            'post_status' => 'publish'
        );
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post();
    ?>
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12"> 
                <h1><?php the_title(); ?></h1>                         
	        </div>
	    </div>
	    <div class="section group"><?php the_content(); ?></div>
	</div>
    <?php
        endwhile;
        endif;
        wp_reset_postdata();
    ?>    
</div>-->
<!--<div id="testimonial">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12">
                <h1>Testimonials</h1>                          
	        </div>
	    </div>
	    <div class="section group">
	        <div class="col span_12_of_12">
                <?php
                    $args = array(
                        'post_type' => 'testimonial',
                        'posts_per_page' => -1,
                        'post_status' => 'publish'
                    );
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) :
                ?>
                <div class="bxslider">
                    <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                    <div class="slide">
                        <?php the_content(); ?>
                        <div class="testi_img"><?php the_post_thumbnail('image_size_133_133'); ?></div>
                        <div class="testi_name"><?php the_title(); ?></div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <div class="slider_prev"></div>
                <div class="slider_next"></div> 
                <?php
                    endif;
                    wp_reset_postdata();
                ?>                       
	        </div>
	    </div>
	</div>
</div> -->
<?php get_footer(); ?>