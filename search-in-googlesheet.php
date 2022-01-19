<?php

/*
Plugin Name:  Search-In-GoogleSheet
Version: 1.0
Description: Enable to search in google spreadsheet.
Author: リンセン
Author URI: 
License: GPLv2 or later
License URI: 
Text Domain: exportpdfrs
*/

define( 'MY_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'MY_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
define( 'MY_HOME_URL', get_home_url() );

require_once MY_PLUGIN_PATH . 'functions.php';

// PDFページテンプレートを適用
function catch_plugin_template($template) {
    if( is_page_template('searchingoogle_page.php') ) {
        $template = MY_PLUGIN_PATH . '/page-template/searchingoogle_page.php';
    }
    
    if (is_page('plans')) {
        $template = MY_PLUGIN_PATH . '/page-template/plan-list.php';
    }

    if (is_page('thanks')) {
        $template = MY_PLUGIN_PATH . '/page-template/thanks.php';
    }

    if (is_page('cancel')) {
        $template = MY_PLUGIN_PATH . '/page-template/cancel.php';
    }
    return $template;
}
// Filter page template
add_filter('page_template', 'catch_plugin_template');

// プラグインをアクティブするときにページを作成
register_activation_hook( __FILE__ , 'my_plugin_install');
function my_plugin_install() {
    global $wpdb;

    $the_page_title = '検索ページ';
    $the_page_name = 'search-page';

    delete_option("sgs_plugin_page_title");
    add_option("sgs_plugin_page_title", $the_page_title, '', 'yes');

    delete_option("sgs_plugin_page_name");
    add_option("sgs_plugin_page_name", $the_page_name, '', 'yes');

    delete_option("sgs_plugin_page_id");
    add_option("sgs_plugin_page_id", '0', '', 'yes');

    $the_page = get_page_by_title( $the_page_title );

    if ( ! $the_page ) {
        $the_page = array(
            'post_title'    => $the_page_title,
            'post_content'  => "",
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'comment_status' => 'closed',
            'ping_status'   => 'closed',
            'post_category' => array(1),
            'menu_order'    => 1000,
            'post_name'     => $the_page_name,
        );

        $post_id = wp_insert_post( $the_page );
    } else {
        $post_id = $the_page->ID;

        $the_page->post_status = 'publish';
        $post_id = wp_update_post( $the_page );
    }
    update_post_meta( $post_id, '_wp_page_template', 'searchingoogle_page.php' );

    delete_option( 'sgs_plugin_page_id' );
    add_option( 'sgs_plugin_page_id', $post_id );

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

/* Runs on plugin deactivation */
register_deactivation_hook( __FILE__, 'my_plugin_remove') ;
function my_plugin_remove() {
    global $wpdb;
    $the_page_title = get_option( "sgs_plugin_page_title" );
    $the_page_name = get_option( "sgs_plugin_page_name" );

    $the_page_id = get_option( 'sgs_plugin_page_id' );
    if( $the_page_id ) {
        wp_delete_post( $the_page_id ); // this will trash, not delete
    }

    delete_option("sgs_plugin_page_title");
    delete_option("sgs_plugin_page_name");
    delete_option("sgs_plugin_page_id");
}

?>