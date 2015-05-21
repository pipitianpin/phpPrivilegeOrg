
<form id="orgform" >


    <h1 align="center">Create Organization</h1>
    <label> Enter Organization Name </label>
    <input type="text" name="org_name" id="org_name" required></input> 
    <button type="submit" >Add organization</button> 

</form>

<br>
<div id="org_list">
    <table class='table table-striped table-bordered '>
        <thead>
            <tr><td>Current All Organizations Name List</td></tr>
        </thead>
        <?php
        foreach ($org as $orgrow) {
            ?>
            <tr>
<!--                <td>    <?php echo $orgrow->id; ?>    </td>-->
                <td>    <?php echo $orgrow->org_name; ?>    </td>
            </tr>

            <?php
        }
        ?>
    </table>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js "></script>
<script>
    $(document).ready(function () {
        $("#orgform").submit(function () {
            $("#org_list").html('loadinging....');
            data1 = $("#org_name").val();
            url1 = "<?php echo site_url(); ?>userrolematrix/org/result";
            $.ajax({
                type: 'POST',
                url: url1,
                data: {org_name: data1}
            })
                    .done(function (data2) {
                          alert('Create organization success');
                        $('#org_list').html(tablestyle(data2));
                    })
                    .fail(function () {
                        alert('posting failed');
                    });

            function tablestyle(arr)
            {
                var arr2 = JSON.parse(arr);


                var out = "<table class='table table-striped table-bordered '><thead><tr><td>Current All Organizations Name List</td></tr></thead></tr>";
                var i;
                for (i = 0; i < arr2.result.length; i++)
                {
                    out += "<tr><td>" + arr2.result[i].org_name + "</td></tr>";
                }

                out += "</table>";
                return out;

            }
            ;
            // to prevent refreshing the whole page page
            return false;
        });
    });


</script>