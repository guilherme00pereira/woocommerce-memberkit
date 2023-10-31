<?php

namespace G28\WoocommerceMemberkit;

class Admin
{
	public function __construct(  )
	{
		add_action( 'admin_menu', array( $this, 'settings_page' ) );
	}
}