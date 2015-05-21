<div class="container">
    <div class="row">  
        <div class="col-sm-12"> 

            <div> <h3 align="center">Show user roles and privileges </h3></div>



            <?php
            $role_id = $this->session->userdata('role_id'); //== 1
            ?>

            <div class="selectorg" <?php echo $role_id == 1 ? "hidden" : ""; ?> >
                <label for="select_org">Select one organization:</label>
                <select class="form-control" id="select_org" data-live-search="true" title="Select one organization">
                    <?php
                    foreach ($org as $one_org) {
                        ?>
                        <option value="<?php echo $one_org->id; ?>"><?php echo $one_org->org_name; ?></option>    
                        <?php
                    }
                    ?>
                </select>
            </div>   
            <br>
        </div>
    </div>




    <div class="row">  

        <div class="col-sm-12"> 
            <form id="v_org_user_form1" enctype="multipart/form-data">
                <label hidden>Select one user</label>
                <div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter_available_user" type="text" class="form-control" placeholder="Type here...">
                </div>

                <table id="table_availableuser" class='table table-striped table-bordered'  >
                    <thead><tr><th></th><th>First Name</th><th>Last Name</th><th>Email</th></tr></thead>
                    <tbody id="available_user" class="searchable"> </tbody>
                </table>
            </form>
        </div>
    </div>







    <br>

    <label>Assigned roles </label>
    <div id="Assigned_role"> </div>

    <label>Assigned privilege in the organization </label>
    <div id="Assigned_privilege"> </div>
</div>


<script>
    $(document).ready(function () {

//jquery filter 
        (function ($) {
            $('#filter_available_user').keyup(function () {

                var rex = new RegExp($(this).val(), 'i');
                $('#available_user tr').hide();
                $('#available_user tr').filter(function () {
                    return rex.test($(this).text());
                }).show();

            })

        }(jQuery));

        $("#select_org").change(function () {
//       alert($(this).val());
            $("#select_user").removeClass("hidden");
            $("label").show();
//            $(".select_role").show();
            var url1 = "<?php echo site_url(); ?>/userrolematrix/org_user/get_org_user";
//       alert(url1);
            var org_id1 = $(this).val();
//            alert(org_id1);
            $.ajax({
                type: "POST",
                url: url1,
                data: {org_id: org_id1}
            })
                    .done(function (returndata) {
//                        alert(tablestyle(returndata));
                        $("#available_user").html(tablestyle(returndata));
//                        $("#select_user").change();
                    })
                    .fail(function () {
                        alert('selecting privilege for the organization failed')
                    });
            function tablestyle(arr)
            {
                var arr2 = JSON.parse(arr);
                var out = '   ';
                out += '    ';
                var i;
                for (i = 0; i < arr2.org_user.length; i++)
                {
//                    out += '<option value="' + arr2.org_user[i].id + '">' + arr2.org_user[i].email + '</option>';
//                    out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' value='" + arr2.org_role[i].id + "' name='" + arr2.org_role[i].role_name + "'>" + arr2.org_role[i].role_name + "</label></div></td></tr>";
                    out += " <tr>";
//                    out += "<td><label><input type='radio' id='available_checkbox' value='" + arr2.org_user[i].id + "' name='" + arr2.org_user[i].email + "'>"
//                            + "</label></div></td>";
                    out += "<td><div> <a href='#' onclick='change_user("+ arr2.org_user[i].id +")' ><label><input type='radio' name='optradio'  id='privilegecheckbox' /> </label></a></div></td>";

                    out += "<td > " + (arr2.org_user[i].first_name ? arr2.org_user[i].first_name : "") + "</td>";
                    out += "<td > " + (arr2.org_user[i].last_name ? arr2.org_user[i].last_name : "") + "</td>";
                    out += "<td>" + arr2.org_user[i].email + "</td></tr>";


                }
//                out += '    </select> ';





                return out;
            }           ;



            return false;
        });


        $("#select_org").change();


    });
    
    
    
            function change_user(user_id) {
                var org_id = $("#select_org").prop('value');
//            var user_id = $(this).prop('value');
//                alert(org_id);
//                alert(user_id);
            $(".btn").removeClass("hidden");
//            var url1 = "<?php echo site_url(); ?>userrolematrix/role_privilege/select_privilege_to_role";
            var url1 = "<?php echo site_url(); ?>/userrolematrix/org_user/get_user_privilege";
//       alert(url1);
            $.ajax({
                type: "POST",
                url: url1,
                data: {org_id: org_id, user_id: user_id}
            })
                    .done(function (returndata) {
//                        alert(returndata);
                        $("#Assigned_role").html(tablestyle2(returndata));
                        $("#Assigned_privilege").html(tablestyle(returndata));
                    })
                    .fail(function () {
                        alert('selecting privilege for the organization failed')
                    });

            function tablestyle2(arr)
            {
                var arr2 = JSON.parse(arr);

                var out = "<table class='table table-striped table-bordered '>";
                var i;
                for (i = 0; i < arr2.user_role.length; i++)
                {
                    if (arr2.user_role[i].role_id != null) {
//                        alert(arr2.user_privilege[i].role_name);
//                        out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' checked value='" + arr2.org_privilege[i].id + "' name='" + arr2.org_privilege[i].privilege_name + "'>" + arr2.org_privilege[i].privilege_name + "</label></div></td></tr>";
                        out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' disabled checked value='" + arr2.user_role[i].role_name + "' name='" + arr2.user_role[i].role_name + "'>" + arr2.user_role[i].role_name + "</label></div></td></tr>";
                    } else {
                        out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox'  disabled value='" + arr2.user_role[i].role_name + "' name='" + arr2.user_role[i].role_name + "'>" + arr2.user_role[i].role_name + "</label></div></td></tr>";
                    }
                }
                out += "</table>";
                return out;
            }
            ;


            function tablestyle(arr)
            {
                var arr2 = JSON.parse(arr);

                var out = "<table class='table table-striped table-bordered '>";
                var i;
                for (i = 0; i < arr2.user_privilege.length; i++)
                {
                    if (arr2.user_privilege[i].privilege_value == 1) {
//                        alert(arr2.user_privilege[i].role_name);
//                        out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' checked value='" + arr2.org_privilege[i].id + "' name='" + arr2.org_privilege[i].privilege_name + "'>" + arr2.org_privilege[i].privilege_name + "</label></div></td></tr>";
                        out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' disabled checked value='" + arr2.user_privilege[i].privilege_name + "' name='" + arr2.user_privilege[i].privilege_name + "'>" + arr2.user_privilege[i].privilege_name + "</label></div></td></tr>";
                    } else {
                        out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox'  disabled value='" + arr2.user_privilege[i].privilege_name + "' name='" + arr2.user_privilege[i].privilege_name + "'>" + arr2.user_privilege[i].privilege_name + "</label></div></td></tr>";
                    }
                }
                out += "</table>";
                return out;
            }
            ;



            return false;
            }            ;


</script>









