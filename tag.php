<?php get_header(); ?>

<div id="content">

<?php the_post(); ?>
    
<h2 class="page-title"><?php _e( 'Tag Archives:', 'bright-light' ) ?> <span><?php single_tag_title() ?></span></h2>
<?php $categorydesc = category_description(); if ( !empty($categorydesc) ) echo apply_filters( 'archive_meta', '<div class="archive-meta">' . $categorydesc . '</div>' ); ?>

<?php rewind_posts(); ?>

<?php while ( have_posts() ) : the_post(); ?>

    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <h2 class="entry-title">
        <a href="<?php the_permalink(); ?>" title="<?php printf( __('Permalink to %s', 'bright-light'), the_title_attribute('echo=0') ); ?>" rel="bookmark"><?php the_title(); ?></a>
    </h2>

    <p class="entry-meta">
<?php
    global $bl_show_author;
    if ($bl_show_author == "1") {
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
        <?php the_content( __( 'Continue reading <span class="meta-nav">&raquo;</span>', 'bright-light' )  ); ?>
        <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'bright-light' ) . '&after=</div>') ?>
    </div><!-- .entry-content -->

    <p class="entry-utility">
        <span class="cat-links"><span class="entry-utility-prep entry-utility-prep-cat-links"><?php _e( 'Posted in ', 'bright-light' ); ?></span><?php echo get_the_category_list(', '); ?></span>
        <span class="meta-sep"> | </span>
        <?php the_tags( '<span class="tag-links"><span class="entry-utility-prep entry-utility-prep-tag-links">' . __('Tagged ', 'bright-light' ) . '</span>', ", ", "</span>\n\t\t\t\t\t\t<span class=\"meta-sep\">|</span>\n" ) ?>
        <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'bright-light' ), __( '1 Comment', 'bright-light' ), __( '% Comments', 'bright-light' ) ) ?></span>
        <?php edit_post_link( __( 'Edit', 'bright-light' ), "<span class=\"meta-sep\">|</span>\n\t\t\t\t\t\t<span class=\"edit-link\">", "</span>\n\t\t\t\t\t\n" ) ?>
    </p><!-- #entry-utility -->

    <!--
	<?php trackback_rdf(); ?>
    -->

</div><!-- #post-<?php the_ID(); ?> -->

<?php endwhile; ?>

<?php global $wp_query; $total_pages = $wp_query->max_num_pages; if ( $total_pages > 1 ) { ?>
    <div id="nav-below" class="navigation">
            <div class="nav-previous"><?php next_posts_link(__( '<span class="meta-nav">&laquo;</span> Older posts', 'bright-light' )) ?></div>
            <div class="nav-next"><?php previous_posts_link(__( 'Newer posts <span class="meta-nav">&raquo;</span>', 'bright-light' )) ?></div>
    </div><!-- #nav-below -->
<?php } ?>
</div>
<!-- content end -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>