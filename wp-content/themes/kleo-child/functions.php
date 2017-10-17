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

$amCustStringPrefixTitleTag = 'Tagged: ';
$amCustStringPrefixTitleCategory = '';

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