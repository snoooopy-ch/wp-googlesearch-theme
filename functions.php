<?php

require_once WP_CONTENT_DIR . '/themes/quiz_snoopy/vendor/autoload.php';

define('BASE_URL', home_url()); 

add_theme_support( 'post-thumbnails' );

function quiz_snoopy_wbiyoka_style_and_scripts_handler() {
	wp_enqueue_style('custom_style', get_template_directory_uri() . '/assets/css/common.css', array(), '' );
    wp_enqueue_style('common_style', get_template_directory_uri() . '/assets/css/style.css', array(), '' );
	wp_enqueue_style('layout_style', get_template_directory_uri() . '/assets/css/layout.css', array(), '' );
    wp_enqueue_style('bxslider_style', get_template_directory_uri() . '/assets/css/jquery.bxslider.min.css', array(), '' );
    wp_enqueue_script('jquery_js', get_template_directory_uri() . '/assets/js/jquery-3.6.0.min.js', array(), '' );
	wp_enqueue_script('moment', 'https://momentjs.com/downloads/moment.js', array(), '');
	wp_enqueue_script('bxslider_js', get_template_directory_uri() . '/assets/js/jquery.bxslider.min.js', array(), '' );
	wp_enqueue_script('loadingoverlay', 'https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js', array(), null, true);
    wp_enqueue_script('index_script', get_template_directory_uri() . '/assets/js/searchingoogle-index.js', array(), '' );
}
add_action( 'wp_enqueue_scripts' , 'quiz_snoopy_wbiyoka_style_and_scripts_handler', 1000 );

/*
 *	global functions
 */

function wp_display_name_from_userid() {
	$userid = get_current_user_id();
	$last_name = get_user_meta( $userid, 'last_name', true );
	$first_name = get_user_meta( $userid, 'first_name', true );
	$display_name = $last_name . $first_name;
	if (empty($display_name)) {
		$display_name = get_user_meta($userid, 'nickname', true);
	}

	return $display_name;
}

function print_log( $filename = "", $functionname = "", $tagname = "", $message = 'default') {
	global $wpdb;

    try {
        ob_start();
        var_dump($message);
        $result = ob_get_clean();
    
        $wpdb->insert(
            'wp_debug',
            array(
                'file' 		=> $filename,
                'tag' 		=> $functionname,
                'name' 		=> $tagname,
                'message' 	=> $result,
            )
        );
    } catch (\Exception $e) {
        print_log('functions.php', 'print_log', 'error', $e);
    }
	
}

function str_contains_all($haystack, array $needles) {
    foreach ($needles as $needle) {
        if (strpos($haystack, $needle) === false) {
            return false;
        }
    }
    return true;
}

function search_in_google() {
    try {
        global $_POST;
        
        if (!empty($_POST['keyword'])) {
            $keyword = $_POST['keyword'];
            $category = $_POST['category'];
            $keywords = preg_split('/\s|,/', $keyword);

            $service_account_file = WP_CONTENT_DIR . '/themes/quiz_snoopy/client_secret.json';
            $spreadsheet_id = '1Aa9miQUZwfVMpLScK-jy_5ewrvxUlS8BW6wIEw5droQ';

            $sheet1 = '玉手箱（非言語・表の読み取り）!A1:J';
            $sheet2 = '玉手箱（非言語・欠落表）!A1:J';
            $sheet3 = '玉手箱（言語）!A1:J';
            $sheet4 = '玉手箱（英語）!A1:J';
            $sheet5 = '新型TG-Web（非言語）!A1:J';
            $sheet6 = '新型TG-Web（言語）!A1:J';
            $sheet7 = 'TG-Web(非言語)!A1:J';
            $sheet8 = 'TG-Web(言語)!A1:J';
            $sheet9 = 'TG-Web(英語)!A1:J';
            $sheet10 = 'SPI（言語）!A1:J';
            $sheet11 = 'SPI（非言語）!A1:J';

            $spreadsheet_range = array();
            $spreadsheet_range['SPI'] = [$sheet10, $sheet11];
            $spreadsheet_range['玉手箱'] = [$sheet1, $sheet2, $sheet3, $sheet4];
            $spreadsheet_range['TGWEB'] = [$sheet5, $sheet6, $sheet7, $sheet8, $sheet9];
            $spreadsheet_range['コンプリート'] = [$sheet1, $sheet2, $sheet3, $sheet4, $sheet5, $sheet6, $sheet7, $sheet8, $sheet9, $sheet10, $sheet11];

            putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $service_account_file);

            $client = new Google_Client();
            $client->useApplicationDefaultCredentials();
            $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);
            $service = new Google_Service_Sheets($client);

            $data = array();
            $search_result = array();

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
                $categries[$title] = $api_id;
            endwhile;

            print_log('functions.php', 'search_in_google', 'categries', $categries);
            print_log('functions.php', 'search_in_google', 'category', $category);
            print_log('functions.php', 'search_in_google', 'spreadsheet_range[$category]', $spreadsheet_range[$category]);

            foreach ($spreadsheet_range[$category] as $sheet) {
                $price_info = get_stripe_info($categries[$category]);
                if ($price_info == null) {
                    echo json_encode(array());
                    die();
                }
                $result = $service->spreadsheets_values->get($spreadsheet_id, $sheet);
                $result = $result->getValues();
                
                foreach($result as $row) {
                    if (sizeof($row) != 0) {
                        $data[$row[1]] = $row;
                        if (str_contains_all($row[1], $keywords)) {
                            $search_result[] = $row;
                            if (sizeof($search_result) > 9) break;
                        }
                    }
                }
                if (sizeof($search_result) > 9) break;
            }

            echo json_encode($search_result);
            die();
        }

    } catch (\Exception $e) {
        print_log('functions.php', 'search_in_google', 'e', $e);
    }
}

add_action( 'wp_ajax_nopriv_search_in_google', 'search_in_google' );
add_action( 'wp_ajax_search_in_google', 'search_in_google' );

add_filter('wpmem_register_form', 'wpmem_register_form_handler', 10, 4);
function wpmem_register_form_handler($form, $tag, $rows, $hidden) {
    return $form;
}

add_filter( 'single_template', 'single_template_handler' );
function single_template_handler( $single_template ){
    global $post;

    if ($post->post_type == 'plan') {
        $file = dirname(__FILE__) .'/single-'. $post->post_type .'.php';
        if ( file_exists( $file ) ) $single_template = $file;
    }

    return $single_template;
}

function get_stripe_info($stripe_plan) {
    global $table_prefix;
    global $wpdb;

    $table_name = $table_prefix . "subscriptions";
    $current_user = get_current_user_id();

    $sql = "SELECT * FROM `" . $table_name . "` WHERE `stripe_plan` LIKE '" . $stripe_plan . "' AND `user_id` = " . (string)$current_user . " AND `ends_at` > NOW() ORDER BY `created_at`;";
    $result = $wpdb->get_results($sql);
    print_log('functions.php', 'get_stripe_info', 'sql', $sql);

    if (!isset($result) || empty($result))
        return null;
    else 
        return $result[0];
}

function get_stripe_info_with_title($title) {
    global $table_prefix;
    global $wpdb;

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
        $categries[$title] = $api_id;
    endwhile;

    $table_name = $table_prefix . "subscriptions";
    $current_user = get_current_user_id();
    $stripe_plan = $categries[$title];
    return get_stripe_info($stripe_plan);
}

add_filter( 'wpmem_login_redirect', 'my_login_redirect', 10, 2 );
function my_login_redirect( $redirect_to, $user_id ) {
    return home_url( '/home/' );
}


add_action('after_setup_theme', 'after_setup_quiztheme_handler');
function after_setup_quiztheme_handler () {
	create_plugin_database_table();
}

function create_plugin_database_table()
{
    global $table_prefix, $wpdb;

    $tblname = 'subscriptions';
    $wp_track_table = $table_prefix . "$tblname";

    #Check to see if the table exists already, if not, then create it

    $t =  $wpdb->get_var( "show tables like '$wp_track_table'" );

    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) 
    {
        $sql = "CREATE TABLE IF NOT EXISTS `". $wp_track_table . "` ( ";
        $sql .= "  `id`  int(11)   NOT NULL auto_increment, ";
        $sql .= "  `user_id` int(11) NOT NULL, ";
        $sql .= "  `customer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, ";
        $sql .= "  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, ";
        $sql .= "  `stripe_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, ";
        $sql .= " `stripe_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL, ";
        $sql .= " `stripe_plan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL, ";
        $sql .= " `quantity` int(11) DEFAULT NULL, ";
        $sql .= " `trial_ends_at` timestamp NULL DEFAULT NULL, ";
        $sql .= " `ends_at` timestamp NULL DEFAULT NULL, ";
        $sql .= " `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP, ";
        $sql .= " `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP, ";
        $sql .= "  PRIMARY KEY (`id`) USING BTREE"; 
        $sql .= ") ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC; ";

        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }
}

add_filter('manage_plan_posts_columns', 'manage_plan_posts_columns_handler', 10, 1);
function manage_plan_posts_columns_handler($columns) {
    $columns['API'] = 'API ID';
    $columns['GOOD'] = '商品 ID';
    return $columns;
}

add_action('manage_plan_posts_custom_column', 'manage_plan_posts_custom_column_handler', 10, 2);
function manage_plan_posts_custom_column_handler($column, $post_id) {
    switch ( $column ) {
        case 'API' :
            $terms = get_field( 'api_id', $post_id);
            if ( is_string( $terms ) )
                echo $terms;
            else
                echo '';
            break;
        case 'GOOD' :
            $terms = get_field( 'good_id', $post_id);
            if ( is_string( $terms ) )
                echo $terms;
            else
                echo '';
            break;
        default:
        break;
    }
}

add_action('init', 'admin_action_stripe_webhook_handler', 1000, 2);
function admin_action_stripe_webhook_handler() {
    global $pagenow;
    global $_POST;
    global $_GET;

    if (! isset( $_GET['action'] ) || $_GET['action'] != 'stripe_webhook') {
        return;
    }

    $payload = @file_get_contents('php://input');
    $event= json_decode( $payload, FALSE );

    print_log('functions.php', 'admin_action_stripe_webhook_handler', 'event->type', $event->type);
    $status = $event->data->object->status;

    if(isset($event->id)) {
        try {
            $event_id = $event->id;
            $type = $event->type;

            global $table_prefix;
            global $wpdb;

            $table_name = $table_prefix . "subscriptions";
            switch($type) {
                // 定期購読の支払いが完了
                case 'invoice.payment_succeeded':
                    $user_id = get_user_by( 'email', $event->data->object->customer_email );
                    $wpdb->insert($table_name, array(
                        'user_id'       => $user_id->ID,
                        'customer'      => $event->data->object->customer,
                        'name'          => $event->data->object->customer_name,
                        'stripe_id'     => $event->data->object->subscription,
                        'stripe_status' => $event->data->object->status,
                        'stripe_plan'   => $event->data->object->lines->data[0]->plan->id,
                        'quantity'      => 1,
                        'trial_ends_at' => $event->data->object->lines->data[0]->plan->trial_period_days,
                        'ends_at'       => date("Y/m/d H:i:s", $event->data->object->lines->data[0]->period->end),
                    ));
                    break;
                // 定期購読がキャンセル
                case 'customer.subscription.deleted':
                break;
                // 定期購読がアップデート
                case 'customer.subscription.updated':
                    $cancel_at_period_end = $event->data->object->cancel_at_period_end;
                    $stripe_id = $event->data->object->id;
                    $trial_period_days = $event->data->object->current_period_end;

                    print_log('functions.php', '1', 'cancel_at_period_end', $cancel_at_period_end);
                    print_log('functions.php', '1', 'stripe_id', $stripe_id);
                    print_log('functions.php', '1', 'trial_period_days', $trial_period_days);

                    if ($cancel_at_period_end) {
                        $wpdb->update(
                            $table_name,
                            array(
                                'stripe_status' => 'cancel',
                            ),
                            array(
                                'stripe_id' => $stripe_id
                            )
                        );
                    } else {
                        $wpdb->update(
                            $table_name,
                            array(
                                'ends_at' => date("Y/m/d H:i:s", $trial_period_days),
                            ),
                            array(
                                'stripe_id' => $stripe_id
                            )
                        );
                    }
                    break;
                default:
                break;
            }
            
        } catch (Exception $e) {
            print_log('functions.php', 'admin_action_stripe_webhook_handler', $event->type, $e);
            // something failed, perhaps log a notice or email the site admin
        }
    }

    exit;
}