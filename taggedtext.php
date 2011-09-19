<?php

$options = get_option('dirtysuds_export_options');

if ($options['outputFormat'])
	$outputFormat       = $options['outputFormat'];
else
	$outputFormat       = '<ANSI-MAC>';

if ($options['outputFormat']=='<ANSI-MAC>')
	$newLine            = "\x0a";
else
	$newLine            = "\x0d\x0a";

$NormalParagraphStyle = 'NormalParagraphStyle';
$defineStyles =
'<DefineParaStyle:'.
$NormalParagraphStyle.
'=<Nextstyle:'.$NormalParagraphStyle.'>'.
'<cColor:Registration><cSize:10><cLeading:11>'.
'<pFirstLineIndent:12><cFont:Times New Roman>'.
'>';

function dirtysuds_content_taggedtext(){

	global $NormalParagraphStyle,$newLine;

	$allowed_taggedtext_tags = array(
		'p'      => array(),
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
		'span'   => array(),
		'sub'    => array(),
		'sup'    => array(),
		'h1'     => array(),
		'h2'     => array(),
		'h3'     => array(),
		'h4'     => array(),
		'h5'     => array(),
		'h6'     => array(),
		'blockquote' => array(),
	);
	
	$conversion_table = array(
		"\r"            =>$newLine,
		"\f"            =>$newLine,
		'&nbsp;'        =>' ',
		"<pre>"         =>$newLine.'<ParaStyle:'.$NormalParagraphStyle.'>'.
		                  '<cFont:Andale Mono>',
		"</pre>"        =>'<cFont:>'.$newLine,
		'<p>'           =>$newLine.'<ParaStyle:'.$NormalParagraphStyle.'>',
		'</p>'          =>'',
		'<b>'           =>'<cTypeface:Bold>',
		'<strong>'      =>'<cTypeface:Bold>',
		'<i>'           =>'<cTypeface:Italic>',
		'<em>'          =>'<cTypeface:Italic>',
		'</b>'          =>'<cTypeface:>',
		'</strong>'     =>'<cTypeface:>',
		'</i>'          =>'<cTypeface:>',
		'</em>'         =>'<cTypeface:>',
		'<u>'           =>'<cUnderline:1>',
		'</u>'          =>'<cUnderline:>',
		'<del>'         =>'<cStrikethru:1>',
		'</del>'        =>'<cStrikethru:>',
		'<sub>'         =>'<cPosition:Subscript>',
		'</sub>'        =>'<cPosition:>',
		'<sup>'         =>'<cPosition:Superscript>',
		'</sup>'        =>'<cPosition:>',
		'<h1>'          =>$newLine.'<ParaStyle:><cTypeface:Bold><cSize:48>',
		'<h2>'          =>$newLine.'<ParaStyle:><cSize:36>',
		'<h3>'          =>$newLine.'<ParaStyle:><cTypeface:Bold><cSize:18>',
		'<h4>'          =>$newLine.'<ParaStyle:><cTypeface:Bold>',
		'<h5>'          =>$newLine.'<ParaStyle:><cTypeface:Bold Italic>',
		'<h6>'          =>$newLine.'<ParaStyle:><cTypeface:Italic>',
		'</h1>'         =>'<cTypeface:><cSize:>'.$newLine,
		'</h2>'         =>'<cSize:>'.$newLine,
		'</h3>'         =>'<cTypeface:><cSize:>'.$newLine,
		'</h4>'         =>'<cTypeface:>'.$newLine,
		'</h5>'         =>'<cTypeface:>'.$newLine,
		'</h6>'         =>'<cTypeface:>'.$newLine,
		'<blockquote>'  =>'<ParaStyle:'.$NormalParagraphStyle.'>'.
		                  '<pLeftIndent:12><pSpaceBefore:6><pSpaceAfter:6>',
		'</blockquote>' =>$newLine.'<pLeftIndent:><pSpaceBefore:><pSpaceAfter:>',
	);

	$trickyCharacters = array(
		'&Yuml;'   => "\xd9",
		'&oelig;'  => "\x97",
		'&OElig;'  => "\xee",
		'&scaron;' => '<0x0161>',
		'&Scaron;' => '<0x0160>',
	);

	$html_tags = array(
		'/&(#60|lt);/',
		'/&(#62|gt);/',
		'/&#61;/',
		'/[\n\r\f]+/',
		'/&#[xX]([0-9A-Fa-f]{4})\;/e',
		'/&#([0-9]+)\;/e',
		'/([\n\r\f]*<p>|<br[\s\/]*>[\s\t\n\r\f]+|[\s\t]*[\n\r\f]+[\s\t]*)/',
		'/&(#60|lt);/',
		'/&#61;/',
		'/&(#62|gt);/',
		'/([\ ]|&nbsp;)+/',
		'/[\t]+[\ \t]*/',
		'/[\n\r\f]+/',
		'/\xc4([\x80-\xff])/e',
		'/\xc5([\x40-\xff])/e',
		'/&([A-Za-z]+)\;/e',
	);

	$tagged_tags = array(
		'<',
		'>',
		'&',
		$newLine,
		"'<0x'.$1.'>'",
		"'<0x'.str_pad(dechex($1),4,'0',STR_PAD_LEFT).'>'",
		"<p>",
		'\\<',
		' ',
		'\\>',
		' ',
		chr(9),
		$newLine,
		"'<0x'.str_pad(dechex(ord($1) + 128),4,'0',STR_PAD_LEFT).'>'",
		"'<0x'.str_pad(dechex(ord($1) + 192),4,'0',STR_PAD_LEFT).'>'",
		"'<0x'.str_pad(dechex(ord(html_entity_decode('&'.$1.';'))),4,'0',STR_PAD_LEFT).'>'",
	);

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

// We don't want any optimization plugins mistaking our output for HTML. Let's turn them off.
ob_end_clean();
the_post();

// We don't want the browser to render the file, only download it. Let's call it a binary file
header('Content-type: binary/text; charset=utf-8');

// We need to give the file some sort of name. In this case, the author's last name and the title of the story
// Don't forget to strip the spaces out. This makes it more compatible cross browser

header('Content-Disposition: filename='.preg_replace("/[^a-zA-Z0-9\-_]/", "",get_the_author_lastname().'-'.str_replace(' ','_',basename(get_permalink()))).'.txt;');

echo
	$outputFormat.$newLine.
	$defineStyles.$newLine.
	dirtysuds_content_taggedtext();

exit();