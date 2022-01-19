<?php /* Template Name: TOPページ */ ?>

<?php get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main">

	<?php get_template_part( 'template-parts/main-visual' );  ?>

		<section class="plan-intro">
			<div class="wrapper1000">
				<h1>Webテスト　SPI/玉手箱/TG-Web　の解答・添削サービス</h1>
				<h2 class="sub-title">わからない問題を質問し効率良く対策しましょう！</h2>

				<?php
				$paged = (get_query_var('paged'))? get_query_var('paged') : 1;

				$args = array(
					'order'				=> 'ASC',
					'post_type'			=> 'plan',
					'paged'				=> $paged,
					'post_status' 		=> 'publish',
				);
				$the_query = new WP_Query( $args );
				?>
				<a href="<?php echo BASE_URL;?>/share"><div class="start-button yellow-btn">質問する</div></a>
				<div class="desc-text-content">
					<h2>ご質問頂いた問題はご登録されたメールに解答を送ると同時に、弊社のデータベースに追加させていただきます。</h2>
					<p>※弊社の利用規約に同意したものとみなします。</p>
					<p>※質問の解答までに数日要する場合がございます。</p>
					<p>※記載されている解答は管理者が考えたオリジナルのものであり、正解を保証するものではございません。</p>
				</div>
			</div>
		</section>

		<section class="effective-intro">
			<h2 class="sub-title">効率的なWebテスト対策</h2>
			<div class="wrapper-full">
				<div class="d-flex">
					<div>
						<img class="effective-img" src="<?php echo get_template_directory_uri() ?>/assets/image/effective.webp" />
					</div>
					<div class="desc-text-content">
						<p>日本企業の就職・転職採用制度はエントリーシート作成をはじめ、テスト対策、グループディスカッション対策、面接対策、企業分析、自己分析など時間を要するものが多くあり、優先順位を付けて効率よく行うことが求められます。</p>
						<p>その中の１つであるWebテストを効率よく対策するには、実際のテストを受け、それを解けるようにすることが非常に重要だと考えます。</p>
						<p>1つ1つ質問をするという時間と労力を減らすことは就活生の負担を軽減することにも繋がります。Webテスト対策に割く時間を減らすことで、就活生の方々に企業分析や面接対策に集中してもらい、最大限のパフォーマンスを発揮してほしいと考えております。</p>
					</div>
				</div>
			</div>
		</section>

		<section class="plan-intro">
			<div class="wrapper1000">
				<div id="schedule-list" class="desc-text-content">
					<h2 class="sub-title">有料サービスのお申込み〜利用までの流れ</h2>
					<div class="flow-text-content">
						<div class="schedule-item">
							<div class="schedule-item-step">STEP1</div>
							<div class="schedule-desc">
								<p class="txt">ご登録いただいたユーザー名でログインをしてください。<br>未登録の方はこちらから新規ユーザー登録をして下さい。</p>
							</div>
						</div>
						<div class="schedule-item">
							<div class="schedule-item-step">STEP2</div>
							<div class="schedule-desc">
								<p class="txt">ご利用頂くプランを選択してください</p>
							</div>
						</div>
						<div class="schedule-item">
							<div class="schedule-item-step">STEP3</div>
							<div class="schedule-desc">
								<p class="txt">個人情報の入力、お支払い方法を選択してください（クレジットカードをご用意下さい）</p>
							</div>
						</div>
						<div class="schedule-item">
							<div class="schedule-item-step">STEP4</div>
							<div class="schedule-desc">
								<p class="txt">お支払い確認のメールをご確認下さい</p>
							</div>
						</div>
						<div class="schedule-item">
							<div class="schedule-item-step">STEP5</div>
							<div class="schedule-desc">
								<p class="txt">メニューバーにある検索エンジンから形式を選択し、キーワードをご入力することでご利用いただけます</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="plan-intro">
			<div class="wrapper1000">
				<h2 class="sub-title">プラン</h2>
				<ul class="home-list">
					<?php 
						if ($the_query->have_posts()): while($the_query->have_posts()): $the_query->the_post();

						if (has_post_thumbnail(get_the_ID())) {
							$src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full', false );
						}

						if (get_the_title() == 'コンプリート') continue;
					?>
					<a href="<?php echo get_post_permalink(get_the_ID()); ?>">
						<li class="home-list-item">
							<div><img src="<?php echo $src[0]; ?>"></div>
							<div class="home-item-over">
								<div style="">
									<span class="item-title"><?php echo the_title(); ?></span>
									<span class="item-desc"><?php echo the_field('description') ?></span>
									<span class="item-btn"> もっと見る</span>
								</div>
							</div>
						</li>
					</a>
					<?php
						endwhile;
					endif;
					?>
				</ul>
			</div>
			
		</section>

	</main>
</div>

<?php get_footer(); ?>

