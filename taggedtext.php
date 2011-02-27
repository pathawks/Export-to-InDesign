<?php

function dirtysuds_content_taggedtext(){

	$listTag = '<0x2022> ';
	$listEnd = '';

	$allowed_taggedtext_tags = array(
		'p' => array(),
		'br' => array(),
		'b' => array(),
		'strong' => array(),
		'i' => array(),
		'em' => array(),
		'li' => array(),
		'span' => array()
	);
	
	$html_tags = array(
		'/&(#60|lt);/',
		'/&(#62|gt);/',
		'/&#61;/',
		'/'.chr(194).chr(160).'/',
		'/[\n\r\f]+/',
		'/&#[xX]([0-9]{4})\;/',
		'/([\n\r\f]*<p>|<br[\s\/]*>[\s\t\n\r\f]+|[\s\t]*[\n\r\f]+[\s\t]*)/',
		'/(<br>|<br \/>)/',
		'/(<b>|<strong>)/',
		'/(<i>|<em>)/',
		'/<li>/',
		'/<\/li>/',
		'/<[\/]*(span|p)>/',
		'/<\/[^\>]+>/',
		'/&(#60|lt);/',
		'/&#61;/',
		'/&(#62|gt);/',
		'/&(#167|sect);/',
		'/&(#183|middot);/',
		'/&(#182|para);/',
		'/&(#174|reg);/',
		'/&(#169|copy);/',
		'/(&#(8230);|'.chr(226).chr(128).chr(166).')/',
		'/&(#8211|ndash);/',
		'/&(#8212|mdash);/',
		'/(&(#8220|ldquo);|'.chr(226).chr(128).chr(156).')/',
		'/(&(#8221|rdquo);|'.chr(226).chr(128).chr(157).')/',
		'/&(#8216|lsquo);/',
		'/(&(#8217|rsquo);|'.chr(226).chr(128).chr(153).')/',
		'/&(#160|nbsp);/',
		'/&(#176|deg);/',
		'/&(#8482|trade);/',
		'/&#(8209);/',
		'/[\ ]+/',
		'/[\t]+[\ \t]*/',
		'/[\n\r\f]+/',
		'/(&[#a-z0-9]+;|'.chr(226).chr(128).'.|<pstyle:NormalParagraphStyle>\t[\n\r\f]+|<pstyle:NormalParagraphStyle>\t$)/',
		'/\^<{0}/',
	);
	
	$tagged_tags = array(
		'<',
		'>',
		'&',
		' ',
		chr(10),
		'<0x$1>',
		chr(10).'<pstyle:NormalParagraphStyle>'.chr(9),
		'<0x000A>',
		'<ct:Bold>',
		'<ct:Italic>',
		$listTag,
		$listEnd,
		'',
		'<ct:>',
		'\\<',
		chr(97),
		'\\>',
		'<0x00A7>',
		'<0x2022>',
		'<0x00B6>',
		'<0x00AE>',
		'<0x00A9>',
		'<0x2026>',
		'<0x2013>',
		'<0x2014>',
		'<0x201C>',
		'<0x201D>',
		'<0x2018>',
		'<0x2019>',
		'<0x00A0>',
		'<0x00B0>',
		'<0x2122>',
		'<0x2011>',
		' ',
		chr(9),
		chr(10),
		'',
		chr(10).'<pstyle:NormalParagraphStyle>'.chr(9).'$1',
	);
	$content = '';
	$content = get_the_content();
	$content = strip_shortcodes($content);
	$content = wpautop($content);
	$content = wp_kses($content,$allowed_taggedtext_tags);
	$content = wptexturize($content);
	$content = htmlentities($content, ENT_QUOTES, get_bloginfo('charset'), false);
	$content = preg_replace($html_tags,$tagged_tags,$content);
	return $content;
}

if (have_posts()): while (have_posts()): the_post();

// We don't want any optimization plugins mistaking our output for HTML. Let's turn them off.
ob_end_clean();

// We don't want the browser to render the file, only download it. Let's call it a binary file
header('Content-type: binary/text; charset=utf-8');

// We need to give the file some sort of name. In this case, the author's last name and the title of the story
// Don't forget to strip the spaces out. This makes it more compatible cross browser
header('Content-Disposition: filename='.preg_replace("/[^a-zA-Z\-_]/", "",get_the_author_lastname().'-'.str_replace(' ','_',get_the_title())).'.txt;');


?><ANSI-MAC>
<vsn:7><fset:InDesign-Roman><ctable:=<Black:COLOR:CMYK:Process:0,0,0,1>>
<dps:NormalParagraphStyle=<Nextstyle:NormalParagraphStyle><cs:10.000000><cl:11.000000><ptr:18\,Left\,.\,0\,\;><cf:Times New Roman>><?php
echo dirtysuds_content_taggedtext();
endwhile; endif;
exit();