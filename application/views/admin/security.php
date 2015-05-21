
	<!-- 960 Container -->
	<div class="container">
		
			<div class="twelve columns">
				<h3 class="page_headline">User Manager</h3>
<div class="row-fluid">
						<div class="span12">
							<table class="table table-bordered table-striped table_vam" id="dt_gal">
								<thead>
									<tr>
										<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>
										<th>Username</th>
										<th>Email</th>
										<th>Joined</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($users as $user): ?>
									<tr>
										<td><input type="checkbox" name="row_sel" class="row_sel" /></td>
										<td><?php echo $user->username ?></td>
										<td><?php echo $user->email ?></td>
										<td><?php echo $user->created ?></td>
										<td>
											<a href="/admin/users/edit/<?php echo $user->id ?>" class="sepV_a" title="Edit">Edit</a> | 
											<a href="/admin/users/view/<?php echo $user->id ?>" class="sepV_a" title="View">View</a> | 
											<a href="/admin/users/delete/<?php echo $user->id ?>" title="Delete">Delete</a>
										</td>
									</tr>
									<?php endforeach ?>
									
								</tbody>
							</table>
							
						</div>
					</div>

			</div>
			<div class="four columns"><h3 class="page_headline">Add new user</h3>
					<form method="post" id="page-contact" action="/admin/add_user">
							<input type="hidden" name="password" value="<?php echo 'FN' . print rand(1487646, 10400000); ?>" name="action">
							<div>
								<label style="margin-top: 0" for="name">Username:</label>
								<input type="text" value="" maxlength="60" size="40" class="contact_text" id="username" name="username">
							</div>
							<br/>
							<div>
								<label for="email">Email: <span>*</span></label>
								<input type="text" value="" maxlength="60" size="40" class="contact_text validate['required','email']" id="email" name="email">
							</div>
							<br/>	
							<div>
								<label for="role">Role: <span>*</span></label>
								<select name="role" class="contact_text">
									<?php foreach ($roles as $role): ?>
										<option value="<?php echo $role->id ?>"><?php echo $role->role_name ?></option>
									<?php endforeach ?>
								</select>	
							</div>
							<div class="send_button">
								<input type="submit" value="Add user" id="submit_btn" name="submit" class="contact_submit">
								<input type="hidden" value="send" name="action">
							</div>
							<span class="no_error">An email will be sent to the new user with login details.</span>	
						</form>
			</div>
			
	</div>
	<!-- End 960 Container -->

	<!-- Invisible Spacer -->
	<div class="container clearfix spacer"></div>