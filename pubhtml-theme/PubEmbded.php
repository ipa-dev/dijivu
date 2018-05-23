<?php /* Template Name: Publication Embded */ ?>
<?php get_header(); ?>
<style>
#header, #footer, #copy {
    display: none;
}
body {
    background: #333333 !important;
}
</style>
<?php
$upload_dir = wp_upload_dir();
$uploaddir = $upload_dir['basedir'].'/ebooks/';
$filename = get_post_meta($_GET['puid'], 'upload_pdf', true);
$file = get_bloginfo('url').'/wp-content/uploads/ebooks/'.$filename;
echo do_shortcode('[flipbook pdf="'.$file.'"]');
?>
<div class="logo_hider"></div>
<?php get_footer(); ?>