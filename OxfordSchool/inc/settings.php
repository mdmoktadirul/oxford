<?php


/**
 * Plugin settings page
 */
function oxford_school_register() {
    
    // register a new section
    add_settings_section(
        'oxford_school_settings_section', 
        __('Oxford School Settings', 'oxford-school-init'), 'oxford_school_section_text', 
        'oxford_school_section'
    );

    // register a new field in the "oxford_school_settings_section" section
    add_settings_field(
        'oxford_username', 
        __('Username','oxford-school-init'), 
        'oxford_username_field_callback', 
        'oxford_school_section',  
        'oxford_school_settings_section'
    );

    add_settings_field(
      'oxford_password', 
      __('Password','oxford-school-init2'), 
      'oxford_password_field_callback', 
      'oxford_school_section',  
      'oxford_school_settings_section'
    );

  add_settings_field(
   'oxford_access_token', 
   __('Access Token','oxford-school-init3'), 
   'oxford_access_token_field_callback', 
   'oxford_school_section',  
   'oxford_school_settings_section'
    );

    // register a new setting for access token field
    register_setting('oxford_school_settings_section', 'oxford_username');
    register_setting('oxford_school_settings_section', 'oxford_password');
    register_setting('oxford_school_settings_section', 'oxford_access_token');

}
add_action('admin_init', 'oxford_school_register');


//Login redirect field content
function oxford_username_field_callback(){
    $oxford_username = get_option('oxford_username');
	printf('<input name="oxford_username" type="text" id="oxford_username" class="regular-text" value="%s"/>', $oxford_username);
}

function oxford_password_field_callback(){
   $oxford_password = get_option('oxford_password');
  printf('<input name="oxford_password" type="password" id="oxford_password" class="regular-text" value="%s"/>', $oxford_password);
}

function oxford_access_token_field_callback(){
   $oxford_access_token = str_shuffle(get_option('oxford_access_token'));
  printf('<input name="oxford_access_token" disabled id="oxford_access_token" type="text" class="regular-text" value="%s"/>', $oxford_access_token);
}

//Plugin settings page section text
function oxford_school_section_text() {
	printf('%s %s %s', '<p>', __('Please add username, password and generate Access Token', 'oxford-school-init'), '</p>');
}


//Register plugin admin menu
add_action('admin_menu', 'oxford_school_menu');
function oxford_school_menu() {
	add_menu_page(__('Oxford School', 'oxford-school-init'), __('Oxford School', 'oxford-school-init'), 'manage_options', 'oxford_school', 'oxford_school_output', 'dashicons-lock');
}

//Plugin options form
function oxford_school_output(){
    settings_errors();
    ?>
	<form action="options.php" method="POST" id="generateAccessToken">
		<?php do_settings_sections('oxford_school_section');?>
		<?php settings_fields('oxford_school_settings_section');?>
		<?php submit_button();?>
	</form>
<?php }


