<?php /* Template Name: Gallery Edit Publication Ajax 4 */ ?>
<div id="quick_upload">
    <form id="pdf_upload" action="" method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?php echo $_POST['pub_id']; ?>" name="pub_id" required="required" />
        <p><label>Title *: </label><input name="pdf_name" type="text" value="" placeholder="Title" required="required" /></p>
        <p><label>Description *: </label><textarea name="pdf_des" required="required"></textarea></p>
        <p>
            <label>Select Status: </label>
            <select name="status">
                <option value="private1">Private</option>
                <option value="publish">Publish</option>
            </select>
        </p>
        <p>
            <label>Category: </label>
            <select name="cat">
                <?php
                $taxonomy = 'pub_category';
                $tax_terms = get_terms($taxonomy, array(
                    'hide_empty' => 0,
                    'parent' => 0,
                    'orderby' => 'slug',
                ));
                $term_array = wp_get_post_terms($_GET['pid'], 'pub_category');
                ?>
                <?php
                foreach ($tax_terms as $tax_term) {
                    echo '<optgroup label="'.$tax_term->name.'">';
                    $terms = get_terms($taxonomy, array('parent' => $tax_term->term_id, 'orderby' => 'slug', 'hide_empty' => 0));
                    foreach ($terms as $term) {
                        echo '<option value="'.$term->term_id.'">'.$term->name.'</option>';
                    }
                    echo '</optgroup>';
                }
                ?>
            </select>
        </p>
        <p><input class="submit_button" type="submit" name="upload" value="Upload" /></p>
    </form>
    <div id="Editloading" style="text-align: center; display: none;">
        <img src="<?php bloginfo('template_directory'); ?>/images/loading_spinner.gif"/>
    </div>
    <script>
        jQuery(document).ready(function() {
            jQuery('#pdf_upload').submit(function(event) {
                jQuery('#pdf_upload').hide();
                jQuery('#Editloading').show();
                event.preventDefault();
                var formData = {
                    'pub_id' : jQuery('input[name=pub_id]').val(),
                    'pdf_name' : jQuery('input[name=pdf_name]').val(),
                    'pdf_des' : jQuery('textarea[name=pdf_des]').val(),
                    'status' : jQuery('select[name=status]').val(),
                    'cat' : jQuery('select[name=cat]').val(),
                };
                jQuery.ajax({
                    url: "<?php bloginfo('url'); ?>/gallery-create-publication-2-ajax/",
                    data: formData,
                    type: 'POST',
                    success: function(response){
                        //jQuery('#quick_upload').html(response);
                        location.href = response;
                    }
                });
            });
        });
    </script>
</div>
