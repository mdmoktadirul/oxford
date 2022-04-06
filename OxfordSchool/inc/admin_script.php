<?php


add_action("wp_ajax_set_token",function(){
    update_option('token_set_at', time());
    update_option( 'oxford_username', $_POST['oxford_username']);
    update_option( 'oxford_password', $_POST['oxford_password']);
    update_option( 'oxford_access_token', $_POST['oxford_access_token']);
    die();
});

add_action('admin_enqueue_scripts', 'custom_script_in_admin');