<?php
/*
Template Name: Modèle MAP
*/
?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	
	<![endif]-->
<style type="text/css">
.site-info {
    display: none;
}
#wpadminbar {
display:none;
}
/*Directions MAP*/

#wpgmaps_directions_editbox_1 td {
}
#wpgmaps_directions_editbox_1 td a {
  color: gray;
    display: block;
    font-size: 15px;
    margin-bottom: 13px;
}
.wpgmaps_directions_outer_div {
   background-color: #fff;
    border: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 6px;
    color: black !important;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
    height: 80%;
    margin: auto auto auto 50px;
    position: fixed;
    width: 700px;
    bottom: 0;
    left: 0;
    outline: 0 none;
    overflow-x: auto;
    overflow-y: scroll;
    right: 0;
    top: 0;
    z-index: 1050;
}
</style>
</head>
<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">	
<header id="masthead" class="site-header" role="banner">

				<div class="ggmap"><?php echo do_shortcode('[wpgmza id="1"]'); ?></div>
		</header><!-- #masthead -->
	<div id="main" class="site-main">
		


<script>
jQuery('document').ready(function{
jQuery( "#wpgmaps_directions_edit_1" ).append( "<span>X</span>" );
});
</script>
<?php get_footer(); ?>