<!doctype html>  
<html <?php language_attributes(); ?>>
	<head>

		<!-- "H5": HTML5 Starter Theme -->
		<meta charset="<?php bloginfo('charset'); ?>">
		<meta name="application-name" content="<?php bloginfo('name'); ?>">
		<meta name="description" content="<?php bloginfo('description'); ?>">
		<title><?php bloginfo('name'); ?><?php wp_title('|'); ?></title>
		<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>">
		<!--[if lt IE 9]>
    			<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/lib/css/ie.css">
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>	
		<![endif]-->
		
		<?php wp_head(); ?>
		
	</head>
	<body <?php body_class(); ?>>

		<div class="header">
			<h1><a href="<?php echo home_url('/'); ?>"><?php bloginfo('name'); ?></a></h1>
			<h2><?php bloginfo('description'); ?></h2>
		</div>
		
		<div class="nav">
			<ul>
				<?php wp_list_pages('depth=1&title_li='); ?>
			</ul>
		</div>
