<div class="container">
    <div class="row">  
        <div> <h3 align="center">Assign Privileges for Roles </h3></div>


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

        <label for="select_role" hidden>Select one role:</label>
        <select class="form-control hidden" id="select_role" data-live-search="true" title="Select one role" >
            <div id="temp2">
            </div>
        </select>

        <br>

        <form id="v_role_privilege_form" enctype="multipart/form-data">
            <button type='submit' class='btn btn-primary v_user_privilege_submit hidden' id="bn_role_privilege">Modify Privilege</button>
            <div id="role_privilege"> </div>
        </form>

    </div>
</div>

<script>
    $(document).ready(function () {
        $("#select_org").change(function () {
//       alert($(this).val());
            $("#select_role").removeClass("hidden");
            $("label").show();
//            $(".select_role").show();
            var url1 = "<?php echo site_url(); ?>/userrolematrix/org_role/select_role";
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
                        $("#select_role").html(tablestyle(returndata));
                        $("#select_role").change();
                    })
                    .fail(function () {
                        alert('select privilege for the organization failed')
                    });
            function tablestyle(arr)
            {
                var arr2 = JSON.parse(arr);
                var out = '   ';
                out += '    ';
                var i;
                for (i = 0; i < arr2.org_role.length; i++)
                {
                    out += '<option value="' + arr2.org_role[i].id + '">' + arr2.org_role[i].role_name + '</option>';
//                    out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' value='" + arr2.org_role[i].id + "' name='" + arr2.org_role[i].role_name + "'>" + arr2.org_role[i].role_name + "</label></div></td></tr>";
                }
//                out += '    </select> ';
                return out;
            }
            ;

            $("#select_role").change();
            return false;


        });

        $("#select_role").change(function () {
            var org_id = $("#select_org").prop('value');
            var role_id = $(this).prop('value');
//            alert("roleid is "+role_id);

            //used for org admin first into the page
            if (role_id == "") {
//                            alert("roleid is key "+role_id);
                return;
            }

            $(".btn").removeClass("hidden");
            var url1 = "<?php echo site_url(); ?>/userrolematrix/role_privilege/select_privilege_to_role";
//       alert(url1);
            $.ajax({
                type: "POST",
                url: url1,
                data: {org_id: org_id, role_id: role_id}
            })
                    .done(function (returndata) {
//                        alert(returndata);
                        $("#role_privilege").html(tablestyle(returndata));
                    })
                    .fail(function () {
                        alert('select privilege for the role failed')
                    });
            function tablestyle(arr)
            {
                var arr2 = JSON.parse(arr);

                var out = "<table class='table table-striped table-bordered '>";
                var i;
                for (i = 0; i < arr2.role_privilege.length; i++)
                {
                    if (arr2.role_privilege[i].privilege_value == 1) {
//                        out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' checked value='" + arr2.org_privilege[i].id + "' name='" + arr2.org_privilege[i].privilege_name + "'>" + arr2.org_privilege[i].privilege_name + "</label></div></td></tr>";
                        out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' checked value='" + arr2.role_privilege[i].privilege_id + "' name='" + arr2.role_privilege[i].privilege_name + "'>" + arr2.role_privilege[i].privilege_name + "</label></div></td></tr>";
                    } else {
                        out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox'         value='" + arr2.role_privilege[i].privilege_id + "' name='" + arr2.role_privilege[i].privilege_name + "'>" + arr2.role_privilege[i].privilege_name + "</label></div></td></tr>";
                    }
                }
                out += "</table>";
                return out;
            }
            ;
            return false;
        });

        $("#bn_role_privilege").click(function () {
//            var select_org =($("#select_org").val());
//            alert(select_org);
            var select_role = ($("#select_role").val());
            var url1 = "<?php echo site_url(); ?>/userrolematrix/role_privilege/assign_privilege_to_role";
//            alert(url1);
            var formdata = new FormData();
//            formdata.append("org_id",select_org);
            formdata.append("role_id", select_role);
            $("input").each(function () {
                formdata.append($(this).prop('value'), $(this).prop('checked') ? 1 : 0);
            });
            $.ajax({
                type: "POST",
                data: formdata,
                url: url1,
                processData: false,
                contentType: false
            })
                    .done(function (returndata) {
                        alert('update privilege success');
//                      alert(returndata);
                    })
                    .fail(function () {
                        alert('fail');
                    });
            return false;
        });

        $("#select_org").change();


    });
</script>









