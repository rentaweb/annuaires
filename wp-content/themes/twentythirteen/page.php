<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>

						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
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

  <meta itemprop="openingHours" content=""><?php
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
                  ?></span></div>
						<?php the_content(); ?>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->

	
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>