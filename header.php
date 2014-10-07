<!DOCTYPE html>
<html>
<head>
<?php if( is_page('Splash') ) { ?>
<title><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
<?php } else { ?>
<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?> | <?php bloginfo('description'); ?></title>
<?php } ?>
<meta name="google-site-verification" content="o3pZLQFckopEk3nkoAh4s_8ArM4lTadm--Vc88hpEXM" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/img/favicon.ico">
<link rel="apple-touch-icon" sizes="57x57" href="<?php bloginfo('template_url'); ?>/img/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php bloginfo('template_url'); ?>/img/apple-touch-icon-114x114.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php bloginfo('template_url'); ?>/img/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php bloginfo('template_url'); ?>/img/apple-touch-icon-144x144.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php bloginfo('template_url'); ?>/img/apple-touch-icon-60x60.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php bloginfo('template_url'); ?>/img/apple-touch-icon-120x120.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php bloginfo('template_url'); ?>/img/apple-touch-icon-76x76.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php bloginfo('template_url'); ?>/img/apple-touch-icon-152x152.png">
<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/img/favicon-196x196.png" sizes="196x196">
<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/img/favicon-160x160.png" sizes="160x160">
<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/img/favicon-96x96.png" sizes="96x96">
<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/img/favicon-16x16.png" sizes="16x16">
<link rel="icon" type="image/png" href="<?php bloginfo('template_url'); ?>/img/favicon-32x32.png" sizes="32x32">
<meta name="msapplication-TileColor" content="#111111">
<meta name="msapplication-TileImage" content="<?php bloginfo('template_url'); ?>/img/mstile-144x144.png">
<meta name="msapplication-config" content="<?php bloginfo('template_url'); ?>/img/browserconfig.xml">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo basic_wp_seo(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<?php
	if(is_page()) {
		$twitter_url = get_permalink();
		$twitter_title = get_the_title();
		$twitter_desc = get_the_excerpt();
		$twitter_img = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@StopIvory">
<meta name="og:title" content="<?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?>">
<meta name="twitter:url" content="<?php echo $twitter_url; ?>">
<meta name="twitter:domain" content="<?php bloginfo('url'); ?>">
<meta name="twitter:description" content="<?php echo $twitter_desc; ?>...">
<meta name="twitter:creator" content="@StopIvory">
<meta name="twitter:image" content="<?php echo $twitter_img; ?>">
<meta property="og:title" content="<?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $twitter_img; ?>" />
<meta property="og:url" content="<?php echo $twitter_url; ?>" />
<meta property="og:description" content="<?php echo $twitter_desc; ?>..." />
<meta property="title" content="<?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?>" />
<meta property="type" content="article" />
<meta property="image" content="<?php echo $twitter_img; ?>" />
<meta property="url" content="<?php echo $twitter_url; ?>" />
<meta property="description" content="<?php echo $twitter_desc; ?>..." />
<?php		
	}
?>
<?php endwhile; else :  endif; ?>
<link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet" type="text/css">
<?php wp_head(); ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
</head>
<body <?php body_class(); ?>>

<div id="cookie">
	This website uses cookies for the purposes of analytics and to improve your experience. You won't see this message again. <span id="closeCookie">&times;</span>
</div>

<div class="device-header">
	<?php wp_nav_menu( array('menu' => 'Mobile Menu' )); ?>
</div>

<div class="menuToggle">
	<a href="#">
		<div></div>
		<div></div>
		<div></div>
	</a>
</div>
<?php if( is_page('Splash') ) { ?>

<?php } else { ?>  
<div id="mainMenu" class="hidden-phone hidden-tablet">
	<a href="<?php bloginfo('url'); ?>" id="epiLogo"></a>
	<?php wp_nav_menu( array('menu' => 'Main Menu' )); ?>
	<?php wp_nav_menu( array('menu' => 'Social Menu' )); ?>
</div>
<?php } ?>