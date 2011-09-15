<?php

function dirtysuds_content_taggedtext(){

// Business News category ID = 6722
$biznewsbody = 'BR\_News\:News body text';
$biznewscategory = 'BR\_News\:News category title';
// Business Digest category ID = 6731
$bizdigesthead = 'BDigest heads';
// Leases category ID = 6721
$leasesbody = 'BR\_Leases - Sales - FBN\:Leases body text';
$leasescategory = 'BR\_Leases - Sales - FBN\:Leases CITIES categories';
// People News category ID = 28. Combine with Business Register category ID = 14.
$peoplebody = 'BR\_People\:People body text';
$peoplecategory = 'BR\_People\:People category';
// Upcoming Events calendar category ID = 39. Combine with Business Register category ID = 14.
$nbbjcalendarbody = 'BR\_Calendar\:Calendar body text';
$nbbjcalendarcategory = 'BR\_Calendar\:Calender Categories \(centerd\)';
$nbbjcalendarevent = 'BR\_Calendar\:CAL Event';
if (in_category(6722)) { $postparastyle = $biznewsbody; $posth3style = $biznewscategory; }
elseif (in_category(6731)) { $postparastyle = 'Body text'; $posth3style = $bizdigesthead; }
elseif (in_category(6721)) { $postparastyle = $leasesbody; $posth3style = $leasescategory; $posth4style = $leasescategory; }
elseif (in_category(28) && in_category(14)) { $postparastyle = $peoplebody; $posth3style = $peoplecategory; }
elseif (in_category(39) && in_category(14)) {$postparastyle = $nbbjcalendarbody; $posth3style = $nbbjcalendarcategory; $posth4style = $nbbjcalendarevent; }
else { $postparastyle = 'Body text'; $posth3style = '3 line subhead'; $posth4style = '3 line subhead'; }

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
'span' => array(),
'h3' => array(),
'h4' => array(),
'td' => array()
);

$html_tags = array(
'/&(#60|lt);/',
'/&(#62|gt);/',
'/<td>/',
'/<\/td>/',
'/&(#61|amp);/',
'/'.chr(194).chr(160).'/',
'/[\n\r\f]+/',
'/[xX]([0-9]{4})\;/',
'/<h3>/',
'/<\/h3>/',
'/<h4>/',
'/<\/h4>/',
'/<p style='.chr(34).'text-align\: center;'.chr(34).'>/',
'/([\n\r\f]*<p>|<br[\s\/]*>[\s\t\n\r\f]+|[\s\t]*[\n\r\f]+[\s\t]*)/',
'/(<br>|<br \/>)/',
'/(<b>|<strong>)/',
'/(<i>|<em>)/',
'/<li>/',
'/<\/li>/',
'/<[\/]*(span|p)>/',
'/<\/[^\>]+>/',
'/&(#60|lt);/',
'/=/',
'/&(#62|gt);/',
'/&(#167|sect);/',
'/&(#183|middot);/',
'/&(#182|para);/',
'/&(#174|reg);/',
'/&(#169|copy);/',
'/((8230);|'.chr(226).chr(128).chr(166).')/',
'/&(#8211|ndash);/',
'/&(#8212|mdash);/',
'/(&(#8220|ldquo);|'.chr(226).chr(128).chr(156).')/',
'/(&(#8221|rdquo);|'.chr(226).chr(128).chr(157).')/',
'/&(#8216|lsquo);/',
'/(&(#8217|rsquo);|'.chr(226).chr(128).chr(153).')/',
'/&(#160|nbsp);/',
'/&(#176|deg);/',
'/&(#8482|trade);/',
'/(8209);/',
'/(&(#223|eacute);|'.chr(130).')/',
'/(&(#241|ntilde);|'.chr(164).')/',
'/[\ ]+/',
'/[\t]+[\ \t]*/',
'/[\n\r\f]+/',
'/(&[#a-z0-9]+;|'.chr(226).chr(128).'.|<ParaStyle:'.$postparastyle.'>\t[\n\r\f]+|<ParaStyle:'.$postparastyle.'>\t$)/',
'/\^<{0}/',
);

$tagged_tags = array(
'<',
'>',
'',
'<0x0009>',
'&',
' ',
chr(10),
'<0x$1>',
'<0x000D>'.'<ParaStyle:'.$posth3style.'>',
'',
'<0x000D>'.'<ParaStyle:'.$posth4style.'>',
'',
'<0x000D>'.'<pTextAlignment:Center>',
'<0x000D>'.'<ParaStyle:'.$postparastyle.'>',
'<0x000A>',
'<cTypeface:Bold>',
'<cTypeface:Italic>',
$listTag,
$listEnd,
'',
'<cTypeface:>',
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
'<0x2013>',
'<0x201C>',
'<0x201D>',
'<0x2018>',
'<0x2019>',
'<0x00A0>',
'<0x00B0>',
'<0x2122>',
'<0x2011>',
'é',
'ñ',
' ',
chr(9),
chr(10),
'',
'<0x000D>'.'<ParaStyle:'.$postparastyle.'>'.'$1',
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

if ( have_posts() ) : while ( have_posts() ) : the_post();

// We don't want any optimization plugins mistaking our output for HTML. Let's turn them off.
ob_end_clean();

// We don't want the browser to render the file, only download it. Let's call it a binary file
header('Content-type: binary/text; charset=utf-8');

// We need to give the file some sort of name. In this case, the author's last name and the title of the story
// Don't forget to strip the spaces out. This makes it more compatible cross browser
header('Content-Disposition: filename='.get_post_meta($post->ID, 'story_file_slug', true).'.txt;');


?><ANSI-WIN>
<Version:5><FeatureSet:InDesign-Roman><ColorTable:=<Black:COLOR:CMYK:Process:0,0,0,1>>
<?php $storycaptions = get_post_meta($post->ID, 'story_captions', true); if ($storycaptions) { echo "<ParaStyle:Caption>" . $storycaptions . "<0x000D>"; } else { echo ""; } ?><ParaStyle:1 col Headline Times><?php echo get_post_meta($post->ID, 'story_print_headline', true) ?><0x000D><?php $sub_head = get_post_meta($post->ID, 'sub_head', true); if ( $sub_head ) { echo "<ParaStyle:3 line subhead>" . $sub_head . "<0x000D>"; } else { echo ""; } ?><ParaStyle:BYLINE><?php
// CHECK TO SEE IF AUTHOR IS GUEST_AUTHOR AND IF SO, OUTPUT THAT VALUE
$guest_author = get_post_custom_values("guest_author");
if ( $guest_author ) {
$guest_author = get_post_custom_values("guest_author");
?>By <?php echo $guest_author['0']; ?><?php } else { ?>By <?php the_author(); ?><?php } ?><?php
// ADD ANOTHER AUTHOR TO BYLINE AND LINK TO THEIR AUTHOR PAGE
$add_author = get_post_custom_values("add_author");
if ( $add_author ) {
//	$wpdb->show_errors();
foreach($add_author as $key => $value) { 
// QUERY FOR DISPLAY NAME BY SEARCHING FOR NICENAME
$q_author = $wpdb->get_var("SELECT display_name FROM $wpdb->users WHERE user_nicename = '$add_author[$key]'");
// REMOVE ANY SPECIAL CHARS THAT MAY BE IN THE NICENAME ( FOR LINK )
$remove_chars = array(".",",");
$q_author = str_replace($remove_chars, "", $q_author);
$q_author_link = strtolower(str_replace(" ", "-", $q_author));
if ($q_author) {
?> and <?php echo $q_author; ?>
<?php } else { echo "and $add_author[$key]"; } ?><?php } 
}
?><?php echo dirtysuds_content_taggedtext();
endwhile; endif;
exit();