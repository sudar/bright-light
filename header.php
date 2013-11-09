<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package BrightLight 
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head> 

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'bright-light' ), max( $paged, $page ) );

	?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php
// For threaded comments
    if ( is_singular() && comments_open() && get_option('thread_comments')) wp_enqueue_script( 'comment-reply' );

// wp_head hook
wp_head();

?>
</head>

<body <?php body_class(); ?>>
<div id="header">

  <div id="logo">
    <h1 id="blogname">
        <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
    </h1>

    <div class="description">
      <?php bloginfo('description'); ?>
    </div>
  </div>

    <p class="skip-link"><a href="#content" title="<?php _e( 'Skip to content', 'bright-light' ) ?>"><?php _e( 'Skip to content', 'bright-light' ) ?></a></p>
<?php
global $bright_light_options;
$bright_light_options = get_option('bright-light-options');

$show_home      = isset( $bright_light_options['show-home'] ) ? $bright_light_options['show-home'] : '';
$included_pages = isset( $bright_light_options['included-pages'] ) ? $bright_light_options['included-pages'] : '';
$sort_order     = isset( $bright_light_options['sort-order'] ) ? $bright_light_options['sort-order'] : '';
$sort_order     = ($sort_order == "")? "menu_order":$sort_order;

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
    <form action="<?php bloginfo( 'url' ); ?>/search/" method="get" onsubmit="location.href='<?php bloginfo( 'url' ); ?>/search/' + encodeURIComponent(this.s.value).replace(/%20/g, '+'); return false;">
        <input type="search" name="s" id="s" size="25" accesskey="s" placeholder="Search" >
        <input type="submit" value="<?php echo esc_attr( __( 'Search', 'bright-light' ) ); ?>" >
    </form>
  </div>
</div> <!-- header -->
<div id="wrap" class ="hfeed">
