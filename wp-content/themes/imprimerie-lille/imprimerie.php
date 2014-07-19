<?php /* Template Name: Présentation imprimeries */ ?> 
<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
<div id="primary" class="site-content">
    <div id="content" role="main">

      <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
      <h1 class="entry-title"><?php the_title(); ?></h1>
    </header>
<div itemscope itemtype="http://schema.org/LocalBusiness">
  <h2><span itemprop="name"><?php
                  $exemple_metas = get_post_custom();
                  if( isset($exemple_metas['nom établissement'][0]) ){
                  echo '<div class="infos">'.$exemple_metas['nom établissement'][0].'</div>';
                  }
                  ?></span></h2>

  <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    <span itemprop="streetAddress"><?php
                  $exemple_metas = get_post_custom();
                  if( isset($exemple_metas['adresse'][0]) ){
                  echo '<div class="infos">'.$exemple_metas['adresse'][0].'</div>';
                  }
                  ?></span>

  <span itemprop="telephone"><?php
                  $exemple_metas = get_post_custom();
                  if( isset($exemple_metas['téléphone'][0]) ){
                  echo '<div class="infos">'.$exemple_metas['téléphone'][0].'</div>';
                  }
                  ?></span>

  <meta itemprop="openingHours" content="<?php
                  $exemple_metas = get_post_custom();
                  if( isset($exemple_metas['horaire ouverture'][0]) ){
                  echo '<div class="infos">'.$exemple_metas['horaire ouverture'][0].'</div>';
                  }
                  ?>"><?php
                  $exemple_metas = get_post_custom();
                  if( isset($exemple_metas['horaire ouverture'][0]) ){
                  echo '<div class="infos">'.$exemple_metas['horaire ouverture'][0].'</div>';
                  }
                  ?>

  <span itemprop="map"><?php
                  $exemple_metas = get_post_custom();
                  if( isset($exemple_metas['Google map'][0]) ){
                  echo '<div class="infos">'.$exemple_metas['Google map'][0].'</div>';
                  }
                  ?></span>

                      <div class="entry-content">
      <?php the_content(); ?>
      <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->
    <pre>

    <footer class="entry-meta">
      <?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-meta -->
  </article><!-- #post -->


        <nav class="nav-single">
          <h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
          <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span>
          <span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
        </nav><!-- .nav-single -->

        

      <?php endwhile; // end of the loop. ?>

    </div><!-- #content -->
  </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>