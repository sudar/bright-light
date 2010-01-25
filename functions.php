<?php

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'bright-light', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable($locale_file) )
	require_once($locale_file);

// Get the page number
function get_page_number() {
    if ( get_query_var('paged') ) {
        print ' | ' . __( 'Page ' , 'bright-light') . get_query_var('paged');
    }
} // end get_page_number


// register sidebar
function theme_widgets_init() {
    // Area 1
    register_sidebar( array (
	'name' => 'Primary Widget Area',
	'id' => 'primary_widget_area',
	'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	'after_widget' => "</li>",
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
    ) );

	// Area 2
    register_sidebar( array (
	'name' => 'Secondary Widget Area',
	'id' => 'secondary_widget_area',
	'before_widget' => '<li id="%1$s" class="widget-container siteinfo-widget %2$s">',
	'after_widget' => "</li>",
	'before_title' => '<h4 class="widget-title">',
	'after_title' => '</h4>',
  ) );
} // end theme_widgets_init

add_action( 'init', 'theme_widgets_init' );

$preset_widgets = array (
    'primary_widget_area'  => array( 'search', 'pages', 'categories', 'archives' ),
    'secondary_widget_area'  => array( 'links', 'meta' )
);

if ( isset( $_GET['activated'] ) ) {
    update_option( 'sidebars_widgets', $preset_widgets );
}
// update_option( 'sidebars_widgets', NULL );  // To make sidebars empty uncomemnt this line


/**
 * Custom callback to list pings
 * @param <type> $comment
 * @param <type> $args
 * @param <type> $depth
 */
function custom_pings($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;
?>
    <li id="comment-<?php comment_ID() ?>" <?php comment_class() ?>>
        <div class="comment-author"><?php printf(__('By %1$s on %2$s at %3$s', 'bright-light'),
                        get_comment_author_link(),
                        get_comment_date(),
                        get_comment_time() );
                        edit_comment_link(__('Edit', 'bright-light'), ' <span class="meta-sep">|</span> <span class="edit-link">', '</span>'); ?></div>
    <?php if ($comment->comment_approved == '0') _e('\t\t\t\t\t<span class="unapproved">Your trackback is awaiting moderation.</span>\n', 'bright-light') ?>
<?php } // end custom_pings


/**
 * Admin class for the theme
 */
class BrightLight {

    /**
     * Initalize the plugin by registering the hooks
     */
    function __construct() {

        // Register hooks
        add_action( 'admin_menu', array(&$this, 'register_settings_page') );
        add_action( 'admin_init', array(&$this, 'add_settings') );
    }

    /**
     * Register the settings page
     */
    function register_settings_page() {
        add_theme_page( __('Bright Light', 'bright-light'), __('Bright Light', 'bright-light'), 8, 'bright-light', array(&$this, 'settings_page') );
    }

    /**
     * add options
     */
    function add_settings() {
        // Register options
        register_setting( 'bright-light', 'bright-light-options', array(&$this, 'validate_settings'));
    }

    /**
     * validate settings
     */
    function validate_settings($input) {
        $input['show-home'] = ($input['show-home'] == "1")? "1":"0";
        return $input;
    }
    /**
     * Dipslay the Settings page
     */
    function settings_page() {
?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2><?php _e( 'Bright Light Settings', 'bright-light' ); ?></h2>

            <form method="post" action="options.php">
                <?php settings_fields('bright-light'); ?>
                <?php $options = get_option('bright-light-options'); ?>

                <?php $options['show-home'] = ($options['show-home'] == "")? "1":$options['show-home'];?>
                <?php $options['sort-order'] = ($options['sort-order'] == "")? "menu_order":$options['sort-order'];?>

                <?php $options['show-author'] = ($options['show-author'] == "")? "1":$options['show-author'];?>

                <?php $options['enable-icon'] = ($options['enable-icon'] == "")? "1":$options['enable-icon'];?>
                <?php $options['icon-size'] = ($options['icon-size'] == "")? "64":$options['icon-size'];?>
                <?php $options['social-icons'] = (!is_array($options['social-icons']))? array('delicious','facebook','linkedin','reddit','stumble','technorati','twitter',) : $options['social-icons'];?>

<?php
        $social_icons = array(
        'blinklist',
        'delicious',
        'dzone',
        'facebook',
        'linkedin',
        'reddit',
        'stumble',
        'technorati',
        'twitter',
        'yahoo'
        );
?>

                <h3><?php _e('Top Navigation', 'bright-light');?></h3>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Include these pages in top navigation', 'bright-light' ); ?></th>
                        <td>
<?php 
                            $pages = get_pages("parent=0");
                            foreach ($pages as $page) {
?>
                                <p><label><input type="checkbox" name="bright-light-options[included-pages][]" value="<?php echo $page->ID;?>" <?php checked_array($page->ID, $options['included-pages']); ?> /> <a href = "<?php echo get_permalink($page->ID);?>"><?php echo $page->post_title;?></a></label></p>
<?php
                            }
?>
                                <p><?php _e("Select the pages that you want to appear in the top navigation", 'bright-light');?></p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php _e( 'Include home as a tap in top navigation', 'bright-light' ); ?></th>
                        <td>
                            <p><label><input type="radio" name="bright-light-options[show-home]" value="1" <?php checked('1', $options['show-home']); ?> /> <?php _e('Yes', 'bright-light');?></label>
                            <label><input type="radio" name="bright-light-options[show-home]" value="0" <?php checked('0', $options['show-home']); ?> /> <?php _e('No', 'bright-light');?></label></p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php _e( 'Sorting order for tabs in in top navigation', 'bright-light' ); ?></th>
                        <td>
                            <p><label><input type="radio" name="bright-light-options[sort-order]" value="post_title" <?php checked('post_title', $options['sort-order']); ?> /> <?php _e('Sort Pages alphabetically by title', 'bright-light');?></label></p>
                            <p><label><input type="radio" name="bright-light-options[sort-order]" value="menu_order" <?php checked('menu_order', $options['sort-order']); ?> /> <?php _e('Sort Pages by Page Order', 'bright-light');?></label></p>
                            <p><label><input type="radio" name="bright-light-options[sort-order]" value="post_date" <?php checked('post_date', $options['sort-order']); ?> /> <?php _e('Sort by time last modified.', 'bright-light');?></label></p>
                            <p><label><input type="radio" name="bright-light-options[sort-order]" value="post_modifiyed" <?php checked('post_modifiyed', $options['sort-order']); ?> /> <?php _e('Sort by time last modified.', 'bright-light');?></label></p>
                            <p><label><input type="radio" name="bright-light-options[sort-order]" value="ID" <?php checked('ID', $options['sort-order']); ?> /> <?php _e('Sort by numeric Page ID.', 'bright-light');?></label></p>
                            <p><label><input type="radio" name="bright-light-options[sort-order]" value="post_author" <?php checked('post_author', $options['sort-order']); ?> /> <?php _e("Sort by the Page author's numeric ID.", 'bright-light');?></label></p>
                            <p><label><input type="radio" name="bright-light-options[sort-order]" value="post_name" <?php checked('post_name', $options['sort-order']); ?> /> <?php _e('Sort alphabetically by Post slug.', 'bright-light');?></label></p>
                        </td>
                    </tr>

                </table>

                <h3><?php _e('Social Icons', 'bright-light');?></h3>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Enable Social Icons', 'bright-light' ); ?></th>
                        <td>
                            <p>
                                <label><input type="radio" name="bright-light-options[enable-icon]" value="1" <?php checked('1', $options['enable-icon']); ?> /> <?php _e('Yes', 'bright-light');?></label>
                                <label><input type="radio" name="bright-light-options[enable-icon]" value="0" <?php checked('0', $options['enable-icon']); ?> /> <?php _e('No', 'bright-light');?></label>
                            </p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php _e( 'Size of Social Icons', 'bright-light' ); ?></th>
                        <td>
                            <p>
                                <label><input type="radio" name="bright-light-options[icon-size]" value="16" <?php checked('16', $options['icon-size']); ?> /> <?php _e('16x16', 'bright-light');?></label>
                                <label><input type="radio" name="bright-light-options[icon-size]" value="32" <?php checked('32', $options['icon-size']); ?> /> <?php _e('32x32', 'bright-light');?></label>
                                <label><input type="radio" name="bright-light-options[icon-size]" value="64" <?php checked('64', $options['icon-size']); ?> /> <?php _e('64x64', 'bright-light');?></label>
                            </p>
                        </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><?php _e( 'Select the Social Icons that you want to display', 'bright-light' ); ?></th>
                        <td>
                            <table>
                        <?php
                            $i = 0;
                            foreach ($social_icons as $social_icon) {
                                $i++;
                                if ($i==1) {
                                    echo '<tr>';
                                }
                        ?>
                            <td><label><input type="checkbox" name="bright-light-options[social-icons][]" value="<?php echo $social_icon;?>" <?php checked_array($social_icon, $options['social-icons']) ; ?> /> <?php _e(ucwords($social_icon) , 'bright-light');?></label></td>
                        <?php
                                if ($i==4) {
                                    echo '</tr>';
                                    $i=0;
                                }
                            }
                        ?>
                            </table>
                            <p><?php _e("These icons are provided by ", 'bright-light');?><a href ="http://thedesignsuperhero.com/2008/10/heart-my-free-social-icon-set/"><?php _e('Aravind','bright-light');?></a></p>
                        </td>
                    </tr>

                </table>

                <h3><?php _e('Posts', 'bright-light');?></h3>

                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e( 'Show author name in posts meta', 'bright-light' ); ?></th>
                        <td>
                            <p><label><input type="radio" name="bright-light-options[show-author]" value="1" <?php checked('1', $options['show-author']); ?> /> <?php _e('Yes', 'bright-light');?></label>
                            <label><input type="radio" name="bright-light-options[show-author]" value="0" <?php checked('0', $options['show-author']); ?> /> <?php _e('No', 'bright-light');?></label></p>
                            <p><?php _e("On single author blogs, you might want to hide the author name.", 'bright-light');?></p>
                        </td>
                    </tr>

                </table>

                <p class="submit">
                    <input type="submit" name="bright-light-submit" class="button-primary" value="<?php _e('Save Changes', 'bright-light') ?>" />
                </p>
            </form>
        </div>
<?php
    }

    // PHP4 compatibility
    function BrightLight() {
            $this->__construct();
    }
}

// Start this plugin once all other plugins are fully loaded
add_action( 'init', 'BrightLight' ); function BrightLight() { global $BrightLight; $BrightLight = new BrightLight(); }

// similar to checked() but checks for array
if (!function_exists('checked_array')) {
    function checked_array($checked, $current) {
        if (is_array($current)) {
            if (in_array($checked, $current)) {
                echo ' checked="checked"';
            }
        } else {
            if ($checked == $current) {
                echo ' checked="checked"';
            }
        }
    }
}

/**
 * Add social icons
 * @param <string> $permalink
 */
function get_social_icons($permalink, $title) {
    $options = get_option('bright-light-options');
    
    $options['enable-icon']  = ($options['enable-icon'] == "")? "1":$options['enable-icon'];
    $options['icon-size']    = ($options['icon-size'] == "")? "64":$options['icon-size'];
    $options['social-icons'] = (!is_array($options['social-icons']))? array('delicious','facebook','linkedin','reddit','stumble','technorati','twitter',) : $options['social-icons'];

    $enable_icon  = $options['enable-icon'];
    $icon_size    = $options['icon-size'];
    $social_icons = $options['social-icons'];

    $icon_path =  get_bloginfo('template_directory') . '/images/icons/' . $icon_size . '/';
    if ($enable_icon == "1") {
?>
        <h4><?php _e('Share thy love', 'bright-light') ?></h4>
        <p class="share-icons">
<?php
           foreach ($social_icons as $social_icon) {
               switch ($social_icon) {
                   case 'blinklist':
                       ?>
                       <a rel="nofollow" href ="http://www.blinklist.com/index.php?Action=Blink/addblink.php&amp;Quick=true&amp;Url=<?php echo $permalink;?>&amp;Title=<?php echo $title?>&amp;Pop=yes" title="<?php _e('Bookmark in Blinklist', 'bright-light');?>">
                           <img class="share-icon" alt="<?php _e('Blinklist', 'bright-light');?>" src="<?php echo $icon_path . $social_icon;?>.png" />
                       </a>
                       <?php
                       break;

                   case 'delicious':
                       ?>
                       <a rel ="nofollow" href ="http://del.icio.us/post?url=<?php echo $permalink; ?>&amp;title=<?php echo $title;?>" title="<?php _e('Bookmark in delicious', 'bright-light');?>">
                           <img class="share-icon" alt="<?php _e('Delicious', 'bright-light');?>" src="<?php echo $icon_path . $social_icon;?>.png" />
                       </a>
                       <?php
                       break;

                   case 'dzone':
                       ?>
                       <a rel ="nofollow" href ="http://www.dzone.com/links/add.html? url=<?php echo $permalink; ?>&amp;title=<?php echo $title;?>" title="<?php _e('Bookmark in Dzone', 'bright-light');?>">
                           <img class="share-icon" alt="<?php _e('Dzone', 'bright-light');?>" src="<?php echo $icon_path . $social_icon;?>.png" />
                       </a>
                       <?php
                       break;

                   case 'facebook':
                       ?>
                       <a rel="nofollow" href ="http://www.facebook.com/sharer.php?u=<?php echo $permalink;?>&amp;t=<?php echo $title;?>" title="<?php _e('Share in Facebook', 'bright-light');?>">
                           <img class="share-icon" alt="<?php _e('Facebook', 'bright-light');?>" src="<?php echo $icon_path . $social_icon;?>.png" />
                       </a>
                       <?php
                       break;

                   case 'linkedin':
                       ?>
                       <a rel ="nofollow" href ="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $permalink; ?>&amp;title=<?php echo $title;?>" title="<?php _e('Share in Linkedin', 'bright-light');?>">
                           <img class="share-icon" alt="<?php _e('Linkedin', 'bright-light');?>" src="<?php echo $icon_path . $social_icon;?>.png" />
                       </a>
                       <?php
                       break;

                   case 'reddit':
                       ?>
                       <a rel="nofollow" href ="http://reddit.com/submit?url=<?php echo $permalink;?>&amp;title=<?php echo $title;?>" title="<?php _e('Bookmark in Reddit', 'bright-light');?>">
                           <img class="share-icon" alt="<?php _e('Reddit', 'bright-light');?>" src="<?php echo $icon_path . $social_icon;?>.png" />
                       </a>
                       <?php
                       break;

                   case 'stumble':
                       ?>
                       <a rel ="nofollow" href ="http://www.stumbleupon.com/submit?url=<?php echo $permalink; ?>&amp;title=<?php echo $title; ?>" title="<?php _e('Bookmark in Stumbleupon', 'bright-light');?>">
                           <img class="share-icon" alt="<?php _e('Stumbleupon', 'bright-light');?>" src="<?php echo $icon_path . $social_icon;?>.png" />
                       </a>
                       <?php
                       break;

                   case 'technorati':
                       ?>
                       <a rel ="nofollow" href ="http://technorati.com/faves?add=<?php echo $permalink;?>" title="<?php _e('Bookmark in Technorati', 'bright-light');?>">
                           <img class="share-icon" alt="<?php _e('Technorati', 'bright-light');?>" src="<?php echo $icon_path . $social_icon;?>.png" />
                       </a>
                       <?php
                       break;

                   case 'twitter':
                       ?>
                       <a rel ="nofollow" href ="http://twitter.com/home?status=<?php echo $permalink;?>" title="<?php _e('Share in Twitter', 'bright-light');?>">
                           <img class="share-icon" alt="<?php _e('Twitter', 'bright-light');?>" src="<?php echo $icon_path . $social_icon;?>.png" />
                       </a>
                       <?php
                       break;

                   case 'yahoo':
                       ?>
                       <a rel="nofollow" href ="http://myweb2.search.yahoo.com/myresults/bookmarklet?u=<?php echo $permalink;?>&amp;t=<?php echo $title;?>" title="<?php _e('Share in Yahoo', 'bright-light');?>">
                           <img class="share-icon" alt="<?php _e('Yahoo', 'bright-light');?>" src="<?php echo $icon_path . $social_icon;?>.png" />
                       </a>
                       <?php
                       break;

               }
           }
?>
        </p>
<?php
    }
}

if (is_readable(TEMPLATEPATH . '/custom-functions.php')) {
	include_once(TEMPLATEPATH . '/custom-functions.php');
}
?>
