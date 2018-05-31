<form id="pdf_upload" action="" method="post" enctype="multipart/form-data">
    <p><label>Title: </label><input name="pdf_name" type="text" value="<?php the_title(); ?>" placeholder="Title" required="required" /></p>
    <p><label>Description: </label><textarea name="pdf_des" required="required"><?php $bookcase_cont = get_post(get_the_ID()); echo $bookcase_cont->post_content; ?></textarea></p>
    <p>
        <label>Select Books: </label>
        <select name="books[]" multiple="multiple" required="required">
            <?php
                $pub_array = json_decode(get_post_meta(get_the_ID(), 'books', true));
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
                <option<?php if(in_array(get_the_ID(), $pub_array)) { echo ' selected="selected"'; } ?> value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
            <?php
                endwhile;
                endif;
                wp_reset_postdata();
            ?>
        </select>
    </p>
    <input type="hidden" name="bid" value="<?php echo get_the_ID(); ?>" />
    <p><input class="submit_button" type="submit" name="edit_bookcase" value="Update Bookcase" /></p>                       
</form>
<?php
if(isset($_POST['edit_bookcase'])) {
    $post_arg = array(
        'ID' => $_POST['bid'],
        'post_title'    => $_POST['pdf_name'],
        'post_content'  => $_POST['pdf_des']
    );
    wp_update_post( $post_arg );
    update_post_meta($_POST['bid'], 'books', json_encode($_POST['books']));
}
?>