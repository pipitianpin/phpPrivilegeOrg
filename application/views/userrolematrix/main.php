<div class="container">
    <div class='row'>
        <h3 align="center">
            Organization and Privilege Management
        </h3>

        <ul>
            <?php
                $this->session->set_userdata('role_id',1);

                ?>
            

                <li><a href="userrolematrix/org/sub_org">Create organization structure</a></li>
                <li><a href="userrolematrix/org_user/add_user_into_org">Add users into one organization</a></li>
                <li><a href="userrolematrix/org/add_user_into_sub_org">Add users into one sub-organization</a></li>
                <li><a href="#">*************************************************</a></li>
                <li><a href="userrolematrix/org_role/create_role">Create roles for one organization</a></li>
                <li><a href="userrolematrix/role_privilege">Assign privileges for roles of one organization</a></li>
                <li><a href="userrolematrix/org_role/add_user_to_role">Add users to roles </a></li>
                <li><a href="userrolematrix/org_user/get_user_roleandprivilege">Show user's roles and privileges</a></li>
                <li><a href="privilege/get_user_privilege_pre">Assign specific privilege to specific User</a></li>
           
                
 


        </ul>

    </div>
</div>

<?php $this->load->view('inc/footer'); ?>

