=== Export to InDesign ===
Contributors: pathawks, jquackenbush, Kawauso
Donate link: https://github.com/DirtySuds/Export-to-InDesign
Tags: export, post, indesign, print
Requires at least: 3.1
Tested up to: 3.9.1
Stable tag: 1.2.0

Export a WordPress post as Adobe TaggedText for import to InDesign

== Description ==

Make WordPress the center of your digital newsroom. Allow reporters to print stories or export to InDesign, right inside the post editor.


== Installation ==

1. Upload `dirty-suds-export-to-indesign` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In the post editor, find the **Export Post** metabox in the right sidebar. Click **Export to InDesign** to download  the story as a TaggedText file
4. Place the story into an InDesign document

== Frequently Asked Questions ==

= Some characters are missing =

This is an infrequent, but known issue.
Support for non-English characters and special characters has improved over past versions, but is still not 100%. If the plugin finds a character is does not recognize, it will be replaced with a box, making it easy to fix manually in InDesign.
If you come across this, please email the TaggedText file and a link to the live post on your site to plugins@dirtysuds.com


= Something is broken, or I have a great idea. =

Please create an issue on the [GitHub page](https://github.com/pathawks/Export-to-InDesign/issues).
Creating a pull request with a fix is an even better option.


== Screenshots ==

1. Metabox in post editor with "Export to InDesign" button


== Changelog ==

= 1.11 =
* Merged some changes from North Bay Business Journal

= 1.10 =
* Improved support for non-English characters

= 1.03 =
* Fixed issue with Print Function

= 1.02 =
* More improvement for special characters
* Removes shortcodes

= 1.01 =
* Significant improvement to the way special characters are handled
* Almost any character should be supported now

= 1.00 =
* First version

== Upgrade Notice ==

= 1.11 =
Merged some changes from North Bay Business Journal

= 1.10 =
Improved support for non-English characters. Upgrading is strongly recommended.

= 1.03 =
Fixed issue with Print function

= 1.02 =
Removes shortcakes before processing. Faster

= 1.01 =
Better support for special characters
