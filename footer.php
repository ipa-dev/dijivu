<div id="footer">
	<div class="maincontent">
	    <div class="section group">
	        <div class="col span_3_of_12">  
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 1') ) : ?> <?php endif; ?>       
	        </div>
	        <div class="col span_3_of_12">  
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 2') ) : ?> <?php endif; ?>        
	        </div>
	        <div class="col span_3_of_12"> 
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 3') ) : ?> <?php endif; ?>        
	        </div>
	        <div class="col span_3_of_12">  
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Widget 4') ) : ?> <?php endif; ?>        
	        </div>
	    </div>
	</div>
</div>
<div id="copy">
	<div class="maincontent noPadding">
	    <div class="section group">
	        <div class="col span_6_of_12">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Copyright') ) : ?> <?php endif; ?>      
	        </div>
	        <div class="col span_6_of_12">
                <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Social Menu') ) : ?> <?php endif; ?>        
	        </div>
	    </div>
	</div>
</div>
<!--<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>-->
<?php wp_footer(); ?>
</body>
</html>