<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.osdn.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'LAA1297239-zphsef');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'LAA1297239');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'lKc9QZ3E');

/** MySQL のホスト名 */
define('DB_HOST', 'mysql151.phy.lolipop.lan');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY', '3}sq!iz)d:AH-4clz&5=fv;lDz1l>R[4nS<,UPkLCxEt[W.z561rmn~!~FD<f<aI');
define('SECURE_AUTH_KEY', 'A.zyzZShO1tVcZ|S(-TQA?~^U-fu_I,2cB?LV58~,{5T*@[dhrZ%}LL"HzyefbDM');
define('LOGGED_IN_KEY', 'Pd9Y5TdL[rIKnFLstpSvt7+tj85=u%(t;O.IhZs##2wn6tQRcMfrK,nFz6Uz"re[');
define('NONCE_KEY', 'x}n1k20%!!KuCdo8LT",Zqwuk}7v57U6CYm5a=2y0{G)=GlXH^6+RY^S*{<0jh@Y');
define('AUTH_SALT', 'g(QYjc7`xUVfH]gr^e$LQDDqzG:kJNrDR!sGc:J"Q6]:8d3NR+KIx,Z*V=:7,>I%');
define('SECURE_AUTH_SALT', 'xV0SBV,/-PGL12j*]>o3S?[*$~A?KkrA02B$}DJsj*:USQ=wk8?N/e/Tr(oCj?qP');
define('LOGGED_IN_SALT', 'VZt@C3ZRz"}z09N"o*4}[&*LQw?%mW/=QndkuEpS0s10tlRi`/T~:I*q7y?X"/zl');
define('NONCE_SALT', 'hR0eHm6%#FZYUGA:rpK58&PUp2<r[Bao,+<Wo1OoN](stFFxPFs,mszB?8614*-Y');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp20210430004829_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define( 'WP_DEBUG', true );
define ( 'WP_DEBUG_DISPLAY', false);
// Enable Debug logging to the /wp-content/debug.log file
define( 'WP_DEBUG_LOG', 'wp-content/debug.log' );

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
  define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
