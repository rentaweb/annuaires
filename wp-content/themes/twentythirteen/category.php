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
<script>jQuery(document).ready(function () {
    jQuery(".openingHours, .map, .name, .entry-content").remove();
    jQuery(".catThumb").show();
});
</script>
<link rel='stylesheet' href="http://www.imprimerie-paris.org/wp-content/themes/imprimerie/category.css" type='text/css' media='all' />
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				

				<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?>
				<span class="articles-number">Il y a actuellement <strong><?php $cat = get_category(get_query_var('cat'), false); echo $cat->count; ?> imprimeries</strong>   inscrites pour cet arrondissement.</span></div>
				<?php endif; ?>
			</header><!-- .archive-header -->

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
<?php theme_pagination(); ?>	
			<?php twentythirteen_paging_nav(); ?>
		
		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>