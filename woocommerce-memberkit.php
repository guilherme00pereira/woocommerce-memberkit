<?php
/*
 * Plugin Name: WooCommerce MemberKit
 * Plugin URI: http://www.woothemes.com/products/woocommerce-memberkit/
 * Description: WooCommerce integration with MemberKit.
 * Version: 0.0.2
 * Author: G28 - Guilherme Pereira
 * Author URI: http://www.g28.com.br
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WooCommerce fallback notice.
 *
 * @since 0.0.1
 */
function woocommerce_memberkit_fallback_notice() {
	echo '<div class="error"><p>' . sprintf( __( 'WooCommerce MemberKit depends on the last version of %s to work!', 'woocommerce-memberkit' ), '<a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce</a>' ) . '</p></div>';
}

/**
 * Load functions.
 *
 * @since 0.0.1
 */
function woocommerce_memberkit_init() {
	// Checks if WooCommerce is installed.
	if ( ! class_exists( 'WC_Integration' ) ) {
		add_action( 'admin_notices', 'woocommerce_memberkit_fallback_notice' );

		return;
	}
}

add_action( 'plugins_loaded', 'woocommerce_memberkit_init' );