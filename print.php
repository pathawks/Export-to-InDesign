<?php
ob_end_clean();
the_post();

$required = array('Web headline','By');

function displayMetaField($title,$data) {
	if ($data)
		echo ' <strong>',$title,':</strong> ',$data,'<br />',PHP_EOL;
	else if ($required[$title])
		echo ' <strong>',$title,':</strong> <span style="color:red;">none specified</span><br />',PHP_EOL;
}

?><html><head><title><?php the_title_attribute(); ?></title>
<style type="text/css">
@media screen, print{ 
html * {
	font-size:14pt;
	line-height:24pt;
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
	font-family: Helvetica, sans-serif;
	text-indent: 0;
	width:100%;
	text-align:right;
	margin: 0 0 4em 0;
	font-size:18pt;
	line-height: 22pt;
	color: #333;
}
#header * {
	font-family: Helvetica, sans-serif;
}
#header strong {
	font-size:12pt;
	text-transform: uppercase;
	font-weight: 100;
	color: #999;
}
#header sub {
	text-transform:uppercase;
	vertical-align:baseline;
	font-size:10pt;
	color: #444;
}
.alignnone { margin: 1em 0 1em 0; text-indent:0; font-style:italic; }
.alignleft { float:left; margin: 0 1.5em 0.5em 0; text-indent:0; font-style:italic; }
.alignright { float:right; margin: 0 0 0.5em 1.5em; text-indent:0; font-style:italic; }
}
</style>
</head><body onload='window.print()'>
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

		if(get_post_custom_values("guest_author"))
			displayMetaField(
				'By',
				get_post_custom_values("guest_author")
			);
		else
			displayMetaField(
				'By',
				get_the_author_meta('first_name').' '.get_the_author_meta('last_name')
			);

		displayMetaField(
			'Email',
			get_the_author_meta('user_email')
		);

		displayMetaField(
			'Modified',
			get_the_date('F j, Y<\s\u\b\>@\<\/\s\u\b\>g:i<\s\u\b\>A\<\/\s\u\b\>')
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
			'Production notes',
			get_post_meta($post->ID, 'story_production_notes', true)
		);

		displayMetaField(
			'Captions',
			get_post_meta($post->ID, 'story_captions', true)
		);

		displayMetaField(
			'Story length',
			str_word_count(strip_tags($post->post_content)).'<sub>words</sub> '.
			round((str_word_count(strip_tags($post->post_content)) / 35), 1).
			'<sub>inches</sub>'
		);

		displayMetaField(
			'Filename',
			preg_replace(
				"/[^a-zA-Z0-9\-_]/","",
				get_the_author_lastname()
					.'-'.str_replace(' ','_',basename(get_permalink()))
			).'.txt'
		);

/*
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
	echo trim(apply_filters('the_content',strip_shortcodes(make_url_footnote(get_the_content()))));
?>

</body>
</html>
<?php
exit();