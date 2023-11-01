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
			'side',
			'core'
		);
	}

	public function memberkit_wc_product_custom_fields()
	{
		$classrooms = $this->get_memberkit_classrooms();
		ob_start();
		?>
		<div class="options_group">
			<?php
			woocommerce_wp_select(
				[
					'id' => 'memberkit_ext_classroom_id_field',
					'label' => __('Classroom'),
					'type' => 'select',
					'options' => ['1' => '1', '2' => '2']
				]
			);
			?>
		</div>
		<?php
		echo ob_get_clean();
	}

	public function memberkit_wc_product_custom_fields_save($post_id)
	{
		$classroom_id = $_POST['memberkit_ext_classroom_id_field'];
		if (!empty($classroom_id)) {
			update_post_meta($post_id, 'memberkit_ext_classroom_id_field', esc_attr($classroom_id));
		}

	}

	private function get_memberkit_classrooms()
	{
		$classes = [];
		$memberkit = new Memberkit();
		$classrooms = $memberkit->getClassrooms();
		if (count($classrooms) == 0) {
			return $classes['0'] = ['Nenhuma turma encontrada'];
		} else {
			foreach ($classrooms as $classroom) {
				$classes[$classroom->id] = $classroom->name;
			}
			return $classes;
		}
	}
}