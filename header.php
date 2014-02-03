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
<meta name="viewport" content="initial-scale=1">
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
<header id="header">

  <div id="logo">
    <h1 id="blogname">
        <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a>
    </h1>

    <div class="description">
      <?php bloginfo('description'); ?>
    </div>
  </div>

    <p class="skip-link"><a href="#content" title="<?php _e( 'Skip to content', 'bright-light' ) ?>"><?php _e( 'Skip to content', 'bright-light' ) ?></a></p>

  <div id = "searchbox">
    <form action="<?php bloginfo( 'url' ); ?>/search/" method="get" onsubmit="location.href='<?php bloginfo( 'url' ); ?>/search/' + encodeURIComponent(this.s.value).replace(/%20/g, '+'); return false;">
        <input type="search" name="s" id="s" size="25" accesskey="s" placeholder="Search" >
        <input type="submit" value="<?php echo esc_attr( __( 'Search', 'bright-light' ) ); ?>" >
    </form>
  </div>
</header> <!-- header -->

<?php
wp_nav_menu( array( 
    'theme_location' => 'primary-menu',
    'container' => 'nav'
) );
?>

<div id="wrap" class ="hfeed">
