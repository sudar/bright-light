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

        <div class="entry-content">
            <?php the_content(); ?>
            <?php wp_link_pages('before=<div class="page-link">' . __( 'Pages:', 'bright-light' ) . '&after=</div>') ?>
            <?php edit_post_link( __( 'Edit', 'bright-light' ), '<span class="edit-link">', '</span>' ) ?>
        </div><!-- .entry-content -->

    <?php get_social_icons(urlencode(get_permalink()), the_title_attribute('echo=0'));?>

    </div><!-- #post-<?php the_ID(); ?> -->

<?php comments_template('', true); ?>

</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>