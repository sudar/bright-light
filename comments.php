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
                <a class="trackback-link" rel="trackback" href="<?php echo get_trackback_url(); ?>"><?php _e('Trackback URI', 'bright-light');?></a>
<?php   }

        if ($post->comment_status == "open") {
            if ($post->ping_status == "open") {
                 echo " | ";
            }
            
            printf( __( '<a href="%2$s" title="Comments RSS to %1$s" rel="alternate" type="application/rss+xml">Follow up comments through RSS Feed</a>', 'bright-light' ),
            the_title_attribute('echo=0'),
            get_post_comments_feed_link() );

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

	<?php comment_form(); ?>
</div>
