<?php

namespace G28\WoocommerceMemberkit;

class Admin
{
	public function __construct(  )
	{
		add_action( 'admin_menu', array( $this, 'add_admin_submenu' ) );
		add_action( 'woocommerce_order_status_changed', [ $this, 'send_new_user_memberkit' ], 99, 3 );
	}

	public function add_admin_submenu(): void
    {
        add_submenu_page(
			'woocommerce',
            'Memberkit',
            'Memberkit',
            'manage_options',
            'woocommerce-memberkit',
            array( $this, 'display_admin_page'),
            99
        );
    }

	public function display_admin_page()
	{
		ob_start();
		include_once sprintf( "%s/templates/settings.php", MEMBERKIT_PLUGIN_PATH);
		echo ob_get_clean();
	}

	public function send_new_user_memberkit( $order_id, $old_status, $new_status )
    {
        if( 'processing' === $new_status )
        {
	        $classrooms_ids = [];
	        $order          = wc_get_order( $order_id );
	        $name = $order->get_billing_first_name() . " " . $order->get_billing_last_name();
	        $mail = $order->get_billing_email();

	        foreach ( $order->get_items() as $item ) {
                $pid = $item->get_product_id();
                $id = get_post_meta( $pid , 'memberkit_ext_classroom_id_field', true );
		        array_push( $classrooms_ids, $id );
	        }

            $ids            = implode( ',', $classrooms_ids );
			$memberkit = new Memberkit();
            $memberkit->addUser( $name, $mail, $ids );
        }
    }

}