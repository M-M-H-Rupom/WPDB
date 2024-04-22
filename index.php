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
   <button class="wpdb_button" data-task="insert_data"> Add data </button>
   <button class="wpdb_button" data-task="update_data"> Update data </button>
   <h2 class='show_first_data'> </h2>
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

        }
    }
});
?>