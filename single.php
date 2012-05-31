<?php get_header(); ?>

<div id="content">
<?php if ( function_exists('yoast_breadcrumb') ) {
    yoast_breadcrumb('<p class="breadcrumbs">','</p>');
} ?>

<?php the_post(); ?>

  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <h2 class="entry-title">
        <a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'bright-light'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a>
    </h2>

    <p class="entry-meta">
<?php
    global $bright_light_options;
    $show_author  = $bright_light_options['show-author'];

    if ($show_author == "1") {
?>
        <span class="meta-prep meta-prep-author"><?php _e('By ', 'bright-light'); ?></span>
        <span class="author vcard"><a class="url fn n" href="<?php echo get_author_link( false, $authordata->ID, $authordata->user_nicename ); ?>" title="<?php printf( __( 'View all posts by %s', 'bright-light' ), $authordata->display_name ); ?>"><?php the_author(); ?></a></span>
        <span class="meta-sep"> | </span>
<?php
    }
?>        
        <span class="meta-prep meta-prep-entry-date"><?php _e('Published ', 'bright-light'); ?></span>
        <span class="entry-date"><abbr class="published" title="<?php the_time('Y-m-d\TH:i:sO') ?>"><?php the_time( get_option( 'date_format' ) ); ?></abbr></span>
        <span class="meta-sep"> | </span>
        <span><?php _e('In ', 'bright-light'); echo get_the_category_list(', ');?></span>

        <?php edit_post_link( __( 'Edit', 'bright-light' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t" ) ?>
    </p>

    <div class="entry-content">
        <?php the_content(); ?>
        <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'bright-light' ) . '&after=</div>') ?>
<?php
    if (function_exists('posts_by_tag')) {
        echo '<h3>' . __('Related posts', 'bright-light') . '</h3>';
        posts_by_tag(); 
    }
?>

    </div><!-- .entry-content -->

    <p class="entry-utility">
        <?php echo get_the_tag_list( __( 'Tags: ', 'bright-light' ), ', ', '' );?>

        <?php edit_post_link( __( 'Edit', 'bright-light' ), "\n\t\t\t\t\t<span class=\"edit-link\">", "</span>" ) ?>
    </p><!-- .entry-utility -->

    <?php get_social_icons(urlencode(get_permalink()), the_title_attribute('echo=0'));?>
    
  </div><!-- #post-<?php the_ID(); ?> -->

  <div class="navigation nav-below">
    <div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span> %title' ) ?></div>
    <div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&raquo;</span>' ) ?></div>
  </div><!-- #nav-below -->
  
<?php comments_template('', true); ?>

  <div class="navigation nav-below">
    <div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&laquo;</span> %title' ) ?></div>
    <div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&raquo;</span>' ) ?></div>
  </div><!-- #nav-below -->
</div>
<!--content ends-->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
