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
