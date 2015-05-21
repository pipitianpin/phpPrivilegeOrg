
<div class="container">
    <div class="row">

        <?php
        echo $save;
        ?>
    </div>
</div>



<script>

    function edit_org($org_id, $org_name)
    {
        var $original_orgname = $org_name;
        var $new_orgname;
        var $url;
        var $data;
        $("#name" + $org_id).html('<input type="text" id="field' + $org_id + '" value="' + $org_name + '" />');
        $("#field" + $org_id).focus();
        $("#field" + $org_id).keypress(function (e) {
            if (e.which == 13) { //enter keycode
                $new_orgname = $(this).val();
                $data = {'org_id': $org_id, 'org_name': $new_orgname};
                $url = "<?php echo site_url() ?>/userrolematrix/org/update_org_name ";
//                alert($url);
                $.ajax({
                    type: "POST",
                    timeout: 300000,
                    url: $url,
                    data: $data
                })
                        .done(function ($returndata) {
                            $("#message").html($returndata);
//                    alert('<?php echo current_url(); ?>');
//                    $("#alertFadeOut").fadeOut(13000000000000);
                            $('#alertFadeOut').fadeOut(30000000000, function () {
                                $('#alertFadeOut').text('');
                            });
                            window.top.location.href = "sub_org"; //refresh current page
//                                    redirect('www.sohu.com','location',301);
//                alert('SUCCESS');
//                            alert($returndata);
                        })
                        .fail(function () {
                            alert('fail');
                        });
                $('#name' + $org_id).html($new_orgname);
            }
            ;
//            return false;

        });
        $('#field' + $org_id).blur(function () {
            $('#name' + $org_id).html($original_orgname);
        });
    }

    function delete_org($org_id)
    {
        if (confirm('Are you sure to delete the organization and its subsidary'))
        {
            $url = "<?php echo site_url() ?>/userrolematrix/org/delete_org";
//        alert($url);
            $data = {'org_id': $org_id};
//        alert($data);
            $.ajax({
                type: "POST",
                timeout: 30000,
                url: $url,
                data: $data
            })
                    .done(function ($returndata) {
//                    alert($returndata);
                        window.top.location.href = "sub_org"; //refresh current page

                    })
                    .fail(function () {
                        alert('fail');
                    });
        }
    }


    function add_suborg($id)
    {
        var $url = "<?php echo site_url(); ?>/userrolematrix/org/add_suborg";
        var $data = "";
        var $org_name = "";
//        alert($url);
        if ($id == null) {
            $("#new_org").html("<input type='text' id='add_suborg'></input>");
            $("#add_suborg").focus();
        } else {
            $("#new_org" + $id).html("<input type='text' id='add_suborg" + $id + "' ></input>");
            $("#add_suborg" + $id).focus();
        }
        $("input").keypress(function (e) {
            if (e.which == 13) {
                $org_name = $(this).val();
//                alert($org_name);
                $data = {'org_name': $org_name, 'parent_id': $id};
//                alert($id);
                $.ajax({
                    type: "POST",
                    timeout: 6000,
                    url: $url,
                    data: $data
                })
                        .done(function ($returndata) {
//                            alert($returndata);
                            window.top.location.href = "sub_org"; //refresh current page

                        })
                        .fail(function () {
                            alert('fail');
                        });
            }
        });
        $("input").blur(function () {
            $("input").hide();
        });

    }


</script>
