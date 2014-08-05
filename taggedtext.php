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
		"\r"            => $newLine,
		"\f"            => $newLine,
		"<br />"        => $newLine,
		"<pre>"         => $newLine.'<ParaStyle:'.$NormalParagraphStyle.'>'.
		                     '<cFont:Andale Mono>',
		"</pre>"        => '<cFont:>'.$newLine,
		'<p>'           => $newLine.'<ParaStyle:'.$NormalParagraphStyle.'>',
		'</p>'          => '',
		'<b>'           => '<cTypeface:Bold>',
		'<strong>'      => '<cTypeface:Bold>',
		'<i>'           => '<cTypeface:Italic>',
		'<em>'          => '<cTypeface:Italic>',
		'</b>'          => '<cTypeface:>',
		'</strong>'     => '<cTypeface:>',
		'</i>'          => '<cTypeface:>',
		'</em>'         => '<cTypeface:>',
		'<u>'           => '<cUnderline:1>',
		'</u>'          => '<cUnderline:>',
		'<del>'         => '<cStrikethru:1>',
		'</del>'        => '<cStrikethru:>',
		'<sub>'         => '<cPosition:Subscript>',
		'</sub>'        => '<cPosition:>',
		'<sup>'         => '<cPosition:Superscript>',
		'</sup>'        => '<cPosition:>',
		'<h1>'          => $newLine.'<ParaStyle:><cTypeface:Bold><cSize:48>',
		'<h2>'          => $newLine.'<ParaStyle:><cSize:36>',
		'<h3>'          => $newLine.'<ParaStyle:><cTypeface:Bold><cSize:18>',
		'<h4>'          => $newLine.'<ParaStyle:><cTypeface:Bold>',
		'<h5>'          => $newLine.'<ParaStyle:><cTypeface:Bold Italic>',
		'<h6>'          => $newLine.'<ParaStyle:><cTypeface:Italic>',
		'</h1>'         => '<cTypeface:><cSize:>'.$newLine,
		'</h2>'         => '<cSize:>'.$newLine,
		'</h3>'         => '<cTypeface:><cSize:>'.$newLine,
		'</h4>'         => '<cTypeface:>'.$newLine,
		'</h5>'         => '<cTypeface:>'.$newLine,
		'</h6>'         => '<cTypeface:>'.$newLine,
		'<blockquote>'  => '<ParaStyle:'.$NormalParagraphStyle.'>'.
		                   '<pLeftIndent:12><pSpaceBefore:6><pSpaceAfter:6>',
		'</blockquote>' => $newLine.'<pLeftIndent:><pSpaceBefore:><pSpaceAfter:>',
		'<0x0026>'      => '<0xFFFD>',

		/* Some day, we will have a better system for handeling lists */
		'<li>'          => '<0x2022> ',
		'</li>'         => '',
		'<ul>'          => '',
		'</ul>'         => '',
		'<ol>'          => '',
		'</ol>'         => '',
	);

/*************
* HTML Named Entities are the suck! We need to kill them. Kill them with fire!
* There MUST be a better solution to all of this
*************/
	$trickyCharacters = array(
		'&amp;'      => '&',
		'&sup1;'     => '<sup>1</sup>',
		'&sup2;'     => '<sup>2</sup>',
		'&sup3;'     => '<sup>3</sup>',
		'&oelig;'    => '<0x0097>',
		'&nbsp;'     => '<0x00A0>',
		'&iexcl;'    => '<0x00A1>',
		'&cent;'     => '<0x00A2>',
		'&pound;'    => '<0x00A3>',
		'&curren;'   => '<0x00A4>',
		'&yen;'      => '<0x00A5>',
		'&brvbar;'   => '<0x00A6>',
		'&sect;'     => '<0x00A7>',
		'&uml;'      => '<0x00A8>',
		'&copy;'     => '<0x00A9>',
		'&ordf;'     => '<0x00AA>',
		'&laquo;'    => '<0x00AB>',
		'&not;'      => '<0x00AC>',
		'&shy;'      => '<0x00AD>',
		'&reg;'      => '<0x00AE>',
		'&macr;'     => '<0x00AF>',
		'&deg;'      => '<0x00B0>',
		'&plusmn;'   => '<0x00B1>',
		'&acute;'    => '<0x00B4>',
		'&micro;'    => '<0x00B5>',
		'&para;'     => '<0x00B6>',
		'&middot;'   => '<0x00B7>',
		'&cedil;'    => '<0x00B8>',
		'&ordm;'     => '<0x00BA>',
		'&raquo;'    => '<0x00BB>',
		'&frac14;'   => '<0x00BC>',
		'&frac12;'   => '<0x00BD>',
		'&frac34;'   => '<0x00BE>',
		'&iquest;'   => '<0x00BF>',
		'&Agrave;'   => '<0x00C0>',
		'&Aacute;'   => '<0x00C1>',
		'&Acirc;'    => '<0x00C2>',
		'&Atilde;'   => '<0x00C3>',
		'&Auml;'     => '<0x00C4>',
		'&Aring;'    => '<0x00C5>',
		'&AElig;'    => '<0x00C6>',
		'&Ccedil;'   => '<0x00C7>',
		'&Egrave;'   => '<0x00C8>',
		'&Eacute;'   => '<0x00C9>',
		'&Ecirc;'    => '<0x00CA>',
		'&Euml;'     => '<0x00CB>',
		'&Igrave;'   => '<0x00CC>',
		'&Iacute;'   => '<0x00CD>',
		'&Icirc;'    => '<0x00CE>',
		'&Iuml;'     => '<0x00CF>',
		'&ETH;'      => '<0x00D0>',
		'&Ntilde;'   => '<0x00D1>',
		'&Ograve;'   => '<0x00D2>',
		'&Oacute;'   => '<0x00D3>',
		'&Ocirc;'    => '<0x00D4>',
		'&Otilde;'   => '<0x00D5>',
		'&Ouml;'     => '<0x00D6>',
		'&times;'    => '<0x00D7>',
		'&Oslash;'   => '<0x00D8>',
		'&Ugrave;'   => '<0x00D9>',
		'&Yuml;'     => '<0x00D9>',
		'&Uacute;'   => '<0x00DA>',
		'&Ucirc;'    => '<0x00DB>',
		'&Uuml;'     => '<0x00DC>',
		'&Yacute;'   => '<0x00DD>',
		'&THORN;'    => '<0x00DE>',
		'&szlig;'    => '<0x00DF>',
		'&agrave;'   => '<0x00E0>',
		'&aacute;'   => '<0x00E1>',
		'&acirc;'    => '<0x00E2>',
		'&atilde;'   => '<0x00E3>',
		'&auml;'     => '<0x00E4>',
		'&aring;'    => '<0x00E5>',
		'&aelig;'    => '<0x00E6>',
		'&ccedil;'   => '<0x00E7>',
		'&egrave;'   => '<0x00E8>',
		'&eacute;'   => '<0x00E9>',
		'&ecirc;'    => '<0x00EA>',
		'&euml;'     => '<0x00EB>',
		'&igrave;'   => '<0x00EC>',
		'&iacute;'   => '<0x00ED>',
		'&icirc;'    => '<0x00EE>',
		'&OElig;'    => '<0x00EE>',
		'&iuml;'     => '<0x00EF>',
		'&eth;'      => '<0x00F0>',
		'&ntilde;'   => '<0x00F1>',
		'&ograve;'   => '<0x00F2>',
		'&oacute;'   => '<0x00F3>',
		'&ocirc;'    => '<0x00F4>',
		'&otilde;'   => '<0x00F5>',
		'&ouml;'     => '<0x00F6>',
		'&divide;'   => '<0x00F7>',
		'&oslash;'   => '<0x00F8>',
		'&ugrave;'   => '<0x00F9>',
		'&uacute;'   => '<0x00FA>',
		'&ucirc;'    => '<0x00FB>',
		'&uuml;'     => '<0x00FC>',
		'&yacute;'   => '<0x00FD>',
		'&thorn;'    => '<0x00FE>',
		'&yuml;'     => '<0x00FF>',
		'&Scaron;'   => '<0x0160>',
		'&scaron;'   => '<0x0161>',
		'&fnof;'     => '<0x0192>',
		'&circ;'     => '<0x02C6>',
		'&tilde;'    => '<0x02DC>',
		'&Alpha;'    => '<0x0391>',
		'&Beta;'     => '<0x0392>',
		'&Gamma;'    => '<0x0393>',
		'&Delta;'    => '<0x0394>',
		'&Epsilon;'  => '<0x0395>',
		'&Zeta;'     => '<0x0396>',
		'&Eta;'      => '<0x0397>',
		'&Theta;'    => '<0x0398>',
		'&Iota;'     => '<0x0399>',
		'&Kappa;'    => '<0x039A>',
		'&Lambda;'   => '<0x039B>',
		'&Mu;'       => '<0x039C>',
		'&Nu;'       => '<0x039D>',
		'&Xi;'       => '<0x039E>',
		'&Omicron;'  => '<0x039F>',
		'&Pi;'       => '<0x03A0>',
		'&Rho;'      => '<0x03A1>',
		'&Sigma;'    => '<0x03A3>',
		'&Tau;'      => '<0x03A4>',
		'&Upsilon;'  => '<0x03A5>',
		'&Phi;'      => '<0x03A6>',
		'&Chi;'      => '<0x03A7>',
		'&Psi;'      => '<0x03A8>',
		'&Omega;'    => '<0x03A9>',
		'&alpha;'    => '<0x03B1>',
		'&beta;'     => '<0x03B2>',
		'&gamma;'    => '<0x03B3>',
		'&delta;'    => '<0x03B4>',
		'&epsilon;'  => '<0x03B5>',
		'&zeta;'     => '<0x03B6>',
		'&eta;'      => '<0x03B7>',
		'&theta;'    => '<0x03B8>',
		'&iota;'     => '<0x03B9>',
		'&kappa;'    => '<0x03BA>',
		'&lambda;'   => '<0x03BB>',
		'&mu;'       => '<0x03BC>',
		'&nu;'       => '<0x03BD>',
		'&xi;'       => '<0x03BE>',
		'&omicron;'  => '<0x03BF>',
		'&pi;'       => '<0x03C0>',
		'&rho;'      => '<0x03C1>',
		'&sigmaf;'   => '<0x03C2>',
		'&sigma;'    => '<0x03C3>',
		'&tau;'      => '<0x03C4>',
		'&upsilon;'  => '<0x03C5>',
		'&phi;'      => '<0x03C6>',
		'&chi;'      => '<0x03C7>',
		'&psi;'      => '<0x03C8>',
		'&omega;'    => '<0x03C9>',
		'&thetasym;' => '<0x03D1>',
		'&upsih;'    => '<0x03D2>',
		'&piv;'      => '<0x03D6>',
		'&ensp;'     => '<0x2002>',
		'&emsp;'     => '<0x2003>',
		'&thinsp;'   => '<0x2009>',
		'&zwnj;'     => '<0x200C>',
		'&zwj;'      => '<0x200D>',
		'&lrm;'      => '<0x200E>',
		'&rlm;'      => '<0x200F>',
		'&ndash;'    => '<0x2013>',
		'&mdash;'    => '<0x2014>',
		'&lsquo;'    => '<0x2018>',
		'&rsquo;'    => '<0x2019>',
		'&sbquo;'    => '<0x201A>',
		'&ldquo;'    => '<0x201C>',
		'&rdquo;'    => '<0x201D>',
		'&bdquo;'    => '<0x201E>',
		'&dagger;'   => '<0x2020>',
		'&Dagger;'   => '<0x2021>',
		'&bull;'     => '<0x2022>',
		'&hellip;'   => '<0x2026>',
		'&permil;'   => '<0x2030>',
		'&prime;'    => '<0x2032>',
		'&Prime;'    => '<0x2033>',
		'&lsaquo;'   => '<0x2039>',
		'&rsaquo;'   => '<0x203A>',
		'&oline;'    => '<0x203E>',
		'&frasl;'    => '<0x2044>',
		'&euro;'     => '<0x20AC>',
		'&image;'    => '<0x2111>',
		'&weierp;'   => '<0x2118>',
		'&real;'     => '<0x211C>',
		'&trade;'    => '<0x2122>',
		'&alefsym;'  => '<0x2135>',
		'&larr;'     => '<0x2190>',
		'&uarr;'     => '<0x2191>',
		'&rarr;'     => '<0x2192>',
		'&darr;'     => '<0x2193>',
		'&harr;'     => '<0x2194>',
		'&crarr;'    => '<0x21B5>',
		'&lArr;'     => '<0x21D0>',
		'&uArr;'     => '<0x21D1>',
		'&rArr;'     => '<0x21D2>',
		'&dArr;'     => '<0x21D3>',
		'&hArr;'     => '<0x21D4>',
		'&forall;'   => '<0x2200>',
		'&part;'     => '<0x2202>',
		'&exist;'    => '<0x2203>',
		'&empty;'    => '<0x2205>',
		'&nabla;'    => '<0x2207>',
		'&isin;'     => '<0x2208>',
		'&notin;'    => '<0x2209>',
		'&ni;'       => '<0x220B>',
		'&prod;'     => '<0x220F>',
		'&sum;'      => '<0x2211>',
		'&minus;'    => '<0x2212>',
		'&lowast;'   => '<0x2217>',
		'&radic;'    => '<0x221A>',
		'&prop;'     => '<0x221D>',
		'&infin;'    => '<0x221E>',
		'&ang;'      => '<0x2220>',
		'&and;'      => '<0x2227>',
		'&or;'       => '<0x2228>',
		'&cap;'      => '<0x2229>',
		'&cup;'      => '<0x222A>',
		'&int;'      => '<0x222B>',
		'&there4;'   => '<0x2234>',
		'&sim;'      => '<0x223C>',
		'&cong;'     => '<0x2245>',
		'&asymp;'    => '<0x2248>',
		'&ne;'       => '<0x2260>',
		'&equiv;'    => '<0x2261>',
		'&le;'       => '<0x2264>',
		'&ge;'       => '<0x2265>',
		'&sub;'      => '<0x2282>',
		'&sup;'      => '<0x2283>',
		'&nsub;'     => '<0x2284>',
		'&sube;'     => '<0x2286>',
		'&supe;'     => '<0x2287>',
		'&oplus;'    => '<0x2295>',
		'&otimes;'   => '<0x2297>',
		'&perp;'     => '<0x22A5>',
		'&sdot;'     => '<0x22C5>',
		'&lceil;'    => '<0x2308>',
		'&rceil;'    => '<0x2309>',
		'&lfloor;'   => '<0x230A>',
		'&rfloor;'   => '<0x230B>',
		'&lang;'     => '<0x2329>',
		'&rang;'     => '<0x232A>',
		'&loz;'      => '<0x25CA>',
		'&spades;'   => '<0x2660>',
		'&clubs;'    => '<0x2663>',
		'&hearts;'   => '<0x2665>',
		'&diams;'    => '<0x2666>',
	);

	$html_tags = array(
		'/&(#60|lt);/',
		'/&(#62|gt);/',
		'/&#(#62);/',
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
		"'<0x'.str_pad(dechex(ord($1) +  128),4,'0',STR_PAD_LEFT).'>'",
		"'<0x'.str_pad(dechex(ord($1) +  192),4,'0',STR_PAD_LEFT).'>'",
		"'<0x'.str_pad(dechex(ord(html_entity_decode('&'.$1.';')),4,'0',STR_PAD_LEFT).'>'",
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
