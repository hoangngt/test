
			<div class="left-side<?php echo (of_get_option('page_layout') == 'right')? ' right float-right' : ' float-left'; ?>">
				
				<?php if(function_exists('is_woocommerce') && is_woocommerce()){ 
				 if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('shop_sidebar') ) : ?><?php endif; ?>
				<?php }	else if(is_page() && !is_page_template()) {
				 if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('page_sidebar') ) : ?><?php endif; ?>
				<?php }  else { 
				 if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('blog_sidebar') ) : ?><?php endif; ?>
				<?php } ?>
			
			</div>
			