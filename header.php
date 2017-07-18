<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
<meta name="description" content="<?php bloginfo('description'); ?>">
<title>
<?php 
	if (is_home()) {
		bloginfo('name');
		echo ' - ';
		bloginfo('description');
	} else {
		wp_title('-',true,'right'); bloginfo('name'); 
	};
?>
</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
<!--[if IE]>
		<script src="https://cat.yunet.work/public/js/html5shiv.min.js"></script>
	<! [endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri() ?><?php fc_ver() ?>" >
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() ?>/github-gist.css" >
</head>

<body>
<div id="container">
	<div id="contents">
		<div id="header">
			<h1><a href="/"><?php bloginfo('name'); ?></a></h1>
			<h2><?php bloginfo('description'); ?></h2>
		</div>
