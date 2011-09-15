<?php
if (have_posts()): while (have_posts()): the_post();
ob_end_clean();
}

?><html><head><title><?php the_title_attribute(); ?></title>
<style type="text/css">
@media screen, print{ 
html * { font-size:9pt; line-height:11pt; font-family: Palatino, Times, serif; }
p { text-indent: 2em; margin:0; padding:0; margin:0; }
h3, h4 { margin-bottom:0; }
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
<p class="header">
	<strong>Print headline:</strong>
	<?php
		$storypostheadline = get_post_meta($post->ID, 'story_print_headline', true);
		if ($storypostheadline)
			echo $storypostheadline;
		else
			echo "<span style=\"color:red;\">none specified</span>";
	?>
</p>

<p class="header">
	<strong>Web headline:</strong><?php the_title(); ?>
</p>

<p class="header">
	<strong>Subhead/deck:</strong>
	<?php
	$storysubhead = get_post_meta($post->ID, 'sub_head', true);
	if ($storysubhead)
		echo $storysubhead;
	?>
</p>

<p class="header">
	<strong>Status:</strong>
	<?php
		$statussearch = array('publish', 'pending', 'draft', 'assigned', 'future', 'sent-to-production', 'pitch', 'waiting-for-feedback');
		$statusreplace = array('Published', 'Pending review by an editor', 'Draft', 'Assigned to a writer', 'Scheduled to post in the future','Sent to Production', 'Story idea', 'Waiting for editor feedback');
		$statussubject = get_post_status( $ID );
		echo str_replace($statussearch, $statusreplace, $statussubject);
	?>
</p>

<p class="header">
	<strong>Modified:</strong>
	<?php
		the_modified_date('F j, Y');
	?>
	at
	<?php
		the_modified_date('g:i a');
	?>
</p>

<p class="header">
	<strong>Production notes:</strong>
	<?php
		echo get_post_meta($post->ID, 'story_production_notes', true);
	?>
</p>

<p class="header">
	<strong>Captions:</strong>
	<?php
		$storycaptions = get_post_meta($post->ID, 'story_captions', true);
		if ($storycaptions)
			echo $storycaptions;
	?>
</p>

<p class="header">
	<strong>Story length:</strong>
	<?php
		echo str_word_count(strip_tags($post->post_content));
	?>
	words (
	<?php
		$numberofwords = str_word_count(strip_tags($post->post_content));
		$wordsperinch = 35;
		echo round(($numberofwords / $wordsperinch), 2);
	?> column inches at <?php
		echo $wordsperinch;
	?> words per inch)
</p>

<p class="header">
	<strong>Filename:</strong>
	<?php
		$storyfileslug = get_post_meta($post->ID, 'story_file_slug', true);
		if ($storyfileslug)
			echo $storyfileslug.".txt";
	?>
</p>

<p class="header">
	<?php
		// CHECK TO SEE IF AUTHOR IS GUEST_AUTHOR AND IF SO, OUTPUT THAT VALUE
		$guest_author = get_post_custom_values("guest_author");
		if ( $guest_author ) {
			$guest_author = get_post_custom_values("guest_author");
			echo 'By ',$guest_author['0'];
		} else {
			echo 'By ';
			the_author();
		}

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
					echo ' and ',$q_author;
				} else {
					echo "and $add_author[$key]";
				}
			} 
		}
	?>
</p>
</div>

<?php
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]>', $content);
	echo apply_filters('the_content',strip_shortcodes(make_url_footnote(get_the_content())));
?>

<script>
window.print();
</script>

</body>
</html>
<?php
endwhile; endif;
exit();