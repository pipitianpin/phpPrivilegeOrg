<head>
    <meta charset="UTF-8">
    <title></title>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>

</head>


<!--<div class="container">
    <div class="row">  
        <form id="form_myprofile" enctype="multipart/form-data">
            <div id="finalprivilege">
                <input type="text" name="myprofile_email"> </input>
                <button type='submit' class='btn btn-primary v_user_privilege_submit'>Modify Privilege</button>
            </div>
        </form>
    </div>
</div>-->


<div class="container">
    <div class="row">
        <div class="col-md-10" id="my_profile">
            <h3 align="center">  My Profile </h3>
            <form id="form_myprofile" enctype="multipart/form-data">

                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control" id="first_name" value="<?php echo $user_profile[0]->first_name; ?>" placeholder="<?php echo $user_profile[0]->first_name; ?>" disabled /> </td>    
                            <td><input type="text" class="form-control" id="last_name" value="<?php echo $user_profile[0]->last_name; ?>" placeholder="<?php echo $user_profile[0]->last_name; ?>" disabled /> </td>    
                            <td><input type="text" class="form-control" name="myprofile_email" id="email" value="<?php echo $user_profile[0]->email; ?>" placeholder="<?php echo $user_profile[0]->email; ?>" disabled /> </td>    
                            
                        </tr>

                        <tr>

                        </tr>
                    </tbody>

                </table>
                <button type="submit" class="btn btn-default" id="submit" >Submit</button>
            </form>                    

        </div>

        <div class="col-md-2">
            <br>
            <br>
            <br>

            <div class="row">
                <button class="btn btn-success btn-block" role="button" id="change_profile">Change profile</button>
            </div>
            <div class="row">
                <a href="/auth/change_password"><button class="btn btn-success  btn-block" role="button" id="change_password">Change password</button></a>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
//        alert("dd1");

        $('#submit').hide();

        $("#change_profile").click(function () {
            $('input').removeAttr('disabled');
            $('#submit').show();
        });

        $("#form_myprofile").submit(function (event) {
            event.preventDefault();
        }).validate({
            rules: {
                myprofile_email: {
                    required: true,
                    email: true
                }
            },
            messages: {
                myprofile_email: {
                    required: "please enter email",
                    email: "should be email"
                }
            },
                 submitHandler: function () {

                var $first_name = $('#first_name').val();
                var $last_name = $('#last_name').val();
                var $email = $('#email').val();

                var $url = "<?php echo site_url(); ?>userrolematrix/org_user/update_myprofile";

                $.ajax({
                    type: "POST",
                    url: $url,
                    data: {first_name: $first_name, last_name: $last_name, email: $email}
                })
                        .done(function (returndata) {
//                        alert(returndata);
                            $('input').prop('disabled', true);
                            $('#submit').hide();
                            location.reload();
                        })
                        .fail(function () {

                            alert('Email is duplicated with current users, please use different email');
                            location.reload();


                        });

                return false;

            }

        });

    });
</script>
