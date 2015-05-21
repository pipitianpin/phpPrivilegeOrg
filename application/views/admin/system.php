<!-- 960 Container -->
<div class="container">
		
			<div class="sixteen columns">
					<ul class="tabs-nav">
						<li class="active">
							<a href="#tab1">View Assets</a>
						</li>
						<li class="">
							<a href="#tab2">Add New Asset</a>
						</li>
					</ul>
					<div class="tabs-container">
						<div id="tab1" class="tab-content" style="display: block;">
							<div class="row-fluid">
							<div class="span12">
								<table class="table table-bordered table-striped table_vam" id="dt_gal">
									<thead>
										<tr>
											<th class="table_checkbox"><input type="checkbox" name="select_rows" class="select_rows" data-tableid="dt_gal" /></th>
											<th>Title</th>
											<th>Filename</th>
											<th>Created</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($assets as $asset): ?>
										<tr>
											<td><input type="checkbox" name="row_sel" class="row_sel" /></td>
											<td width="300"><?php echo $asset->title ?> [<a href="/admin/assets/edit/<?php echo $asset->id ?>" class="sepV_a" title="Edit">Edit</a>]</td>
											<td style="word-wrap:break-word;white-space: pre-line;"><?php echo $asset->protohash ?> [<a href="/admin/assets/edit/<?php echo $asset->id ?>" class="sepV_a" title="Edit">Edit</a>]</td>
											<td><?php echo $asset->date_created ?></td>
											<td style="text-align: center;"><a href="/admin/assets/edit/<?php echo $asset->id ?>" title="Edit">Edit</a> | <a href="/admin/assets/delete/<?php echo $asset->id ?>" title="Delete">Delete</a></td>
										</tr>
										<?php endforeach ?>
										
									</tbody>
								</table>
								
							</div>
							</div>
						</div>
						<div id="tab2" class="tab-content" style="display: none;">
							<div class="contact_form">
								<form id="page-contact" method="post" action="/admin/assets/save">
									<div>
										<label style="margin-top: 0" for="name">Name:</label>
										<input id="name" class="contact_text" type="text" value="" maxlength="60" size="40" name="name">
									</div>
									<div>
										<label for="title">
										Title:
										<span>*</span>
										</label>
										<input id="title" class="contact_text validate['required','text']" type="text" value="" maxlength="60" size="40" name="title">
									</div>
									<div>
										<label for="file">
										File:
										<span>*</span>
										</label>
										<input id="title" class="contact_text" type="file" value="" maxlength="60" size="40" name="file">
									</div>									
									<div>
										<label for="message">
										Message:
										<span>*</span>
										</label>
										<textarea id="message" class="contact_textarea validate['required']" name="message"></textarea>
									</div>
									<div class="send_button">
										<input id="contact_send" class="contact_submit" type="submit" value="Send Email" name="contact_send">
										<input type="hidden" value="send" name="action">
									</div>
								</form>
							</div>
						</div>
					</div>

				

			</div>			
	</div>
	<!-- End 960 Container -->

	<!-- Invisible Spacer -->
	<div class="container clearfix spacer"></div>