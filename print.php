<?php
if (have_posts()): while (have_posts()): the_post();
ob_end_clean();
?><html><head><title><?php the_title_attribute(); ?></title>
<style type="text/css">
html * {
font-size:14pt;
line-height:28pt;
font-family: Times, serif;
}

p {
text-indent: 2em;
margin:0;
padding:0;
}

#author {
width:100%;
text-align:right;
margin-bottom: 4em;
font-size:16pt;
line-height: 22pt;
}
#author strong {
font-size:20pt;
}
</style>
</head><body>
<div id="author">
<strong><?php the_title_attribute(); ?></strong><br />
<?php the_author_firstname() ?> <?php the_author_lastname() ?><br />
<?php echo get_the_author_email() ?>
</div>
<?php echo strip_shortcodes(make_url_footnote(get_the_content())); ?>
<script>
window.print();
</script>
</body></html><?php
endwhile; endif;
exit();