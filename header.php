<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">

<title><?php
    if ( is_single() ) { single_post_title(); }
    elseif ( is_home() || is_front_page() ) { bloginfo('name'); print ' | '; bloginfo('description'); get_page_number(); }
    elseif ( is_page() ) { single_post_title(''); }
    elseif ( is_search() ) { bloginfo('name'); _e(' | Search results for ', 'bright-light');  echo wp_specialchars($s); get_page_number(); }
    elseif ( is_404() ) { bloginfo('name'); _e(' | Not Found', 'bright-light'); }
    else { bloginfo('name'); wp_title('|'); get_page_number(); }
?></title>

<meta http-equiv="content-type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

<?php
// For threaded comments
if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

<?php wp_head(); ?>

<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('rss2_url'); ?>" title="<?php printf( __( '%s latest posts', 'bright-light' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
<link rel="alternate" type="application/rss+xml" href="<?php bloginfo('comments_rss2_url') ?>" title="<?php printf( __( '%s latest comments', 'bright-light' ), wp_specialchars( get_bloginfo('name'), 1 ) ); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
</head>

<body <?php body_class(); ?>>
<div id="header">

  <div id="logo">
    <h1 id="blogname">
        <a href="<?php bloginfo('siteurl'); ?>">
            <?php  bloginfo('name'); ?>
        </a>
    </h1>

    <div class="description">
      <?php bloginfo('description'); ?>
    </div>
  </div>

    <p class="skip-link"><a href="#content" title="<?php _e( 'Skip to content', 'bright-light' ) ?>"><?php _e( 'Skip to content', 'bright-light' ) ?></a></p>
<?php
global $bright_light_options;
$bright_light_options = get_option('bright-light-options');

$show_home = $bright_light_options['show-home'];
$included_pages = $bright_light_options['included-pages'];
$sort_order = $bright_light_options['sort-order'];
$sort_order = ($sort_order == "")? "menu_order":$sort_order;

if ($show_home == "1") {
    $home_cond = 'show_home=1&';
} else {
    $home_cond = "";
}

if (is_array($included_pages)) {
    $included_cond = 'include=' . implode(",", $included_pages) . '&';
} else {
    $included_cond = "";
}

wp_page_menu($home_cond . $included_cond . "sort_column=$sort_order&menu_class=site-menu&depth=1&link_before=<span>&link_after=</span>");
?>

  <div id = "searchbox">
    <form action="<?php bloginfo('wpurl'); ?>/index.php" method="get" onsubmit="location.href='<?php bloginfo('home'); ?>/search/' + encodeURIComponent(this.s.value).replace(/%20/g, '+'); return false;">
        <input type="text" name="s" id="s" size="25" accesskey="s" />
        <input type="submit" value="<?php echo attribute_escape(__('Search', 'bright-light')); ?>" />
    </form>
  </div>
</div> <!-- header -->
<div id="wrap" class ="hfeed">
