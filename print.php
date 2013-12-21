<?php
/* 11-30-12 edits by jquackenbush */
if (have_posts()): while (have_posts()): the_post();
ob_end_clean();
?><html><head><title><?php the_title_attribute(); ?></title>
<style type="text/css">
@media screen, print{ 
html * { font-size:9pt; line-height:11pt; font-family: Palatino, Times, serif; }
p { text-indent: 2em; margin:0; padding:0; margin:0; }
h3, h4, h5, h6 { margin:1em 0 0 0; }
h3 + h4, h4 + h5, h5 + h6 { margin-top: 0; }
<?php if (in_category(8130)) { echo 'h4 + h5 { font-style:italic; font-weight:normal; }'; } ?>
img { width: 50%; max-width: 200px; height:auto; }
.header { text-indent: 0; }
.alignnone { margin: 1em 0 1em 0; text-indent:0; font-style:italic; }
.alignleft { float:left; margin: 0 1.5em 0.5em 0; text-indent:0; font-style:italic; }
.alignright { float:right; margin: 0 0 0.5em 1.5em; text-indent:0; font-style:italic; }
#post_urls { margin-top:1em; text-indent:0; font-style:italic; }
#author { margin-bottom:1em; }
#author strong { font-weight:bold; }
.sociable { display:none; }
}
</style>
</head><body>
<div id="author">
<p class="header"><strong>Print headline:</strong> <?php $nonespecified = "<span style=\"color:red;\">none specified</span>"; $storypostheadline = get_post_meta($post->ID, 'story_print_headline', true); if ($storypostheadline) { echo $storypostheadline; } else echo $nonespecified; ?></p>
<p class="header"><strong>Web headline:</strong> <?php the_title(); ?></p>
<?php $storysubheadtitle = "<p class=\"header\"><strong>Subhead/deck:</strong> "; $storysubhead = get_post_meta($post->ID, 'sub_head', true); $storydeck = get_post_meta($post->ID, 'story_print_deck', true); if ($storysubhead) { echo $storysubheadtitle.$storysubhead; } elseif ($storydeck) { echo $storysubheadtitle.$storydeck; } else { echo $storysubheadtitle.$nonespecified; } ?></p>
<p class="header"><strong>Web excerpt:</strong> <?php 
	$story_excerpt = get_the_excerpt(); 
	if ( preg_match('/\[\.\.\.\]/', $story_excerpt) ) { echo $nonespecified; }
	else { $story_excerpt = wptexturize($story_excerpt); echo $story_excerpt; } 
	?></p>
<p class="header"><strong>Status:</strong> <?php $statussearch = array('publish', 'pending', 'draft', 'assigned', 'future', 'sent-to-production', 'pitch', 'waiting-for-feedback');
$statusreplace = array('Published', 'Pending review by an editor', 'Draft', 'Assigned to a writer', 'Scheduled to post in the future','Sent to Production', 'Story idea', 'Waiting for editor feedback');
$statussubject = get_post_status( $ID );
echo str_replace($statussearch, $statusreplace, $statussubject); ?>
<p class="header"><strong>Publication:</strong> <?php the_time('F j, Y, g:i a'); ?></p>
<p class="header"><strong>Modified:</strong> <?php the_modified_date('F j, Y, g:i a'); ?></p>
<p class="header"><strong>Production notes:</strong> <?php echo get_post_meta($post->ID, 'story_production_notes', true); ?></p>
<p class="header"><strong>Photo captions:</strong> <?php 
	$storycaptions = get_post_meta($post->ID, 'story_captions', true); 
	$storycaptions = wpautop($storycaptions);
	$storycaptions = wptexturize($storycaptions); 
	if ($storycaptions) { echo "</p><div style=\"margin:0 2em 0 2em;\">".$storycaptions."</div>"; } 
	else { echo $nonespecified."</p>"; } 
$storypullquote1 = get_post_meta($post->ID, 'story_pullquote_1', true);
	if ($storypullquote1) { 
		$storypullquote1 = wptexturize($storypullquote1);
		echo "<p class=\"header\"><strong>Pullquote 1:</strong> ".$storypullquote1."</p>"; }
$storypullquote2 = get_post_meta($post->ID, 'story_pullquote_2', true);
	if ($storypullquote2) { 
		$storypullquote2 = wptexturize($storypullquote2);
		echo "<p class=\"header\"><strong>Pullquote 2:</strong> ".$storypullquote2."</p>"; }?>
<p class="header"><strong>Story length:</strong> <?php 
echo str_word_count(strip_tags($post->post_content)); ?> words (<?php 
	$numberofwords = str_word_count(strip_tags($post->post_content)); 
	/* 6722=Business News, 28=People, 39=Calendar, 6721=Leases & Sales */ 
	if(in_category (array('brief-business-news-items','people'))) {$wordsperinch = 50; $wordcounttype = 'Business News and People items';}
		elseif(in_category ('upcoming-events')) {$wordsperinch = 29; $wordcounttype = 'the Calendar';} 
		elseif(in_category ('commercial-real-estate-leases-and-sales')) {$wordsperinch = 43.5; $wordcounttype = 'Leases and Sales';} 
		else {$wordsperinch = 35; $wordcounttype = 'news stories and article submissions';} 
	echo round(($numberofwords / $wordsperinch), 2); ?> column inches at <?php echo $wordsperinch; ?> words per inch for <?php echo $wordcounttype; ?>)</p>
	<p class="header"><strong>Filename:</strong> <?php $storyfileslug = get_post_meta($post->ID, 'story_file_slug', true); if ($storyfileslug) { echo $storyfileslug.".txt"; } else echo $nonespecified; ?></p>
<p class="header"><?php 
					// CHECK TO SEE IF AUTHOR IS GUEST_AUTHOR AND IF SO, OUTPUT THAT VALUE
					// omit "By" for Business Journal Staff Report and Business Journal Editorial
					$guest_author = get_post_custom_values("guest_author");
					$nbbjauthorID = get_the_author_meta('ID');
					if ( $guest_author ) { ?>By <?php echo $guest_author['0']; } 
						elseif(($nbbjauthorID === 10) || ($nbbjauthorID === 17)) { the_author(); }
						else { ?>By <?php the_author(); } ?></p></div>
<?php
$content = apply_filters('the_content', $content);
$content = str_replace(']]>', ']]&gt;', $content);
echo the_content();
// apply_filters('the_content',strip_shortcodes(make_url_footnote(get_the_content()))); ?>
<script>
window.print();
</script>
</body></html><?php
endwhile; endif;
exit();