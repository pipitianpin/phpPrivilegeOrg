<?php
if (!empty($use_username)) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
		'class' => 'login_text',
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class' => 'login_text',
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => 'login_text',
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
	'class' => 'login_text',	
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
	'class' => 'login_text',	
);
?>
<!-- 960 Container -->
<div class="container">
	<div class="twelve columns">
		<h3 class="page_headline">User Manager</h3>
			<div class="row-fluid">
				<div class="span12">
					<table class="table table-bordered table-striped table_vam" id="dt_gal">
						<thead>
							<tr>
								<!--<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>-->
								<th class="users_sort_th">Username
									<div class="users_sort <?php echo ($sortBy == 'username'?'showed_user_sort':''); ?>  <?php echo ($aOrD == 'asc'?'users_sort_asc':'users_sort_desc'); ?>"></div>
									<input type="hidden" class="users_sort_link" value="/admin/users/username/<?php echo (($sortBy == 'username'?($aOrD == 'asc'?'desc':'asc'):($aOrD == 'asc'?'asc':'desc'))) ?>" />
								</th>
								<th class="users_sort_th">Email
									<div class="users_sort <?php echo ($sortBy == 'email'?'showed_user_sort':''); ?>  <?php echo ($aOrD == 'asc'?'users_sort_asc':'users_sort_desc'); ?>"></div>
									<input type="hidden" class="users_sort_link" value="/admin/users/email/<?php echo (($sortBy == 'email'?($aOrD == 'asc'?'desc':'asc'):($aOrD == 'asc'?'asc':'desc'))) ?>" />
								</th>
								<th class="users_sort_th">Joined
									<div class="users_sort <?php echo ($sortBy == 'created'?'showed_user_sort':''); ?>  <?php echo ($aOrD == 'asc'?'users_sort_asc':'users_sort_desc'); ?>"></div>
									<input type="hidden" class="users_sort_link" value="/admin/users/created/<?php echo (($sortBy == 'created'?($aOrD == 'asc'?'desc':'asc'):($aOrD == 'asc'?'asc':'desc'))) ?>" />
								</th>
								<th class="users_sort_th">Role
									<div class="users_sort <?php echo ($sortBy == 'role'?'showed_user_sort':''); ?>  <?php echo ($aOrD == 'asc'?'users_sort_asc':'users_sort_desc'); ?>"></div>
									<input type="hidden" class="users_sort_link" value="/admin/users/role/<?php echo (($sortBy == 'role'?($aOrD == 'asc'?'desc':'asc'):($aOrD == 'asc'?'asc':'desc'))) ?>" />
								</th>
								<!--<th>Actions</th>-->
							</tr>
						</thead>
						<tbody>
							<?php foreach ($users as $user): ?>
							<tr>
								<!--<td><input type="checkbox" name="row_sel" class="row_sel" /></td>-->
								<td><?php echo $user->username ?></td>
								<td><?php echo $user->email ?></td>
								<td><?php echo $user->created ?></td>
								<td><?php echo $user->role ?></td>
								<!--<td>
									<?php if($this->tank_auth->is_logged_in() && $this->session->userdata('role_id') == 5) {?>
									<a href="/admin/users/edit/<?php echo $user->id ?>" title="Edit">Edit</a> |
									<a href="/admin/users/view/<?php echo $user->id ?>" title="">View</a> |
									<a href="/admin/users/delete/<?php echo $user->id ?>" title="Delete">Delete</a>
									<?php } ?>
								</td>-->
							</tr>
							<?php endforeach ?>
							
						</tbody>
					</table>
					
				</div>
			</div>

			</div>
			<div class="four columns"><h3 class="page_headline">Add new user</h3>
                <div style="padding: 10px 0;text-decoration: underline"><a href='/auth/register/'>Create a new user</a></div>
            </div>
	</div>
	<!-- End 960 Container -->

	<!-- Invisible Spacer -->
	<div class="container clearfix spacer"></div>
	<div class="container">
		<form id="search_pagination" method="post" action="">
		<input id="page_searchfield" type="hidden" name="searchfield" value="<?php echo isset($searchfield)?$searchfield:"" ?>" />
		</form>
		<br/>	<?php echo  $this->pagination->create_links() ?>	
	</div>
	
<script>
$(document).ready(function(){
	$('.users_sort_th').each(function(){
		var usersSortDOM = $(this).find('.users_sort');
		var userSortLinkDOM = $(this).find('.users_sort_link');
		$(this).bind('mouseover', function(){
			if (!usersSortDOM.hasClass('showed_user_sort')) {
				usersSortDOM.show();
			} else {
				if (usersSortDOM.hasClass('users_sort_asc')) {
					usersSortDOM.removeClass('users_sort_asc').addClass('users_sort_desc');
				} else {
					usersSortDOM.removeClass('users_sort_desc').addClass('users_sort_asc');
				}
			}
		});
		$(this).bind('mouseout', function(){
			if (!usersSortDOM.hasClass('showed_user_sort')) {
				usersSortDOM.hide();
			} else {
				if (usersSortDOM.hasClass('users_sort_asc')) {
					usersSortDOM.removeClass('users_sort_asc').addClass('users_sort_desc');
				} else {
					usersSortDOM.removeClass('users_sort_desc').addClass('users_sort_asc');
				}
			}
		});
		
		$(this).bind('click', function(){
			window.location.href = userSortLinkDOM.val();
		});
	});
});
</script>