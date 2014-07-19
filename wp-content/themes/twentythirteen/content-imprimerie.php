<?php
/**
 * The template for displaying posts in the Imprimerie  post format
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
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
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentythirteen' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php twentythirteen_entry_meta(); ?>

		<?php if ( comments_open() && ! is_single() ) : ?>
		<span class="comments-link">
			<?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'twentythirteen' ) . '</span>', __( 'One comment so far', 'twentythirteen' ), __( 'View all % comments', 'twentythirteen' ) ); ?>
		</span><!-- .comments-link -->
		<?php endif; // comments_open() ?>
		<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post -->
