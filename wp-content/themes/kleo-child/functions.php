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

// amcust 171209: disable this because child stylesheet is loaded elsewhere, via child configurator        
// if ( !function_exists( 'child_theme_configurator_css' ) ):
//     function child_theme_configurator_css() {
//         wp_enqueue_style( 'chld_thm_cfg_child', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css', array(  ) );
//     }
// endif;
// add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css' );


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
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'remove_admin_login_header');

// Load quickfixes child theme stylesheet
function theme_styles_quickfixes()  
{ 
	// Load quickfixes stylesheet
	// this is required for emergency style changes done online
	// these changes shall be implemented into .scss files when streamlining
	wp_enqueue_style( 'custom', get_stylesheet_directory_uri() . '/style-quickfixes.css' );
}
add_action('wp_enqueue_scripts', 'theme_styles_quickfixes');

// Streamline: remove excess remove excess styles
//Dequeue Styles
//ref: https://wordpress.stackexchange.com/questions/189985/how-to-properly-dequeue-scripts-and-styles-in-child-theme
function project_dequeue_unnecessary_styles() {

	wp_dequeue_style( 'bootstrap-map' );
        wp_deregister_style( 'bootstrap-map' );

	// wp_dequeue_style( 'kleo-style' );
    //     wp_deregister_style( 'kleo-style' );

	// wp_dequeue_style( 'kleo-combined' );
    //     wp_deregister_style( 'kleo-combined' );

	// wp_dequeue_style( 'kleo-colors' );
    //     wp_deregister_style( 'kleo-colors' );

	wp_dequeue_style( 'jetpack_css' );
        wp_deregister_style( 'jetpack_css' );

	wp_dequeue_style( 'jetpack_likes' );
        wp_deregister_style( 'jetpack_likes' );

	wp_dequeue_style( 'dashicons' );
        wp_deregister_style( 'dashicons' );
}
add_action( 'wp_print_styles', 'project_dequeue_unnecessary_styles' );

function sq7r_app_css_child_app() {
    wp_deregister_style( 'kleo-app' );
    wp_dequeue_style( 'kleo-app' );
    wp_enqueue_style('kleo-app', get_stylesheet_directory_uri() . '/assets/css/app.css');
}
add_action('wp_enqueue_scripts', 'sq7r_app_css_child_app');

function sq7r_app_css_child_combined() {
	wp_deregister_style( 'kleo-combined' );
    wp_dequeue_style( 'kleo-combined' );
    wp_enqueue_style('kleo-combined', get_stylesheet_directory_uri() . '/assets/css/combined.css');
}
add_action('wp_enqueue_scripts', 'sq7r_app_css_child_combined');

// function my_wp_nav_menu_args( $args = '' ) { 
// 	if( is_user_logged_in() ) { 
// 		$args['menu'] = 'mm-logged-in';
// 	} else { 
// 		$args['menu'] = 'mm-logged-out';
// 	} 
//     return $args;
// }
// add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );

//Dequeue JavaScripts
// function project_dequeue_unnecessary_scripts() {
//     wp_dequeue_script( 'modernizr-js' );
//         wp_deregister_script( 'modernizr-js' );
//     wp_dequeue_script( 'project-js' );
//         wp_deregister_script( 'project-js' );
// }
// add_action( 'wp_print_scripts', 'project_dequeue_unnecessary_scripts' );