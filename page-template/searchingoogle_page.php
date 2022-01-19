<?php
/**
 * The template for displaying all pages
 *
 * Template Name: 検索ページ
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

$categries = array();
while ($the_query->have_posts()): $the_query->the_post();
	$api_id = get_field('api_id');
	$title = get_the_title();

	if (get_stripe_info($api_id) != null) {
		if ($title == 'コンプリート') {
			$categries[$api_id] = ['全体', get_the_title()];
		}
		else {
			$categries[$api_id] = [get_the_title(), get_the_title()];
		}
	}
		
endwhile;
wp_reset_postdata();

?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="wrapper1000">
				<div class="page-title">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</div>
				<div class="page-body">
					<div class="search-bar">
						<div class="search-bar-container">
							<select id="id_category" name="category_query">
								<?php 
								$i = 0;
								foreach($categries as $api_id => $category) { 
									if ($i == 0) {?>
										<option value="<?php echo $category[1] ?>" selected><?php echo $category[0];?> </option>"
									<?php } else {?>
										<option value="<?php echo $category[1] ?>"><?php echo $category[0];?> </option>"
								<?php }
								$i = $i + 1;
							}?>
							</select>
							<input id="s-word" name="s-word" class="sgs-search" placeholder="検索する" value=""/>
							<div class="searchbtn-container">
								<button id="b-word" class="sgs-searchbtn">検索</button>
							</div>
							<input id="admin_url" value=<?php echo admin_url('admin-ajax.php'); ?> hidden />
						</div>
					</div>
					<div class="search-content">
					</div>
					<?php
					?>
				</div>
			</div>
		</main><!-- #main -->
	</div><!-- inner-right -->
</div><!-- flex wrapper -->

<?php get_footer(); ?>


