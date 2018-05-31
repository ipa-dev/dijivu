<?php ob_start(); ?>
<!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<!-- Responsive and mobile friendly stuff -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php
/*
* Print the <title> tag based on what is being viewed.
*/
global $page, $paged;
wp_title('|', true, 'right');
// Add the blog name.
bloginfo('name');
// Add the blog description for the home/front page.
$site_description = get_bloginfo('description', 'display');
if ($site_description && (is_home() || is_front_page()))
    echo " | $site_description";
// Add a page number if necessary:
if ($paged >= 2 || $page >= 2)
    echo ' | ' . sprintf(__('Page %s', 'twentyeleven'), max($paged, $page));
?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<!-- Responsive Stylesheets -->
<link rel="stylesheet" media="all" href="<?php bloginfo('template_directory'); ?>/css/commoncssloader.css" />
<link rel="stylesheet" media="only screen and (max-width: 1024px) and (min-width: 769px)" href="<?php bloginfo('template_directory'); ?>/css/1024.css">
<link rel="stylesheet" media="only screen and (max-width: 768px) and (min-width: 481px)" href="<?php bloginfo('template_directory'); ?>/css/768.css">
<link rel="stylesheet" media="only screen and (max-width: 480px)" href="<?php bloginfo('template_directory'); ?>/css/480.css">
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>?ver=<?php echo(mt_rand(10,100)); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<!-- Custom Responsive Stylesheets -->
<link rel="stylesheet" media="only screen and (max-width: 1024px) and (min-width: 993px)" href="<?php bloginfo('template_directory'); ?>/css/mediaquerycss/styleMax1024.css?ver=<?php echo(mt_rand(10,100)); ?>">
<link rel="stylesheet" media="only screen and (max-width: 992px) and (min-width: 769px)" href="<?php bloginfo('template_directory'); ?>/css/mediaquerycss/styleMax992.css?ver=<?php echo(mt_rand(10,100)); ?>">
<link rel="stylesheet" media="only screen and (max-width: 768px) and (min-width: 481px)" href="<?php bloginfo('template_directory'); ?>/css/mediaquerycss/styleMax768.css?ver=<?php echo(mt_rand(10,100)); ?>">
<link rel="stylesheet" media="only screen and (max-width: 480px)" href="<?php bloginfo('template_directory'); ?>/css/mediaquerycss/styleMax480.css?ver=<?php echo(mt_rand(10,100)); ?>">
<?php
/* We add some JavaScript to pages with the comment form
* to support sites with threaded comments (when in use).
*/
if (is_singular() && get_option('thread_comments'))
    wp_enqueue_script('comment-reply');
/* Always have wp_head() just before the closing </head>
* tag of your theme, or you will break many plugins, which
* generally use this hook to add elements to <head> such
* as styles, scripts, and meta tags.
*/
wp_enqueue_script('jquery');
wp_head();
?>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.matchHeight-min.js"></script>
<script type="text/javascript">
jQuery(function($){
    $('.matchheight').matchHeight();
    $('.matchheightGallery').matchHeight();
});
</script>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/jquery.fancybox.css" />
<script src="<?php bloginfo('template_directory'); ?>/js/modernizr-2.8.2-min.js"></script>
<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/slicknav.css" />
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.slicknav.js"></script>
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.fancybox.pack.js"></script>
<script>
	jQuery(function(){
		jQuery('.nav').slicknav({
		  prependTo:'#rspnavigation',
          label:''
		});
	});
</script>
<script type="text/javascript">
	jQuery(document).ready(function() {
	    jQuery(".quick_up").fancybox({
                width  : '70%',
                height  : '95%',
                autoSize : false,
                modal : false,
                closeBtn: true,
                helpers : {
                    overlay: { closeClick: false }
                },
	    });
	});
	jQuery(document).ready(function() {
		jQuery(".fancybox").fancybox({
		});
	});
	jQuery(document).ready(function() {
		jQuery(".fancybox1").fancybox({
            width  : '70%',
            height  : '90%',
            autoSize : false
		});
	});
	jQuery(document).ready(function() {
		jQuery(".emb1").fancybox({
            width  : '60%',
            height  : '90%',
            autoSize : false
		});
	});
	jQuery(document).ready(function() {
		jQuery(".fancybox_small").fancybox({
            width  : '30%',
            height  : '20%',
            autoSize : false
		});
	});
</script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" />
<script>
function validatePass(p1, p2) {
    if (p1.value != p2.value || p1.value == '' || p2.value == '') {
        p2.setCustomValidity('Password does not match');
    } else {
        p2.setCustomValidity('');
    }
}
</script>
<script>
function validateEmail(p1, p2) {
    if (p1.value != p2.value || p1.value == '' || p2.value == '') {
        p2.setCustomValidity('Email does not match');
    } else {
        p2.setCustomValidity('');
    }
}
</script>
<script>
jQuery(document).ready(function() {
    jQuery('.tab-links a').on('click', function(e)  {
        var currentAttrValue = jQuery(this).attr('href');
        // Show/Hide Tabs
        jQuery(currentAttrValue).show().siblings().hide();
        // Change/remove current tab to active
        jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
        e.preventDefault();
    });
});
</script>

<!-- BxSlider -->
<!-- bxSlider Javascript file -->
<script src="<?php bloginfo('template_directory'); ?>/js/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="<?php bloginfo('template_directory'); ?>/css/jquery.bxslider.css" rel="stylesheet" />
<script>
jQuery(document).ready(function(){
  jQuery('.bxslider').bxSlider({    
      nextSelector: '.slider_next',
      prevSelector: '.slider_prev',
      nextText: '<img src="<?php bloginfo('template_directory'); ?>/images/next.png" />',
      prevText: '<img src="<?php bloginfo('template_directory'); ?>/images/prev.png" />'
  });
});
</script>

<!-- Turn.js -->

<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/hash.js"></script>
<script type='text/javascript' src="http://www.turnjs.com/lib/turn.min.js"></script>


<!--- Book Shelf -->
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.bookshelfslider.min.js"></script>
<link href="<?php bloginfo('template_directory'); ?>/css/bookshelf_slider.css" rel="stylesheet" />
<link href="<?php bloginfo('template_directory'); ?>/css/skin01.css" rel="stylesheet" />

<!-- FlexPaper -->

<!--<link rel="stylesheet" type="text/css" href="<?php /*bloginfo('template_directory'); */?>/flex/css/flexpaper.css" />
<script type="text/javascript" src="<?php /*bloginfo('template_directory'); */?>/flex/js/jquery.extensions.min.js"></script>-->
<!--[if gte IE 10 | !IE ]><!-->
<!--<script type="text/javascript" src="<?php /*bloginfo('template_directory'); */?>/flex/js/three.min.js"></script>-->
<!--<![endif]-->
<!--<script type="text/javascript" src="<?php /*bloginfo('template_directory'); */?>/flex/js/flexpaper.js"></script>
<script type="text/javascript" src="<?php /*bloginfo('template_directory'); */?>/flex/js/flexpaper_handlers.js"></script>-->


<!-- FlowPaper -->

<!--<link rel="stylesheet" type="text/css" href="<?php /*bloginfo('template_directory'); */?>/flow/css/flowpaper.css" />
<script type="text/javascript" src="<?php /*bloginfo('template_directory'); */?>/flow/js/jquery.extensions.min.js"></script>-->
<!--[if gte IE 10 | !IE ]><!-->
<!--<script type="text/javascript" src="<?php /*bloginfo('template_directory'); */?>/flow/js/three.min.js"></script>-->
<!--<![endif]-->
<!--<script type="text/javascript" src="<?php /*bloginfo('template_directory'); */?>/flow/js/flowpaper.js"></script>
<script type="text/javascript" src="<?php /*bloginfo('template_directory'); */?>/flow/js/flowpaper_handlers.js"></script>-->


<!-- Data Table -->

<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" />
<script type="text/javascript" src="//cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('#dataTable').DataTable();
});
</script>

<!-- Stripe -->
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<script type="text/javascript">
    // this identifies your website in the createToken call below
    Stripe.setPublishableKey('pk_test_ziCnvgJXeeT1QR88PaEervZ7');
    function stripeResponseHandler(status, response) {
        if (response.error) {
            // re-enable the submit button
            jQuery('.submit-button').removeAttr("disabled");
            // show the errors on the form
            jQuery(".payment-errors").html(response.error.message);
        } else {
            var form$ = jQuery("#payment-form");
            // token contains id, last4, and card type
            var token = response['id'];
            // insert the token into the form so it gets submitted to the server
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            // and submit
            form$.get(0).submit();
        }
    }
    jQuery(document).ready(function() {
        jQuery("#payment-form").submit(function(event) {
            // disable the submit button to prevent repeated clicks
            jQuery('.submit-button').attr("disabled", "disabled");
            // createToken returns immediately - the supplied callback submits the form if there are no errors
            Stripe.createToken({
                number: jQuery('.card-number').val(),
                cvc: jQuery('.card-cvc').val(),
                exp_month: jQuery('.card-expiry-month').val(),
                exp_year: jQuery('.card-expiry-year').val()
            }, stripeResponseHandler);
            return false; // submit from callback
        });
    });
</script>
<!-- TinyMCE -->
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<?php if(is_singular('pub')) { ?>
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' ); ?>
<meta property="og:url" content="<?php echo get_the_permalink(get_the_ID()); ?>"/>
<meta property="og:title" content="<?php echo get_the_title(get_the_ID()); ?>"/>
<?php
	$my_postid = get_the_ID();
	$content_post = get_post($my_postid);
	$content = $content_post->post_content;
	$content = apply_filters('the_content', $content);
	$content = strip_tags(str_replace(']]>', ']]&gt;', $content));
?>
<meta property="og:description" content="<?php echo $content; ?>"/>
<meta property="og:image" content="<?php echo $thumb[0]; ?>"/>
<?php } ?>
<?php if(is_page('pub-emb')) { ?>
    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($_GET['puid']), 'full' ); ?>
    <meta property="og:url" content="<?php echo get_the_permalink($_GET['puid']); ?>"/>
    <meta property="og:title" content="<?php echo get_the_title($_GET['puid']); ?>"/>
<?php
	$my_postid = get_the_ID();
	$content_post = get_post($my_postid);
	$content = $content_post->post_content;
	$content = apply_filters('the_content', $content);
	$content = strip_tags(str_replace(']]>', ']]&gt;', $content));
?>
    <meta property="og:description" content="<?php echo $content; ?>"/>
    <meta property="og:image" content="<?php echo $thumb[0]; ?>"/>
<?php } ?>
    <script data-path="<?php bloginfo('template_directory'); ?>/pixie" src="<?php bloginfo('template_directory'); ?>/pixie/pixie-integrate.js"></script>


    <script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/paginga.jquery.min.js"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery(".paginate").paginga({
                itemsPerPage: 100,
            });
        });
    </script>

    <!-- Lazy Load -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.6/jquery.lazy.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.6/jquery.lazy.plugins.min.js"></script>
</head>
<body <?php body_class(); ?>>
<div id="header">
	<div class="maincontent noPadding">
	    <div class="section group">
	        <div class="col span_2_of_12"> 
                <a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" /></a>                         
	        </div>
	        <div class="col span_3_of_12">
                <form class="search_form" method="get" action="<?php bloginfo('url'); ?>">
                    <input type="text" name="s" required="required" />
                    <input type="hidden" name="post_type" value="pub" />
                    <input type="submit" name="search" value="" /> 
                </form>                    
	        </div>
            <div class="col span_4_of_12">
                <div class="nav"><?php wp_nav_menu(array('theme_location' => 'mainmenu')); ?></div>
            </div>
            <div class="col span_2_of_12">
                <div class="sign_reg">
                    <?php if(is_user_logged_in()) { ?>
                        <a style="padding: 8px; font-size: 12px;" href="<?php bloginfo('url'); ?>/my-account/">My Account</a>                
                        <a style="padding: 8px; font-size: 12px;" href="<?php wp_logout_url(home_url()); ?>/login/">Logout</a>
                    <?php } else { ?>
                        <a href="<?php bloginfo('url'); ?>/login/">Sign in/Register</a>                    
                    <?php } ?>                                        
                </div>
            </div>          
	    </div>
	</div>
    <div id="rspnavigation"></div>
</div>