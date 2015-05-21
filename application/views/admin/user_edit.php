<!-- 960 Container -->

<style>
.edit_text {
	width: 350px;
	border: 1px solid #d7d7d7;
	color: #888;
	font-size: 12px;
	font-family: Tahoma, Arial, sans-serif;
	padding: 9px;
	background-color: #fff;
	outline: none;
}

.edit_form label {
	display: block;
    margin: 20px 0 5px 0;
}

.edit_form label span {color: #ff0000;}

.edit_textarea {	
	width: 100%;
	max-width: 96%;
	height: 100px;
	border: 1px solid #d7d7d7;
	color: #888;
	font-size: 12px;
	font-family: Tahoma, Arial, sans-serif;
	padding: 10px;
	background-color: #fff;
	outline: none;
}

.msgtext {
	font-size: 13px;
	display:block;
}
.msgtext.success{
	color: green;
}

.msgtext.error {
	color: red;
}

</style>
<script type='text/javascript'>
	$("#chk_frame").toggle(function() {
		$("#txt_position").attr("disabled", "disabled");
	 	$(this).attr("disabled", "");
	}, function() {
	 	$("#txt_position").attr("disabled", "");
	});
</script>
<div class="container">
	<div class="sixteen columns">			
		<h3 class="page_headline" style="margin: 0px 0px 20px;">Edit
			<span class="send_button" style="float:right;">
				<input type="submit" value="Save Asset" id="submit_btn" name="submit" class="button green">
			</span>
		</h3>
	</div>
	<div class="seven columns">
			<div class="page_content">
				<div class="edit_form">
				<form method="post" id="page-contact" action="/admin/update_asset">
					<input type="hidden" value="<?php echo $asset->id ?>" maxlength="60" size="40" class="edit_text" width="90px" id="id" name="id">
					<div>
						<label style="margin-top: 0" for="name">Title: <span>*</span></label>
						<input type="text" value="<?php echo $asset->title ?>" maxlength="90" size="40" class="edit_text" id="title" name="title">
					</div>	
					<br/>
					<?php if($this->session->userdata('role_id') == 5) {?>
					<div>
						<label style="margin-top: 0" for="name">Protohash: <span>*</span></label>
						<input type="text" value="<?php echo $asset->protohash ?>" maxlength="90" size="40" class="edit_text" id="protohash" name="protohash">
					</div>
					<br/>					
					<?php } else { ?>
						<label style="margin-top: 0" for="name">Protohash:</label>
						<p><?php echo $asset->protohash ?></p>
						<input type="hidden" value="<?php echo $asset->protohash ?>" id="protohash" name="protohash">
						<br/>
					<?php } ?>
					<?php if($this->session->userdata('role_id') == 5) {?>
					<div>
						<label style="margin-top: 0" for="name">Filename:</label>
						<input type="text" value="<?php echo $asset->filename ?>" maxlength="90" size="40" class="edit_text" id="filename" name="filename">
					</div>	

					<?php } else { ?>
						<label style="margin-top: 0" for="name">Filename:</label>
						<p><?php echo $asset->filename ?></p>
						<input type="hidden" value="<?php echo $asset->filename ?>" id="filename" name="filename">
					<?php } ?>
					<div>
						<label for="filetype">File Type: <span>*</span></label>
						<select name="filetype" class="edit_text">
							<option value="video" <?php if($asset->filetype == 'video') echo 'selected="selected"' ?>>Video</option>
							<option value="Image" disabled <?php if($asset->filetype == 'image') echo 'selected="selected"' ?>>Image</option>
							<option value="Audio" disabled <?php if($asset->filetype == 'audio') echo 'selected="selected"' ?>>Audio</option>
						</select>	
					</div>
					<div>
						<label for="securitylevel">Security Level: <span>*</span></label>
						<select name="securitylevel" class="edit_text">
							<option value="1" <?php if($asset->security_level == '1') echo 'selected="selected"' ?>>Private</option>
							<option value="2" <?php if($asset->security_level == '2') echo 'selected="selected"' ?>>Public</option>
							<option value="3" disabled<?php if($asset->security_level == '3') echo 'selected="selected"' ?>>Secure</option>
						</select>	
					</div>

					<div>
						<label style="margin-top: 0" for="name">HD Master Available: </label>
						<input type="checkbox" value="1" id="hdavailable" name="hdavailable" <?php if($asset->hd_available == '1') echo 'checked="checked"' ?>>
					</div>

					<span class="no_error"></span>	
				</div>	
		</div>	
	</div>
	<div class="nine columns"></div>	
	</form>
	</div>		
</div>			
<!-- End 960 Container -->

<!-- Invisible Spacer -->
<div class="container clearfix spacer"></div>

<script>
	$('#submit_btn').click(function() {
		$('#page-contact').submit();
	});
</script>

