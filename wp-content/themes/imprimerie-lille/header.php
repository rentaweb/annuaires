<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" lang="fr-FR">
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" lang="fr-FR">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html lang="fr-FR">
<!--<![endif]-->
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title>Imprimerie Lille</title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="http://www.imprimerie-lille.org/xmlrpc.php">
        <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>
</head>
<div id="top-navbar"></div>
<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<header id="masthead" class="site-header" role="banner">
<div id="navbar" class="navbar">
<nav id="site-navigation" class="navigation main-navigation" role="navigation">
	<h3 class="menu-toggle"><?php _e( 'Menu', 'twentythirteen' ); ?></h3>
	<a class="screen-reader-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentythirteen' ); ?>"><?php _e( 'Skip to content', 'twentythirteen' ); ?></a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
					<?php get_search_form(); ?>
				</nav><!-- #site-navigation -->
			</div><!-- #navbar -->
			<a class="home-link" href="http://www.imprimerie-lille.org/" title="Imprimerie lille" rel="home">
				
			</a>



		</header><!-- #masthead -->
<?php if ( function_exists('yoast_breadcrumb') ) {
yoast_breadcrumb('<p id="breadcrumbs">','</p>');
} ?>
		<div id="main" class="site-main">
