<?php /* Template Name: My Account */ ?>
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
                <?php if($_GET['status'] == 'upload_complete') { ?>
                    <p class="successMsg">Upload Successful...</p>
                <?php } ?>
                <?php if($_GET['status'] == 'upload_failed_page') { ?>
                    <p class="errorMsg">Too many pages, Please upgrade your plan...</p>
                <?php } ?>
                <h1><?php the_title(); ?></h1>
                <?php
                    $args = array(
                        'post_type' => 'pub',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'author' => $user_ID,
                    );
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) :
                    $i = 0;
                    $j = 0;
                    while ( $the_query->have_posts() ) : $the_query->the_post();
                        $upload_dir = wp_upload_dir();
                        $uploaddir = $upload_dir['basedir'].'/ebooks/';
                        $filename = get_post_meta(get_the_ID(), 'upload_pdf', true);
                        $file = $uploaddir.$filename;
                        $i = $i + formatbytes($file, 'GB');
                        if(get_the_time('m') == date('m')) {
                            $j = $j + 1;
                        }
                    endwhile;
                    endif;
                    wp_reset_postdata();
                ?>
                <?php
                    $storage = get_field('storage', get_user_meta($user_ID, 'plan', true));
                    $upload = get_field('upload', get_user_meta($user_ID, 'plan', true));
                ?>
                <?php if($storage == 0 && $upload == 0) { ?>
                <div id="qup" style="display: none;"><?php get_sidebar('quickupload') ?></div>
                <a href="#qup" class="quick_up"><i class="fa fa-cloud-upload"></i>&nbsp; &nbsp; &nbsp;Quick Upload</a>
                <a href="<?php bloginfo('url'); ?>/create-new-publication" class="quick_up"><i class="fa fa-plus-circle"></i>&nbsp; &nbsp; &nbsp;Create New Publication</a>
                <?php } else { ?>                
                <?php if($i <= $storage && $j <= $upload) { ?>
                <div id="qup" style="display: none;"><?php get_sidebar('quickupload') ?></div>
                <a href="#qup" class="quick_up"><i class="fa fa-cloud-upload"></i>&nbsp; &nbsp; &nbsp;Quick Upload</a>
                <a href="<?php bloginfo('url'); ?>/create-new-publication" class="quick_up"><i class="fa fa-plus-circle"></i>&nbsp; &nbsp; &nbsp;Create New Publication</a>
                <?php } else { ?>
                <p class="warningMsg">Plan Limit Exceeded...</p>
                <?php } ?>
                <?php } ?>
                <a href="<?php bloginfo('url'); ?>/edit-existing-publications" class="quick_up"><i class="fa fa-pencil"></i>&nbsp; &nbsp; &nbsp;Edit Existing Publication</a>
                <h1>My Uploads</h1>
                <?php
                    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                    $args = array(
                        'post_type' => 'pub',
                        'posts_per_page' => 8,
                        'author' => $user_ID,
                        'paged' => $paged
                    );
                    $the_query = new WP_Query( $args );
                    if ( $the_query->have_posts() ) :
                        if(get_post_status(get_the_ID()) != 'draft') {
                            ?>
                            <div id="case" class="inner">
                                <div class="section group">
                                    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                                        <div class="col span_3_of_12 matchheight">
                                            <div class="case_book">
                                                <div class="book_img">
                                                    <?php the_post_thumbnail('thumb_size_222_150'); ?>
                                                    <div class="book_hover"><a href="<?php the_permalink(); ?>"><img
                                                                    src="<?php bloginfo('template_directory'); ?>/images/book_view.png"/></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <p>
                                                <a href="<?php the_permalink(); ?>"><?php if (get_post_status(get_the_ID()) == 'private1') {
                                                        echo 'Private: ';
                                                    } ?><?php the_title(); ?></a></p>
                                            <?php
                                            $author_id = get_the_author_ID();
                                            $user_info = get_userdata($author_id);
                                            ?>
                                            <small>
                                                <a href="<?php bloginfo('url'); ?>/user/uid=<?php echo $author_id; ?>"><?php echo $user_info->display_name; ?></a>
                                            </small>
                                            <p class="case_content"><?php echo content(15, get_the_ID()); ?></p>
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                                <?php wp_pagenavi(array('query' => $the_query)); ?>

                            </div>
                            <?php
                        }
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