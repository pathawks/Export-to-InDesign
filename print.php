<?php
ob_end_clean();
the_post();

$required = array();

function displayMetaField($title,$data) {
	if ($data)
		echo '<strong>',$title,':</strong> ',$data,'<br />';
	else if ($required[$title])
		echo '<strong>',$title,':</strong> <span style="color:red;">none specified</span><br />';
}

?><html><head><title><?php the_title_attribute(); ?></title>
<style type="text/css">
@media screen, print{ 
html * {
	font-size:9pt;
	line-height:11pt;
	font-family: Palatino, Times, serif;
}
p {
	text-indent: 2em;
	margin:0;
	padding:0;
	margin:0;
}
h3, h4 { margin-bottom:0; }
#header {
	text-indent: 0;
	width:100%;
	text-align:right;
	margin-bottom: 4em;
	font-size:16pt;
	line-height: 22pt;
}
#header strong {
font-size:20pt;
}
.alignnone { margin: 1em 0 1em 0; text-indent:0; font-style:italic; }
.alignleft { float:left; margin: 0 1.5em 0.5em 0; text-indent:0; font-style:italic; }
.alignright { float:right; margin: 0 0 0.5em 1.5em; text-indent:0; font-style:italic; }
}
</style>
</head><body>
<div id="header">
	<?php
		displayMetaField(
			'Print headline',
			get_post_meta($post->ID, 'story_print_headline', true)
		);

		displayMetaField(
			'Web headline',
			$post->post_title
		);

		displayMetaField(
			'Subhead/deck',
			get_post_meta($post->ID, 'sub_head', true)
		);

		displayMetaField(
			'Status',
			strtr(
				get_post_status( $ID ),
				array(
					'publish' => 'Published',
					'pending' => 'Pending review by an editor',
					'draft' => 'Draft',
					'assigned' => 'Assigned to a writer',
					'future' => 'Scheduled to post in the future',
					'sent-to-production' => 'Sent to Production',
					'pitch' => 'Story idea',
					'waiting-for-feedback' => 'Waiting for editor feedback',
				)
			)
		);

		displayMetaField(
			'Modified',
			get_the_date('F j, Y \a\t g:i a')
		);

		displayMetaField(
			'Production notes',
			get_post_meta($post->ID, 'story_production_notes', true)
		);

		displayMetaField(
			'Captions',
			get_post_meta($post->ID, 'story_captions', true)
		);

		displayMetaField(
			'Story length',
			str_word_count(strip_tags($post->post_content)).' words ('.
			round((str_word_count(strip_tags($post->post_content)) / 35), 2).
			' column inches at 35 words per inch)';
		);

		displayMetaField(
			'Filename',
			get_post_meta($post->ID, 'story_file_slug', true).'.txt'
		);

		if(get_post_custom_values("guest_author"))
			displayMetaField(
				'By',
				get_post_custom_values("guest_author")[0]
			);
		else
			displayMetaField(
				'By',
				get_the_author()
			);
	?>
</p>

<p class="header">
	<?php
	
	/*
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
		} */
	?>
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
exit();