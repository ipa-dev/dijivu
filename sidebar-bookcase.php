<form id="pdf_upload" action="" method="post" enctype="multipart/form-data">
    <p><label>Title: </label><input name="pdf_name" type="text" value="" placeholder="Title" required="required" /></p>
    <p><label>Description: </label><textarea name="pdf_des" required="required"></textarea></p>
    <p>
        <label>Select Books: </label>
        <select name="books[]" multiple="multiple" required="required">
            <?php
                $args = array(
                    'post_type' => 'pub',
                    'posts_per_page' => -1,
                    'author' => $user_ID,
                    'post_status' => 'publish'
                );
                $the_query = new WP_Query( $args );
                if ( $the_query->have_posts() ) :
                while ( $the_query->have_posts() ) : $the_query->the_post();
            ?>
                <option value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
            <?php
                endwhile;
                endif;
                wp_reset_postdata();
            ?>
        </select>
    </p>
    <p><input class="submit_button" type="submit" name="add_bookcase" value="Add Bookcase" /></p>                       
</form>
<?php
if(isset($_POST['add_bookcase'])) {
    $post_arg = array(
        'post_title'    => $_POST['pdf_name'],
        'post_content'  => $_POST['pdf_des'],
        'post_type'     => 'bookcase',
        'post_author'   => $user_ID,
        'post_date'     => date('Y-m-d H:i:s'),
        'comment_status' => 'closed',
        'post_status'   => 'publish'
    );
    $new_post_id = wp_insert_post( $post_arg );
    add_post_meta($new_post_id, 'books', json_encode($_POST['books']));
}
?>