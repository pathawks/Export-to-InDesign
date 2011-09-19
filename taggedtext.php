<?php

function dirtysuds_content_taggedtext(){

	$NormalParagraphStyle = 'NormalParagraphStyle';

	$allowed_taggedtext_tags = array(
		'p' => array(),
		'br' => array(),
		'b' => array(),
		'strong' => array(),
		'i' => array(),
		'em' => array(),
		'li' => array(),
		'ul' => array(),
		'ol' => array(),
		'span' => array()
	);

	$html_tags = array(
		'/&(#60|lt);/',
		'/&(#62|gt);/',
		'/&#61;/',
		'/[\n\r\f]+/',
		'/&#[xX]([0-9]{4})\;/',
		'/&#([0-9]+)\;/e',
		'/([\n\r\f]*<p>|<br[\s\/]*>[\s\t\n\r\f]+|[\s\t]*[\n\r\f]+[\s\t]*)/',
		'/<[\/\s]*br[\/\s]*>/',
		'/(<b>|<strong>)/',
		'/(<i>|<em>)/',
		'/<li>/',
		'/<\/li>/',
		'/<[\/]*(\!|span|p|a)>/',
		'/<\/[^\>]+>/',
		'/&(#60|lt);/',
		'/&#61;/',
		'/&(#62|gt);/',
		'/([\ ]|&nbsp;)+/',
		'/[\t]+[\ \t]*/',
		'/[\n\r\f]+/',
		'/\xc4([\x81-\xff])/e',
		'/\xc5([\x41-\xff])/e',
	);

	$tagged_tags = array(
		'<',
		'>',
		'&',
		chr(10),
		'<0x$1>',
		"'<0x'.str_pad(dechex($1),4,'0',STR_PAD_LEFT).'>'",
		"\x0a<pstyle:$NormalParagraphStyle>",
		'<0x000A>',
		'<ct:Bold>',
		'<ct:Italic>',
		'<bnlt:Bullet>',
		'<bnlt:>',
		'',
		'<ct:>',
		'\\<',
		chr(97),
		'\\>',
		' ',
		chr(9),
		chr(10),
		"'<0x'.str_pad(dechex(ord($1) + 128),4,'0',STR_PAD_LEFT).'>'",
		"'<0x'.str_pad(dechex(ord($1) + 192),4,'0',STR_PAD_LEFT).'>'",
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

	$content = preg_replace($html_tags,$tagged_tags,$content);
	
	// Replace Unordered List Items with bullets
	$countUnorderedLists = preg_match_all('/(<ul>(.+)<\/ul>)/i',$content,$UnorderedLists);
	for ($i=0;$i<$countUnorderedLists;$i++) {
		
		echo "\n\n",implode('',$UnorderedLists[0]),"\n\n";
		
		$content = strtr(
			$content,
			array(
				implode('',$UnorderedLists[0]) =>
				strtr(
					$UnorderedLists[$i-1][2],
					array(
						'<li>' => "\x0a<pstyle:$NormalParagraphStyle><bnlt:Bullet>",
						'</li>' => "\x0a<bnlt:><pstyle:NormalParagraphStyle>",
						"<pstyle:$NormalParagraphStyle>\x0a<pstyle:$NormalParagraphStyle>" => "\x0a<pstyle:$NormalParagraphStyle>",
					)
				)
			)
		);
	}

	$countHtmlNamedEntities = preg_match_all("/\&[a-zA-Z]+;/",$content,$htmlNamedEntities);

	for ($i=0;$i<$countHtmlNamedEntities;$i++)
		$content = strtr(
			$content,
			array(
				$htmlNamedEntities[0][$i] =>
				'<0x'.str_pad(dechex(ord(html_entity_decode($htmlNamedEntities[0][$i]))),4,'0',STR_PAD_LEFT).'>',
			)
		);

// Some characters did not transcode well
// We will replace them with blocks, so it is obvious that characters are missing

	$content = strtr(
		$content,
		array(
		'<0x00ff>' => '<0x2588>',
		'<0x0026>' => '<0x2588>',
		)
	);

	$content = trim($content);
	return $content;
}

while ( have_posts() ) : the_post();

// We don't want any optimization plugins mistaking our output for HTML. Let's turn them off.
ob_end_clean();

// We don't want the browser to render the file, only download it. Let's call it a binary file
header('Content-type: binary/text; charset=utf-8');

// We need to give the file some sort of name. In this case, the author's last name and the title of the story
// Don't forget to strip the spaces out. This makes it more compatible cross browser

header('Content-Disposition: filename='.preg_replace("/[^a-zA-Z0-9\-_]/", "",get_the_author_lastname().'-'.str_replace(' ','_',basename(get_permalink()))).'.txt;');


?><ANSI-MAC>
<vsn:7.5><fset:InDesign-Roman><ctable:=>
<dps:<?php echo $NormalParagraphStyle;?>=<Nextstyle:<?php echo $NormalParagraphStyle;?>><cc:Registration><cs:10><cl:11><pfli:12><cf:Times New Roman><pbl:1><cotfcalt:0>>
<?php
echo dirtysuds_content_taggedtext();
endwhile;
exit();