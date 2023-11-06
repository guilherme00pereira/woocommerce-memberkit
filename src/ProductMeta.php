<?php

namespace G28\WoocommerceMemberkit;

class ProductMeta
{

	public function __construct()
	{
		add_action('add_meta_boxes', [$this, 'memberkit_wc_product_metabox']);
		add_action('woocommerce_process_product_meta', [$this, 'memberkit_wc_product_custom_fields_save']);
	}

	public function memberkit_wc_product_metabox()
	{
		add_meta_box(
			'memberkit_wc_product_metabox',
			__('MemberKit'),
			[$this, 'memberkit_wc_product_custom_fields'],
			'product',
			'normal',
			'high'
		);
	}

	public function memberkit_wc_product_custom_fields($post)
	{
		$classrooms = $this->get_memberkit_classrooms();
		$enable_memberkit = empty(get_post_meta($post->ID, 'enable-memberkit', true)) ? "0" : "1";
		$selected_classroom = get_post_meta($post->ID, 'memberkit_ext_classroom_id_field', true);
		ob_start();
		include_once sprintf("%smemberkit-options.php", Plugin::getInstance()->getTemplateDir());
		echo ob_get_clean();
	}

	public function memberkit_wc_product_custom_fields_save($post_id)
	{
		$enable_memberkit = $_POST['enable-memberkit'];
		if ($enable_memberkit === "1") {
			$classroom_id = $_POST['memberkit_ext_classroom_id_field'];
			if (!empty($classroom_id)) {
				update_post_meta($post_id, 'memberkit_ext_classroom_id_field', esc_attr($classroom_id));
			}
		}
		update_post_meta($post_id, 'enable-memberkit', esc_attr($enable_memberkit));
	}

	private function get_memberkit_classrooms(): array
	{
		$classes = [];
		$memberkit = new Memberkit();
		$classrooms = $memberkit->getClassroms();
		if (is_null($classrooms)) {
			$classes['0'] = ['Nenhuma turma encontrada'];
		} else {
			foreach ($classrooms as $classroom) {
				$classes[$classroom->id] = $classroom->name;
			}
		}
		return $classes;
	}
}