<?php

function oxford_style_and_scripts() {
    // wp_enqueue_style('bootstrap.min', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css');
    // wp_enqueue_style('datatables', 'https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css');
   
    // wp_enqueue_script('jquery.slim.min', 'https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js', array(), '3.5.1', true);
    // wp_enqueue_script('popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js', array(), '1.16.1', true);
    // wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js', array(), '4.6.1', true);
	// wp_enqueue_script('datatables', 'https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js', array('jquery'), '1.10.21', true);
	wp_enqueue_script('custom-js', plugin_dir_url( __FILE__ ) .'../js/custom.js', array('jquery'), '1.10.21', true);
}
add_action( 'wp_enqueue_scripts', 'oxford_style_and_scripts' );

function custom_script_in_admin($hook) {
   wp_register_script( 'app_js',plugin_dir_url( __FILE__ ) .'./../js/app.js', array('jquery'), '1.10.21', true );
   wp_enqueue_script('app_js');

   $datatoBePassed = array(
    'plugin_dir'            => plugin_dir_url( __FILE__ ),
    'home_url' => get_home_url(),
    'ajax_url' => admin_url( 'admin-ajax.php' ),
);
wp_localize_script( 'app_js', 'js_handler', $datatoBePassed );
}