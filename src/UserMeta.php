<?php

namespace G28\WoocommerceMemberkit;

class UserMeta {

	public function __construct()
	{
		add_action( 'show_user_profile', [ $this, 'show_memberkit_id_field' ] );
		add_action( 'edit_user_profile', [ $this, 'show_memberkit_id_field' ] );

	}

	public function show_memberkit_id_field( $user )
	{
		?>
			<h3>MemberKit</h3>
			<table class="form-table">
				<tr>
					<th>ID</th>
					<td>
						<?php echo get_user_meta( $user->ID, 'memberkit_user_id', true ) ?>
					</td>
				</tr>
			</table>
		<?php
	}

}