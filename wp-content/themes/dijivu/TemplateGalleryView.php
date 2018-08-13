<?php /* Template Name: Gallery View */ ?>
<?php get_header(); ?>
<div id="content">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12"> 
                <div class="container">
                    <?php while (have_posts()) : the_post(); ?>
                    <h1><?php the_title(); ?></h1>
                    <div class="gallery_front">
                        <?php $gid = json_decode(decripted($_GET['gid'])); ?>
                        <?php foreach($gid as $g) { ?>
                        <?php $image = get_post_meta($g, 'upload_pdf_image', true); ?>
                        <div class="metro-tile"><a href="<?php echo get_the_permalink($g); ?>" target="_blank"><img src="<?php bloginfo('url'); ?>/wp-content/uploads/ebooks/<?php echo $image; ?>" /></a></div>
                        <?php } ?>
                    </div>
                    <?php endwhile; ?>  
                </div>                         
	        </div>
	    </div>
	</div>
</div>
<?php get_footer(); ?>