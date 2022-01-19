<?php /* <header></header> */ ?>
	<header style="background: white; position: fixed; width: 100%;z-index: 1000">
		<div class="wrapper1000">
			<nav class="pc">
				<div class="flex-btw center_v">
					<div class="site-logo-container">
						<a href="<?php echo BASE_URL;?>"><h1><img class="site-logo" src="<?php echo get_template_directory_uri() ;?>/assets/image/logo2.webp" alt="QuizHubはみんなでつくる、就活のWebテスト対策サービス。お互いにわからない問題や知恵、知識を共有することで効率的に対策できるサイトです。" width="120"></h1></a>
					</div>
					<div class="site-menu-container">
						<div class="sm-down-container">
							<ul class="menu-list flex-end">
								<li class="down-item"><a href="<?php echo BASE_URL;?>"><span>Home</span></a></li>
								<li class="down-item"><a href="<?php echo BASE_URL;?>/plans"><span>プラン</span></a></li>
								<li class="down-item"><a href="<?php echo BASE_URL;?>/search"><span>検索</span></a></li>
								<li class="down-item"><a href="<?php echo BASE_URL;?>/share"><span>質問</span></a></li>
								<li class="down-item"><a href="<?php echo BASE_URL;?>/contact"><span>お問い合わせ</span></a></li>
								<?php if (!is_user_logged_in()) {?>
									<li class="down-item"><a href="<?php echo BASE_URL;?>/login"><span>ログイン</span></a></li>
								<?php } else {?> 
									<li class="down-item  drop-down-parent">
										<a href="javascript:void(0)" class=""><span><?php echo wp_display_name_from_userid() ?></span></a>
										<ul class="drop-down">
											<li class="down-item drop-down-item"><a href="<?php echo BASE_URL;?>/profile/?a=edit"><span>プロフィール</span></a></li>
											<li class="down-item drop-down-item"><a href="<?php echo BASE_URL;?>/?a=logout"><span>ログアウト</span></a></li>
										</ul>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
				</div>
			</nav>

			<nav class="sp site-nav">
				<h1 class="logo"><a href="<?php echo BASE_URL;?>"><img class="site-logo" src="<?php echo get_template_directory_uri(); ?>/assets/image/logo.png" alt="QuizHubはみんなでつくる、就活のWebテスト対策サービス。お互いにわからない問題や知恵、知識を共有することで効率的に対策できるサイトです。"></a></h1>
				<div class="menu-toggle">
					<span class="line-1"></span>
					<span class="line-2"></span>
					<span class="line-3"></span>
				</div>

				<ul class="sp-menu open desktop">
					<ul class="menu-list">
						<li class="sp-down-item"><a href="<?php echo BASE_URL;?>"><span>Home</span></a></li>	
						<li class="sp-down-item"><a href="<?php echo BASE_URL;?>/plans"><span>プラン</span></a></li>
						<li class="sp-down-item"><a href="<?php echo BASE_URL;?>/search"><span>検索</span></a></li>
						<li class="sp-down-item"><a href="<?php echo BASE_URL;?>/share"><span>質問</span></a></li>
						<li class="sp-down-item"><a href="<?php echo BASE_URL;?>/contact"><span>お問い合わせ</span></a></li>
						<?php if (is_user_logged_in()) {?>
							<li class="sp-down-item"><a href="<?php echo BASE_URL;?>/profile/?a=edit"><span>プロフィル</span></a></li>
							<li class="sp-down-item"><a href="<?php echo BASE_URL;?>/?a=logout"><span>ログアウト</span></a></li>
						<?php } else { ?>
							<li class="sp-down-item"><a href="<?php echo BASE_URL;?>/login"><span>ログイン</span></a></li>
						<?php } ?>
					</ul>
				</ul>
			</nav>
		</div>
	</header>
		
