// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.mygallery', {
		// creates control instances based on the control's id.
		// our button's id is "mygallery_button"
		createControl : function(id, controlManager) {
			if (id == 'mygallery_button') {
				// creates the button
				var button = controlManager.createButton('mygallery_button', {
					title : 'Shortcodes Index', // title of the button
					image : '../wp-content/themes/bellissima/images/favicon.ico',  // path to the button's image
					onclick : function() {
						// triggers the thickbox
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Shortcodes Index', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=mygallery-form' );
					}
				});
				return button;
			}
			return null;
		}
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('mygallery', tinymce.plugins.mygallery);
	
	// executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="mygallery-form"><table id="mygallery-table" style="margin-top: 20px;" class="form-table">\
			<tr class="myshortcode">\
				<td><label for="myshortcode">Select the shortcode :</label>\
					<select style="width: 250px;" name="shortcode" id="myshortcode">\
						<option selected>--------------------</option>\
						<option value="clear">clear</option>\
						<option value="raw">raw</option>\
						<option value="faq">faq</option>\
						<option value="faqitem">faq item</option>\
						<option value="tabgroup">tabgroup</option>\
						<option value="alt-tabgroup">alternative tabgroup</option>\
						<option value="tab">tab</option>\
						<option value="button">button</option>\
						<option value="divider">divider</option>\
						<option value="highlight">highlight text</option>\
						<option value="accordion">accordion</option>\
						<option value="alt-accordion">alternative accordion</option>\
						<option value="pane">accordion pane</option>\
						<option value="list">fancy list</option>\
						<option value="icon">icon</option>\
						<option value="social">social icons</option>\
						<option value="link">hyperlink</option>\
						<option value="contactform">contactform form</option>\
						<option value="success">success message</option>\
						<option value="error">error message</option>\
						<option value="info">info message</option>\
						<option value="warning">warning message</option>\
						<option value="col2">column 2</option>\
						<option value="col2_last">column 2 last</option>\
						<option value="col3">column 3</option>\
						<option value="col3_last">column 3 last</option>\
						<option value="col4">column 4</option>\
						<option value="col4_last">column 4 last</option>\
						<option value="col23">column 2/3</option>\
						<option value="col23_last">column 2/3 last</option>\
						<option value="col34">column 3/4</option>\
						<option value="col34_last">column 3/4 last</option>\
					</select>\
				</td>\
			</tr>\
			<tr class="button" style="display: none;">\
				<th><label for="button_linkto">Link Url</label></th>\
				<td><input type="text" value="" id="button_linkto" /><br />\
				<small>The URL the button points to.</small></td>\
			</tr>\
			<tr class="button" style="display: none;">\
				<th><label for="button_content">Button Text</label></th>\
				<td><input type="text" value="" id="button_content" /><br />\
				<small>The text that appears on the button.</small></td>\
			</tr>\
			<tr class="button" style="display: none;">\
				<th><label for="button_color">Button Color</label></th>\
				<td>\
					<select id="button_color">\
						<option selected value="orange">orange</option>\
						<option value="red">red</option>\
						<option value="green">green</option>\
						<option value="blue">blue</option>\
						<option value="purple">purple</option>\
						<option value="grey">grey</option>\
						<option value="black">black</option>\
					</select>\
				<br />\
				<small>Select the button color.</small></td>\
			</tr>\
			<tr class="button" style="display: none;">\
				<th><label for="button_size">Button Color</label></th>\
				<td>\
					<select id="button_size">\
						<option selected value="small">small</option>\
						<option value="big">big</option>\
					</select>\
				<br />\
				<small>Select the button size.</small></td>\
			</tr>\
			<tr class="highlight" style="display: none;">\
				<th><label for="highlight_color">Select Highlight Color :</label></th>\
				<td>\
					<select id="highlight_color">\
						<option selected value="light">light</option>\
						<option value="dark">dark</option>\
					</select>\
				<br />\
				<small>Select the highlight color.</small></td>\
			</tr>\
			<tr class="link" style="display: none;">\
				<th><label for="link_type">Set Link Type:</label></th>\
				<td>\
					<select id="link_type">\
						<option selected value="regular">regular</option>\
						<option value="arrow">arrow</option>\
					</select>\
				<br />\
				<small>Select the link type.</small></td>\
			</tr>\
			<tr class="link" style="display: none;">\
				<th><label for="link_linkto">Hyperlink URL</label></th>\
				<td><input type="text" value="" id="link_linkto" /><br />\
				<small>Enter a URL to link to.</small></td>\
			</tr>\
			<tr class="link" style="display: none;">\
				<th><label for="link_content">Button Text</label></th>\
				<td><input type="text" value="" id="link_content" /><br />\
				<small>The text that appears on the link.</small></td>\
			</tr>\
			<tr class="faqitem" style="display: none;">\
				<th><label for="question_faqitem">Question</label></th>\
				<td><input type="text" value="" id="question_faqitem" /><br /></td>\
			</tr>\
			<tr class="faqitem" style="display: none;">\
				<th><label for="answer_faqitem">Answer</label></th>\
				<td><textarea type="text" name="text" id="answer_faqitem"></textarea><br /></td>\
			</tr>\
			<tr class="social" style="display: none;">\
				<th><label for="social_type">Select Icon Type:</label></th>\
				<td>\
					<select id="social_type">\
						<option selected value="twitter">twitter</option>\
						<option value="facebook">facebook</option>\
						<option value="vimeo">vimeo</option>\
						<option value="google">google plus</option>\
						<option value="youtube">youtube</option>\
					</select>\
				<br />\
				<small>Select the social network that you want to link to.</small></td>\
			</tr>\
			<tr class="social" style="display: none;">\
				<th><label for="social_linkto">URL of your Account</label></th>\
				<td><input type="text" value="" id="social_linkto" /><br />\
				<small>URL of your account on the respective Social Network.</small></td>\
			</tr>\
			<tr class="list" style="display: none;">\
				<th><label for="list_type">Select list style</label></th>\
				<td>\
					<select id="list_type">\
						<option selected value="default">default</option>\
						<option value="check">check</option>\
						<option value="arrow">arrow</option>\
					</select>\
				<br />\
				<small>Select the style of the list.</small></td>\
			</tr>\
			<tr class="icon" style="display: none;">\
				<th><label for="icon_type">Select Icon Type</label></th>\
				<td>\
					<select id="icon_type">\
						<option selected value="notepad">notepad</option>\
						<option value="briefcase">briefcase</option>\
						<option value="map">map</option>\
						<option value="home">home</option>\
						<option value="phone">phone</option>\
						<option value="mail">mail</option>\
					</select>\
				</td>\
			</tr>\
			<tr class="contactform" style="display: none;">\
				<th><label for="contactform_sendto">Send Email To</label></th>\
				<td><input type="text" value="" id="contactform_sendto" /><br />\
				<small>The email address of the recipient.</small></td>\
			</tr>\
			<tr class="success" style="display: none;">\
				<th><label for="success_content">Content</label></th>\
				<td><textarea type="text" name="text" id="success_content"></textarea><br />\
				<small>The content text of the success message.</small></td>\
			</tr>\
			<tr class="error" style="display: none;">\
				<th><label for="error_content">Content</label></th>\
				<td><textarea type="text" name="text" id="error_content"></textarea><br />\
				<small>The content text of the error message.</small></td>\
			</tr>\
			<tr class="info" style="display: none;">\
				<th><label for="info_content">Content</label></th>\
				<td><textarea type="text" name="text" id="info_content"></textarea><br />\
				<small>The content text of the info message.</small></td>\
			</tr>\
			<tr class="warning" style="display: none;">\
				<th><label for="warning_content">Content</label></th>\
				<td><textarea type="text" name="text" id="warning_content"></textarea><br />\
				<small>The content text of the warning message.</small></td>\
			</tr>\
			<tr class="pane" style="display: none;">\
				<th><label for="pane_title">Title</label></th>\
				<td><input type="text" value="" id="pane_title" /><br />\
				<small>The title of this accordion pane.</small></td>\
			</tr>\
			<tr class="tabgroup" style="display: none;">\
				<th><label for="tabgroup_1">Title 1</label></th>\
				<td><input type="text" value="" id="tabgroup_1" /><br />\
				<small>The title for the first tab.</small></td>\
			</tr>\
			<tr class="tabgroup" style="display: none;">\
				<th><label for="tabgroup_2">Title 2</label></th>\
				<td><input type="text" value="" id="tabgroup_2" /></td>\
			</tr>\
			<tr class="tabgroup" style="display: none;">\
				<th><label for="tabgroup_3">Title 3</label></th>\
				<td><input type="text" value="" id="tabgroup_3" /></td>\
			</tr>\
			<tr class="tabgroup" style="display: none;">\
				<th><label for="tabgroup_4">Title 4</label></th>\
				<td><input type="text" value="" id="tabgroup_4" /></td>\
			</tr>\
			<tr class="tabgroup" style="display: none;">\
				<th><label for="tabgroup_5">Title 5</label></th>\
				<td><input type="text" value="" id="tabgroup_5" /></td>\
			</tr>\
			<tr class="alt-tabgroup" style="display: none;">\
				<th><label for="alt-tabgroup_1">Title 1</label></th>\
				<td><input type="text" value="" id="alt-tabgroup_1" /><br />\
				<small>The title for the first tab.</small></td>\
			</tr>\
			<tr class="alt-tabgroup" style="display: none;">\
				<th><label for="alt-tabgroup_2">Title 2</label></th>\
				<td><input type="text" value="" id="alt-tabgroup_2" /></td>\
			</tr>\
			<tr class="alt-tabgroup" style="display: none;">\
				<th><label for="alt-tabgroup_3">Title 3</label></th>\
				<td><input type="text" value="" id="alt-tabgroup_3" /></td>\
			</tr>\
			<tr class="alt-tabgroup" style="display: none;">\
				<th><label for="alt-tabgroup_4">Title 4</label></th>\
				<td><input type="text" value="" id="alt-tabgroup_4" /></td>\
			</tr>\
			<tr class="alt-tabgroup" style="display: none;">\
				<th><label for="alt-tabgroup_5">Title 5</label></th>\
				<td><input type="text" value="" id="alt-tabgroup_5" /></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="mygallery-submit" class="button-primary" value="Insert" name="submit" />\
		</p>\
		</div>');		
		
		
		var table = form.find('table');
		form.appendTo('body').hide();		
		
		table.find('#myshortcode').change(function(){
			var mycode = table.find('#myshortcode').val();
			table.find('tr').not('.myshortcode').css("display", "none");			
			table.find('.'+mycode).css("display", "block");
		});
		
		
		// handles the click event of the submit button
		form.find('#mygallery-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless

			var current = table.find('#myshortcode').val();
			var shortcode;
			
			if(current == 'clear'  || current == 'divider')
			shortcode = '['+current+' /]';
			
			else if (current == 'accordion' || current == 'alt-accordion')
			shortcode = '[raw]['+current+']Your content ...[/'+current+'][/raw]';
			
			else if(current == 'raw' || current == 'col2' || current == 'col2_last' || current == 'col3' || current == 'col3_last' || current == 'col4' || current == 'col4_last' || current == 'col23' || current == 'col23_last' || current == 'col34' || current == 'col34_last' || current == 'tab' || current == 'faq' )
			shortcode = '['+current+']Your content ...[/'+current+']';
			
			else if(current == 'list' || current == 'icon')
			shortcode = '['+current+' type="'+table.find('#'+current+'_type').val()+'"]Content..[/'+current+']';
			
			else if(current == 'social')
			shortcode = '[social type="'+table.find('#social_type').val()+'"]'+table.find('#social_linkto').val()+'[/social]';
			
			else if(current == 'tabgroup' || current == 'alt-tabgroup'){
				shortcode = '['+current;
				var i;
				for(i=1; i<=5; i++){
					if(table.find('#'+current+'_'+i).val() != '')
					shortcode += ' tab'+i+'="'+table.find('#'+current+'_'+i).val()+'"';
					else break;
				}
				shortcode += ']Your tabs..[/'+current+']';
			}

			else if(current == 'button')
			shortcode = '[button linkto="'+table.find('#button_linkto').val()+'" size="'+table.find('#button_size').val()+'" color="'+table.find('#button_color').val()+'"]'+table.find('#button_content').val()+'[/button]';
			
			else if(current == 'link')
			shortcode = '[link linkto="'+table.find('#link_linkto').val()+'" type="'+table.find('#link_type').val()+'"]'+table.find('#link_content').val()+'[/link]';
			
			else if(current == 'highlight')
			shortcode = '[highlight color="'+table.find('#highlight_color').val()+'"]Your content..[/highlight]';
			
			else if(current == 'contactform')
			shortcode = '[raw][contactform sendto="'+table.find('#contactform_sendto').val()+'" /][/raw]';
			
			else if(current == 'pane')
			shortcode = '[pane title="'+table.find('#pane_title').val()+'"]Your content..[/pane]';
			
			else if(current == 'faqitem') {
			shortcode = '[faqitem question="'+table.find('#question_faqitem').val()+'"]'+table.find('#answer_faqitem').val()+'[/faqitem]';
			}
			
			else if(current == 'success' || current == 'error'  || current == 'info'  || current == 'warning')
			shortcode = '['+current+']'+table.find('#'+current+'_content').val()+'[/'+current+']';

			else 
			shortcode = '';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})()