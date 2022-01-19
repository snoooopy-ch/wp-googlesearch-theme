<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package yoneko
 */

echo '<link rel="stylesheet" href="https://quizhub.jp/stripe_css/style.css">';
get_header();
?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            <div class="wrapper1000">
                <div class="page-title">
                    <h1><?php the_title(); ?>の購入</h1>
                </div>
                <div class="page-body">
                    <div class="d-flex">
                        <?php if (have_posts()): the_post(); 
                        if (has_post_thumbnail(get_the_ID())) {
                            $src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full', false );
                        }?>
                            <div class="detail-img-container">
                                <img class="detail-img" src="<?php echo $src[0]; ?>"/>
                            </div>
                            <div class="right-half">
                                <h2>プラン：<?php the_title(); ?></h2>
                                <p><?php the_field('description'); ?></p>
                                <p><?php echo number_format(get_field('price')) . '￥/月'; ?></p>

                                <?php
                                if (!is_user_logged_in()) {
                                ?>
                                <span><a href="<?php echo home_url() . '/login' ?>">ログイン</a>してください。</span>
                                <?php
                                } else { 
                                    $current_user = wp_get_current_user();
                                    $info = get_stripe_info(get_field('api_id'));

                                    if ($info == null || $info->stripe_status == 'cancel') {
                                ?>
                                        <div class="dlg-show start-button">購入</div>
                                        <div class="dlg-mask"></div>
                                        <div class="dlg-modal">
                                            <form action="https://quizhub.jp/subsc_charge.php" method="post" id="payment-form">
                                                <div class="form-row">
                                                    <input type="text" name="name" class="form-control StripeElement StripeElement--empty" placeholder="ユーザー名" value="<?php echo $current_user->display_name; ?>">
                                                    <input type="email" name="email" class="form-control StripeElement StripeElement--empty" placeholder="メールアドレス" value="<?php echo $current_user->user_email ; ?>">
                                                    <input type="text" name="item" hidden value="<?php echo the_field('api_id')?>" />
                                                    <div id="card-element" class="form-control"></div>
                                                    <div id="card-errors" role="alert"></div>
                                                </div>
                                                <label><input name="agree-protocal" type="checkbox" id="agree"><a href="<?php echo BASE_URL;?>/protocal" target="_blank" style="text-decoration: underline; color: blue;">利用規約</a>に同意する</label><br>
                                                <button type="submit" style="margin:16px auto;" id="submit-btn">申し込む（テスト）</button> <br>
                                            </form>
                                            <button class="dlg-close" >X</button>
                                        </div>
                                    <?php } else {?>
                                        <form action="https://quizhub.jp/subsc_cancel.php" method="post" id="payment-form">
                                            <div class="form-row">
                                                <input type="text" name="stripe_id" hidden value="<?php echo $info->stripe_id; ?>" />
                                            </div>
                                            <button type="submit">取り消し（テスト）</button> <br>
                                        </form>
                                <?php }} ?>
                            </div>
                        <?php endif; 
                        echo '<script src="https://js.stripe.com/v3/"></script>';
                        echo '<script src="https://quizhub.jp/stripe_js/script.js"></script>';
                        ?>
                    </div>
                </div>
            </div>
		</main><!-- #main -->
	</div><!-- inner-right -->
</div><!-- flex wrapper -->

<?php get_footer(); ?>


