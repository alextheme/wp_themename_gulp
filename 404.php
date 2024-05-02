<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package _themename
 */

get_header();
?>

	<main id="primary_404" class="site-main">

		<section class="section error_404">
			<div class="section_in">
				<p class="subtitle">Oops</p>
				<div class="number_404">
					<span class="four">4</span>
					<span class="icon-menu"></span>
					<span class="four">4</span>
				</div>
				<p class="title">Page not found</p>
				<p class="descr">We're already trying to fix it.</p>
				<a class="link_404" href="<?php echo esc_url(home_url('/')) ?>">To the home page</a>

			</div><!-- .page-content -->
		</section><!-- .error-404 -->

	</main><!-- #main -->

<?php
get_footer();
