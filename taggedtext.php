<?php

function dirtysuds_content_taggedtext(){

	$listTag = chr(165).' ';
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
		'/([\n\r\f]*<p>|<br[\s\/]*>[\s\t\n\r\f]+)/',
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
		'/(&#(8230|x2026);|'.chr(226).chr(128).chr(166).')/',
		'/&(#8211|ndash);/',
		'/&(#8212|mdash);/',
		'/(&(#8220|ldquo);|'.chr(226).chr(128).chr(156).')/',
		'/(&(#8221|rdquo);|'.chr(226).chr(128).chr(157).')/',
		'/&(#8216|lsquo);/',
		'/(&(#8217|rsquo);|'.chr(226).chr(128).chr(153).')/',
		'/&(#160|nbsp);/',
		'/(&[#a-z0-9]+;|'.chr(226).chr(128).'.)/'
	);
	
	$tagged_tags = array(
		PHP_EOL.'<pstyle:NormalParagraphStyle>'.chr(9),
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
		chr(164),
		chr(165),
		chr(166),
		chr(168),
		chr(169),
		chr(201),
		chr(208),
		chr(209),
		chr(210),
		chr(211),
		chr(212),
		chr(213),
		' ',
		''
	);
	$content = '';
	$content = get_the_content();
	$content = wpautop($content);
	$content = wp_kses($content,$allowed_taggedtext_tags);
	$content = wptexturize($content);
	$content = str_replace(chr(194).chr(160),' ',$content);
	$content = preg_replace('/[\n\r\f]+/',PHP_EOL,$content);
	$content = preg_replace($html_tags,$tagged_tags,$content);
	$content = str_replace('<pstyle:NormalParagraphStyle>'.chr(9).PHP_EOL,'',$content);
	
	while (strpos($content,'  ')>1) {
		$content = str_replace('  ',' ',$content);
	}

	while (strpos($content,PHP_EOL.PHP_EOL)>1) {
		$content = str_replace(PHP_EOL.PHP_EOL,PHP_EOL,$content);
	}
	
	
	$content = str_replace(chr(9).' ',chr(9),$content);
	$content = str_replace(' '.PHP_EOL,PHP_EOL,$content);
		
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