<?php /* Template Name: Bookshelf */ ?>
<?php get_header(); ?>
<style>
#header, #footer, #copy {
    display: none;
}
</style>

<div id="bookshelf_slider" class="bookshelf_slider">
    
    <div class="panel_title">
        <div class="selected_title_box"><div class="selected_title">Selected Title</div></div>
        
        <div class="menu_top">
        </div>
    </div><!-- .panel_title -->    
    <div class="panel_slider">
        <div class="panel_items">
            <div class="slide_animate">
                <div class="products_box" id="products_box_2">
                    <?php
                        $books = get_post_meta($_GET['bid'], 'books', true);
                        $books_array = json_decode($books);
                    ?>
                    <?php foreach($books_array as $book) { ?>
                        <div class="product" data-type="magazine" data-popup="true" data-url="bookshelf/images/magazine_large.png" title="Magazine"><a href="<?php echo get_the_permalink($book); ?>" target="_blank"><?php echo get_the_post_thumbnail($book, 'thumb_size_85_109'); ?></a></div>
                    <?php } ?>
                </div>
            </div>           
        </div><!-- panel_items -->
    </div><!-- panel_slider -->    
    <div class="panel_bar">
        <div class='buttons_container'>
        </div>
    </div>    
</div><!-- bookshelf_slider -->


<script type="text/javascript"> 
    jQuery(document).ready(function() {
        //define custom parameters
        jQuery.bookshelfSlider('#bookshelf_slider', {
            'item_width': '100%', //responsive design > resize window to see working
            'item_height': 180,
            'products_box_margin_left': 30,
            'product_title_textcolor': '#ffffff',
            'product_title_bgcolor': '#c33b4e',
            'product_margin': 30,
            'product_show_title': true,
            'show_title_in_popup': true,
            'show_selected_title': true,
            'show_icons': true,
            'buttons_margin': 15,
            'buttons_align': 'center', // left, center, right
            'slide_duration': 800,
            'slide_easing': 'easeOutQuart',
            'arrow_duration': 800,
            'arrow_easing': 'easeInOutQuart',
            'video_width_height': [500,290],
            'iframe_width_height': [500,330],
			'folder': 'bookshelf'
		});        
    });
</script>
<?php get_footer(); ?>