<?php
/* 12-20-13 update of NBBJ edits to v1.03 by jquackenbush for v1.10 */
$options = get_option('dirtysuds_export_options');

/* if ($options['outputFormat'])
	$outputFormat       = $options['outputFormat'];
else */
	$outputFormat       = '<ANSI-WIN>';

if ($options['outputFormat']=='<ANSI-MAC>')
	$newLine            = "\x0a";
else
	$newLine            = "<0x000D>"; // original: "\x0d\x0a";
// Spotlight and Profiles category (ID = 8130 live, 7832 dev)
$spotlightCat = 8130;
// NBBJ: add NBBJ InDesign styles for Business Register items based on which WordPress category is used
	$postparastyle = 'Body text'; 
		$definePostParaStyle = '<DefineParaStyle:'.$postparastyle.'=<cSize:9><cLeading:10.5><pFirstLineIndent:9><cFont:Palatino LT Std><pTextAlignment:JustifyLeft>>'; // 120605 removed Nextstyle bc import error
	$posth3style = 'body text SUBHEAD'; 
		$defineH3style = '<DefineParaStyle:'.$posth3style.'=<cSize:11><cLeading:10.5><pFirstLineIndent:0><cFont:Helvetica LT Std><cTypeface:Compressed><cTracking:50><cCase:All Caps><pTextAlignment:Center>>';
	$posth4style = 'body text SUB-SUBHEAD';
		$defineH4style = '<DefineParaStyle:'.$posth4style.'=<cSize:10.5><cLeading:10.5><pFirstLineIndent:0><cFont:Helvetica LT Std><cTypeface:Bold><cTracking:50><cCase:Normal><pTextAlignment:Left>>';
	$posth5style = 'body text SUB-SUB-SUBHEAD';
		$defineH5style = '<DefineParaStyle:'.$posth5style.'=<cSize:10><cLeading:10.5><pFirstLineIndent:0><cFont:Helvetica LT Std><cTypeface:Bold><cTracking:50><cCase:Normal><pTextAlignment:Left>>';
	$posth6style = 'body text SUB-SUB-SUB-SUBHEAD';
		$defineH6style = '<DefineParaStyle:'.$posth6style.'=<cSize:9.5><cLeading:10.5><pFirstLineIndent:0><cFont:Helvetica LT Std><cTypeface:Bold><cTracking:50><cCase:Normal><pTextAlignment:Left>>';
	$bylinestyle = 'BYLINE';
		$defineBylineStyle = '<DefineParaStyle:'.$bylinestyle.'=<cSize:9><cLeading:10.5><pFirstLineIndent:0><cFont:Palatino LT Std><cCase:Small Caps><pTextAlignment:Center>>'; // 120605 removed Nextstyle bc import error
	$captionstyle = 'Caption';
		$defineCaptionStyle = '<DefineParaStyle:'.$captionstyle.'=<cSize:8><cLeading:9><pFirstLineIndent:0><cFont:Helvetica LT Std><cTracking:-5><pTextAlignment:Left><pRuleBelowColor:Black><pRuleBelowOn:1><pRuleBelowOffset:4><pRuleBelowTint:100><pRuleBelowMode:Column><pRuleBelowStroke:.25>>'; // 120605 removed Nextstyle bc import error if next is same style not already defined
	$pullquotestyle = 'Pull Quote'; // 120803
		$definePullquoteStyle = '<DefineParaStyle:'.$pullquotestyle.'=<cSize:16.74><cLeading:20.46><pFirstLineIndent:0><cFont:Palatino LT Std><cTypeface:Italic><cTracking:-15><pTextAlignment:Left>>'; // 120803
	$mainheadlinestyle = 'Headline Times';
		$defineMainHeadlineStyle = '<DefineParaStyle:'.$mainheadlinestyle.'=<cSize:36><cLeading:36><pFirstLineIndent:0><cFont:Times LT Std><cTypeface:Bold><cTracking:-25><pTextAlignment:Left>>';
	$decksubheadstyle = '3 line subhead';
		$defineDeckSubheadStyle = '<DefineParaStyle:'.$decksubheadstyle.'=<cSize:17><cLeading:16.2><pFirstLineIndent:0><cFont:Times LT Std><cTypeface:Bold><pTextAlignment:Center>>';	
	// Upcoming Events calendar category ID = 39
	$nbbjcalendarbody = 'BR\_Calendar\:Calendar body text';
		$defineCalendarBodyStyle = '<DefineParaStyle:'.$nbbjcalendarbody.'=<cFont:Helvetica LT Std><cSize:8><cLeading:9.5><cTracking:-10><pLeftIndent:9><pFirstLineIndent:-9><pTextAlignment:Left>>';
	$nbbjcalendarcategory = 'BR\_Calendar\:Calender Categories \(centerd\)';
		$defineCalendarCategoryStyle = '<DefineParaStyle:'.$nbbjcalendarcategory.'=<cFont:Helvetica LT Std><cSize:9><cLeading:9.5><cTypeface:Bold><cTracking:-10><pTextAlignment:Center>>';
	$nbbjcalendarevent = 'BR\_Calendar\:CAL Event';
		$defineCalendarEventStyle = '<DefineParaStyle:'.$nbbjcalendarevent.'=<pSpaceBefore:9.5><cTypeface:Bold><cFont:Helvetica LT Std><cSize:8><cLeading:9.5><cTracking:-10><pLeftIndent:9><pFirstLineIndent:-9><pTextAlignment:Left>>'; // 120605 added 9.5pt space before, removed BasedOn bc import error <BasedOn:'.$nbbjcalendarbody.'>
	// People News category ID = 6728
	$peoplebody = 'BR\_People\:People body text';
		$definePeopleBodyStyle = '<DefineParaStyle:'.$peoplebody.'=<cFont:Palatino LT Std><cSize:9><cLeading:10.5><cTracking:-10><pTextAlignment:JustifyLeft><pFirstLineIndent:9><pKeepFirstNLines:1><pKeepLastNLines:1>>';
	$peoplecategory = 'BR\_People\:People category';
		$definePeopleCategoryStyle = '<DefineParaStyle:'.$peoplecategory.'=<cFont:Palatino LT Std><cSize:9><cLeading:10.5><cTracking:-10><pTextAlignment:Center><pFirstLineIndent:0><pKeepFirstNLines:1><pKeepLastNLines:1>>'; // 120605 TextAlignment:Center, pFirstLine:0; removed BasedOn bc import error <BasedOn:'.$peoplebody.'>
	$peoplecaptions = 'People caption';
		$definePeopleCaptionsStyle = '<DefineParaStyle:'.$peoplecaptions.'=<cFont:Helvetica LT Std><cSize:7><cLeading:8><cTracking:-5><pTextAlignment:Center><pFirstLineIndent:9><pKeepFirstNLines:1><pRuleBelowColor:Black><pRuleBelowOn:1><pRuleBelowOffset:1.44>
<pRuleBelowTint:100><pRuleBelowMode:Column><pRuleBelowStroke:.25>>';
	// Business News category ID = 6722
	$biznewsbody = 'BR\_News\:News body text';
		$defineBizNewsBodyStyle = '<DefineParaStyle:'.$biznewsbody.'=<cSize:8><cLeading:9><pFirstLineIndent:9><cFont:Helvetica LT Std><pTextAlignment:JustifyLeft><cTracking:-10>>';
	$biznewscategory = 'BR\_News\:News category title';
		$defineBizNewsCategoryStyle = '<DefineParaStyle:'.$biznewscategory.'=<BasedOn:'.$nbbjcalendarcategory.'>>';
	// Leases category ID = 6721
	$leasesbody = 'BR\_Leases - Sales - FBN\:Leases body text';
		$defineLeasesBodyStyle = '<DefineParaStyle:'.$leasesbody.'=<BasedOn:'.$nbbjcalendarbody.'>>';
	$leasesheading = 'BR\_Leases - Sales - FBN\:Leases CITIES categories'; // 120605 define LEASES and SALES headings same as county headings
		$defineLeasesHeadingStyle = '<DefineParaStyle:'.$leasescategory.'=<cFont:Helvetica LT Std><cSize:9><cLeading:9.5><cTracking:-10><cTypeface:Bold><pTextAlignment:Center>>'; // 120605 updated to add center alignment, define LEASES and SALES headings same as county headings
	// Business Digest category ID = 6731
	$bizdigesthead = 'BDigest heads';
		$defineBizDigestHead = '<DefineParaStyle:'.$bizdigesthead.'=<cFont:Helvetica LT Std><cTypeface:Compressed><cSize:16><cLeading:16><cTracking:50><pTextAlignment:JustifyLeft><pKeepFirstNLines:1><pKeepLastNLines:1><pMinLetterspace:-0.05>>';
	$nbbjtablerow = 'Table Row';
		$defineNBBJtablerow = '<DefineParaStyle:'.$nbbjtablerow.'=<cSize:9><cLeading:10><pFirstLineIndent:0><cFont:Helvetica LT Std><cTypeface:Compressed>>';

if (in_category(39) && in_category(14)) {
	$postparastyle = $nbbjcalendarbody;
	$definePostParaStyle = $defineCalendarBodyStyle;
	$posth3style = $nbbjcalendarcategory; 
	$defineH3style = $defineCalendarCategoryStyle;
	$defineH1style = $defineCalendarCategoryStyle; // 120605 added H1 and H2 traps in case of misapp of headings
	$defineH2style = $defineCalendarCategoryStyle; // 120605 added H1 and H2 traps in case of misapp of headings
	$posth4style = $nbbjcalendarevent; 
	$defineH4style = $defineCalendarEventStyle;
}
elseif (in_category(6722)) { 
	$definePostParaStyle = $defineBizNewsBodyStyle;
	$postparastyle = $biznewsbody;
	$posth3style = $biznewscategory;
	$defineH3style = $defineBizNewsCategoryStyle;
	}
elseif (in_category(6731)) {
	$posth3style = $bizdigesthead;
	$defineH3style = $defineBizDigestHead;
	}
elseif (in_category(6721)) { 
	$postparastyle = $leasesbody;
	$definePostParaStyle = $defineLeasesBodyStyle;
	$posth3style = $leasesheading; // 120605 define LEASES and SALES headings same as county headings
	$defineH3style = $defineLeasesHeadingStyle; // 120605 define LEASES and SALES headings same as county headings
	$posth4style = $leasesheading; // 120605 define LEASES and SALES headings same as county headings
	$defineH4style = $defineLeasesHeadingStyle; // 120605 define LEASES and SALES headings same as county headings
	}
elseif (in_category(28) && in_category(14)) { 
	$postparastyle = $peoplebody;
	$definePostParaStyle = $definePeopleBodyStyle;
	$posth3style = $peoplecategory;
	$defineH3style = $definePeopleCategoryStyle;
	$defineH4style = $definePeopleCategoryStyle; // 120605 added H1, H2, H4 traps in case of misapp of headings
	$defineH2style = $definePeopleCategoryStyle; // 120605 added H1, H2, H4 traps in case of misapp of headings
	$defineH1style = $definePeopleCategoryStyle; // 120605 added H1, H2, H4 traps in case of misapp of headings
	$captionsstyle = $peoplecaptions;
	$defineCaptionStyle = $definePeopleCaptionsStyle;
	}
// 120629 NBBJ new styles for Spotlight and Profiles category (ID = 8130 live, 7832 dev)
elseif (in_category($spotlightCat)) {
	$decksubheadstyle = 'SPOTLIGHT\:SPOT\_category';
		$defineDeckSubheadStyle = '<DefineParaStyle:'.$decksubheadstyle.'=<cSize:8><cLeading:12><pSpaceBefore:10.5><pFirstLineIndent:0><cTracking:125><cHorizontal Scale:0.9><cCase:All Caps><cUnderline:1><cFont:Helvetica LT Std><cTypeface:Plain><pTextAlignment:Left>>';
	$mainheadlinestyle = 'SPOTLIGHT\:SPOT\_name-12 pt Hel Blk';
		$defineMainHeadlineStyle = '<DefineParaStyle:'.$mainheadlinestyle.'=<cSize:12><cLeading:10.5><pFirstLineIndent:0><cFont:Helvetica LT Std><cTypeface:Black><pTextAlignment:Left><cTracking:-10>>';
		$defineMainHeadlineStyleNoDeck = '<DefineParaStyle:'.$mainheadlinestyle.'=<pSpaceBefore:10.5><cSize:12><cLeading:10.5><pFirstLineIndent:0><cFont:Helvetica LT Std><cTypeface:Black><pTextAlignment:Left><cTracking:-10>>';
	$postparastyle = 'SPOTLIGHT\:SPOT\_body - 9pt pal'; 
		$definePostParaStyle = '<DefineParaStyle:'.$postparastyle.'=<cSize:9><cLeading:10.5><pFirstLineIndent:9><cFont:Palatino LT Std><pTextAlignment:JustifyLeft><cTracking:-10>>';
	// if it's a people-focused spotlight, with People category applied, ID = 28
	if (in_category(28)){
		$posth3style = 'SPOTLIGHT\:SPOT\_title';
			$defineH3style = '<DefineParaStyle:'.$posth3style.'=<cSize:8><cLeading:9.5><pFirstLineIndent:0><cFont:Helvetica LT Std><cTypeface:Plain><pTextAlignment:Left><cTracking:-10>>';
		$posth4style = 'SPOTLIGHT\:SPOT\_co name - 8pt Hel Blk';
			$defineH4style = '<DefineParaStyle:'.$posth4style.'=<cSize:8><cLeading:9.5><pFirstLineIndent:0><cFont:Helvetica LT Std><cTypeface:Black><pTextAlignment:Left><cTracking:-10>>';
		$posth5style = 'SPOTLIGHT\:SPOT\_address\/city,zip,phone,web - 8pt pal';
			$defineH5style = '<DefineParaStyle:'.$posth5style.'=<cSize:8><cLeading:9.5><pFirstLineIndent:0><cFont:Palatino LT Std><cTypeface:Italic><pTextAlignment:Left><cTracking:-10>>';	
	}
	// if it's a company-oriented spotlight, with no People category applied
	else {
		$posth3style = 'SPOTLIGHT\:SPOT\_address\/city,zip,phone,web - 8pt pal';
			$defineH3style = '<DefineParaStyle:'.$posth3style.'=<cSize:8><cLeading:9.5><pFirstLineIndent:0><cFont:Palatino LT Std><cTypeface:Italic><pTextAlignment:Left><cTracking:-10>>';	
	}	
}

	$defineStyles = $definePostParaStyle.$defineH3style.$defineH4style.$defineH5style.$defineH6style.$defineBylineStyle.$defineCaptionStyle.$defineMainHeadlineStyle.$defineDeckSubheadStyle.$definePullquoteStyle.$defineNBBJtablerow.$newLine;
	
	$allowed_taggedtext_tags = array(
		'p'      => array(
			'style'	=> array(
				'text-align' => array() // NBBJ 131216
			)  // NBBJ
		),
		'br'     => array(),
		'b'      => array(),
		'strong' => array(),
		'i'      => array(),
		'em'     => array(),
		'u'      => array(),
		'del'    => array(),
		'li'     => array(),
		'ul'     => array(),
		'ol'     => array(),
// 120515		'span'   => array(),
		'sub'    => array(),
		'sup'    => array(),
		'h1'     => array(),
		'h2'     => array(),
		'h3'     => array(),
		'h4'     => array(),
		'h5'     => array(),
		'h6'     => array(),
		'blockquote' => array(),
		'td'	=> array(), // NBBJ
		'tr'	=> array() // NBBJ
	);
	
	$conversion_table = array(
		"\n"		=>'', // NBBJ 120523 softbreak with soft return
		"\r"        =>'',
		"\f"        =>'',
		'&nbsp;'    =>' ',
		"<pre>"     =>$newLine.'<ParaStyle:'.$postparastyle.'>', // NBBJ
		"</pre>"    =>$newLine,
		'<p>'       =>$newLine.'<ParaStyle:'.$postparastyle.'>', // NBBJ
		'<p style=<0x0022>text-align: center<0x0022>>'		=>$newLine.'<pTextAlignment:Center>', // NBBJ
		'<p style=<0x0022>text-align: right<0x0022>>'		=>$newLine.'<pTextAlignment:Right>', // NBBJ 120530 right flush
		'</p>'		=>'',
		'<br />'	=>'<0x000A>', // NBBJ 120523
		'<b>'       =>'<cTypeface:Bold>',
		'<strong>'  =>'<cTypeface:Bold>',
		'<i>'       =>'<cTypeface:Italic>',
		'<em>'      =>'<cTypeface:Italic>',
		'</b>'      =>'<cTypeface:>',
		'</strong>' =>'<cTypeface:>',
		'</i>'      =>'<cTypeface:>',
		'</em>'     =>'<cTypeface:>',
		'<u>'       =>'<cUnderline:1>',
		'</u>'      =>'<cUnderline:>',
		'<del>'     =>'<cStrikethru:1>',
		'</del>'    =>'<cStrikethru:>',
		'<sub>'     =>'<cPosition:Subscript>',
		'</sub>'    =>'<cPosition:>',
		'<sup>'     =>'<cPosition:Superscript>',
		'</sup>'    =>'<cPosition:>',
		'<h1>'      =>$newLine.'<ParaStyle:'.$posth3style.'>', // NBBJ
		'<h2>'      =>$newLine.'<ParaStyle:'.$posth3style.'>', // NBBJ
		'<h3>'      =>$newLine.'<ParaStyle:'.$posth3style.'>', // NBBJ
		'<h4>'      =>$newLine.'<ParaStyle:'.$posth4style.'>', // NBBJ
		'<h5>'      =>$newLine.'<ParaStyle:'.$posth5style.'>', // NBBJ
		'<h6>'      =>$newLine.'<ParaStyle:'.$posth6style.'>', // NBBJ
		'</h1>'     =>'',
		'</h2>'     =>'',
		'</h3>'     =>'',
		'</h4>'     =>'',
		'</h5>'     =>'',
		'</h6>'     =>'',
		'<blockquote>'  =>'<ParaStyle:'.$postparastyle.'>', // NBBJ
		'</blockquote>' =>'',
		'<ul>'		=>'', // NBBJ 120618
		'</ul>'		=>'', // NBBJ
		'<ol>'		=>'', // NBBJ 120618
		'</ol>'		=>'', // NBBJ
		'<li>'		=>$newLine.'<ParaStyle:'.$postparastyle.'><0x2022> ', // NBBJ 120618
		'</li>'		=>'', // NBBJ 120618 added parabreak because list text run together
		'<tr>'		=>$newLine.'<ParaStyle:'.$nbbjtablerow.'>', // NBBJ 121012
		'</tr>'		=> '', // NBBJ 121012
		'</td>'		=> '<0x0009>', // NBBJ 121012 change table cell closing tag to tab
		'<td>'		=> '' // NBBJ 121012
	);

	$trickyCharacters = array(
		'&Yuml;'   => "\xd9",
		'&oelig;'  => "\x97",
		'&OElig;'  => "\xee",
		'&scaron;' => '<0x0161>',
		'&Scaron;' => '<0x0160>',
		'…'	=> '<0x2026>' // NBBJ 120620 ellipsis
	);

	$html_tags = array(
		'/('.chr(60).'|&(#60|lt);)/', // NBBJ 120530 added pure ASCII code
		'/('.chr(62).'|&(#62|gt);)/', // NBBJ 120530 added pure ASCII code
//		'/&(#38|amp);/', // NBBJ 120702 commented out because eliminating text after an ampersand as in K&C
		'/('.chr(8211).'|&(#8211|ndash);)/', // NBBJ 120517 ndash with ndash
		'/('.chr(8212).'|&(#8212|mdash);)/', // NBBJ 120517 mdash with ndash not mdash
		'/('.chr(8216).'|&(#8216|lsquo);)/', //NBBJ left single quote
		'/('.chr(8217).'|&(#8217|rsquo);)/', //NBBJ right single quote
		'/('.chr(8220).'|&(#8220|ldquo);)/', //NBBJ left double quote
		'/('.chr(8221).'|&(#8221|rdquo);)/', //NBBJ right double quote
		'/&(#8230|hellip);/', // NBBJ 120620 ellipsis; 
		'/[\n\r\f]+/', // NBBJ 120523
		'/&#[xX]([0-9A-Fa-f]{4})\;/e',
		'/&#([0-9]+)\;/e',
//		'/&(#60|lt);/', // NBBJ 120530 commented out, breaks preg_replace?
//		'/&#61;/', // NBBJ 120530 commented out, breaks preg_replace?
//		'/&(#62|gt);/', // NBBJ 120530 commented out, breaks preg_replace?
		'/([\ ]|&nbsp;)+/',
		'/[\t]+[\ \t]*/',
		'/[\n\r\f]+/',
		'/\xc4([\x80-\xff])/e',
		'/\xc5([\x40-\xff])/e',
		'/&([A-Za-z]+)\;/e',
		'/\'<0x\'\.\.\'>\'/', // NBBJ cleanup blank-coded parabreak as '<0x'..'>'
		"/[\ ]{0,3}<\/td>/", // 121012 NBBJ clean up table cell conversion
		'/<\/td><\/tr>/', // NBBJ 121012 clean up table cell conversion
		"/($newLine){2,7}/", // 120618 NBBJ clean up double parabreaks 
		"/<0x000A>$newLine/" // NBBJ 120523 replace softbreak plus parabreak with one parabreak
	);

	$tagged_tags = array(
		'<',
		'>',
//		'&', // NBBJ 120702
		'<0x2013>', // NBBJ 120517
		'<0x2013>', // NBBJ 120517
		'<0x2018>', //NBBJ
		'<0x2019>', //NBBJ
		'<0x201c>', //NBBJ
		'<0x201d>', //NBBJ
		'<0x2026>', // NBBJ 120620 ellipsis
		"'<0x'.$1.'>'",
		"'<0x'.str_pad(dechex($1),4,'0',STR_PAD_LEFT).'>'",
		'', // NBBJ 120530 no need for parabreaks, as conversion_table will add
//		'\\<', // NBBJ 120530
//		' ', // NBBJ 120530
//		'\\>', // NBBJ 120530
		' ',
		chr(9),
		'',
		"'<0x'.str_pad(dechex(ord($1) + 128),4,'0',STR_PAD_LEFT).'>'",
		"'<0x'.str_pad(dechex(ord($1) + 192),4,'0',STR_PAD_LEFT).'>'",
		"'<0x'.str_pad(dechex(ord(html_entity_decode('&'.$1.';'))),4,'0',STR_PAD_LEFT).'>'",
		'', // NBBJ 
		'</td>', // NBBJ 120517
		'', // NBBJ 121012
		$newLine, // NBBJ 120618
		$newLine // NBBJ 120523
	);

function dirtysuds_content_taggedtext(){
	 // NBBJ: Moved arrays out of function to allow them to be called in the other functions. Called arrays as global variables in this function.

	global $cleanup_search,$cleanup_replace, $allowed_taggedtext_tags, $conversion_table, $tagged_tags, $html_tags, $trickyCharacters, $postparastyle, $newLine, $posth3style, $posth4style; // 120618

	remove_all_filters('loop_end');

	$content = get_the_content();
	$content = strip_shortcodes($content);

	// Change double line-breaks in the text into HTML paragraphs
	$content = wpautop($content);

	// Strip all HTML except for $allowed_taggedtext_tags
	$content = wp_kses($content,$allowed_taggedtext_tags);

	// Add Smart Quotes
	$content = wptexturize($content);
	$content = trim($content);

	//Convert special characters to HTML entities
	$content = mb_convert_encoding($content,'UTF-8',get_bloginfo('charset'));
	$content = htmlentities($content, ENT_QUOTES, 'UTF-8', false);
	$content = strtr($content,$trickyCharacters);
	$content = preg_replace($html_tags,$tagged_tags,$content);
	$content = strtr($content,$conversion_table);	
/*
	// Replace Unordered List Items with bullets
	$unorderedLists = explode('<ul>',' '.$content);
	$countUnorderedLists = count($unorderedLists);

	for ($i=1;$i<$countUnorderedLists+1;$i=$i+2) {
		$thislist = explode('</ul>',$unorderedLists[$i]);
		$thislist = $thislist[0];
		$content = strtr(
			$content,
			array(
				'<ul>'.$thislist.'</ul>' =>
				strtr(
					$thislist,
					array(
						'<li>' => "<bnListType:Bullet>",
						'</li>' => "\x0a<bnListType:>",
						"<bnListType:>\x0a<bnListType:Bullet>" => "<bnListType:><bnListType:Bullet>",
					)
				)
			)
		);
	}

	*/
	$content = trim($content);
	return $content;
}

if ( have_posts() ) : while ( have_posts() ) : the_post();
// NBBJ: pull story metadata into variables
$storycaptions = get_post_meta($post->ID, 'story_captions', true);
$storyprintheadline = get_post_meta($post->ID, 'story_print_headline', true); 
$subhead = get_post_meta($post->ID, 'sub_head', true);
$storydeck =  get_post_meta($post->ID, 'story_print_deck', true);
$subhead = $storydeck;
$storypullquote1 = get_post_meta($post->ID, 'story_pullquote_1', true);
$storypullquote2 = get_post_meta($post->ID, 'story_pullquote_2', true);

function nbbj_pullquote_taggedtext(){
// 120803 NBBJ: add 1-2 pullquotes to the top of the story sent to InDesign and allows for HTML styling in story_pullquote_1 and story_pullquote_2
	global $postparastyle, $pullquotestyle, $storypullquote1, $storypullquote2, $allowed_taggedtext_tags, $trickyCharacters, $html_tags, $tagged_tags, $conversion_table, $newLine ;
	if ($storypullquote1) { 
		$storypullquote1 = wptexturize($storypullquote1);
		$storypullquote1 = trim($storypullquote1);
		$storypullquote1 = mb_convert_encoding($storypullquote1,'UTF-8',get_bloginfo('charset'));
		$storypullquote1 = esc_html($storypullquote1);
		$storypullquote1 = htmlentities($storypullquote1, ENT_QUOTES, 'UTF-8', false);
		$storypullquote1 = strtr($storypullquote1,$trickyCharacters);
		$storypullquote1 = preg_replace($html_tags,$tagged_tags,$storypullquote1); // NBBJ 120522
		$storypullquote1 = strtr($storypullquote1,$conversion_table); // NBBJ 120522
		$storypullquote1 = '<ParaStyle:'.$pullquotestyle.'>'.$storypullquote1.$newLine;
	}
		else { $storypullquote1 = ""; }
if ($storypullquote2) { 
		$storypullquote2 = wptexturize($storypullquote2);
		$storypullquote2 = trim($storypullquote2);
		$storypullquote2 = mb_convert_encoding($storypullquote2,'UTF-8',get_bloginfo('charset'));
		$storypullquote2 = esc_html($storypullquote2);
		$storypullquote2 = htmlentities($storypullquote2, ENT_QUOTES, 'UTF-8', false);
		$storypullquote2 = strtr($storypullquote2,$trickyCharacters);
		$storypullquote2 = preg_replace($html_tags,$tagged_tags,$storypullquote2); // NBBJ 120522
		$storypullquote2 = strtr($storypullquote2,$conversion_table); // NBBJ 120522
		$storypullquote2 = '<ParaStyle:'.$pullquotestyle.'>'.$storypullquote2.$newLine;
	}
		else { $storypullquote2 = ""; }
	$storypullquotes = $storypullquote1.$storypullquote2;
	return $storypullquotes;
}

function nbbj_captions_taggedtext(){
// NBBJ: add story captions to the top of the story sent to InDesign and allows for HTML styling in story_captions
	global $postparastyle, $captionstyle, $storycaptions, $allowed_taggedtext_tags, $trickyCharacters, $html_tags, $tagged_tags, $conversion_table, $newLine ;
	if ($storycaptions) { 
		$storycaptions = wpautop($storycaptions);
		$storycaptions = wptexturize($storycaptions); // NBBJ 120522
		$storycaptions = trim($storycaptions); // NBBJ 120522
		$storycaptions = mb_convert_encoding($storycaptions,'UTF-8',get_bloginfo('charset')); // NBBJ 120522
		$storycaptions = esc_html($storycaptions); // NBBJ 120622 WP function to handle amp and quotes
		$storycaptions = htmlentities($storycaptions, ENT_QUOTES, 'UTF-8', false); // NBBJ 120522
		$storycaptions = strtr($storycaptions,$trickyCharacters); // NBBJ 120522
		$conversion_table['<p>'] = $newLine.'<ParaStyle:'.$captionstyle.'>'; // NBBJ 120522 replaces body text with caption style
		$storycaptions = preg_replace($html_tags,$tagged_tags,$storycaptions); // NBBJ 120522
		$storycaptions = strtr($storycaptions,$conversion_table); // NBBJ 120522
		$captioncleanupsearch = array(
								'/^<0x000D><ParaStyle:'.$captionstyle.'>/',
								'/<0x000A><0x000D><ParaStyle:'.$captionstyle.'>/',
								'/(<0x000D>){0}<0x000A>(<0x000D>){0}/'
								); // NBBJ 120522 cleans up extra soft returns
		$captioncleanupreplace = array(
								'',
								'<0x000D><ParaStyle:'.$captionstyle.'>',
								'<0x000D><ParaStyle:'.$captionstyle.'>'
								); // NBBJ 120522
		$storycaptions = preg_replace($captioncleanupsearch,$captioncleanupreplace,$storycaptions); // NBBJ 120522 cleans up extra soft returns
		$storycaptions = '<ParaStyle:'.$captionstyle.'>'.$storycaptions.$newLine;
		$conversion_table['<p>'] = $newLine.'<ParaStyle:'.$postparastyle.'>'; // NBBJ 120523 resets back to body text style
	}
		else { $storycaptions = ""; }
	return $storycaptions;
}

function nbbj_headline_taggedtext(){
// NBBJ: add story print headline to the story
	global $mainheadlinestyle, $storyprintheadline, $trickyCharacters, $html_tags, $tagged_tags, $conversion_table, $newLine;
	if ($storyprintheadline) { 
		$storyprintheadline = wptexturize($storyprintheadline); // NBBJ 120522
		$storyprintheadline = trim($storyprintheadline); // NBBJ 120522
		$storyprintheadline = mb_convert_encoding($storyprintheadline,'UTF-8',get_bloginfo('charset')); // NBBJ 120522
		$storyprintheadline = esc_html($storyprintheadline); // NBBJ 120622 WP function to handle amp and quotes
		$storyprintheadline = htmlentities($storyprintheadline, ENT_QUOTES, 'UTF-8', false); // NBBJ 120522
		$storyprintheadline = strtr($storyprintheadline,$trickyCharacters); // NBBJ 120522
		$storyprintheadline = preg_replace($html_tags,$tagged_tags,$storyprintheadline); // NBBJ 120522
		$storyprintheadline = strtr($storyprintheadline,$conversion_table); // NBBJ 120522
		$storyprintheadline = preg_replace('/(<0x000A>|\n)/',' ',$storyprintheadline); // NBBJ 120522
		$storyprintheadline = "<ParaStyle:$mainheadlinestyle>".$storyprintheadline.$newLine; } 
		else { $storyprintheadline = ""; }
	return $storyprintheadline;
}

function nbbj_subhead_taggedtext(){
// NBBJ: add subhead to the story
	global $decksubheadstyle, $subhead, $trickyCharacters, $html_tags, $tagged_tags, $conversion_table, $newLine;
	if ($subhead) { 
		$subhead = wptexturize($subhead); // NBBJ 120522
		$subhead = trim($subhead); // NBBJ 120522
		$subhead = mb_convert_encoding($subhead,'UTF-8',get_bloginfo('charset')); // NBBJ 120522
		$subhead = esc_html($subhead); // NBBJ 120622 WP function to handle amp and quotes
		$subhead = htmlentities($subhead, ENT_QUOTES, 'UTF-8', false); // NBBJ 120522
		$subhead = strtr($subhead,$trickyCharacters); // NBBJ 120522
		$subhead = preg_replace($html_tags,$tagged_tags,$subhead); // NBBJ 120522
		$subhead = strtr($subhead,$conversion_table); // NBBJ 120522
		$subhead = preg_replace('/(<0x000A>|\n)/',' ',$subhead); // NBBJ 120522
		$subhead = "<ParaStyle:$decksubheadstyle>".$subhead.$newLine; }
		else { $subhead = ""; }
	return $subhead;
}

function nbbj_byline_taggedtext(){
	global $bylinestyle;
	echo "<ParaStyle:" . $bylinestyle .">";
	// CHECK TO SEE IF AUTHOR IS GUEST_AUTHOR AND IF SO, OUTPUT THAT VALUE
	$guest_author = get_post_custom_values("guest_author");
	$nbbjauthor = get_the_author();
	// 120810 push author title to next line with soft return in byline
	$nbbjauthortitle = array(
		", Business Journal" => "<0x000A>Business Journal",
		", Special to the Business Journal" => "<0x000A>Special to the Business Journal",
		", Event Development Manager" => "<0x000A>Event Development Manager"
		);
	$nbbjauthor = strtr($nbbjauthor,$nbbjauthortitle);
	$nbbjauthorID = get_the_author_meta('ID');
	$guest_author['0'] = strtr($guest_author['0'],$nbbjauthortitle);
	if ( $guest_author['0'] ) { echo "By " . $guest_author['0']; } 
	// omit "By" for Business Journal Staff Report and Business Journal Editorial
	elseif(($nbbjauthorID === 10) || ($nbbjauthorID === 17)) { echo $nbbjauthor; }
	else { echo "By " . $nbbjauthor; }
}

// We don't want any optimization plugins mistaking our output for HTML. Let's turn them off.
// 131111 gbuce removed because it was clipping the style definitions at the top of the tagged-text file and not creating the file.
// ob_end_clean(); 

// We don't want the browser to render the file, only download it. Let's call it a binary file
header('Content-type: binary/text; charset=utf-8');

// We need to give the file some sort of name. In this case, the author's last name and the title of the story
// Don't forget to strip the spaces out. This makes it more compatible cross browser
header('Content-Disposition: filename='.get_post_meta($post->ID, 'story_file_slug', true).'.txt;');

// START RENDERING OF TAGGED TEXT FILE
echo $outputFormat; ?>

<Version:5><FeatureSet:InDesign-Roman><ColorTable:=<Black:COLOR:CMYK:Process:0,0,0,1>>
<?php 
echo $defineStyles;
echo nbbj_pullquote_taggedtext(); // 120803
echo nbbj_captions_taggedtext();
// 120807 for Spotlights and Profiles subhead as category above the headline
if (in_category($spotlightCat)) {
	echo nbbj_subhead_taggedtext();
	echo nbbj_headline_taggedtext();
	echo nbbj_byline_taggedtext();
}
// 130708 no byline in Business Register or Amplifications & Corrections
elseif (in_category(14) || in_category(4826)) {
	echo nbbj_headline_taggedtext();
}
// 130708 all other types of stories
else {
	echo nbbj_headline_taggedtext();
	echo nbbj_subhead_taggedtext();
	echo nbbj_byline_taggedtext();
}
/*	?><ParaStyle:<?php echo $bylinestyle; ?>><?php
					// CHECK TO SEE IF AUTHOR IS GUEST_AUTHOR AND IF SO, OUTPUT THAT VALUE
					// omit "By" for Business Journal Staff Report and Business Journal Editorial
					// 120810 push author title to next line with soft return in byline
					$guest_author = get_post_custom_values("guest_author");
					$nbbjauthor = get_the_author();
					$nbbjauthortitle = array(
						", Business Journal" => "<0x000A>Business Journal",
						", Special to the Business Journal" => "<0x000A>Special to the Business Journal",
						", Event Development Manager" => "<0x000A>Event Development Manager"
					);
					$nbbjauthor = strtr($nbbjauthor,$nbbjauthortitle);
					$nbbjauthorID = get_the_author_meta('ID');
					$guest_author['0'] = strtr($guest_author['0'],$nbbjauthortitle);
					if ( $guest_author['0'] ) { ?>By <?php echo $guest_author['0']; } 
						elseif(($nbbjauthorID === 10) || ($nbbjauthorID === 17)) { echo $nbbjauthor; }
						else { ?>By <?php echo $nbbjauthor; } */
echo dirtysuds_content_taggedtext();
endwhile;
endif;
exit();