<?php
/**
 * Plugin Name:       Oxford School
 * Plugin URI:        https://www.fiverr.com/errorfix
 * Description:       Oxford School Settings WordPress Plugin.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      5.6
 * Author:            Moktadirul, Whatsapp/Telegram: +8801718169591
 * Author URI:        https://www.wdctheme.us
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       int-researcher
 * Domain Path:       /languages
 */
 
 
 
/**
 * Enqueue scripts and styles
 */

include ('inc/update_access_token.php');
include ('inc/settings.php');
include('inc/assets.php');
include('inc/admin_script.php');
include('inc/short_code/get_results.php');
include('inc/short_code/newsletter.php');
include('inc/short_code/get_employee.php');
include('inc/short_code/get_merit_list.php');


add_shortcode('oxford_admission_results','get_results');
add_shortcode('oxford_newsletter','get_newsletter');
add_shortcode('oxford_employee','get_employee');

add_shortcode('oxford_merit_list','get_merit_list');