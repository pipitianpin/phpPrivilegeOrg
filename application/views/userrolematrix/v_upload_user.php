
<div class="container">
    <div class="row">
        <div class="col-md-12" id="my_profile">
            <h3 align="center">  Upload Users </h3>
            
            <div style='color:red'><?php echo $error; ?> </div>
            
            <?php echo form_open_multipart('/userrolematrix/org_user/upload_user_process'); ?>
            <input type="file" name="userfile" size="20" >
            <br /> <br />
            <input type="submit" value="Upload user CSV file">
            </form>
            
        </div>
    </div>
</div>
      