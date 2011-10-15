<?php
/**
 * @package WordPress
 * @subpackage Default_Theme
 */

// Do not delete these lines
	if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');
	
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'kubrick'); ?></p> 
	<?php
		return;
	}
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<h3 id="comments"><?php comments_number(__('No Responses'), __('One Response'), __('% Responses'));?> <?php printf(__('to &#8220;%s&#8221;'), the_title('', '', false)); ?></h3>
    <a id="showhide" href="#">Show / Hide Comments</a><div class="clear"></div>


	<ol class="commentlist">
	<?php wp_list_comments('avatar_size=64'); ?>
	</ol>

	<div class="navigation">
		<?php if ( get_previous_comments_link() != '' ) : ?><div class="alignleft"><?php previous_comments_link() ?></div><?php endif; ?>
		<?php if ( get_next_comments_link() != '' ) : ?><div class="alignright"><?php next_comments_link() ?></div><?php endif; ?>
	</div>
 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.'); ?></p>

	<?php endif; ?>
<?php endif; ?>


<?php if ( comments_open() ) : ?>

<div id="respond">

<h3><?php comment_form_title( __('Leave a Comment'), __('Leave a Reply for %s' ) ); ?></h3>

<div id="cancel-comment-reply"> 
	<small><?php cancel_comment_reply_link() ?></small>
</div> 

<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
<p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url( get_permalink() )); ?></p>
<?php else : ?>

<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( is_user_logged_in() ) : ?>

<p><?php printf(__('Logged in as <a href="%1$s">%2$s</a>.'), get_option('siteurl') . '/wp-admin/profile.php', $user_identity); ?> <a href="<?php echo wp_logout_url(get_permalink()); ?>" title="<?php _e('Log out of this account'); ?>"><?php _e('Log out &raquo;'); ?></a></p>

<?php else : ?>

<p>


<input type="text" name="author" id="author" value="<?php if( esc_attr($comment_author) != '' ) echo esc_attr($comment_author); else echo "Name *"; ?>"   tabindex="1" <?php if ($req) echo "aria-required='true'"; ?> />
<input type="text" name="email" id="email" value="<?php if( esc_attr($comment_author_email) != '' ) echo esc_attr($comment_author_email); else echo "Email *"; ?>"   tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
<input type="text" name="url" id="url" value="<?php if( esc_attr($comment_author_url) != '' ) echo esc_attr($comment_author_url); else echo "Url"; ?>"   tabindex="3" />
</p>

<?php endif; ?>

<!--<p><small><?php printf(__('<strong>XHTML:</strong> You can use these tags: <code>%s</code>'), allowed_tags()); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="58" rows="10" tabindex="4"></textarea></p>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Post Comment'); ?>" />
<?php comment_id_fields(); ?> 
</p>
<?php do_action('comment_form', $post->ID); ?>

</form>

<?php endif; // If registration required and not logged in ?>
</div>

<?php endif; // if you delete this the sky will fall on your head ?>
