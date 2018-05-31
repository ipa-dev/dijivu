<!-- Facebook -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1823475261058474',
            xfbml      : true,
            version    : 'v2.8'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function popup1(permalink_f) {
        FB.ui({
            method: 'share',
            mobile_iframe: true,
            //hashtag: '#',
            display: 'popup',
            href: permalink_f,
        }, function(response){
            if (response && !response.error_code) {
            } else {
            }
        });
    }
</script>
<div class="share_emb">
    <a href="#share" class="fancybox1"><i class="fa fa-share-alt"></i>Share</a>
    <a href="#emb" class="emb1"><i class="fa fa-sign-out"></i>Embed</a>
</div>
<div id="share" style="display: none;">
    <h1>Share This Book</h1>
    <div class="section group social_single_full">
        <div class="col span_6_of_12">
            <p><input name="share_doc" type="radio" class="single_doc" /> Share This Page</p>
        </div>
        <div class="col span_6_of_12">
            <p><input name="share_doc" type="radio" class="full_doc" checked="checked" /> Share Full Document</p>
        </div>
    </div>
    <div class="section group">
        <div class="col span_2_of_12">            
            <label><strong>Book Link:</strong></label>
        </div>
        <div class="col span_10_of_12">
            <input type="text" value="<?php the_permalink(); ?>" disabled="disabled" />
        </div>
    </div>
    <div class="section group">
        <div class="col span_2_of_12">            
            <label><strong>Share On:</strong></label>
        </div>
        <div class="col span_10_of_12">
            <div class="share_emb">
                <?php
                    global $post;
                    $site_name = get_bloginfo("name");
                
                	$permalink = get_permalink($post->ID);
                    $permalink_f = get_bloginfo('url')."/pub-emb/?puid=".get_the_ID();
                    $image = get_post_meta(get_the_ID(), 'upload_pdf_image', true);
                	$featured_image = get_the_post_thumbnail_url($post->ID, 'full');
                	$post_title = rawurlencode(get_the_title($post->ID));
                ?>
                <!--<a href="http://www.facebook.com/sharer.php?u=<?php /*echo $permalink_f; */?>&amp;images=<?php /*echo $featured_image; */?>" class="facebook" target="_blank"><i class="fa fa-facebook"></i>Facebook</a>-->
                <a href="javascript:void(0);" onclick="popup1('<?php echo $permalink_f; ?>')" class="facebook" target="_blank"><i class="fa fa-facebook"></i>Facebook</a>
                <a href="https://twitter.com/share?url=<?php echo $permalink_f; ?>" class="twitter" target="_blank"><i class="fa fa-twitter"></i>Twitter</a>
                <a href="https://plus.google.com/share?url=<?php echo $permalink_f; ?>" class="gplus" target="_blank"><i class="fa fa-google-plus"></i>Google Plus</a>
                <a href="http://www.addthis.com/bookmark.php?v=15&winname=addthis&s=more&url=<?php echo $permalink_f; ?>" class="addthis" target="_blank"><i class="fa fa-plus"></i>More</a>
            </div>
        </div>
    </div> 
    <div class="section group">
        <div class="col span_2_of_12">            
            <label><strong>Share To:</strong></label>
        </div>
        <div class="col span_10_of_12">
            <form method="POST" action="">
                <?php global $user_ID; ?>
                <?php $user_info = get_userdata($user_ID) ?>
                <p><input type="email" name="email_to" value="" required="required" /></p>
                <p><input type="email" name="email_form" value="<?php echo $user_info->user_email; ?>" required="required" /></p>
                <p><input type="text" name="from" value="<?php echo $user_info->display_name; ?>" required="required" /></p>
                <p><textarea name="msg" placeholder="Enter Message Here" required="required"></textarea></p>
                <input type="hidden" value="" name="url_main" class="url_main" />
                <input type="submit" name="send" value="Send" />
            </form>
            <?php
                if(isset($_POST['send'])) {                    
                    $to = $_POST['email_to'];
    				$from = $_POST['email_form'];
    				$headers = 'From: '.$from. "\r\n";
                    $headers .= "MIME-Version: 1.0\n"; 
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    				$subject = 'Check out this awesome publication from: '.$_POST['from']; 
                    $msg = $_POST['msg'];
                    $msg .= '</br>Publication Link: <a href="'.get_the_permalink().'">'.get_the_permalink().'</a>'; 
    				wp_mail( $to, $subject, $msg, $headers );
                }
            ?>
        </div>
    </div>   
</div>
<div id="emb" style="display: none;">
    <div class="section group">
        <div class="col span_12_of_12">
            <div class="iframe_container"><iframe style='width:200px;height:125px' src='<?php bloginfo('url'); ?>/pub-emb/?puid=<?php echo get_the_ID(); ?>'  seamless='seamless' scrolling='no' frameborder='0' allowtransparency='true' allowfullscreen='true' ></iframe></div>
        </div>
    </div>
    <div class="section group">
        <div class="col span_2_of_12">
            <label><strong>Size: </strong></label>
        </div>
        <div class="col span_6_of_12">
            <form>
            <label class="embded small">
                <input type="radio" value="small" name="size" checked="checked" />
            </label>
            <label class="embded medium">
                <input type="radio" value="medium" name="size" />
            </label>
            <label class="embded large">
                <input type="radio" value="large" name="size" />
            </label>
            </form>
        </div>
        <div class="col span_4_of_12">
            <div class="size_value">
                <input type="text" name="sizex" disabled="disabled" value="400px" />
                X
                <input type="text" name="sizey" disabled="disabled" value="250px" />
            </div>
        </div>
    </div>
    <div class="section group">
        <div class="col span_12_of_12">
            <br /><br />
            <p><strong>Copy the Embed Code below and paste it into your HTML file.</strong></p>
            <textarea name="iframe_code" onclick="this.focus();this.select()"><iframe style='width:400px;height:250px' src='<?php bloginfo('url'); ?>/pub-emb/?puid=<?php echo get_the_ID(); ?>'  seamless='seamless' scrolling='no' frameborder='0' allowtransparency='true' allowfullscreen='true' ></iframe></textarea>
        </div>
    </div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
   jQuery('input[name="size"]').change(function() {
        if(this.value == 'small') {
            jQuery('input[name="sizex"]').val('400');
            jQuery('input[name="sizey"]').val('250');
            jQuery('textarea[name="iframe_code"]').text("<iframe style='width:400px;height:250px' src='<?php bloginfo('url'); ?>/pub-emb/?puid=<?php echo get_the_ID(); ?>'  seamless='seamless' scrolling='no' frameborder='0' allowtransparency='true' allowfullscreen='true' ></iframe>");
            jQuery('.iframe_container iframe').css('width', '200px');
            jQuery('.iframe_container iframe').css('height', '125px');
        }
        if(this.value == 'medium') {
            jQuery('input[name="sizex"]').val('700');
            jQuery('input[name="sizey"]').val('400');
            jQuery('textarea[name="iframe_code"]').text("<iframe style='width:700px;height:400px' src='<?php bloginfo('url'); ?>/pub-emb/?puid=<?php echo get_the_ID(); ?>'  seamless='seamless' scrolling='no' frameborder='0' allowtransparency='true' allowfullscreen='true' ></iframe>");
            jQuery('.iframe_container iframe').css('width', '350px');
            jQuery('.iframe_container iframe').css('height', '200px');
        }
        if(this.value == 'large') {
            jQuery('input[name="sizex"]').val('900');
            jQuery('input[name="sizey"]').val('500');
            jQuery('textarea[name="iframe_code"]').text("<iframe style='width:900px;height:500px' src='<?php bloginfo('url'); ?>/pub-emb/?puid=<?php echo get_the_ID(); ?>'  seamless='seamless' scrolling='no' frameborder='0' allowtransparency='true' allowfullscreen='true' ></iframe>");
            jQuery('.iframe_container iframe').css('width', '450px');
            jQuery('.iframe_container iframe').css('height', '250px');
        }
   }); 
});
</script>
<script>
    jQuery(document).ready(function () {
       jQuery('input.single_doc').change(function () {
            var page_num = jQuery('input.flexpaper_txtPageNumber').val();
            jQuery('input.url_main').val('<?php the_permalink(); ?>/?page_num='+page_num);
       });
       jQuery('input.full_doc').change(function () {
            jQuery('input.url_main').val('<?php the_permalink(); ?>');
       });
    });
</script>