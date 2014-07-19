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

		<footer id="colophon" class="site-footer" role="contentinfo">
			

			<div class="site-info">
				©Imprimeur-Lille.fr - <?php echo date("Y"); ?> - <a href="/mentions-legales">Mentions légales</a> - <a href="/contact">Nous contacter</a>		</div><!-- .site-info -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
<script>
jQuery(document).ready(function() {
jQuery( "#text-2 h3" ).html( ' Demande de Devis* ');
});
</script>
<script src="<?php echo get_template_directory_uri(); ?>/moving-form.js"></script>
</body>
</html>