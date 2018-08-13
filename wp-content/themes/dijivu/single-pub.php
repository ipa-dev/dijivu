<?php get_header(); ?>
<?php global $user_ID; ?>
<?php while ( have_posts() ) : the_post(); ?>
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
    $fol_array = json_decode($fol);
    if(!empty($fol_array)) {
        if(in_array($user_ID, $fol_array)) {
            $isfol = 'active';
        ?>
            <script>
                jQuery(document).ready(function() {
                    jQuery('a#follow').bind('click', unFollow);
                });
            </script>
        <?php
        }
    }
?>
<div class="flipbook-viewport">
<?php if(is_user_logged_in()) { ?>
<a href="javascript:void(0)" id="fav" class="<?php echo $isfav; ?>" title="[+] Add as favorite"><i class="fa fa-heart"></i></a>
<?php if(get_the_author_ID() == $user_ID) { ?>
<?php $created_from_gallery = get_post_meta(get_the_ID(), 'created_from_gallery', true); ?>
<?php if($created_from_gallery == 1) { ?>
<a href="<?php bloginfo('url'); ?>/edit-pub-gallery/?pid=<?php echo get_the_ID(); ?>" id="edit"><i class="fa fa-pencil"></i></a>
<?php } else { ?>
<a href="<?php bloginfo('url'); ?>/edit-pub/?pid=<?php echo get_the_ID(); ?>" id="edit"><i class="fa fa-pencil"></i></a>
<?php } ?>
<?php } ?>
<?php } ?>
<style>
<?php
    $bg_color = get_post_meta(get_the_ID(), 'bg-color', true);
    $bg_img = wp_get_attachment_image_src(get_post_meta(get_the_ID(), 'bg-img', true), 'full');
    if(!empty($bg_color)) {
?>
.flexpaper_viewer_container {
    background-color: <?php echo $bg_color; ?> !important;
}
<?php } ?>
<?php
    if(!empty($bg_img)) {
?>
.flexpaper_viewer_container {
    background-image: url(<?php echo $bg_img[0]; ?>) !important;
    background-position: top left !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;
}
<?php } ?>
</style>        
	<!--<div class="container">
		<div id="documentViewer" class="flowpaper_viewer"></div>
	</div>-->
    <?php
    $upload_dir = wp_upload_dir();
    $uploaddir = $upload_dir['basedir'].'/ebooks/';
    $filename = get_post_meta(get_the_ID(), 'upload_pdf', true);
    $file = get_bloginfo('url').'/wp-content/uploads/ebooks/'.$filename;
    echo do_shortcode('[flipbook pdf="'.$file.'"]');
    ?>
    <div class="logo_hider"></div>
</div>
<div id="content">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12"> 
                <div class="container">
                    <h1><?php the_title(); ?></h1>
                <div><?php the_content(); ?></div>
                </div>                         
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
                            <?php if((get_the_author_ID() != $user_ID) && is_user_logged_in()) { ?>
                                <a id="follow" class="<?php echo $isfol; ?>" href="javascript:void(0)"><i class="fa fa-rss"></i>&nbsp; &nbsp; &nbsp;<?php if($isfol == 'active') { echo 'Unfollow'; } else { echo 'Follow'; } ?></a>
                            <?php } ?>
                            <div style="clear: both;"></div>
                            <?php
                                $author_id = get_the_author_ID();
                                $user_info = get_userdata($author_id);
                            ?>
                            <h2 style="text-align: right; margin-bottom: 5px;"><a href="<?php bloginfo('url'); ?>/user/uid=<?php echo $author_id; ?>"><?php echo $user_info->display_name; ?></a></h2>
                            <?php
                                $follow_num = get_user_meta(get_the_author_ID(), 'follow', true);
                                $follow_num_array = json_decode($follow_num);
                            ?>
                            <p class="follow_update" style="text-align: right;"><strong><i class="fa fa-rss"></i> Followers: <?php echo count($follow_num_array); ?></strong></p>
                        </div>
                    </div>
                </div>                         
	        </div>
	        <div class="col span_4_of_12"> 
                <div class="share_emb">
                    <a href="<?php bloginfo('url'); ?>/text-version/?pubid=<?php echo get_the_ID(); ?>"><i class="fa fa-font"></i>Text Version</a>
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
                <div class="col span_3_of_12 matchheight">
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
            <?php wp_pagenavi( array( 'query' => $the_query1 ) ); ?>
            
        </div>
        <?php
            endif;
            wp_reset_postdata();
        ?>
	</div>
</div>
<?php
$upload_dir = wp_upload_dir();
$uploaddir = $upload_dir['basedir'].'/ebooks/';
$filename = get_post_meta(get_the_ID(), 'upload_pdf', true);
$file = get_bloginfo('url').'/wp-content/uploads/ebooks/'.$filename;
?>
<!--<script type="text/javascript">
    jQuery(function($) {
        $('#documentViewer').FlowPaperViewer(
            { config : {
                PDFFile : '<?php /*echo $file; */?>',
            }}
        );
    });
</script>-->
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
<?php if($isfav != 'active') { ?>
jQuery('a#fav').bind('click', addFav);
<?php } ?>
</script>
<script>
function Follow(){
    jQuery('a#follow').html('<i class="fa fa-spinner fa-spin"></i>&nbsp; &nbsp; &nbsp;Loading');
    var userid = <?php echo get_the_author_ID(); ?>;
    jQuery.ajax({
      url: "<?php bloginfo('url'); ?>/add-follow/",
      data: {"id": userid},
      success: function(response){
           jQuery('a#follow')
                 .addClass('active')
				 .html('<i class="fa fa-rss"></i>&nbsp; &nbsp; &nbsp;Unfollow')
                 .attr('title','[-] unfollow')
                 .unbind('click')
                 .bind('click', unFollow)
           ;
           jQuery('.follow_update').html('<strong><i class="fa fa-rss"></i> Followers: '+(response+1)+'</strong>');
      }
    });
}
function unFollow(){
    jQuery('a#follow').html('<i class="fa fa-spinner fa-spin"></i>&nbsp; &nbsp; &nbsp;Loading');
    var userid = <?php echo get_the_author_ID(); ?>;
    jQuery.ajax({
      url: "<?php bloginfo('url'); ?>/un-follow/",
      data: {"id": userid},
      success: function(response){
            jQuery('a#follow')
                 .removeClass('active')
				 .html('<i class="fa fa-rss"></i>&nbsp; &nbsp; &nbsp;Follow')
                 .attr('title','[+] Follow')
                 .unbind('click')
                 .bind('click', Follow)
            ;
           jQuery('.follow_update').html('<strong><i class="fa fa-rss"></i> Followers: '+(response)+'</strong>');
      }
    });
}
<?php if($isfol != 'active') { ?>
jQuery('a#follow').bind('click', Follow);
<?php } ?>
</script>
<?php endwhile; ?>
<?php get_footer(); ?>