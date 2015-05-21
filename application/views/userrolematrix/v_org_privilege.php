<div class="container">
    <div class="row">  
        <div> <h3 align="center">Assign privileges to Organizations </h3></div>



        <div class="selectorg">
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


        <form id="v_org_privilege_form" enctype="multipart/form-data">
            <button type='submit' class='btn btn-primary v_user_privilege_submit hidden' >Modify Privilege</button>
            <div id="org_privilege"> </div>
        </form>

    </div>
</div>
<script>
    $(document).ready(function () {

        $("#select_org").change(function () {
//       alert($(this).val());
            $(".btn").removeClass("hidden");
            var url1 = "<?php echo site_url(); ?>userrolematrix/org_privilege/assign_privilege_to_org";
//       alert(url1);
            var org_id1 = $(this).val();
//            alert(org_id1);
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

                var out = "<table class='table table-striped table-bordered '>";
                var i;
                for (i = 0; i < arr2.org_privilege.length; i++)
                {
                    if (arr2.org_privilege[i].privilege_value == 1) {
                        out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' checked value='" + arr2.org_privilege[i].id + "' name='" + arr2.org_privilege[i].privilege_name + "'>" + arr2.org_privilege[i].privilege_name + "</label></div></td></tr>";
                    } else {
                        out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox'         value='" + arr2.org_privilege[i].id + "' name='" + arr2.org_privilege[i].privilege_name + "'>" + arr2.org_privilege[i].privilege_name + "</label></div></td></tr>";
                    }
                }
                out += "</table>";
                return out;
            }
            ;

            return false;
        });


        $(".btn").click(function () {
            var url2 = "<?php echo site_url(); ?>userrolematrix/org_privilege/update_org_privilege";
//       alert(url2);
            // var $form = $("#v_org_privilege_form");
            var $formdata = new FormData(); //$form);

            $formdata.append("org_id", $("#select_org").prop('value'));
//            alert($("#select_org").prop('value'));
            $("input").each(function () {
                $formdata.append($(this).prop('value'), $(this).prop('checked') ? 1 : 0);
            });

            $.ajax({
                type: "POST",
                data: $formdata,
                processData: false, //Setting processData to false lets you prevent jQuery from automatically transforming the data into a query string
                contentType: false,
                url: url2
            })
                    .done(function (returndata) {
                        alert("Privilege Changed");
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









