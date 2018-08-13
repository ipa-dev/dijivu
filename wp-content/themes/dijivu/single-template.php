<?php if(is_user_logged_in()) { ?>
<?php get_header(); ?>
<?php global $user_ID; ?>
<?php $user_info = get_userdata($user_ID); ?>
<?php $img_num = 99; ?>
<div id="my_account">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_2_of_12">
                <?php get_sidebar('accnav'); ?>
	        </div>
	        <div class="col span_10_of_12">
                <div id="acc_section" class="mob_responsive">
                    <?php if(isset($_GET['search_type'])) { ?>
                    <div class="section group">
                        <div class="col span_8_of_12 matchheight">
                            <?php if($_GET['search_type'] == 'images_lib') { ?>
                            <div id="dragAndDropFiles" class="uploadArea">
                            	<h1>Drop Images Here to Upload into Gallery</h1>
                            </div>
                            <form name="demoFiler" id="demoFiler" enctype="multipart/form-data">
                            <p style="display: none;"><input type="file" name="multiUpload" id="multiUpload" multiple="multiple" /></p>
                            <p><input type="submit" name="submitHandler" id="submitHandler" value="Upload" class="buttonUpload" /></p>
                            </form>
                            <div class="progressBar">
                            	<div class="status"></div>
                            </div>
                            <?php } ?>
                            <?php if($_GET['search_type'] == 'designer_lib') { ?>
                            <div class="section group">
                            <div class="col span_1_of_4">
                            <select name="color" class="tags">
                                <option value="NULL">Select Color</option>
                                <?php
                                    $taxonomy = 'gallery_category_color';
                                    $tax_terms = get_terms($taxonomy, array(
                                        'hide_empty' => 0,
                                        'orderby' => 'slug',
                                    ));
                                ?>
                                <?php
                                foreach ($tax_terms as $tax_term) {
                                    /*$args_tax = array(
                                        'post_type' => 'pub_gallery_img',
                                        'posts_per_page' => -1,
                                        'post_status' => 'publish',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => $taxonomy,
                                                'field' => 'id',
                                                'terms' => array($tax_term->term_id),
                                                'operator' => 'IN'
                                            )
                                        ),
                                        'meta_query' => array(array('key' => '_thumbnail_id')),
                                        //'author' => -$user_ID
                                    );
                                    $the_query_tax = new WP_Query( $args_tax );*/
                                    echo '<option value="'.$tax_term->term_id.'">'.$tax_term->name.'('./*$the_query_tax->post_count*/$tax_term->count.')</option>';
                                }
                                ?>
                            </select>
                            </div>
                            <div class="col span_1_of_4">
                            <select name="designer" class="tags">
                                <option value="NULL">Select Designer</option>
                                <?php
                                    $taxonomy = 'gallery_category_designer';
                                    $tax_terms = get_terms($taxonomy, array(
                                        'hide_empty' => 0,
                                        'orderby' => 'slug',
                                    ));
                                ?>
                                <?php
                                    foreach ($tax_terms as $tax_term) {
                                        /*$args_tax = array(
                                            'post_type' => 'pub_gallery_img',
                                            'posts_per_page' => -1,
                                            'post_status' => 'publish',
                                            'tax_query' => array(
                                                array(
                                                    'taxonomy' => $taxonomy,
                                                    'field' => 'id',
                                                    'terms' => array($tax_term->term_id),
                                                    'operator' => 'IN'
                                                )
                                            ),
                                            'meta_query' => array(array('key' => '_thumbnail_id')),
                                            //'author' => -$user_ID
                                        );
                                        $the_query_tax = new WP_Query( $args_tax );*/
                                        echo '<option value="'.$tax_term->term_id.'">'.$tax_term->name.'('./*$the_query_tax->post_count*/$tax_term->count.')</option>';
                                    }
                                ?>
                            </select>
                            </div>
                            <div class="col span_1_of_4">
                            <select name="style" class="tags">
                                <option value="NULL">Select Style</option>
                                <?php
                                    $taxonomy = 'gallery_category_style';
                                    $tax_terms = get_terms($taxonomy, array(
                                        'hide_empty' => 0,
                                        'orderby' => 'slug',
                                    ));
                                ?>
                                <?php
                                foreach ($tax_terms as $tax_term) {
                                    /*$args_tax = array(
                                        'post_type' => 'pub_gallery_img',
                                        'posts_per_page' => -1,
                                        'post_status' => 'publish',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => $taxonomy,
                                                'field' => 'id',
                                                'terms' => array($tax_term->term_id),
                                                'operator' => 'IN'
                                            )
                                        ),
                                        'meta_query' => array(array('key' => '_thumbnail_id')),
                                        //'author' => -$user_ID
                                    );
                                    $the_query_tax = new WP_Query( $args_tax );*/
                                    echo '<option value="'.$tax_term->term_id.'">'.$tax_term->name.'('./*$the_query_tax->post_count*/$tax_term->count.')</option>';
                                }
                                ?>
                            </select>
                            </div>
                            <div class="col span_1_of_4">
                            <select name="event" class="tags">
                                <option value="NULL">Select Event</option>
                                <?php
                                    $taxonomy = 'gallery_category_event';
                                    $tax_terms = get_terms($taxonomy, array(
                                        'hide_empty' => 0,
                                        'orderby' => 'slug',
                                    ));
                                ?>
                                <?php
                                foreach ($tax_terms as $tax_term) {
                                    /*$args_tax = array(
                                        'post_type' => 'pub_gallery_img',
                                        'posts_per_page' => -1,
                                        'post_status' => 'publish',
                                        'tax_query' => array(
                                            array(
                                                'taxonomy' => $taxonomy,
                                                'field' => 'id',
                                                'terms' => array($tax_term->term_id),
                                                'operator' => 'IN'
                                            )
                                        ),
                                        'meta_query' => array(array('key' => '_thumbnail_id')),
                                        //'author' => -$user_ID
                                    );
                                    $the_query_tax = new WP_Query( $args_tax );*/
                                    echo '<option value="'.$tax_term->term_id.'">'.$tax_term->name.'('./*$the_query_tax->post_count*/$tax_term->count.')</option>';
                                }
                                ?>
                            </select>
                            </div>
                            </div>
                            <br />
                            <?php } ?>
                            <?php if($_GET['search_type'] == 'style_no') { ?>
                                <a href="#style_no_search" class="fancybox_small quick_up">Search</a>
                                <div id="style_no_search" style="display: none; text-align: center;">
                                    <form class="style_no_search">
                                        <input type="text" value="" name="search_style_no" placeholder="Enter Style Number" />
                                        <br /><br />
                                        <input type="submit" value="Search" name="submit_style_no" />
                                    </form>
                                </div>
                            <?php } ?>
                            <div id="left-events" class="items">
                            <?php
                                //$paged = get_query_var('paged') ? get_query_var('paged') : 1;
                                if($_GET['search_type'] == 'images_lib') {
                                    global $user_ID;
                                    $args = array(
                                        'post_type' => 'pub_gallery_img',
                                        'posts_per_page' => $img_num,
                                        'post_status' => 'publish',
                                        'author' => $user_ID,
                                        'meta_query' => array(array('key' => '_thumbnail_id'))
                                    );
                                } else {
                                    $args = array(
                                        'post_type' => 'pub_gallery_img',
                                        'posts_per_page' => $img_num,
                                        'post_status' => 'publish',
                                        'author' => -$user_ID,
                                        'meta_query' => array(array('key' => '_thumbnail_id'))
                                    );
                                }
                                $the_query = new WP_Query( $args );
                                if ( $the_query->have_posts() ) :
                                while ( $the_query->have_posts() ) : $the_query->the_post();
                            ?>
                                <div class="metro-tile diji_share_<?php echo get_the_ID(); ?>" data-id="<?php echo get_the_ID(); ?>">
                                    <a href="javascript:void(0)">
                                        <?php the_post_thumbnail('thumb_size_200_185', array('class' => 'lazy')); ?>
                                        <span class="style_no"><?php echo get_post_meta(get_the_ID(), 'style_no', true); ?></span>
                                    </a>
                                    <?php if($_GET['search_type'] == 'images_lib') { ?><a href="javascript:void(0)" onclick="galleryDelete(<?php echo get_the_ID(); ?>)" class="metro-tile-delete"><i class="fa fa-trash"></i></a><?php } ?>
                                </div>
                           <?php
                                endwhile;
                            ?>
                                <div style="clear: both;"></div>
                                <div id="custom_pagination">
                                    <?php
                                        $found_posts = $the_query->found_posts;
                                        if($found_posts >1) {
                                            $pages = round($found_posts/$img_num);
                                    ?>
                                    <ul>
                                        <?php for($i=1;$i<=$pages;$i++) { ?>
                                            <li><a<?php if($i == 1) { ?> class="active" <?php } else { ?>  onclick="pagination(<?php echo $i; ?>)";<?php } ?> href="javascript:void(0);"><?php echo $i; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php
                                endif;
                                wp_reset_postdata();
                            ?>
                            <div id="loading" style="text-align: center; display: none;">
                                <img src="<?php bloginfo('template_directory'); ?>/images/loading_spinner.gif"/>
                            </div>
                        </div>
                        <div class="col span_4_of_12 matchheight">
                            <div class="share_drop">
                                <div id="right-events" class="share_drop_div">
                                    <h1>Drop Images Here to Create Publication</h1>
                                    <a href="javascript:void(0);" class="gallery_share"><i class="fa fa-share-alt"></i>Create Publication</a>
                                    <a href="javascript:void(0);" class="preview_edit"><i class="fa fa-eye" aria-hidden="true"></i>Preview Edit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } else { ?>
                    <a class="quick_up" href="<?php the_permalink(); ?>/?search_type=designer_lib"><i class="fa fa-folder-open" aria-hidden="true"></i> Browse Designer Library</a>
                    <a class="quick_up" href="<?php the_permalink(); ?>/?search_type=style_no"><i class="fa fa-search" aria-hidden="true"></i> Search by Style Number</a>
                    <a class="quick_up" href="<?php the_permalink(); ?>/?search_type=images_lib"><i class="fa fa-picture-o" aria-hidden="true"></i> My Images Library</a>
                    <?php } ?>
                </div>
	        </div>
	    </div>
	</div>
</div>
<div id="quick_share" style="display: none;"></div>
<script>
    jQuery('.share_drop div a.gallery_share').click(function() {
        jQuery(this)
            .html('<i class="fa fa-spinner fa-pulse"></i>Loading')
            .attr('title','Loading')
        ;
        var current_obj = jQuery(this);
        var parent = jQuery(this).parent();
        var arr = [];
        jQuery(parent).children('.metro-tile').each(function() {
            var valid;
            valid = jQuery(this).attr('data-id');
            arr.push(valid);
        });
        var template = <?php echo get_the_ID(); ?>;
        jQuery.ajax({
          url: "<?php bloginfo('url'); ?>/gallery-create-publication-ajax",
          data: {"id_arr": arr},
          type: 'POST',
          success: function(response){
            jQuery('#quick_share').html(response);
            jQuery.fancybox.open( {
                content: jQuery("#quick_share"),
                width  : '70%',
                height  : '80%',
                autoSize : false,
                modal : false,
                closeBtn: true,
                helpers : { 
                    overlay : {closeClick: false}
                },
                afterClose : function () {
                     jQuery(current_obj)
                         .html('<i class="fa fa-share-alt"></i>Create Publication')
                         .attr('title', 'Create Publication')
                     ;
                }
            });
            jQuery(parent).css('border', '1px solid #4cbac7');
            jQuery('#pdfupload p .submit_button').click(function () {
                 jQuery(current_obj)
            	     .html('<i class="fa fa-check"></i>Publication Created')
                     .attr('title','Publication Created')
                     .unbind('click')
                 ;
             });
          }
        });
    });
    jQuery('.share_drop div a.preview_edit').click(function() {
        jQuery(this)
            .html('<i class="fa fa-spinner fa-pulse"></i>Loading')
            .attr('title','Loading')
        ;
        var current_obj = jQuery(this);
        var parent = jQuery(this).parent();
        var arr = [];
        jQuery(parent).children('.metro-tile').each(function() {
            var valid;
            valid = jQuery(this).attr('data-id');
            arr.push(valid);
        });
        var template = <?php echo get_the_ID(); ?>;
        jQuery.ajax({
          url: "<?php bloginfo('url'); ?>/gallery-edit-publication-ajax/",
          data: {"id_arr": arr, "template_id": template},
          type: 'POST',
          success: function(response){
            jQuery('#quick_share').html(response);
            jQuery.fancybox.open( {
                content: jQuery("#quick_share"),
                width  : '70%',
                height  : '90%',
                autoSize : false,
                modal : false,
                closeBtn : true,
                helpers : { 
                    overlay : {closeClick: false}
                },
            });
            //jQuery('.matchheight').matchHeight();
            tinymce.init({ 
                selector:'textarea.tm', 
                height : "1273",
                menubar: "edit format view",
                plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste imagetools layer",
                "textcolor"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor | add_button | change_bg",
                imagetools_cors_hosts: ['www.tinymce.com', 'codepen.io'],
                content_css: [
                '//www.tinymce.com/css/codepen.min.css',
                '<?php bloginfo('template_directory'); ?>/css/tinyMCE.css'
                ],
                setup: function (editor) {
                    editor.addButton('add_button', {
                        text: 'Add button',
                        icon: false,
                        /*onclick: function () {
                            editor.insertContent('&nbsp;<div style="display: inline-block; padding: 10px 20px; font-size: 16px; border-radius: 10px; color: #ffffff; background: #0A246A;">Add text Here</div>&nbsp;');
                        }*/
                        onclick : function() {
                            //console.log(editor);
                            editor.windowManager.open({
                                title: 'Add button',
                                body: [
                                    {type: 'textbox', name: 'source', label: 'Source'},
                                    {type: 'textbox', name: 'link', label: 'Link'},
                                    {type: 'colorpicker', name: 'color', label: 'Select Button Color'},
                                ],
                                onsubmit: function(e) {
                                    //console.log(e);
                                    editor.focus();
                                    editor.selection.setContent('&nbsp;<a href="' + e.data.link + '" style="display: inline-block; padding: 10px 20px; font-size: 16px; border-radius: 10px; color: #ffffff; text-decoration: none; background:' + e.data.color + ';">' + e.data.source + '</a>&nbsp;');
                                    //editor.selection.getContent()
                                }
                            });
                        }
                    });
                    /*editor.addButton('change_bg', {
                        text: 'Change BG From Selected ',
                        icon: false,
                        onclick: function () {
                            console.log(editor);
                        }
                    });*/
                },
                relative_urls: false,
                //extended_valid_elements:'script[language|type|src]',
                remove_script_host: false
            });
            jQuery(parent).css('border', '1px solid #4cbac7');
            jQuery(current_obj)
            	 .html('<i class="fa fa-eye" aria-hidden="true"></i>Preview Edit')
                 .attr('title','Preview Edit')
            ;
          }
        });
    });
</script>
<!-- Dragula -->
<script src='<?php bloginfo('template_directory'); ?>/js/dragula.js'></script>
<script src='<?php bloginfo('template_directory'); ?>/js/example.min.js'></script>
<link href='<?php bloginfo('template_directory'); ?>/css/dragula.css' rel='stylesheet' type='text/css' />
<?php if($_GET['search_type'] == 'images_lib') { ?>
<!-- Multiple Image Upload -->
<?php global $user_ID; ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/multiupload.js"></script>
<script type="text/javascript">
var config = {
	support : "image/jpg,image/png,image/bmp,image/jpeg,image/gif",		// Valid file formats
	form: "demoFiler",					// Form ID
	dragArea: "dragAndDropFiles",		// Upload Area ID
	uploadUrl: "<?php bloginfo('url'); ?>/gallery-image-upload-ajax",				// Server side upload url
    refreshUrl: "<?php bloginfo('url'); ?>/gallery-content-refresh-ajax/?user_id=<?php echo $user_ID; ?>",
    Url: "<?php bloginfo('template_directory'); ?>"
}
jQuery(document).ready(function(){
	initMultiUploader(config);
});
</script>
<?php } ?>
<script>
function galleryDelete(galleryId) {
    jQuery.ajax({
      url: "<?php bloginfo('url'); ?>/gallery-delete-ajax/",
      data: {"galleryId": galleryId},
      type: 'POST',
      success: function(response){
        var user_id = <?php echo $user_ID; ?>;
        jQuery.ajax("<?php bloginfo('url'); ?>/gallery-content-refresh-ajax", {
           type: "POST",
           data: {'user_id': user_id},
           success: function (data) {
               jQuery("#left-events").html(data);
               var numItems = jQuery('#left-events .metro-tile').length;
               jQuery('.matchheight').matchHeight();
           } 
        });
      }
    });
}
</script>
<script>
jQuery('select.tags').on('change', function() {
    //alert(this.value);
    jQuery("#left-events").hide();
    jQuery('#loading').show();
    jQuery('.matchheight').matchHeight();
    var color = jQuery('select[name="color"]').val();
    var designer = jQuery('select[name="designer"]').val();
    var style = jQuery('select[name="style"]').val();
    var event = jQuery('select[name="event"]').val();
    //if(tag != 'NULL') {
    jQuery.ajax("<?php bloginfo('url'); ?>/gallery-content-refresh-ajax", {
        data: {"gallery_category_color": color, "gallery_category_designer": designer, "gallery_category_style": style, "gallery_category_event": event, "tag": 1},
        type: "POST",
        success: function (data) {
            jQuery('#loading').hide();
            jQuery("#left-events").html(data);
            jQuery("#left-events").show();
            setTimeout(function(){
                jQuery('.matchheight').matchHeight();
            },1000);
        } 
    });        
    /*} else {
    jQuery.ajax("/gallery-content-refresh-ajax", {
        type: "POST",
        success: function (data) {
           jQuery("#left-events").html(data);
        } 
    });         
    }*/
});
</script>
<script>
    jQuery('.style_no_search').submit(function(event) {
        jQuery.fancybox.close();
        jQuery("#left-events").hide();
        jQuery('#loading').show();
        event.preventDefault();
        var formData = {
            'search_style_no' : jQuery('input[name=search_style_no]').val(),
        };
        jQuery.ajax({
            url: "<?php bloginfo('url'); ?>/gallery-content-refresh-ajax/",
            data: formData,
            type: 'POST',
            success: function(response){
                jQuery('#loading').hide();
                jQuery("#left-events").html(response);
                jQuery("#left-events").show();
                setTimeout(function(){
                    jQuery('.matchheight').matchHeight();
                },1000);
            }
        });
    });
    jQuery(document).ready(function() {
        jQuery('.fancybox_small').trigger('click');
    });
</script>
<script>
    <?php if($_GET['search_type'] == 'designer_lib') { ?>
    function pagination(page) {
        jQuery("#left-events").hide();
        jQuery('#loading').show();
        jQuery('.matchheight').matchHeight();
        var color = jQuery('select[name="color"]').val();
        var designer = jQuery('select[name="designer"]').val();
        var style = jQuery('select[name="style"]').val();
        var event = jQuery('select[name="event"]').val();
        if(color == 'NULL' && color == 'NULL' && color == 'NULL' && color == 'NULL') {
            jQuery.ajax("<?php bloginfo('url'); ?>/gallery-content-refresh-ajax", {
                data: {
                    "gallery_category_color": color,
                    "gallery_category_designer": designer,
                    "gallery_category_style": style,
                    "gallery_category_event": event,
                    "page_no": page
                },
                type: "POST",
                success: function (data) {
                    jQuery('#loading').hide();
                    jQuery("#left-events").html(data);
                    jQuery("#left-events").show();
                    setTimeout(function () {
                        jQuery('.matchheight').matchHeight();
                    }, 2000);
                }
            });
        } else {
            jQuery.ajax("<?php bloginfo('url'); ?>/gallery-content-refresh-ajax", {
                data: {
                    "gallery_category_color": color,
                    "gallery_category_designer": designer,
                    "gallery_category_style": style,
                    "gallery_category_event": event,
                    "tag": 1,
                    "page_no": page
                },
                type: "POST",
                success: function (data) {
                    jQuery('#loading').hide();
                    jQuery("#left-events").html(data);
                    jQuery("#left-events").show();
                    setTimeout(function () {
                        jQuery('.matchheight').matchHeight();
                    }, 2000);
                }
            });
        }
    }
    <?php } ?>
    <?php if($_GET['search_type'] == 'style_no') { ?>
    function pagination(page) {
        var search_style_no = jQuery('input[name=search_style_no]').val();
        if(search_style_no = '') {
            jQuery("#left-events").hide();
            jQuery('#loading').show();
            event.preventDefault();
            var formData = {
                'page_no': page,
            };
            jQuery.ajax({
                url: "<?php bloginfo('url'); ?>/gallery-content-refresh-ajax/",
                data: formData,
                type: 'POST',
                success: function (response) {
                    jQuery('#loading').hide();
                    jQuery("#left-events").html(response);
                    jQuery("#left-events").show();
                    setTimeout(function () {
                        jQuery('.matchheight').matchHeight();
                    }, 1000);
                }
            });
        } else {
            jQuery.fancybox.close();
            jQuery("#left-events").hide();
            jQuery('#loading').show();
            event.preventDefault();
            var formData = {
                'search_style_no': search_style_no,
                'page_no': page,
            };
            jQuery.ajax({
                url: "<?php bloginfo('url'); ?>/gallery-content-refresh-ajax/",
                data: formData,
                type: 'POST',
                success: function (response) {
                    jQuery('#loading').hide();
                    jQuery("#left-events").html(response);
                    jQuery("#left-events").show();
                    setTimeout(function () {
                        jQuery('.matchheight').matchHeight();
                    }, 1000);
                }
            });
        }
    }
    <?php } ?>
    <?php if($_GET['search_type'] == 'images_lib') { ?>
    <?php global $user_ID; ?>
    function pagination(page) {
        jQuery("#left-events").hide();
        jQuery('#loading').show();
        var user_id = <?php echo $user_ID; ?>;
        jQuery.ajax("<?php bloginfo('url'); ?>/gallery-content-refresh-ajax", {
            type: "POST",
            data: {'user_id': user_id, 'page_no': page},
            success: function (data) {
                jQuery('#loading').hide();
                jQuery("#left-events").html(data);
                jQuery("#left-events").show();
                setTimeout(function () {
                    jQuery('.matchheight').matchHeight();
                }, 1000);
            }
        });
    }
    <?php } ?>
</script>
<script>
    var myPixie = Pixie.setOptions({
        onSaveButtonClick: function() {
            myPixie.save('jpeg', 10);
        },
        onSave: function(data, img) {
            jQuery('#preview_done').hide();
            jQuery('#Editloading').show();
            setTimeout(function(){
                var image_json = jQuery('#temp_data').text();
                jQuery('#temp_data').text('');
                //console.log(image_json);
                jQuery.ajax({
                    type: 'POST',
                    //dataType: 'json',
                    url: "<?php bloginfo('url'); ?>/save-image-ajax",
                    data: { imgData: data, image_json: image_json },
                }).success(function(response) {
                    var json_obj = jQuery.parseJSON(response);
                    var counter = parseInt(jQuery(img).parent().attr('data-id'));
                    jQuery('.dummy'+counter).attr('src', json_obj['img']);
                    jQuery(img).attr('src', image_json);
                    jQuery('.preview_pdf_'+counter).val(json_obj['id']);
                    jQuery('#Editloading').hide();
                    jQuery('#preview_done').show();
                });
            },1000);
        }
    });
    myPixie.enableInteractiveMode();

    jQuery('#edit-me').on('click', function(e) {
        myPixie.open({
            url: e.target.src,
            image: e.target
        });
    });
</script>
<script>
    jQuery(document).ready(function() {
        jQuery(window).scroll(function () {
            var fixmeTop = jQuery('#footer').offset().top;
            var currentScroll = jQuery(window).scrollTop();
            //console.log(fixmeTop);
            if (currentScroll <= (fixmeTop)) {
                jQuery('.preview_edit ').css({
                    position: 'fixed',
                    bottom: '40px',
                    right: '15%'
                });
                jQuery('.gallery_share ').css({
                    position: 'fixed',
                    bottom: '90px',
                    right: '15%'
                });
            } else {
                jQuery('.preview_edit').css({
                    position: 'absolute',
                    bottom: '10px',
                    right: '2%'
                });
                jQuery('.gallery_share ').css({
                    position: 'absolute',
                    bottom: '60px',
                    right: '2%'
                });
            }
        });
    });
</script>

<script>
    jQuery(function() {
        jQuery('.lazy').lazy({
            afterLoad: function(element) {
                console.log('image "' + stripTime(element.data('src')) + '" was loaded successfully');
            },

        });
    });
</script>
<?php get_footer(); ?>
<?php } else {
   header('Location: '.get_bloginfo('home').'/login'); 
} ?>