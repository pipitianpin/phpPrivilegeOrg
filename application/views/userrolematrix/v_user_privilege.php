<head>
    <meta charset="UTF-8">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/additional-methods.js"></script>

    <!--using data table for searching-->
    <script src="http://cdn.datatables.net/1.10.6/js/jquery.dataTables.min.js"></script>
    <script src="http://cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.js"></script>
    <link rel="stylesheet" href="http://cdn.datatables.net/plug-ins/1.10.6/integration/bootstrap/3/dataTables.bootstrap.css">


</head>


<div class="container">
    <div class="row">  

        <div> <h3 align="center">Modify privilege to users </h3></div>
        <div id="finalprivilegefeedback"></div>



        <form id="v_user_privilege_form" enctype="multipart/form-data">

            <div id="finalprivilege">
                <button type='submit' class='btn btn-primary v_user_privilege_submit'>Modify Privilege</button>

                <div class="selectuser">
                    <label for="select1">Select one user:</label>
                    <table id="table_user" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($users as $user) {
                                ?>
                                <tr><td><div>
                                            <a href='#' onclick='user_change(<?php echo $user->id; ?>);
                                               ' >
                                                <label>
                                                    <input type='radio' name='optradio'  id='checkbox_user' value="<?php echo $user->id; ?>" >  
                                                    <?php echo $user->first_name; ?>
                                                </label>
                                            </a>
                                        </div></td>
                                    <td><?php echo $user->last_name; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>   
                <br>

                <h4>The selected user's privileges</h4>
                <div id="url1">

                </div>

                <div id="org_id" hidden><?php echo ($org_id); ?></div>
                <!--<button type='button' class='btn btn-primary v_user_privilege_submit'>Confirm Modification</button>-->
            </div>
        <!--<input type="text" name="input1" value="va1">va2</input>-->
        </form>


    </div>
</div>

<div id="radio_user_id" hidden> </div>


<?php $this->load->view('inc/footer'); ?>



<script>

    function user_change($user_id) {
        var str = $user_id;
        $('#radio_user_id').html($user_id);
        var url1 = "<?php echo site_url(); ?>/privilege/get_user_privilege/" + str;
//           alert(url1);
        var org_id = $('#org_id').text();
//           alert(org_id);
        $.ajax({
            type: "POST",
            cache: false,
            url: url1,
            data: {org_id: org_id}
        })
                .done(function (msg) {
                    $('#url1').html(tablestyle1(msg));
//                        $('#url1').html((msg));

                    function tablestyle1(arr) {
                        var arr = JSON.parse(arr);
//                    alert(typeof(arr));
//                    alert(arr.length);

                        var out = "<table class='table table-striped table-bordered '>";
                        var i;
                        for (i = 0; i < arr.result.length; i++)
                        {
                            if (arr.result[i].privilege_value == 1) {
                                out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' checked value='" + arr.result[i].id + "' name='" + arr.result[i].privilege_name + "'>" + arr.result[i].privilege_name + "</label></div></td></tr>";
                            } else {
                                out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' value='" + arr.result[i].id + "' name='" + arr.result[i].privilege_name + "'>" + arr.result[i].privilege_name + "</label></div></td></tr>";

                            }
                        }
                        out += "</table>";
//    alert(out);                
                        return out;


                    }
                    ;
                });
    }


    $(document).ready(function () {
//        alert("dd1");

        $('#table_user').dataTable();







        $("#v_user_privilege_form").submit(function (event) {
            event.preventDefault();
        }).validate({
            rules: {
                privilegeinput: {
                    required: true,
                    minlength: 4
                }
            },
            messages: {
                privilegeinput: {
                    required: "please enter new  privilege",
                    minlength: "at least 4 character"
                }
            },
            errorPlacement: function (error, element)
            {
                error.insertAfter($(element).parent());
            },
            submitHandler: function () {
                alert('Privilege Changed');
                $url = "<?php echo site_url(); ?>/privilege/get_user_privilege_feedback";
//                alert($url);
                $form = $("#v_user_privilege_form");
                var formdata = new FormData();
                var $user_id = $('#radio_user_id').text();
                formdata.append("userid", $user_id);
                $("input").each(function () {
                    if ($(this).attr("id") == "privilegecheckbox") {
                        formdata.append($(this).prop('value'), $(this).prop('checked') ? 1 : 0);
                    }
                });


                function reqlistener() {
                    if (xhr.status === 200) {
                        if (xhr.responseText == "true") {
                            $("#finalprivilegefeedback").html(xhr.responseText);
                        } else {
                            $("#finalprivilegefeedback").html(xhr.responseText);
                        }
                    } else {
                        $("#finalprivilegefeedback").html("You cannot insert same privilege");
                    }
                }

                function tablestyle(arr) {
                    var arr = JSON.parse(arr);
//                    alert(typeof(arr));
//                    alert(arr);var

                    var out = "<table class='table table-striped '>\n\
                              <thead>\n\
                              <tr><th>ID\n\
                                </th><th>Privilege</th><th>Desc</th></tr></thead>";
                    var i;
                    for (i = 0; i < arr.entry.length; i++)
                    {
                        out += "<tr><td>" + arr.entry[i].id + "</td><td>" + arr.entry[i].privilege_name + "</td><td>" + arr.entry[i].privilege_desc + "</td></tr>";
                    }
                    out += "</table>";
//    alert(out);                
                    return out;


                }


                var xhr = new XMLHttpRequest();
                xhr.open("POST", $url, true);
                xhr.onload = reqlistener;
                xhr.send(formdata);
//                location.reload(true);
                return false;
            }

        });

    });
</script>
