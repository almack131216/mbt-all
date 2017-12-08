<?php
/**
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

/**
 * Kleo Child Theme Functions
 * Add custom code below
*/

global $amCustStringPrefixTitleTag;
global $amCustStringPrefixTitleCategory;
global $amCustIconSearch;

$amCustStringPrefixTitleTag = 'Tagged: ';
$amCustStringPrefixTitleCategory = '';
$amCustIconSearch = 'icon-search fa-lg fa-bold';//(was: icon icon-search)

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

define('WP_SCSS_ALWAYS_RECOMPILE', true);

function avia_fix_breadcrumb_trail($trail)
{
	foreach($trail as $key => $data)
	{
		if(strpos($data, 'Auto Draft') !== false) unset($trail[$key]);
	}
	return $trail;
}
add_filter('avia_breadcrumbs_trail','avia_fix_breadcrumb_trail');

function member_only_shortcode($atts, $content = null)
{
    if (is_user_logged_in() && !is_null($content) && !is_feed()) {
        return $content;
    }
}
add_shortcode('member_only', 'member_only_shortcode');

function visitor_only_shortcode($atts, $content = null)
{
    if (!is_user_logged_in() && !is_null($content) && !is_feed()) {
        return $content;
    }
}
add_shortcode('visitor_only', 'visitor_only_shortcode');

        
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array(  ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css' );

// END ENQUEUE PARENT ACTION

//https://codex.wordpress.org/Function_Reference/wp_dequeue_style
function remove_excess_css(){
	wp_dequeue_style( 'kleo-fonts' );
}
add_action( 'remove_excess_css', 'wp_67472455', 100 );

add_filter( 'style_loader_src', function($href){
	if(strpos($href, "//fonts.googleapis.com/css?family=Roboto") === false) {
		return $href;
	}
	return false;
});

//ref: https://davidwalsh.name/remove-wordpress-admin-bar-css
add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}


// Load quickfixes child theme stylesheet
function theme_styles_quickfixes()  
{ 
	// Load quickfixes stylesheet
	// this is required for emergency style changes done online
	// these changes shall be implemented into .scss files when streamlining
	wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/style-quickfixes.css' );
}
add_action('wp_enqueue_scripts', 'theme_styles_quickfixes');