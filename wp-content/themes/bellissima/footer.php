	
	
	<div class="clear"></div>

	<div id="footer">
		<div id="footer-inner">
			<div class="back-to-top"><a href="#top"><img src="<?php echo THEME_DIR; ?>/images/top.png" alt="Back to top" /></a></div>
		</div>
		<div class="footer-main">
			
			<!-- Footer Column 1 Begin -->
			<div class="left-column float-left">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_column_1') ) : ?>
			<?php endif; ?>
			</div>
			<!-- Footer Column 1 End -->
			
			<!-- Footer Column 2 Begin -->
			<div class="middle-column float-left">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_column_2') ) : ?>
			<?php endif; ?>
			</div>
			<!-- Footer Column 2 End -->
			
			<!-- Footer Column 3 Begin -->
			<div class="left-column float-right">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer_column_3') ) : ?>
			<?php endif; ?>
			</div>
			<!-- Footer Column 3 End -->
		</div>
	</div>
</div>
<?php wp_footer() ?>
<?php if(of_get_option('scripts') <> ""){ echo of_get_option('scripts'); } ?>
</body>
</html>