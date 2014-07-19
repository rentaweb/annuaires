<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<!--<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>-->
		<?php endif; ?>
		<?php if (is_home() ) : ?>
		<h2 class="posts_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<?php elseif (is_category() ) : ?>
		<h2 class="posts_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		<?php endif; // is_front_page() ?>
		
		<?php if ( is_single() ) : ?>
		<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php endif; // is_single() ?>
		
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div itemscope itemtype="http://schema.org/LocalBusiness" class="coordonnees">



	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr; </span>', 'twentythirteen' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->
	  <span class="name" itemprop="name"><?php
                  $exemple_metas = get_post_custom();
                  if( isset($exemple_metas['nom établissement'][0]) ){
                  echo '<h2 class="name">'.$exemple_metas['nom établissement'][0].'</h2>';
                  }
                  ?></span>
  <div class="address" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
    <span itemprop="streetAddress"><?php
                  $exemple_metas = get_post_custom();
                  if( isset($exemple_metas['adresse'][0]) ){
                  echo '<div class="address"><i class="icon-home"> Adresse: </i>'.$exemple_metas['adresse'][0].'</div>';
                  }
                  ?></span>

  <span class="telephone" itemprop="telephone"><?php
                  $exemple_metas = get_post_custom();
                  if( isset($exemple_metas['téléphone'][0]) ){
                  echo '<div class="telephone"><i class="icon-phone"> Téléphone: </i> '.$exemple_metas['téléphone'][0].'</div>';
                  }
                  ?></span>

  <meta class="openingHours" itemprop="openingHours"><?php
                  $exemple_metas = get_post_custom();
                  if( isset($exemple_metas['horaire ouverture'][0]) ){
                  echo '<div class="openingHours"><i class="icon-time"> Horaire: </i>' .$exemple_metas['horaire ouverture'][0].'</div>';
                  }
                  ?>

  <span class="map" itemprop="map"><?php
                  $exemple_metas = get_post_custom();
                  if( isset($exemple_metas['Google map'][0]) ){
                  echo '<div class="map	"><iframe width="600" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=" '.$exemple_metas['Google map'][0].'&amp;output=embed"></iframe></div>';
                  }
                  ?></span></div>
<span class="autres-imprimeries"></span>
              </div>


	<?php endif; ?>
				<footer class="entry-meta">
		

		<?php if ( is_single() && get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
		<script>
		jQuery('document').ready(function(){
		jQuery(".yarpp-related").appendTo(".autres-imprimeries");
		});
		</script>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
