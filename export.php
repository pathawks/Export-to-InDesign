<?php
/*
Plugin Name: DirtySuds - Export to InDesign
Plugin URI: https://fundry.com/project/165-export-to-indesign
Description: Export a post as Adobe TaggedText for import to InDesign
Author: Dirty Suds
Version: 1.10
Author URI: http://blog.dirtysuds.com

Updates:
1.10 - Better support for non-English characters
1.03 - Indent Text
1.02 - Faster. Now removes shortcodes
1.01 - Better support for special characters
1.00.20110222 - First Version

  Copyright 2011 Pat Hawks  (email : pat@pathawks.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Define the custom box */
add_action('admin_init', 'dirtysuds_export_html_box', 1);
add_action('single_template', 'dirtysuds_export_html');

/* Adds a box to the main column on the Post and Page edit screens */
function dirtysuds_export_html_box() {
    add_meta_box( 'dirtysuds_export_html', 'Export Post', 'dirtysuds_export_html_box_inner', 'post', 'side','high' );
}

/* Prints the box content */
function dirtysuds_export_html_box_inner($post, $metabox) {

	echo '<a class="button" style="float:right;margin-top:-3px" target="_blank" href="'.get_permalink($post->ID).'?export=print'.'">Print</a>';
	echo '<a class="button" href="'.get_permalink($post->ID).'?export=taggedtext'.'">Export to InDesign</a> ';
}

function dirtysuds_export_html($single_template) {
if (strpos(' '.$_SERVER['QUERY_STRING'],'export=taggedtext')) {
ob_end_clean();
return dirname( __FILE__ ) .'/taggedtext.php';
} else if (strpos(' '.$_SERVER['QUERY_STRING'],'export=print')) {
ob_end_clean();
return dirname( __FILE__ ) .'/print.php';
} else {
return $single_template;
}
}

function dirtysuds_export_html_rate($links,$file) {
		if (plugin_basename(__FILE__) == $file) {
			$links[] = '<a href="http://wordpress.org/extend/plugins/dirty-suds-export-to-indesign/">Rate this plugin</a>';
		}
	return $links;
}