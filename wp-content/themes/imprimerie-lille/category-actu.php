<?php
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header(); ?>
<script>jQuery(document).ready(function(){
jQuery(".openingHours, .map, .name, .coordonnees, .telephone").remove();
jQuery(".catThumb").show();});</script>
<link rel='stylesheet' href="http://www.imprimerie-paris.org/wp-content/themes/imprimerie/actu.css" type='text/css' media='all' />

	<div id="primary" class="content-area category-actu">
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
			<h2 class="posts_title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				<a href="<?php the_permalink() ?>"><?php the_excerpt(); ?></a></article>
			<?php endwhile; ?>
			<?php theme_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>