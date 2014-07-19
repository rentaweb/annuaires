<?php get_header(); ?>
<link rel='stylesheet' href="/wp-content/themes/fortyniners/category.css" type='text/css' media='all' />
<script>jQuery(document).ready(function () {
    jQuery(".openingHours, .map, .name, .entry-content").remove();
    jQuery(".catThumb").show();
});
</script>


	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				

				<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?if (is_category()) { $page = (get_query_var('paged')) ? get_query_var('paged') : 1; if ($page == 1) {echo category_description(); }}?></div>
				<?php endif; ?>
			</header><!-- .archive-header -->

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
	
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
	<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>



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
</div>
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

				
				
			<?php endwhile; ?>

<?php theme_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>