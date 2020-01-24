<?php

//my_wp_list_table_{table_name} like  my_wp_list_table_customer

add_action( 'admin_menu', 'my_wp_list_table_customer_admin_menu_page_fun');
function my_wp_list_table_customer_admin_menu_page_fun(){

    $hook = add_menu_page( 'My WP List Table', 'My WP List Table', 'manage_options', 'my-wp-list-table', 'my_wp_list_table_customer_admin_menu_fun');

    add_action( "load-$hook", 'my_wp_list_table_customer_add_option');


}

function my_wp_list_table_customer_admin_menu_fun(){
?>
    <div class="wrap">
        <a href="http://127.0.0.1/wordpress521/wp-admin/admin.php?page=my-wp-list-table&action=add">Add</a>
        <?php
            global $wpdb;

            if ($_GET['action'] == 'add') {

                ?>
                <h2>Add Customer</h2>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

                    <input type="text" name="name" placeholder="Name" value=""> <br>

                    <input type="text" name="address" placeholder="Address" value=""> <br>

                    <input type="text" name="city" placeholder="City" value=""> <br>

                    <input type="hidden" name="action" value="my_wp_list_table_customer_Form_Action">

                    <input type="hidden" name="mode" value="add">

                    <button name="btn_smt">Submit</button>

                </form>
                <?php
               
            }else if ($_GET['action'] == 'edit') {

                $result = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}customers WHERE ID=".$_GET['customer']);
                $name = $result[0]->name;
                $address = $result[0]->address;
                $city = $result[0]->city;

                ?>
                 <h2>Edit Customer</h2>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

                    <input type="text" name="name" placeholder="Name" value="<?php echo $name?>"> <br>

                    <input type="text" name="address" placeholder="Address" value="<?php echo $address?>"> <br>

                    <input type="text" name="city" placeholder="City" value="<?php echo $city?>"> <br>

                    <input type="hidden" name="customer" value="<?php echo $_GET['customer'];?>">

                    <input type="hidden" name="mode" value="edit">

                    <input type="hidden" name="action" value="my_wp_list_table_customer_Form_Action">

                    <button name="btn_smt">Submit</button>

                </form>
                <?php

               
            }else{

                $exampleListTable = new MyWpListTableCustomer();
                ?>
                <h2>List</h2>
                <form method="post">
                    <?php
                    $exampleListTable->prepare_items();
                    $exampleListTable->search_box("Search Post(s)", "search_post_id");
                    $exampleListTable->display(); 
                    ?>
                </form>
                <?php

            }
        ?>
    </div>
<?php
}







add_action('admin_post_my_wp_list_table_customer_Form_Action', 'my_wp_list_table_customer_Form_Action');
add_action('admin_post_nopriv_my_wp_list_table_customer_Form_Action', 'my_wp_list_table_customer_Form_Action');
function my_wp_list_table_customer_Form_Action(){

    global $wpdb;

    if ($_POST['mode'] == 'add') { 

        $wpdb->insert( 
            "{$wpdb->prefix}customers", 
            array( 
                'name' => $_POST['name'], 
                'address' => $_POST['address'],
                'city' => $_POST['city']
                ), 
            array( 
                '%s',   
                '%s',
                '%s'    
            )
        ); 

        $lastid = $wpdb->insert_id;  

    }  


    if ($_POST['mode'] == 'edit') {

        $wpdb->update( 
            "{$wpdb->prefix}customers", 
            array( 
                'name' => $_POST['name'], 
                'address' => $_POST['address'],
                'city' => $_POST['city']
            ), 
            array( 'ID' => $_POST['customer'] ), 
            array( 
                '%s',   
                '%s',
                '%s'    
            ), 
            array( '%d' ) 
        );

        $lastid = $_POST['customer'];
        
    }

    $delete_nonce = wp_create_nonce( 'sp_delete_customer' );
    
    $redirect_url = admin_url().'admin.php?page=my-wp-list-table&action=edit&customer='.$lastid;

    wp_redirect($redirect_url);
    die();


}






function my_wp_list_table_customer_add_option() {

   $option = 'per_page';
 
	$args = array(
	    'label' => 'Movies',
	    'default' => 10,
	    'option' => 'customer_list_per_page'
	);
	 
	add_screen_option( $option, $args );

}


add_filter('set-screen-option', 'my_wp_list_table_customer_set_option', 10, 3);
 
function my_wp_list_table_customer_set_option($status, $option, $value) {
 
    if ( 'customer_list_per_page' == $option ) return $value;
 
    return $status;
 
}