<?php

namespace G28\WoocommerceMemberkit;

class Admin
{
	public function __construct()
	{
		add_action('admin_menu', array($this, 'add_admin_submenu'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('woocommerce_order_status_changed', [$this, 'send_new_user_memberkit'], 99, 3);
	}

	public function add_admin_submenu(): void
	{
		add_submenu_page(
			'woocommerce',
			'Memberkit',
			'Memberkit',
			'manage_options',
			'woocommerce-memberkit',
			array($this, 'display_admin_page'),
			99
		);
	}

	public function display_admin_page()
	{
		ob_start();
		include_once sprintf("%ssettings.php", Plugin::getInstance()->getTemplateDir());
		echo ob_get_clean();
	}

	public function enqueue_scripts()
	{
		wp_enqueue_style(
			Plugin::getInstance()->getAssetsPrefix() . 'admin',
			Plugin::getInstance()->getAssetsUrl() . '/css/admin.css'
		);
		wp_enqueue_script(
			Plugin::getInstance()->getAssetsPrefix() . 'admin',
			Plugin::getInstance()->getAssetsUrl() . '/js/admin.js',
			array('jquery'),
			Plugin::getInstance()->getVersion(),
			true
		);
	}

	public function send_new_user_memberkit($order_id, $old_status, $new_status)
	{
		if ('processing' === $new_status) {
			$order = wc_get_order($order_id);
			$name = $order->get_billing_first_name() . " " . $order->get_billing_last_name();
			$mail = $order->get_billing_email();
			foreach ($order->get_items() as $item) {
				$products_names[] = $item->get_name();
				$pid = $item->get_product_id();
				$enable_memberkit = get_post_meta($pid, 'enable-memberkit', true);
				if ($enable_memberkit !== "1") {
					continue;
				} else {
					$classrooms_ids = get_post_meta($pid, 'memberkit_ext_classroom_id_field', true);
					if (!empty($classrooms_ids)) {
						$ids = implode(',', $classrooms_ids);
						$names = implode(',', $products_names);
						$memberkit = new Memberkit();
						$memberkit->addUser($name, $mail, $ids, $names);
					}
				}

			}

		}
	}

}