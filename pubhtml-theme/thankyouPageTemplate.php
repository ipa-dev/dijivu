<?php /* Template Name: Thank You Template */ ?>
<?php get_header(); ?>
<div id="title">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_12_of_12"> 
                <h1><span><?php the_title(); ?></span></h1>                
	        </div>
	    </div>
	</div>
</div>
<div id="content">
    <div class="maincontent noPadding">
        <div class="section group">
            <div class="col span_12_of_12">
                <?php
					$action = decripted($_GET['action']);
					if($action == 'registration'){
						echo "<p class='successMsg'>Please check your mail to complete your registration process.<br />if email does not appear in your inbox please check your spam folder</p>";
					}
					if($action == 'forgotpassword'){
						echo "<p class='successMsg'>Please check your registered email and click on the reset password link.</p>";
					}
					if($action == 'resetpassword'){
                ?>
					<p class='successMsg'>Your password was updated successfully. Please click here to <a class="alink" href="<?php bloginfo('home'); ?>/login">Login</a>.</p>
				<?php } ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>