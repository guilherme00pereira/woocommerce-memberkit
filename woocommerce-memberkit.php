<?php
/*
 * Plugin Name: WooCommerce MemberKit
 * Plugin URI: http://www.woothemes.com/products/woocommerce-memberkit/
 * Description: WooCommerce integration with MemberKit.
 * Version: 0.0.3
 * Author: G28 - Guilherme Pereira
 * Author URI: http://www.g28.com.br
 *
 */

 if ( ! defined( 'ABSPATH' ) ) exit;

 require "vendor/autoload.php";

 define('MEMBERKIT_PLUGIN_PATH', plugin_dir_path(__FILE__));
 define('MEMBERKIT_ROOT', __FILE__);
 
 use function G28\WoocommerceMemberkit\runPlugin;
 
 runPlugin();