<?php
/*
 * Plugin Name: WooCommerce MemberKit
 * Plugin URI: #
 * Description: WooCommerce integration with MemberKit.
 * Version: 0.1.2
 * Author: G28 - Guilherme Pereira
 * Author URI: http://www.g28.com.br
 *
 */

 if ( ! defined( 'ABSPATH' ) ) exit;

 require "vendor/autoload.php";
 
 use function G28\WoocommerceMemberkit\runPlugin;
 
 runPlugin(__FILE__);