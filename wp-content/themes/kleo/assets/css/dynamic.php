<?php

/* ----------------------------------------------------------------
    Element definitions here
-----------------------------------------------------------------*/

global $kleo_config, $kleo_theme;
$style_sets = $kleo_config['style_sets'];

$sections = kleo_style_options();

if(!empty($sections)) {
foreach ($sections as $name => $section) {


//checks if we have a dark or light background and then creates a stronger version of the main font color for headings
$section['heading'] = kleo_calc_similar_color($section['text'], (kleo_calc_perceived_brightness($section['bg'], 100) ? 'lighter' : 'darker'), 3);


//making sure there are no errors
if (! isset( $section['headings'] )) {
    $section['headings'] = $section['heading'];
}

//check if we have a dark or light background and then creates a lighter version of the main font color
$section['lighter'] = kleo_calc_similar_color($section['bg'], (kleo_calc_perceived_brightness($section['bg'], 100) ? 'lighter' : 'darker'), 4);

// Highlight background color in RBG
$section["high_bg_rgb"] = kleo_hex_to_rgb($section['high_bg']);

// Alternate background color in RBG
$section["alternate_bg_rgb"] = kleo_hex_to_rgb($section['alt_bg']);

// Text color in RBG
$section["text_color_rgb"] = kleo_hex_to_rgb($section['text']);

// Background color in RBG
$section["bg_color_rgb"] = kleo_hex_to_rgb($section['bg']);

// Link color in RBG
$section["link_color_rgb"] = kleo_hex_to_rgb($section['link']);

//check if we have a dark or light background and then create a stronger version of the background color
$section['mat-color-bg'] = kleo_calc_similar_color($section['bg'], (kleo_calc_perceived_brightness($section['bg'], 50) ? 'lighter' : 'darker'), 1);

/* Use like this
 *
 * .<?php echo $name; ?>-color .rgb-element {
 *	background-color: rgba(<?php echo $section['high_bg_rgb']['r']; ?>,<?php echo $section['high_bg_rgb']['g']; ?>,<?php echo $section['high_bg_rgb']['b']; ?>,0.4);
 * }
 */
?>


<?php if ( $name == 'main' ) { //only for main-color ?>

#main {
    background-color: <?php echo $section['bg']; ?>;
}
/*** Popover ***/
.popover-content {
    color: <?php echo $section['text']; ?>;
}
.popover-title {
    color: <?php echo $section['high_color']; ?>;
    background-color: <?php echo $section['high_bg']; ?>;
}
/*** Tooltip ***/
.tooltip-inner {
  border-color: <?php echo $section['border']; ?>;
}
.tooltip.top .tooltip-arrow,
.tooltip.top-left .tooltip-arrow,
.tooltip.top-right .tooltip-arrow {
border-top-color: <?php echo $section['border']; ?>;
}
.tooltip.bottom .tooltip-arrow,
.tooltip.bottom-left .tooltip-arrow,
.tooltip.bottom-right .tooltip-arrow {
  border-bottom-color: <?php echo $section['border']; ?>;
}
.tooltip.right .tooltip-arrow {
  border-right-color: <?php echo $section['border']; ?>;
}
.tooltip.left .tooltip-arrow {
  border-left-color: <?php echo $section['border']; ?>;
}

<?php } else if ( $name == 'header' ) { ?>

    .kleo-notifications {
        background-color: <?php echo $section['alt_bg']; ?>;
    }
    .kleo-notifications.new-alert {
        background-color: <?php echo $section['high_bg']; ?>;
        color: <?php echo $section['high_color']; ?>;
    }
    .kleo-notifications-nav ul.submenu-inner li:before {
        color: <?php echo $section['border']; ?>;
    }

    .kleo-main-header .nav > li.active > a {
        box-shadow: inset 0px <?php if ( sq_option('header_layout') == 'center_logo' ) { echo '-'; } ?>2px 0px 0px <?php echo $section['high_bg']; ?>;
    }
    .kleo-main-header .nav > li > a:hover {
        box-shadow: inset 0px <?php if ( sq_option('header_layout') == 'center_logo' ) { echo '-'; } ?>2px 0px 0px <?php echo $section['border']; ?>;
    }
    .header-centered .dropdown > .dropdown-menu.sub-menu {
        box-shadow: 0px -2px 0px 0px <?php echo $section['border']; ?>;
    }
    .kleo-main-header .nav > li.kleo-toggle-menu a,
    .kleo-main-header .nav > li.kleo-search-nav a,
    .kleo-main-header .nav > li.kleo-toggle-menu a:hover,
    .kleo-main-header .nav > li.kleo-search-nav a:hover {
        box-shadow: none;
    }

    <?php
    if ( $section['border'] == 'transparent' ) { ?>
        .kleo-main-header.header-scrolled { box-shadow: 0 0 2px 0 rgba(0, 0, 0, 0.22); }
    <?php } ?>

<?php } ?>

<?php
$extra_section_css = apply_filters( 'kleo_dynamic_' . $name , '', $section );
if ( $extra_section_css != '' ) {
    echo $extra_section_css;
}

} /* end foreach section */

echo '.alternate-color .masonry-listing .post-content { background-color: #fff; }';

}
/* Body Background */
echo $kleo_theme->get_bg_css('body_bg', 'body.page-boxed-bg');

/* Sections background */
foreach( $style_sets as $set ) {
	if ( $set == 'header' ) {
		$element = '.' . $set . '-color, .' . $set . '-color .kleo-main-header';
	} else {
		$element = '.' . $set . '-color';
	}
	echo $kleo_theme->get_bg_css( 'st__' . $set . '__bg_image', $element );

    if ( $set == 'main' ) {
        $db_option = sq_option( 'st__' . $set . '__bg_image' );

        if ( isset( $db_option['background-image'] ) && $db_option['background-image'] != '' ) {
            echo '.rounded {color: rgba(0,0,0,0);}';
        }
    }
}

if ( sq_option( 'menu_size', '' ) != '' ) {
  echo '.kleo-main-header .navbar-nav > li > a { font-size: ' . kleo_set_default_unit( sq_option( 'menu_size', '' ) ) . '; }';
}

if ( sq_option( 'boxed_size', '1440' ) != '1440' ) {
    echo '.page-boxed, .kleo-navbar-fixed .page-boxed .kleo-main-header, .kleo-navbar-fixed.navbar-transparent .page-boxed #header { max-width: ' . sq_option( 'boxed_size' ) . 'px; }';
    echo '.navbar-full-width .page-boxed #main, .navbar-full-width .page-boxed #footer, .navbar-full-width .page-boxed #socket { max-width: ' . sq_option( 'boxed_size' ) . 'px; }';

    if ( sq_option( 'boxed_size', '1440' ) == '1024' ) {
        echo '@media (min-width: 1440px) { .page-boxed .container { max-width: 996px;} }';
    }
    elseif ( sq_option( 'boxed_size', '1440' ) == '1200' ) {
        echo '@media (min-width: 1440px) { .page-boxed .container { max-width: 1170px;} }';
    }
}

//title padding
$title_padding = sq_option( 'title_padding' );
echo '.main-title {padding-top: ' . $title_padding['padding-top'] . '; padding-bottom: ' . $title_padding['padding-bottom'] . ';}';

$header_height = sq_option( 'menu_height', 88 );
$header_two_row_height = sq_option( 'menu_two_height', 88 );

if ( sq_option( 'menu_height_scrolled', '' ) != '' ) {
    $header_h_scrolled = sq_option('menu_height_scrolled', '');
} else {
    $header_h_scrolled = $header_height / 2;
}

if ( sq_option( 'menu_two_height_scrolled', '' ) != '' ) {
    $header_two_row_h_scrolled = sq_option('menu_two_height_scrolled', '');
} else {
    $header_two_row_h_scrolled = $header_two_row_height / 2;
}

$two_row_total = (int)$header_height + (int)$header_two_row_height;

//header height
echo '.kleo-main-header:not(.header-left):not(.header-centered) .navbar-collapse > ul > li > a { line-height: ' . $header_height . 'px;}';
echo '.kleo-main-header.header-left .navbar-collapse > ul > li > a, .kleo-main-header.header-centered .navbar-collapse > ul > li > a { line-height: ' . $header_two_row_height . 'px;}';

echo '.navbar-header { height: ' . $header_height . 'px; line-height: ' . $header_height . 'px;}';

echo '@media screen and (min-width: 991px) {';
echo '.kleo-main-header .navbar-collapse > ul > li.has-btn-see-through { height: ' . $header_height . 'px;}';
echo '.kleo-main-header.header-left .navbar-collapse > ul > li.has-btn-see-through, .kleo-main-header.header-centered .navbar-collapse > ul > li.has-btn-see-through {height: ' . $header_two_row_height . 'px;}';
echo '}';

echo '#header .sticky-wrapper { height: ' . $header_height . 'px;}';
echo '.header-two-rows #header .sticky-wrapper { height: ' . $two_row_total . 'px !important;}';
echo '@media (max-width: 991px) {.header-two-rows #header .sticky-wrapper { height: auto !important;} }';

echo '.header-banner { line-height: ' . $header_height . 'px;}';
echo '.header-banner { display: inline-block; vertical-align: middle; float:right;}';
echo '@media (min-width: 991px) {.header-banner {height: ' . $header_height . 'px;}}';


/* only at page load - not to mess with item menus overlapping */
echo '@media screen and (min-width: 991px) {';
echo '.header-overflow .kleo-main-header:not(.header-left):not(.header-centered) .navbar-collapse { height: ' . $header_height . 'px !important;}';
echo '.header-overflow .kleo-main-header.header-scrolled:not(.header-left):not(.header-centered) .navbar-collapse { height: ' . $header_h_scrolled . 'px !important;}';
echo '.header-overflow .kleo-main-header.header-left .navbar-collapse, .header-overflow .kleo-main-header.header-centered .navbar-collapse { height: ' . $header_two_row_height . 'px !important;}';
echo '.header-overflow .kleo-main-header.header-left.header-scrolled .navbar-collapse, .header-overflow .kleo-main-header.header-centered.header-scrolled .navbar-collapse { height: ' . $header_two_row_h_scrolled . 'px !important;}';
echo '}';


//here you can apply other styles
$extra_output = apply_filters( 'kleo_add_dynamic_style', '' );
echo $extra_output;
