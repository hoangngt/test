<?php
 
// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die (__('Please do not load this page directly. Thanks!', 'bellissima'));
 
if ( post_password_required() ) { ?>
<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'bellissima'); ?></p>
<?php
return;
}
?>
 
<!-- You can start editing here. -->
 
<?php if ( have_comments() ) : ?>
<h3><?php _e('Comments', 'bellissima'); ?></h3>
 
<div class="navigation">
<div class="alignleft"><?php previous_comments_link() ?></div>
<div class="alignright"><?php next_comments_link() ?></div>
</div>
 
<ol class="commentlist">
<?php wp_list_comments('callback=mytheme_comment'); ?>
</ol>
 
<?php else : // this is displayed if there are no comments so far ?>
 
<?php if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->
 
<?php else : // comments are closed ?>
<!-- If comments are closed. -->
<p class="nocomments"><?php _e('Comments are closed.', 'bellissima'); ?></p>
 
<?php endif; ?>
<?php endif; ?>
 
<?php if ('open' == $post->comment_status) : ?>

<div class="clear"></div>
 
<div class="comment-form-container">
 
<span class="new-comment-heading"><?php _e('Post Your Comment', 'bellissima'); ?></span>

<div class="clear"></div>
 
<?php if ( get_option('comment_registration') && !$user_ID ) : ?>
<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>
<?php else : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform" class="blog_comment">
 
<?php if ( $user_ID ) : ?>
 
<p><?php _e('Logged in as', 'bellissima'); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="Log out of this account"><?php _e('Log out &raquo;', 'bellissima'); ?></a></p>
 
<?php else : ?>

<div class="form-name float-left">
	<span><?php _e('Your Name', 'bellissima'); ?></span>
	<input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" class="form-name input-text" <?php if ($req) echo "required"; ?> />
</div>
	
<div class="form-name float-right">
	<span><?php _e('Your E-mail', 'bellissima'); ?></span>
	<input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" class="form-name input-text" <?php if ($req) echo "required"; ?> />
</div>
	
<!-- <span class="comment_field last">
	<label for="url">Website :</label>
	<input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" />
</span> -->

<?php endif; ?>
 
<!--<p><small><strong>XHTML:</strong> You can use these tags: <code><?php echo allowed_tags(); ?></code></small></p>-->
<br class="clear"/>

<div class="form-comment">
	<span><?php _e('Comment', 'bellissima'); ?></span>
	<textarea name="comment" id="comment" cols="20" rows="4" class="txtarea-comment"></textarea>
</div>
 
<input name="submit" type="submit" id="comment-submit" class="button" value="<?php _e('Submit comment', 'bellissima'); ?>" />
<?php comment_id_fields(); ?>

<?php do_action('comment_form', $post->ID); ?>

<div class="clear"></div>
</form>
 
<?php endif; // If registration required and not logged in ?>
</div>
 
<?php endif; // if you delete this the sky will fall on your head ?>