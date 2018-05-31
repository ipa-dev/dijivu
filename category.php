<?php get_header(); ?>
<div id="content">
	<div class="maincontent">
        <div class="section group">
	        <div class="col span_12_of_12">
                <h1><strong>Category: </strong><?php single_cat_title(); ?></h1>                        
	        </div>
	    </div>
	    <div class="section group">
            <div class="col span_8_of_12">        
                <?php
                if ( have_posts() ) :
                while ( have_posts() ) : the_post();
                ?>
                <div class="section group">
                    <div class="col span_12_of_12 matchheight2">
                      <div class="sing_post">
                        <div class="post_img"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog-thumb'); ?></a></div>
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <?php the_excerpt(); ?>
                        <div class="postReadMorebg"><a href="<?php the_permalink(); ?>">Read More</a></div>
                      </div>  
                    </div>        
                </div>
                <?php            
                endwhile;
                endif;
                wp_reset_postdata();
                ?>
                <div class="section group">
                    <div class="col span_12_of_12">
                        <?php if(function_exists('wp_pagenavi')) { wp_pagenavi(); } ?>
                    </div>
                </div>
            </div>
            <div class="col span_4_of_12">
                <?php get_sidebar(); ?>
            </div>
        </div>
	</div>
</div>
<?php get_footer(); ?>