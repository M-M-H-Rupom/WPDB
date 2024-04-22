<?php
/**
 * Plugin Name: WPDB 
 * Author: Rupom
 * Description: Plugin description
 * Version: 1.0
 */

//  function dbdelta_callback(){
//     global $wpdb;
//     $table_name = $wpdb->prefix.'persons';
//     $sql = "CREATE TABLE {$table_name}(
//         id INT NOT NULL AUTO_INCREMENT,
//         p_name VARCHAR(250),
//         email VARCHAR(200),
//         PRIMARY KEY (id)
//     )" ;
//     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
//     dbDelta( $sql );
// }
// register_activation_hook(__FILE__, 'dbdelta_callback');

function wpdb_enqueue_scripts(){
    wp_enqueue_style( 'wpdb_css', plugin_dir_url( __FILE__ ).'/assets/css/style.css',null);
    wp_enqueue_script( 'wpdb_js',plugin_dir_url( __FILE__ ).'/assets/js/main.js', array('jquery'), time(), true );
    $action = 'wpdb_protected';
    $wpdb_nonce = wp_create_nonce($action);
    wp_localize_script('wpdb_js', 'wpdb_data',array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'user_name' => 'rupom',
        'wpdb_nonce' => $wpdb_nonce
    ));
}
add_action( 'admin_enqueue_scripts','wpdb_enqueue_scripts');

function menu_wpdb_callback(){
   ?>
    <div class="buttons_parent">
        <button class="wpdb_button" data-task="insert_data"> Add data </button>
        <button class="wpdb_button" data-task="update_data"> Update data </button>
        <button class="wpdb_button" data-task="single_row"> Load single row </button>
        <button class="wpdb_button" data-task="double_row"> Load multiple row </button>
        <button class="wpdb_button" data-task="multiple_insert"> Add multiple data </button>
        <button class="wpdb_button" data-task="single_col"> Add single column </button>
        <button class="wpdb_button" data-task="delete_data"> Delete data </button>
    </div>
   <h2 class='show_first_data'> </h2>
   <h2 class='show_more_data'> </h2>
   <h2 class=''> </h2>
   <?php
}
add_action( 'admin_menu',function(){
    add_menu_page('wpdb_demo', 'Wpdb_demo', 'manage_options', 'wpdbdemo', 'menu_wpdb_callback');
});
// 

 
add_action( 'wp_ajax_wpdb_action', function(){
    global $wpdb;
    $table_name = $wpdb->prefix.'persons';
    if( wp_verify_nonce($_POST['wpdb_nonce'], 'wpdb_protected')){
        if('insert_data' == $_POST['task']){
            $f_person = [
                'p_name' => 'jane',
                'email' => 'jane@gmail.com'
            ];
            $wpdb->insert($table_name, $f_person);
            wp_send_json('added');
        }elseif('update_data' == $_POST['task']){
            $wpdb->update($table_name,array('p_name' => 'jane deo'),array('id'=> 88));
            wp_send_json('updated');
        }elseif('single_row' == $_POST['task']){
            $row_data = $wpdb->get_row("SELECT * FROM {$table_name} WHERE id=88 ");
            wp_send_json($row_data);
        }elseif('double_row' == $_POST['task']){
            $multiple_data = $wpdb->get_results("SELECT * FROM {$table_name}",ARRAY_A);
            wp_send_json($multiple_data);
        }elseif('multiple_insert' == $_POST['task']){
            $more_persons = [
                [
                    'p_name' => 'jimmy',
                    'email' => 'jimmy@gmail.com'
                ],
                [
                    'p_name' => 'jimmy deo',
                    'email' => 'jimmydeo@gmail.com'
                ]
            ];
            foreach($more_persons as $a_persons){
                $wpdb->insert($table_name,$a_persons);
            }
            wp_send_json('add multiple');
        }elseif('single_col' == $_POST['task']){
            $col_query = ("SELECT email FROM {$table_name}");
            $result = $wpdb->get_col($col_query);
            wp_send_json($result);
        }elseif('delete_data' == $_POST['task']){
            $wpdb->delete($table_name,['id'=> 88]);
            wp_send_json('deleted');
        }
    }
});
?>