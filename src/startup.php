<?php

namespace G28\WoocommerceMemberkit;

if (!function_exists(__NAMESPACE__ . 'runPlugin')) {
    function runPlugin(): void
    {
        $plugin_path = trailingslashit(WP_PLUGIN_DIR) . 'woocommerce/woocommerce.php';
        if (!in_array($plugin_path, wp_get_active_and_valid_plugins())) {
            add_action('admin_notices', 'woocommerce_memberkit_fallback_notice');
            return;
        }

        add_action('plugins_loaded', function () {
            new Admin();
            new UserMeta();
			new ProductMeta();
        });
    }

}

function woocommerce_memberkit_fallback_notice()
{
    echo '<div class="error"><p>' . sprintf(__('WooCommerce MemberKit depends on the last version of %s to work!', Plugin::getInstance()->getTextDomain()), '<a href="http://wordpress.org/extend/plugins/woocommerce/">WooCommerce</a>') . '</p></div>';
}