<?php 







 /* Template Name: Gallery Delete Ajax */ ?>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    wp_delete_post($_POST['galleryId']);
}
?>