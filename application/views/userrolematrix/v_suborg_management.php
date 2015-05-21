<div class="container">
    <div class="row">


        
        <div class="col-md-3"></div>
        <div class="col-md-9"> 	
            <div id="message"></div>
            <div> <h3 align="center">Sub-Organization management </h3></div>

            <ul style="list-style-type:circle">
                <?php
                foreach ($org as $one_org) {
                    ?>
                    <li id="delete<?php echo $one_org->id; ?>">
                        <span id="name<?php echo $one_org->id; ?>"> <?php echo $one_org->org_name; ?></span>

                        <small>
                            (
                            <a href="#" onclick="edit_org(<?php echo $one_org->id; ?>, '<?php echo $one_org->org_name;?>')"; return false; 
                               class="glyphicon glyphicon-edit" title="Edit">
                        </a>
                        ,
                        <a href="#" onclick="delete_org(<?php echo $one_org->id; ?>);
                                    return false;
                           " class="glyphicon glyphicon-trash" title="Delete"></a> 
                        )   
                        (<a href="#" onclick="display_suborg(<?php echo $one_org->id ; ?>, '<?php echo $one_org->parent_id ; ?>');  return false; "  
                            id="showHide<?php echo $one_org->id ; ?>"  class="statusShow<?php echo $one_org->id ; ?>" title="Delete"   >   
                        + Show sub-organization
                        </a>)
                    </small>
                        <div id="return_suborg<?php echo $one_org->id; ?>">
                        </div>

                </li>    
                <?php
            }
            ?>
        </ul>


    </div>
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
                $url = "<?php echo site_url() ?>userrolematrix/org/update_org_name ";
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
        $url = "<?php echo site_url() ?>userrolematrix/org/delete_org";
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
//                    window.top.location.href = "suborg_management"; //refresh current page

                })
                .fail(function () {
                    alert('fail');
                });
    }


    function display_suborg($org_id,$parent_id)
    {
//        alert('leon');
        var $url = "<?php echo site_url(); ?>userrolematrix/org/display_suborg";
//        alert($url);
        var $data={'org_id':$org_id, 'parent_id':$parent_id };
        $("#return_suborg"+$org_id).html('Processing.....');
        $.ajax({
            type:"POST",
            timeout:30000,
            url:$url,
            data:$data
        })
                .done( function($return_data){
                    alert($return_data);
                    $("#return_suborg"+$org_id).html($return_data);
                })
                .fail( function(){
                    alert('fail');
                });
    }
    
    
</script>
