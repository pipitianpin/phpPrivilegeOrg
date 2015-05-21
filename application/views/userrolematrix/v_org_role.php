<div class="container">
    <div class="row">  
        <div> <h3 align="center">Organization Role Management </h3></div>

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

        <div>
            <label class="btn hidden"> Enter new role  Name </label>
            <input type="text" name="new_role" id="new_role" style="display:none" required></input> 
            <button type='submit' class='btn btn-primary hidden' id="insert_role"> Add New Role</button><br><br>
            <button type='submit' class='btn btn-primary hidden' id="delete_role"> Delete selected roles</button>
            <div id="org_privilege"> </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#select_org").change(function () {
//       alert($(this).val());
            $(".btn").removeClass("hidden");
            $("#new_role").show();
            var url1 = "<?php echo site_url(); ?>/userrolematrix/org_role/select_role";
//       alert(url1);
            var org_id1 = $(this).val();
//      alert(org_id1);

            $.ajax({
                type: "POST",
                url: url1,
                data: {org_id: org_id1}
            })
                    .done(function (returndata) {
                        $("#org_privilege").html(tablestyle(returndata));
                    })
                    .fail(function () {
                        alert('selecting privilege for the organization failed')
                    });


            function tablestyle(arr)
            {
                var arr2 = JSON.parse(arr);

                var out = "<div> Roles List </div><table class='table table-striped table-bordered '> <thead><tr><td>Role Name</td></tr></thead>";
                var i;
                for (i = 0; i < arr2.org_role.length; i++)
                {
                    out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' value='" + arr2.org_role[i].id + "' name='" + arr2.org_role[i].role_name + "'>" + arr2.org_role[i].role_name + "</label></div></td></tr>";
                }
                out += "</table>";
                return out;
            }
            ;

            return false;
        });


        $("#insert_role").click(function () {
//            alert('update failed');
            var url1 = "<?php echo site_url(); ?>/userrolematrix/org_role/insert_role";
//       alert(url1);
            var org_id1 = $("#select_org").val();
            var new_role = $("#new_role").val();
//            alert( org_id1);
            $.ajax({
                type: "POST",
                url: url1,
                data: {org_id: org_id1, new_role: new_role}
            })
                    .done(function (returndata) {
//                        $("#org_privilege").html((returndata));
                        $("#select_org").change();
                    })
                    .fail(function () {
                        alert('insert role failed!! you cannot insert same role');
                    });
            return false;
        });

        $("#delete_role").click(function () {
            var url2 = "<?php echo site_url(); ?>/userrolematrix/org_role/delete_role";
//       alert(url2);
            // var $form = $("#v_org_privilege_form");
            var $formdata = new FormData(); //$form);

            $formdata.append("org_id", $("#select_org").val());
//            alert($("#select_org").val() );

            $("input").each(function () {
                $formdata.append($(this).prop('value'), $(this).prop('checked') ? 1 : 0);
//                alert( $(this).prop('value')+ $(this).prop('checked')?1:0 );
            });

            $.ajax({
                type: "POST",
                data: $formdata,
                processData: false, //Setting processData to false lets you prevent jQuery from automatically transforming the data into a query string
                contentType: false,
                url: url2
            })
                    .done(function (returndata) {
//                        alert(returndata);
                        $("#select_org").change();

                    })
                    .fail(function () {
                        alert('update failed');
                    });


            return false;
        });

        $("#select_org").change();


    });
</script>









