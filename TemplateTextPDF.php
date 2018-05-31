<?php /* Template Name: Text Version */ ?>
<?php get_header(); ?>
<?php global $user_ID; ?>
<?php
    $args = array(
        'p' => $_GET['pubid'],
        'post_type' => 'pub',
        'posts_per_page' => 1
    );
    $the_query = new WP_Query($args);
?>
<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
<?php
    $fav = get_post_meta(get_the_ID(), 'fav', true);
    $fav_array = array();
    $fav_array = json_decode($fav);
    if(!empty($fav_array)) {
        if(in_array($user_ID, $fav_array)) {
            $isfav = 'active';
        ?>
            <script>
                jQuery(document).ready(function() {
                   jQuery('a#fav').bind('click', removeFav); 
                });
            </script>
        <?php
        }
    }
?>
<?php
    $fol = get_user_meta(get_the_author_ID(), 'follow', true);
    $fol_array = array();
    $fol_array = json_decode($fav);
    if(!empty($fol_array)) {
        if(in_array($user_ID, $fol_array)) {
            $isfol = 'active';
        ?>
            <script>
                jQuery(document).ready(function() {
                    jQuery('a#follow').bind('click', removeFav);
                });
            </script>
        <?php
        }
    }
?>
<div id="content" class="text">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12"> 
                <div class="container">
                    <h1><?php the_title(); ?></h1>
                    <div><?php the_content(); ?></div>
                    <h2>Text Version</h2>
                    <?php
                    $upload_dir = wp_upload_dir();
                    $uploaddir = $upload_dir['basedir'].'/ebooks/';
                    $filename = get_post_meta(get_the_ID(), 'upload_pdf', true);
                    echo $file = $uploaddir.$filename;
                    $fileloc = $uploaddir.'test.txt';                    
                    ?>
                    <p>
                    <?php
                        /*include('class.pdf2text.php');
                        $a = new PDF2Text();
                        $a->setFilename($file);
                        $a->decodePDF();
                        echo $a->output();*/
                    ?>
                    <?php
                        //echo $text = exec("pdftotext $file $fileloc");
                        //echo file_get_contents($fileloc);                        
                    ?>
                    </p>                    
                </div> 
                <?php if(is_user_logged_in()) { ?>
                <a href="javascript:void(0)" id="fav" class="<?php echo $isfav; ?>" title="[+] Add as favorite"><i class="fa fa-heart"></i></a>
                <?php if(get_the_author_ID() == $user_ID) { ?>
                <a href="<?php bloginfo('url'); ?>/edit-pub/?pid=<?php echo get_the_ID(); ?>" id="edit"><i class="fa fa-pencil"></i></a>
                <?php } ?>
                <?php } ?>                        
	        </div>
	    </div>
	    <div class="section group">
	        <div class="col span_4_of_12"> 
                <div class="user_info">
                    <div class="section group">
                        <div class="col span_6_of_12">
                            <?php echo get_image_size_100_100(get_the_author_ID()); ?>
                        </div>
                        <div class="col span_6_of_12">
                            <?php if(get_the_author_ID() != $user_ID) { ?>
                                <a id="follow" class="<?php echo $isfol; ?>" href="javascript:void(0)"><i class="fa fa-rss"></i>&nbsp; &nbsp; &nbsp;<?php if($isfol == 'active') { echo 'Unfollow'; } else { echo 'Follow'; } ?></a>
                            <?php } ?>
                            <div style="clear: both;"></div>
                            <?php
                                $author_id = get_the_author_ID();
                                $user_info = get_userdata($author_id);
                            ?>
                            <p style="text-align: right;"><a href="<?php bloginfo('url'); ?>/user/uid=<?php echo $author_id; ?>"><?php echo $user_info->display_name; ?></a></p>
                            <?php
                                $args = array(
                                	'meta_query' => array(
                                		array(
                                			'key'     => 'follow',
                                			'value'   => get_the_author_ID(),
                                			'compare' => 'LIKE'
                                		)
                                	)
                                 );
                                $user_query = new WP_User_Query( $args );
                            ?>
                            <p style="text-align: right;"><strong><i class="fa fa-rss"></i> Followers: <?php echo count($user_query->results); ?></strong></p>
                        </div>
                    </div>
                </div>                         
	        </div>
	        <div class="col span_4_of_12"> 
                <div class="share_emb">
                    <a href="<?php the_permalink(); ?>"><i class="fa fa-file-pdf-o"></i>Flip Version</a>
                </div>                     
	        </div>
	        <div class="col span_4_of_12"> 
                <?php get_sidebar('share'); ?>                         
	        </div>
	    </div>
        <?php
            $terms = wp_get_post_terms( get_the_ID(), 'pub_category' );
            //print_r($terms);
            $terms_array = array();
            foreach($terms as $term) {
                array_push($terms_array, $term->term_id);
            }
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $args1 = array(
                'post_type' => 'pub',
                'posts_per_page' => 12,
                'paged' => $paged,
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'pub_category',
                        'field' => 'id',
                        'terms' => $terms_array,
                        'include_children' => false,
                        'operator' => 'IN'
                    )
                )
            );
            $the_query1 = new WP_Query( $args1 );
            if ( $the_query1->have_posts() ) :
        ?>
        <div id="case">
            <div class="section group">
                <h1>Related Publications</h1>
                <?php while ( $the_query1->have_posts() ) : $the_query1->the_post(); ?>
                <div class="col span_3_of_12">
                    <div class="case_book">
                        <div class="book_img">
                            <?php
                                $image = get_post_meta(get_the_ID(), 'upload_pdf_image', true);
                            ?>
                            <img src="<?php bloginfo('url'); ?>/wp-content/uploads/ebooks/<?php echo $image; ?>" width="222px" height="150px" />
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
            <?php wp_pagenavi( array( 'query' => $the_query1 ) ); ?>
            
        </div>
        <?php
            endif;
            wp_reset_postdata();
        ?>
	</div>
</div>
<script>
function addFav(){
    var articleID = <?php echo get_the_ID(); ?>;
    jQuery.ajax({
      url: "<?php bloginfo('url'); ?>/favorite-add/",
      data: {"id": articleID},
      success: function(){
           jQuery('a#fav')
                 .addClass('active')
                 .attr('title','[-] Remove from favorites')
                 .unbind('click')
                 .bind('click', removeFav)
           ;
      }
    });
}
function removeFav(){
    var articleID = <?php echo get_the_ID(); ?>;
    jQuery.ajax({
      url: "<?php bloginfo('url'); ?>/favorite-remove/",
      data: {"id": articleID},
      success: function(){
            jQuery('a#fav')
                 .removeClass('active')
                 .attr('title','[+] Add as favorite')
                 .unbind('click')
                 .bind('click', addFav)
            ;
      }
    });
}
//this will make the link listen to function addFav (you might know this already)
jQuery('a#fav').bind('click', addFav);
</script>
<script>
function Follow(){
    jQuery('a#follow').html('<i class="fa fa-spinner fa-spin"></i>&nbsp; &nbsp; &nbsp;Loading');
    var articleID = <?php echo get_the_author_ID(); ?>;
    jQuery.ajax({
      url: "<?php bloginfo('url'); ?>/add-follow/",
      data: {"id": articleID},
      success: function(){
           jQuery('a#follow')
                 .addClass('active')
				 .html('<i class="fa fa-rss"></i>&nbsp; &nbsp; &nbsp;Unfollow')
                 .attr('title','[-] unfollow')
                 .unbind('click')
                 .bind('click', unFollow)
           ;
      }
    });
}
function unFollow(){
    jQuery('a#follow').html('<i class="fa fa-spinner fa-spin"></i>&nbsp; &nbsp; &nbsp;Loading');
    var articleID = <?php echo get_the_author_ID(); ?>;
    jQuery.ajax({
      url: "<?php bloginfo('url'); ?>/un-follow/",
      data: {"id": articleID},
      success: function(){
            jQuery('a#follow')
                 .removeClass('active')
				 .html('<i class="fa fa-rss"></i>&nbsp; &nbsp; &nbsp;Follow')
                 .attr('title','[+] Follow')
                 .unbind('click')
                 .bind('click', Follow)
            ;
      }
    });
}
jQuery('a#follow').bind('click', Follow);
</script>
<?php endwhile; ?>
<?php get_footer(); ?>