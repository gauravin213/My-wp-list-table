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

                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display: none;">

                    <div id="poststuff">
                          <div id="post-body" class="metabox-holder columns-1">

                            <div id="postbox-container-2" class="postbox-container">
                              <!--normal-->
                              <?php //do_meta_boxes("my-wp-list-table", "normal", null); ?>
                            </div>


                            <div id="postbox-container-1" class="postbox-container">
                              <!--side-->
                              <?php //do_meta_boxes("my-wp-list-table", "side", null); ?>
                            </div>

                          </div>

                    </div>

                  </form>


                <h2>Edit Customer</h2>
                <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">

                    <input type="text" name="name" placeholder="Name" value="<?php echo $name?>" class="large-text="> <br>

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

                <h1 class="wp-heading-inline">Customer</h1>
                <a href="<?php echo admin_url();?>admin.php?page=my-wp-list-table&action=add" class="page-title-action">Add New</a>
                <hr class="wp-header-end">

                <form method="post">
                    <?php
                    $exampleListTable->prepare_items();
                    $exampleListTable->views();
                    $exampleListTable->search_box("Search Post(s)", "search_post_id");
                    $exampleListTable->display(); 
                    ?>
                </form>
                <?php

            }
        ?>
    </div>
    <div class="clear"></div>
<?php
}





function my_wp_list_table_customer_add_option() {

    //add_meta_box("my-wp-list-table-metabox", "My CPT Metabox", "display_my_metabox", "my-wp-list-table", "normal");

    $option = 'per_page';
 
	$args = array(
	    'label' => 'Customer',
	    'default' => 10,
	    'option' => 'customer_list_per_page'
	);
	 
	add_screen_option( $option, $args );

    $exampleListTable = new MyWpListTableCustomer();

}


//
function display_my_metabox(){
    
    ?>
    <table class="tablepress-postbox-table fixed">
    <tbody>
        <tr class="bottom-border">
            <th class="column-1" scope="row"><label for="table-new-id">Table ID:</label></th>
            <td class="column-2">
                <input type="hidden" name="table[id]" id="table-id" value="1">
                <input type="text" name="table[new_id]" id="table-new-id" value="1" title="The Table ID can only consist of letters, numbers, hyphens (-), and underscores (_)." pattern="[A-Za-z0-9-_]+" required="">
                <div style="float: right; margin-right: 1%;"><label for="table-information-shortcode">Shortcode:</label>
                <input type="text" id="table-information-shortcode" class="table-shortcode" value="[table id=1 /]" readonly="readonly"></div>
            </td>
        </tr>
        <tr class="top-border">
            <th class="column-1" scope="row"><label for="table-name">Table Name:</label></th>
            <td class="column-2"><input type="text" name="table[name]" id="table-name" class="large-text" value="demo_tb"></td>
        </tr>
        <tr class="bottom-border">
            <th class="column-1 top-align" scope="row"><label for="table-description">Description:</label></th>
            <td class="column-2"><textarea name="table[description]" id="table-description" class="large-text" rows="4"></textarea></td>
        </tr>
        <tr class="top-border">
            <th class="column-1" scope="row">Last Modified:</th>
            <td class="column-2"><span id="last-modified">January 25, 2020 2:53 pm</span> by <span id="last-editor">admin</span></td>
        </tr>
    </tbody>
    </table>
    <?php
}
//



add_filter('set-screen-option', 'my_wp_list_table_customer_set_option', 10, 3);
 
function my_wp_list_table_customer_set_option($status, $option, $value) {
 
    if ( 'customer_list_per_page' == $option ) return $value;
 
    return $status;
 
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
                'city' => $_POST['city'],
                'status' => 'publish' 
                ), 
            array( 
                '%s',   
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