<!DOCTYPE html>
<html>
	<head>
		<!-- title -->
		<title><?php
    	/*
    	 * Print the <title> tag based on what is being viewed.
    	 */
    	global $page, $paged;

    	wp_title( '|', true, 'right' );

    	// Add the blog name.
    	bloginfo( 'name' );

    	// Add the blog description for the home/front page.
    	$site_description = get_bloginfo( 'description', 'display' );
    	if ( $site_description && ( is_home() || is_front_page() ) )
    		echo " | $site_description";

    	// Add a page number if necessary:
    	if ( $paged >= 2 || $page >= 2 )
    		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

    	?></title>

		<!-- meta -->
		<meta charset="UTF-8" />
		<meta name="author" content="WebExpedition18" />
		<meta name="description" content="<?php bloginfo('description'); ?>" />

		<!-- links -->
		<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/images/favicon.ico" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo('template_url'); ?>/css/style.css" />
        <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
        <link rel="pingback"  href="<?php bloginfo('pingback_url'); ?>" />

		<!-- scripts -->

		<!-- IE Hacks -->
		<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->


		<?php wp_enqueue_script("jquery"); ?>
		<?php wp_head(); ?>
		

        <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.main.js"></script>

		
    </head>
    <body <?php body_class(); ?>>
        <a name="header"></a>
    	<!-- header -->
    	<header>
    		<div id="light">
	    		<div class="container_16">
	    			<h1 class="grid_8"><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
					<nav class="grid_8">
					        <?php wp_nav_menu('container=&fallback_cb=grey_wp_list_pages'); ?>
					</nav>
	    		</div>
			</div>
    	</header>

		<!-- wrapper -->
		<div id="wrapper">
			<div class="container_16">
				<section id="posts" class="prefix_1 grid_9">
				
				
