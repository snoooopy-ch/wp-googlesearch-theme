<?php
/**
 * The template for displaying all pages
 *
 * Template Name: プラン一覧ページ
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package yoneko
 */

if (!is_user_logged_in()) {
	wp_redirect(home_url() . '/login');
	exit;
}

get_header();

$paged = (get_query_var('paged'))? get_query_var('paged') : 1;

$args = array(
	'order'				=> 'ASC',
	'post_type'			=> 'plan',
	'paged'				=> $paged,
	'post_status' 		=> 'publish',
);
$the_query = new WP_Query( $args );

?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="wrapper1000">
				<div class="page-title">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</div>
				<div class="page-body">
					<ul class="plan-list">
						<?php 
						if ($the_query->have_posts()): while($the_query->have_posts()): $the_query->the_post();

						if (has_post_thumbnail(get_the_ID())) {
							$src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full', false );
						}
						echo '<li class="plan-list-item">';
						?>
						<a href="<?php echo get_post_permalink( get_the_ID()); ?>">
							<div class="plan-list-item-container">
								<div class="item-header"><?php the_title(); ?></div>
								<div class="item-image">
									<img class="videos-thumbnail-img" src="<?php echo $src[0]; ?>">
								</div>
								<div class="item-price english"><?php echo number_format(get_field('price')) . '￥/月'; ?></div>
								<div class="item-desc">
									<?php echo the_field('description'); ?>
								</div>
								<div class="item-footer">購入</div>
							</div>
						</a>

						<?php
						echo '</li>';
							endwhile;
						endif;
						?>
					</ul>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- inner-right -->
</div><!-- flex wrapper -->

<?php get_footer(); ?>


