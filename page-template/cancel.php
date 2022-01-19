<?php
/**
 * Template Name: thank you
 * Template Post Type: page
 */

get_header();
?>

	<div class="container inner-right">
		<main id="site-content" role="main">

  <?php
    if(!empty($_GET['tid'] )) {
      	$GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);

		$tid = $GET['tid'];
		$tname = $GET['tname'];

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
			if ($tname == $api_id) $tname = $title;
		endwhile;
    } else {
      header('Location: https://quizhub.jp/error/');
    }
  ?>

    <header class="entry-header has-text-align-center header-footer-group">
      <div class="entry-header-inner section-inner medium">
        <h1 class="entry-title">サブスクリプションが取り消ししました。</h1>
      </div>
    </header>
    <div class="post-inner thin ">
      <div class="entry-content">

        <p>ご登録内容</p>
        <ul>
			<li>購入商品：<?php echo $tname; ?></li>
        </ul>
        <hr>
      </div>
    </div>

</main><!-- #site-content -->
	</div><!-- inner-right -->
</div><!-- flex wrapper -->

<?php get_footer(); ?>