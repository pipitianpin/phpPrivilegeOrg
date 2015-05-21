
<div class="container">
    <div class="row">

        <?php
        echo $save;
        ?>
    </div>
</div>
<div id="radio_org_id" hidden></div>


<div class="container">
    <div class="row">   
        <div class="col-sm-5"> 
            <form id="v_org_user_form1" enctype="multipart/form-data">
                <label hidden>users NOT in the organization</label>
                <div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter_available_user" type="text" class="form-control" placeholder="Type here...">
                </div>

                <table id="table_availableuser" class='table table-striped table-bordered'  >
                    <thead><tr><th></th><th>First Name</th><th>Last Name</th><th>Email</th></tr></thead>
                    <tbody id="available_user" class="searchable"> </tbody>
                </table>
            </form>
        </div>

        <div class="col-sm-2" align='center'> 
            <br><br><br><br>
            <button type="button" class="btn btn-primary" id="include_user" hidden> >> </button><br><br>
            <button type="button" class="btn btn-primary" id="remove_user" hidden> << </button>
        </div>

        <div class="col-sm-5"> 

            <form id="v_org_user_form2" enctype="multipart/form-data">
                <label hidden>users Already in the organization</label>
                <div class="input-group"> <span class="input-group-addon">Filter</span>
                    <input id="filter_already_user" type="text" class="form-control" placeholder="Type here...">
                </div>

                <table class='table table-striped table-bordered' id='already_table' ><thead><tr><th></th><th>First Name</th><th>Last Name</th><th>Email</th></tr></thead>
                    <tbody id="org_user" class="searchable"> </tbody>
                </table>
            </form>
        </div>
    </div>

</div>







<script>

    function list_user($org_id)
    {
//    alert($org_id);
        $('#radio_org_id').html($org_id);
//       alert($(this).val());
//            $(".btn").removeClass("hidden");
        $(".btn").show();
        $("label").show();
        var url1 = "<?php echo site_url(); ?>/userrolematrix/org_user/get_current_user";
//       alert(url1);
        var org_id1 = $org_id;
//            alert(org_id1);
        $.ajax({
            type: "POST",
            url: url1,
            data: {org_id: org_id1}
        })
                .done(function (returndata) {
//                        alert(returndata);
                    $("#available_user").html(tablestyle_availableuser(returndata));
                    $("#org_user").html(tablestyle(returndata));
                })
                .fail(function () {
                    alert('selecting privilege for the organization failed')
                });



            function tablestyle_availableuser(arr)
            {
                var arr2 = JSON.parse(arr);
                var out = "";
                var i;
                for (i = 0; i < arr2.available_user.length; i++)
                {
                    out += " <tr>";
                    out += "<td><div class='checkbox' style='margin:0px'> <label><input type='checkbox' id='available_checkbox' value='" + arr2.available_user[i].id + "' name='" + arr2.available_user[i].email + "'>"
                            + "</label></div></td>";
                    out += "<td > " + (arr2.available_user[i].first_name ? arr2.available_user[i].first_name : "") + "</td>";
                    out += "<td > " + (arr2.available_user[i].last_name ? arr2.available_user[i].last_name : "") + "</td>";
                    out += "<td>" + arr2.available_user[i].email + "</td></tr>";
                }
                return out;
            }            ;


            function tablestyle(arr)
            {
                var arr2 = JSON.parse(arr);
                var out = "";
                var i;
                for (i = 0; i < arr2.org_user.length; i++)
                {
//                    out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='included_checkbox' value='" + arr2.org_user[i].id + "' name='" + arr2.org_user[i].email + "'>" + arr2.org_user[i].email + "</label></div></td></tr>";

                    out += " <tr>";
                    out += "<td><div class='checkbox' style='margin:0px'> <label><input type='checkbox' id='included_checkbox' value='" + arr2.org_user[i].id + "' name='" + arr2.org_user[i].email + "'>"
                            + "</label></div></td>";
                    out += "<td > " + (arr2.org_user[i].first_name ? arr2.org_user[i].first_name : "") + "</td>";
                    out += "<td > " + (arr2.org_user[i].last_name ? arr2.org_user[i].last_name : "") + "</td>";
                    out += "<td>" + arr2.org_user[i].email + "</td></tr>";


                }
                return out;
            }            ;


        return false;
    }

    $(document).ready(function () {

        $('.btn').hide();


        (function ($) {

            $('#filter_available_user').keyup(function () {

                var rex = new RegExp($(this).val(), 'i');
                $('#available_user tr').hide();
                $('#available_user tr').filter(function () {
                    return rex.test($(this).text());
                }).show();

            })

        }(jQuery));


        (function ($) {

            $('#filter_already_user').keyup(function () {

                var rex = new RegExp($(this).val(), 'i');
                $('#org_user tr').hide();
                $('#org_user tr').filter(function () {
                    return rex.test($(this).text());
                }).show();

            })

        }(jQuery));






        $("#include_user").click(function () {
            var url = "<?php echo site_url(); ?>/userrolematrix/org_user/update_org_user"
//            alert(url);
            var formdata = new FormData();
            var org_id = $('#radio_org_id').text();
//            alert(org_id);
            formdata.append("org_id", org_id);
            $("input#available_checkbox").each(function () {
                if ($(this).prop('checked'))
                {
                    formdata.append($(this).prop('value'), $(this).prop('value'));
                }
            });

            $.ajax({
                type: "POST",
                url: url,
                data: formdata,
                processData: false, //Setting processData to false lets you prevent jQuery from automatically transforming the data into a query string
                contentType: false
            })
                    .done(function (returndata) {
//                        alert(returndata);
//                        $($org_id).change();
                        list_user(org_id);
                    })
                    .fail(function () {
//                        alert('fail');
                        list_user(org_id);

                    });
            return false;
        });




        $("#remove_user").click(function () {
            var url = "<?php echo site_url(); ?>/userrolematrix/org_user/remove_user"
//            alert(url);
            var formdata = new FormData();
            var org_id = $('#radio_org_id').text();
//            alert(org_id);
            formdata.append("org_id", org_id);
            $("input#included_checkbox").each(function () {
                if ($(this).prop('checked'))
                {
                    formdata.append($(this).prop('value'), $(this).prop('value'));
                }
            });

            $.ajax({
                type: "POST",
                url: url,
                data: formdata,
                processData: false, //Setting processData to false lets you prevent jQuery from automatically transforming the data into a query string
                contentType: false
            })
                    .done(function (returndata) {
//                        alert(returndata);
                        list_user(org_id);
                    })
                    .fail(function () {
//                        alert('fail');
                        list_user(org_id);

                    });
            return false;
        });


    });



</script>
