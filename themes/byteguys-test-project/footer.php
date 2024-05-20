<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package ByteGuys_Test_Project
 */

?>

	<footer id="colophon" class="site-footer">
		<div class="site-info wrapper">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'byteguys-test-project' ) ); ?>">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( esc_html__( 'Proudly powered by %s', 'byteguys-test-project' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				/* translators: 1: Theme name, 2: Theme author. */
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'byteguys-test-project' ), 'byteguys-test-project', '<a href="https://josephbuarao.com/">Joseph Buarao</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
