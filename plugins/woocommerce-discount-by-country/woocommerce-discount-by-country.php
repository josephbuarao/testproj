<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/**
 * Plugin Name: WooCommerce Discount By Country
 * Description: This is a woocommerce plugin where you can set specific discount per country
 * Author:      Joseph P. Buarao
 * Author URI:  https://josephbuarao.com/
 * Version: 1.0
 * Author: Your Name
 * License: GPL2
 */

// Include the main plugin class
require_once __DIR__.'/vendor/autoload.php';
require_once(plugin_dir_path(__FILE__) . 'includes/class-plugin-settings.php');
require_once(plugin_dir_path(__FILE__) . 'includes/class-woo-discount-by-country.php');

// Instantiate the plugin class
$proj_plugin = new TestProject();