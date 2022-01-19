<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">
			<div class="wrapper1000">
				<div class="page-title">
					<h1><?php the_title(); ?></h1>
				</div>

				<div class="page-body">
					<?php
					// Start the Loop.
					the_content();
					?>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
