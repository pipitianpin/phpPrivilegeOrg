<div> <h3 align="center">Add privileges to system </h3></div>

<div class="container">
    <div class="row">  

        <div>
            <label> Enter privilege </label>
            <input type="text" id="privilegeinput" name="privilegeinput" placeholder="Add new privilege in system"  required/>
            <button type="button"  id="privilegesubmit">Add New Privilege</button>
        </div>
        <br>
        
        <div> <h4>Current List of Privilege</h4></div>
        <div id="finalprivilege">
            <table class='table table-striped table-bordered '>
                <thead><tr><th>Privilege</th></tr></thead>
                <?php
                foreach ($entry as $row) {
                    echo "<tr><td>" . $row->privilege_name . "</td></tr>";
                }
                ?>
            </table>
        </div>

    </div>
</div>
<?php $this->load->view('inc/footer'); ?>

<script>
    $(document).ready(function () {
        $("#privilegesubmit").click(function () {
            var url = "<?php echo site_url(); ?>privilege/user_data_submit";
//             alert(url);
            var privilege_input = $('#privilegeinput').prop('value');
//            alert(privilege_input);
            $.ajax({
                type: "POST",
                url: url,
                data: {privilege_input: privilege_input}
            })
                    .done(function (returndata) {
                        alert('add new privilege success');
                        $("#finalprivilege").html(tablestyle(returndata));
                    })
                    .fail(function () {
                        alert('selecting privilege for the organization failed')
                    });

            function tablestyle(arr)
            {
                var arr2 = JSON.parse(arr);
                var out = "<table class='table table-striped table-bordered '>        <thead><tr><th>Privilege</th></tr></thead> ";
                var i;
                for (i = 0; i < arr2.entry.length; i++)
                {

                    out += "<tr><td>" + arr2.entry[i].privilege_name + "</td></tr>";
//                    out += "<tr><td><div class='checkbox'> <label><input type='checkbox' id='privilegecheckbox' value='" + arr2.entry[i].id + "' name='" + arr2.entry[i].role_name + "'>" + arr2.entry[i].role_name + "</label></div></td></tr>";
                }
                out += '    </table> ';
                return out;
            }
            ;
            return false;

        });
    });
</script>