<?php // Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

// if password protected
if ( post_password_required() ) {
	_e('<p class = "clearboth">This post is password protected. Enter the password to view comments.</p>', 'bright-light');
	return;
}
?>

<div id="commentblock">
  <!--comments area-->
  <h4 id="comments">
    <?php echo count($comments_by_type['comment']);?> <?php _e('Comments so far', 'bright-light');?>
  </h4>

  <p>
<?php
        if ($post->ping_status == "open") { ?>
                <a class="trackback-link" rel="trackback" href="<?php trackback_url(display); ?>"><?php _e('Trackback URI', 'bright-light');?></a>
<?php   }

        if ($post->comment_status == "open") {
            if ($post->ping_status == "open") {
                 echo " | ";
            }
            
            printf( __( '<a href="%2$s" title="Comments RSS to %1$s" rel="alternate" type="application/rss+xml">Follow up comments through RSS Feed</a>', 'bright-light' ),
            the_title_attribute('echo=0'),
            comments_rss() );

            echo " | ";
            _e( '<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a>', 'bright-light' );
        }
?>
  </p>

<?php if ( have_comments() ) : ?>
    <?php if ( !empty($comments_by_type['comment']) ) : ?>
        <ul class="commentlist">
            <?php wp_list_comments('type=comment'); ?>
        </ul>
    <?php endif; ?>

    <?php if ( ! empty($comments_by_type['tweetback']) ) : ?>
      <h4 id="tweetbacks"><?php echo count($comments_by_type['tweetback']); ?> <?php _e('Tweetbacks so far', 'bright-light');?></h4>
          <ul class="commentlist tweetbacks">
              <?php wp_list_comments('type=tweetback'); ?>
          </ul>
    <?php endif; ?>

    <?php if ( ! empty($comments_by_type['pings']) ) : ?>
      <h4 id="pings"><?php echo count($comments_by_type['pings']);?> <?php _e('Trackbacks/Pingbacks so far', 'bright-light');?></h4>
          <ul class="commentlist pingbacks">
            <?php wp_list_comments('type=pings&callback=custom_pings'); ?>
          </ul>
    <?php endif; ?>

    <div class="navigation">
        <div class="alignleft"><?php previous_comments_link() ?></div>
        <div class="alignright"><?php next_comments_link() ?></div>
    </div>

<?php else : // this is displayed if there are no comments so far ?>
    <?php if ('open' == $post->comment_status) : ?>
          <!-- If comments are open, but there are no comments. -->
          <p><?php _e('You are the first one to start the discussion.', 'bright-light');?></p>
    <?php endif;?>
<?php endif;?>

  <?php if ('open' == $post->comment_status) : ?>

  <h4><?php comment_form_title( __('Leave a Comment', 'bright-light'), __('Leave a Reply to %s', 'bright-light') ); ?></h4>

  <div id="respond">
    <div id="cancel-comment-reply"><?php cancel_comment_reply_link() ?></div>

    <?php if ( get_option('comment_registration') && !$user_ID ) : ?>

        <p><?php _e('You must be ', 'bright-light');?><a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>"><?php _e('logged in', 'bright-light');?></a><?php _e(' to post a comment.', 'bright-light');?></p>

    <?php else : ?>

        <form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" >
          <?php if ( $user_ID ) : ?>
              <p><?php _e('Logged in as ', 'bright-light');?><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url();?>&redirect_to=<?php echo $_SERVER['REQUEST_URI']; ?>" title="<?php _e('Log out of this account', 'bright-light') ?>"> <?php _e('Logout ', 'bright-light');?>&raquo; </a> </p>
          <?php else : ?>
              <p>
                <input class="textbox" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="30" tabindex="1" <?php if ($req) echo 'required'; ?> />
                <label for="author">
                        <?php _e('Name', 'bright-light');?>
                        <?php if ($req) _e('(required)', 'bright-light'); ?>
                </label>
              </p>
              <p>
                <input class="textbox" type="email" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="30" tabindex="2" <?php if ($req) echo 'required'; ?> />
                <label for="email">
                        <?php _e('Email', 'bright-light');?>
                        (<?php _e('will not be shown', 'bright-light');?>
                        <?php if ($req) _e(', but required', 'bright-light'); ?>)
                </label>
              </p>
              <p>
                <input class="textbox" type="url" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="30" tabindex="3" <?php if ($req) echo 'required'; ?> />
                <label for="url">
                        <?php _e('Website', 'bright-light');?>
                </label>
              </p>
          <?php endif; ?>
              <p>
                <textarea name="comment" id="comment" cols="50" rows="10" tabindex="4"></textarea>
              </p>

              <p>
                  <small><?php _e('You can use these tags: ', 'bright-light');?><?php echo allowed_tags(); ?></small>
              </p>

              <p>
                <input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
              </p>

                <div id="loading" style="display: none;"><?php _('Posting your comment.');?></div>
                <div id="errors"></div>

          <?php do_action('comment_form', $post->ID); ?>
          <?php comment_id_fields(); ?>
        </form>
    <?php endif; // if you delete this the sky will fall on your head ?>
  </div>
  <?php else : // comments are closed ?>
      <!-- If comments are closed. -->
      <p><?php _e('Comments are closed.', 'bright-light');?></p>
  <?php endif; // comment status?>
</div>
