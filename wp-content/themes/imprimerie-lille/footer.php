<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>

		</div><!-- #main -->
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php get_sidebar( 'main' ); ?>

			<div class="site-info">
				<span><a href="http://www.imprimerie-lille.org/" title="imprimerie-lille.org">&copy;imprimerie-lille.org</a> - 2014</span>
				<span><a href="http://www.imprimerie-lille.org/mentions-legales" title="Mentions légales">Mentions légales </a></span>
				<span><a href="http://www.imprimerie-lille.org/index.php" title="Imprimerie Lille">Imprimerie Lille</a></span>
				<span><a href="http://www.imprimerie-lille.org/contact" title="Contact">Nous contacter</a></span>
			</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>