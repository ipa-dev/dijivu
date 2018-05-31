<?php /* Template Name: Gallery Content Refresh Ajax */ ?>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){

global $user_ID;
if(isset($_POST['page_no'])) {
    $page = $_POST['page_no'];
} else {
    $page = 1;
}
if(isset($_GET['user_id'])){
    $args = array(
        'post_type' => 'pub_gallery_img',
        'posts_per_page' => 100,
        'paged' => $page,
        'post_status' => 'publish',
        'meta_query' => array(array('key' => '_thumbnail_id')),
        'author' => $user_ID
    );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts() ) : $the_query->the_post();
            ?>
            <div class="metro-tile diji_share_<?php echo get_the_ID(); ?>" data-id="<?php echo get_the_ID(); ?>">
                <?php $attr['title'] = the_title_attribute( 'echo=0' ); ?>
                <a href="javascript:void(0)">
                    <?php the_post_thumbnail('thumb_size_200_185', $attr); ?>
                    <span class="style_no"><?php echo get_post_meta(get_the_ID(), 'style_no', true); ?></span>
                </a>
                <?php if($flag != 1) { ?>
                    <a href="javascript:void(0)" onclick="galleryDelete(<?php echo get_the_ID(); ?>)" class="metro-tile-delete"><i class="fa fa-trash"></i></a>
                <?php } ?>
            </div>
            <?php
        endwhile;
        ?>
        <div style="clear: both;"></div>
        <div id="custom_pagination">
            <?php
            if(isset($_POST['page_no'])) {
                $page = $_POST['page_no'];
            } else {
                $page = 1;
            }
            $found_posts = $the_query->found_posts;
            if($found_posts >1) {
                $pages = round($found_posts/100);
                ?>
                <ul>
                    <?php for($i=1;$i<=$pages;$i++) { ?>
                        <li><a<?php if($i == $page) { ?> class="active" <?php } else { ?>  onclick="pagination(<?php echo $i; ?>)";<?php } ?> href="javascript:void(0);"><?php echo $i; ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <?php
    else:
        ?>
        <p>No image found...</p>
        <?php
    endif;
    wp_reset_postdata();
}
if(isset($_POST['user_id'])){
    $args = array(
        'post_type' => 'pub_gallery_img',
        'posts_per_page' => 100,
        'paged' => $page,
        'post_status' => 'publish',
        'meta_query' => array(array('key' => '_thumbnail_id')), 
        'author' => $user_ID
    );
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) :
    while ( $the_query->have_posts() ) : $the_query->the_post();
?>
    <div class="metro-tile diji_share_<?php echo get_the_ID(); ?>" data-id="<?php echo get_the_ID(); ?>">
        <?php $attr['title'] = the_title_attribute( 'echo=0' ); ?>
        <a href="javascript:void(0)">
            <?php the_post_thumbnail('thumb_size_200_185', $attr); ?>
            <span class="style_no"><?php echo get_post_meta(get_the_ID(), 'style_no', true); ?></span>
        </a>
        <?php if($flag != 1) { ?>
        <a href="javascript:void(0)" onclick="galleryDelete(<?php echo get_the_ID(); ?>)" class="metro-tile-delete"><i class="fa fa-trash"></i></a>
        <?php } ?>
    </div>
<?php
    endwhile;
        ?>
        <div style="clear: both;"></div>
        <div id="custom_pagination">
            <?php
            if(isset($_POST['page_no'])) {
                $page = $_POST['page_no'];
            } else {
                $page = 1;
            }
            $found_posts = $the_query->found_posts;
            if($found_posts >1) {
                $pages = round($found_posts/100);
                ?>
                <ul>
                    <?php for($i=1;$i<=$pages;$i++) { ?>
                        <li><a<?php if($i == $page) { ?> class="active" <?php } else { ?>  onclick="pagination(<?php echo $i; ?>)";<?php } ?> href="javascript:void(0);"><?php echo $i; ?></a></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
        <?php
    else:
?>
    <p>No image found...</p>
<?php
    endif;
    wp_reset_postdata();
} else {
    if(!isset($_GET['user_id'])) {
        $image_ids1 = array();
        $image_ids2 = array();
        $image_ids3 = array();
        $image_ids4 = array();
        if (isset($_POST['tag']) && !empty($_POST['tag'])) {
            if($_POST['gallery_category_color'] != 'NULL') {
                $args1 = array(
                    'post_type' => 'pub_gallery_img',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'gallery_category_color',
                            'field' => 'id',
                            'terms' => array($_POST['gallery_category_color']),
                            'operator' => 'IN'
                        )
                    ),
                    'meta_query' => array(array('key' => '_thumbnail_id')),
                    /*'author' => -$user_ID*/
                );
                $the_query1 = new WP_Query($args1);
                if ($the_query1->have_posts()) :
                    while ($the_query1->have_posts()) : $the_query1->the_post();
                        array_push($image_ids1, get_the_ID());
                    endwhile;
                endif;
            }
            if($_POST['gallery_category_designer'] != 'NULL') {
                $args2 = array(
                    'post_type' => 'pub_gallery_img',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'gallery_category_designer',
                            'field' => 'id',
                            'terms' => array($_POST['gallery_category_designer']),
                            'operator' => 'IN'
                        )
                    ),
                    'meta_query' => array(array('key' => '_thumbnail_id')),
                    /*'author' => -$user_ID*/
                );
                $the_query2 = new WP_Query($args2);
                if ($the_query2->have_posts()) :
                    while ($the_query2->have_posts()) : $the_query2->the_post();
                        array_push($image_ids2, get_the_ID());
                    endwhile;
                endif;
            }
            if($_POST['gallery_category_style'] != 'NULL') {
                $args3 = array(
                    'post_type' => 'pub_gallery_img',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'gallery_category_style',
                            'field' => 'id',
                            'terms' => array($_POST['gallery_category_style']),
                            'operator' => 'IN'
                        )
                    ),
                    'meta_query' => array(array('key' => '_thumbnail_id')),
                    /*'author' => -$user_ID*/
                );
                $the_query3 = new WP_Query($args3);
                if ($the_query3->have_posts()) :
                    while ($the_query3->have_posts()) : $the_query3->the_post();
                        array_push($image_ids3, get_the_ID());
                    endwhile;
                endif;
            }
            if($_POST['gallery_category_event'] != 'NULL') {
                $args4 = array(
                    'post_type' => 'pub_gallery_img',
                    'posts_per_page' => -1,
                    'post_status' => 'publish',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'gallery_category_event',
                            'field' => 'id',
                            'terms' => array($_POST['gallery_category_event']),
                            'operator' => 'IN'
                        )
                    ),
                    'meta_query' => array(array('key' => '_thumbnail_id')),
                    /*'author' => -$user_ID*/
                );
                $the_query4 = new WP_Query($args4);
                if ($the_query4->have_posts()) :
                    while ($the_query4->have_posts()) : $the_query4->the_post();
                        array_push($image_ids4, get_the_ID());
                    endwhile;
                endif;
            }
            $new_image_ids1 = array_unique(array_merge($image_ids1, $image_ids2, $image_ids3, $image_ids4));
            if(empty($image_ids1)) {
                $image_ids1 = $new_image_ids1;
            }
            if(empty($image_ids2)) {
                $image_ids2 = $new_image_ids1;
            }
            if(empty($image_ids3)) {
                $image_ids3 = $new_image_ids1;
            }
            if(empty($image_ids4)) {
                $image_ids4 = $new_image_ids1;
            }
            $new_image_ids = array_unique(array_intersect($image_ids1, $image_ids2, $image_ids3, $image_ids4));
            //print_r($new_image_ids); die();
            if(empty($new_image_ids)) {
                $new_image_ids = 'false';
            }
            if(isset($_POST['page_no'])) {
                $page = $_POST['page_no'];
            } else {
                $page = 1;
            }
            $args = array(
                'post_type' => 'pub_gallery_img',
                'posts_per_page' => 100,
                'paged' => $page,
                'post_status' => 'publish',
                'post__in' => $new_image_ids,
                'meta_query' => array(array('key' => '_thumbnail_id')),
                'author' => -$user_ID
            );

            $flag = 1;
        } else {
            if(isset($_POST['page_no'])) {
                $page = $_POST['page_no'];
            } else {
                $page = 1;
            }
            $args = array(
                'post_type' => 'pub_gallery_img',
                'posts_per_page' => 100,
                'paged' => $page,
                'post_status' => 'publish',
                'meta_query' => array(array('key' => '_thumbnail_id')),
                'author' => -$user_ID
            );
            $flag = 0;
        }
        if (isset($_POST['search_style_no'])) {
            if (strpos($_POST['search_style_no'], ',') !== false) {
                $search_style_no = explode(',', $_POST['search_style_no']);
                //print_r($search_style_no);
                foreach($search_style_no as $search_style_no_element) {
                    $args = array(
                        'post_type' => 'pub_gallery_img',
                        'posts_per_page' => 100,
                        'paged' => $page,
                        'post_status' => 'publish',
                        'meta_query' => array(
                            array(
                                'key' => 'style_no',
                                'value' => trim($search_style_no_element),
                                'type' => 'CHAR',
                                'compare' => 'LIKE'
                            ),
                            array('key' => '_thumbnail_id')
                        ),
                        'author' => -$user_ID
                    );
                    $flag = 1;
                    $the_query = new WP_Query($args);
                    if ($the_query->have_posts()) :
                        while ($the_query->have_posts()) : $the_query->the_post();
                            ?>
                            <div class="metro-tile diji_share_<?php echo get_the_ID(); ?>"
                                 data-id="<?php echo get_the_ID(); ?>">
                                <?php $attr['title'] = the_title_attribute('echo=0'); ?>
                                <a href="javascript:void(0)">
                                    <?php the_post_thumbnail('thumb_size_200_185', $attr); ?>
                                    <span class="style_no"><?php echo get_post_meta(get_the_ID(), 'style_no', true); ?></span>
                                </a>
                                <?php //if($flag != 1) { ?>
                                <!--<a href="javascript:void(0)" onclick="galleryDelete(<?php //echo get_the_ID(); ?>)" class="metro-tile-delete"><i class="fa fa-trash"></i></a>-->
                                <?php //} ?>
                            </div>
                            <?php
                        endwhile;
                        ?>
                        <div style="clear: both;"></div>
                        <div id="custom_pagination">
                            <?php
                            if(isset($_POST['page_no'])) {
                                $page = $_POST['page_no'];
                            } else {
                                $page = 1;
                            }
                            $found_posts = $the_query->found_posts;
                            if($found_posts >1) {
                                $pages = round($found_posts/100);
                                ?>
                                <ul>
                                    <?php for($i=1;$i<=$pages;$i++) { ?>
                                        <li><a<?php if($i == $page) { ?> class="active" <?php } else { ?>  onclick="pagination(<?php echo $i; ?>)";<?php } ?> href="javascript:void(0);"><?php echo $i; ?></a></li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div>
                        <?php
                    else:
                        ?>
                        <p>No image found...</p>
                        <?php
                    endif;
                    wp_reset_postdata();
                }

            } else {
                $args = array(
                    'post_type' => 'pub_gallery_img',
                    'posts_per_page' => 100,
                    'paged' => $page,
                    'post_status' => 'publish',
                    'meta_query' => array(
                        array(
                            'key' => 'style_no',
                            'value' => trim($_POST['search_style_no']),
                            'type' => 'CHAR',
                            'compare' => 'LIKE'
                        ),
                        array('key' => '_thumbnail_id')
                    ),
                    'author' => -$user_ID
                );
                $flag = 1;
                $the_query = new WP_Query($args);
                if ($the_query->have_posts()) :
                    while ($the_query->have_posts()) : $the_query->the_post();
                        ?>
                        <div class="metro-tile diji_share_<?php echo get_the_ID(); ?>"
                             data-id="<?php echo get_the_ID(); ?>">
                            <?php $attr['title'] = the_title_attribute('echo=0'); ?>
                            <a href="javascript:void(0)">
                                <?php the_post_thumbnail('thumb_size_200_185', $attr); ?>
                                <span class="style_no"><?php echo get_post_meta(get_the_ID(), 'style_no', true); ?></span>
                            </a>
                            <?php //if($flag != 1) { ?>
                            <!--<a href="javascript:void(0)" onclick="galleryDelete(<?php //echo get_the_ID(); ?>)" class="metro-tile-delete"><i class="fa fa-trash"></i></a>-->
                            <?php //} ?>
                        </div>
                        <?php
                    endwhile;
                    ?>
                    <div style="clear: both;"></div>
                    <div id="custom_pagination">
                        <?php
                        if(isset($_POST['page_no'])) {
                            $page = $_POST['page_no'];
                        } else {
                            $page = 1;
                        }
                        $found_posts = $the_query->found_posts;
                        if($found_posts >1) {
                            $pages = round($found_posts/100);
                            ?>
                            <ul>
                                <?php for($i=1;$i<=$pages;$i++) { ?>
                                    <li><a<?php if($i == $page) { ?> class="active" <?php } else { ?>  onclick="pagination(<?php echo $i; ?>)";<?php } ?> href="javascript:void(0);"><?php echo $i; ?></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <?php
                else:
                    ?>
                    <p>No image found...</p>
                    <?php
                endif;
                wp_reset_postdata();
            }
        } else {
            /*if(isset($_POST['page_no'])) {
                $page = $_POST['page_no'];
            } else {
                $page = 1;
            }
            $args = array(
                'post_type' => 'pub_gallery_img',
                'posts_per_page' => 100,
                'paged' => $page,
                'post_status' => 'publish',
                'meta_query' => array(array('key' => '_thumbnail_id')),
                //'author' => -$user_ID
            );
            $flag = 0;*/
        }
        if (!isset($_POST['search_style_no'])) {
            $the_query = new WP_Query($args);
            if ($the_query->have_posts()) :
                while ($the_query->have_posts()) : $the_query->the_post();
                    ?>
                    <div class="metro-tile diji_share_<?php echo get_the_ID(); ?>"
                         data-id="<?php echo get_the_ID(); ?>">
                        <?php $attr['title'] = the_title_attribute('echo=0'); ?>
                        <a href="javascript:void(0)">
                            <?php the_post_thumbnail('thumb_size_200_185', $attr); ?>
                            <span class="style_no"><?php echo get_post_meta(get_the_ID(), 'style_no', true); ?></span>
                        </a>
                        <?php //if($flag != 1) { ?>
                        <!--<a href="javascript:void(0)" onclick="galleryDelete(<?php //echo get_the_ID(); ?>)" class="metro-tile-delete"><i class="fa fa-trash"></i></a>-->
                        <?php //} ?>
                    </div>
                    <?php
                endwhile;
                ?>
                <div style="clear: both;"></div>
                <div id="custom_pagination">
                    <?php
                    if(isset($_POST['page_no'])) {
                        $page = $_POST['page_no'];
                    } else {
                        $page = 1;
                    }
                    $found_posts = $the_query->found_posts;
                    if($found_posts >1) {
                        $pages = round($found_posts/100);
                        ?>
                        <ul>
                            <?php for($i=1;$i<=$pages;$i++) { ?>
                                <li><a<?php if($i == $page) { ?> class="active" <?php } else { ?>  onclick="pagination(<?php echo $i; ?>)";<?php } ?> href="javascript:void(0);"><?php echo $i; ?></a></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
                <?php
            else:
                ?>
                <p>No image found...</p>
                <?php
            endif;
            wp_reset_postdata();
        }
    }
}
}
?>