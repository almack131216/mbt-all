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

/*
// removed in favor of Nav User Roles plugin
function my_wp_nav_menu_args( $args = '' ) {
	empty($args['menu']);
	if( is_user_logged_in() ) { 
		$args['menu'] = 'mm-logged-in';
	} else { 
		$args['menu'] = 'mm-logged-out';
	} 
    return $args;
}
add_filter( 'wp_nav_menu_args', 'my_wp_nav_menu_args' );
*/