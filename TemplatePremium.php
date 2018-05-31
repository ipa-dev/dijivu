<?php /* Template Name: Premium Page Template */ ?>
<?php get_header(); ?>
<div id="content">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12"> 
                <div class="container">
                    <?php while (have_posts()) : the_post(); ?>
                    <h1><?php the_title(); ?></h1>
                    <div><?php the_content(); ?></div>
                    <?php endwhile; ?>  
                </div>                         
	        </div>
	    </div>
	</div>
</div>
<div id="plans">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12">
                <?php
                    $args = array(
                        'post_type' => 'plan',
                        'posts_per_page' => -1,
                        'post_status' => 'publish'
                    );
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) :
                ?>
                <table>
                    <thead>
                        <tr>
                            <td></td>
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <td style="background-color: <?php the_field('plan_color'); ?>;">
                                <div class="plan_name"><h3><?php the_title(); ?></h3></div>
                                <div class="plan_price"><sup>$</sup><?php the_field('price'); ?><sub>/month</sub></div>
                                <div class="plan_buy"><a href="<?php bloginfo('url'); ?>/plan-buy/?palnid=<?php echo get_the_ID(); ?>">
                                <?php
                                    if(get_field('price') == 0) {
                                        echo 'Try Free';
                                    } else {
                                        echo 'Buy Now';
                                    }
                                ?>
                                </a></div>
                            </td>
                            <?php endwhile; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Storage</td>
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <td>
                            <?php
                                if(get_field('storage') == 0) {
                                    echo 'Unlimited';
                                } else { 
                                    the_field('storage');
                                    echo ' GB'; 
                                } 
                            ?>
                            </td>
                            <?php endwhile; ?>
                        </tr>
                        <tr>
                            <td>Upload / Month</td>
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <td>
                            <?php
                                if(get_field('upload') == 0) {
                                    echo 'Unlimited';
                                } else { 
                                    the_field('upload'); 
                                } 
                            ?>
                            </td>
                            <?php endwhile; ?>
                        </tr>
                        <tr>
                            <td>Pages Per Book</td>
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <td>
                            <?php
                                if(get_field('pages') == 0) {
                                    echo 'Unlimited';
                                } else { 
                                    the_field('pages'); 
                                } 
                            ?>
                            </td>
                            <?php endwhile; ?>
                        </tr>
                        <tr>
                            <td>Watermark</td>
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <td>
                            <?php
                                if(get_field('watermark') == 1) {
                                    echo 'Yes';
                                } else { 
                                    echo 'No'; 
                                } 
                            ?>
                            </td>
                            <?php endwhile; ?>
                        </tr>
                        <tr>
                            <td>Text Version</td>
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <td>
                            <?php
                                if(get_field('text') == 1) {
                                    echo 'Yes';
                                } else { 
                                    echo 'No'; 
                                } 
                            ?>
                            </td>
                            <?php endwhile; ?>
                        </tr>
                        <tr>
                            <td>Custom Logo / Branding</td>
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <td>
                            <?php
                                if(get_field('logo') == 1) {
                                    echo 'Yes';
                                } else { 
                                    echo 'No'; 
                                } 
                            ?>
                            </td>
                            <?php endwhile; ?>
                        </tr>
                        <tr>
                            <td>Custom Background Color</td>
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <td>
                            <?php
                                if(get_field('color') == 1) {
                                    echo 'Yes';
                                } else { 
                                    echo 'No'; 
                                } 
                            ?>
                            </td>
                            <?php endwhile; ?>
                        </tr>
                        <tr>
                            <td>Custom Background Image</td>
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <td>
                            <?php
                                if(get_field('bg') == 1) {
                                    echo 'Yes';
                                } else { 
                                    echo 'No'; 
                                } 
                            ?>
                            </td>
                            <?php endwhile; ?>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                            <td style="background-color: <?php the_field('plan_color'); ?>;">
                                <div class="plan_price"><sup>$</sup><?php the_field('price'); ?><sub>/month</sub></div>
                                <div class="plan_buy"><a href="<?php bloginfo('url'); ?>/plan-buy/?palnid=<?php echo get_the_ID(); ?>">
                                <?php
                                    if(get_field('price') == 0) {
                                        echo 'Try Free';
                                    } else {
                                        echo 'Buy Now';
                                    }
                                ?>
                                </a></div>
                            </td>
                            <?php endwhile; ?>
                        </tr>
                    </tfoot>
                </table>
                <?php
                    endif;
                    wp_reset_postdata();
                ?>                          
	        </div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>