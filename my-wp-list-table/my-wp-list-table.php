<?php

/*
Plugin Name: My WP List Table
Description: This is the My WP List Table plugin
Author: Dev
Text Domain: my-wp-list-table
*/

//prefix: MyWpListTable

defined( 'ABSPATH' ) or die();

define( 'MyWpListTable_VERSION', '1.0.0' );
define( 'MyWpListTable_URL', plugin_dir_url( __FILE__ ) );
define( 'MyWpListTable_PATH', plugin_dir_path( __FILE__ ) );

require_once 'wp-list-table/wp_list_table_customer.php';
require_once 'wp-list-table/customer_admin_menu.php';


/*add_action("admin_menu", "my_add_menu_items");
function my_add_menu_items(){
    add_submenu_page("my-wp-list-table", "Test Page", "Test Page", "edit_posts", "svh-item", "display_my_test_page");
}

function display_my_test_page(){

    do_meta_boxes("my-wp-list-table", "normal", null);
}

add_action("load-my-wp-list-table_page_svh-item", "my_add_metaboxes");
function my_add_metaboxes(){
    add_meta_box("my-wp-list-table-metabox", "My CPT Metabox", "display_my_metabox", "my-wp-list-table", "normal", "core");
}

function display_my_metabox(){
    echo "Hello";
}*/




