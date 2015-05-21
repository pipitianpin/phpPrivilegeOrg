<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of org_role
 *
 * @author leon
 */
class Org_role extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->helper(array("url"));

        $this->load->model("userrolematrix/M_org");
        $this->load->model("userrolematrix/M_org_role");
        $this->load->model("userrolematrix/M_role_user");
        $this->load->model("userrolematrix/M_role_privilege");
        $this->load->model("userrolematrix/M_user_privilege");
//        $this->load->model("userrolematrix/m_org");

        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }
    }

    function create_role() {
        $this->load->view('inc/header');

        $role_id = $this->session->userdata('role_id'); //== 1
//        echo $role_id;
        $user_id = $this->session->userdata('user_id'); //== 1
//        echo $user_id;
        //org admin can only see admin managed org
        if ($role_id == 5) {
            $data["org"] = $this->M_org->get_all_org();
        } else if ($role_id == 1) {
            $data["org"] = $this->M_org->get_all_admin_org($user_id);
        }



//        $data["org"] = $this->M_org->get_all_org();
        $this->load->view("userrolematrix/v_org_role", $data);

        $this->load->view('inc/footer');
    }

    function select_role() {
        $org_id = $this->input->post("org_id");
//        $org_id = substr($org_id, 0, strpos($org_id, ' '));
        $data["org_role"] = $this->M_org_role->get_privilege($org_id);
        echo json_encode($data);
    }

    function insert_role() {
        $org_id = $this->input->post("org_id");
//            $org_id = substr($org_id, 0, strpos($org_id, ' '));
        $role_name = $this->input->post("new_role");
//            echo $org_id.$role_name;
        $this->M_org_role->insert($org_id, $role_name);
    }

    function delete_role() {
//        var_dump($this->input->post(              ));       
        $org_id = $this->input->post("org_id");
//        $org_id = substr($org_id, 0, strpos($org_id, ' '));
//        echo $org_id."<br>";

        $sumdata = $this->input->post();
        foreach ($sumdata as $key => $value) {
            if ($key !== "org_id" && $value == '1') {
//               echo $key.$value."<br>";
                $this->M_org_role->delete_role($org_id, $key);
            }
        }
    }

    function add_user_to_role() {
        $this->load->view('inc/header');

        $role_id = $this->session->userdata('role_id'); //== 1
        $user_id = $this->session->userdata('user_id'); //== 1
       
        if ($role_id == 5) {
            $data["org"] = $this->M_org->get_all_org();
        } else if ($role_id == 1) {
            $data["org"] = $this->M_org->get_all_admin_org($user_id);
        }

        $this->load->view("userrolematrix/v_add_user_to_role", $data);
        $this->load->view('inc/footer');
    }

    //used in v_add-user_to_role.php when click >> to move avaialbe user into already has the privilege list
    function add_avialable_user_to_role() {
//        $org_id = $this->input->post("org_id");
        $role_id = $this->input->post("role_id");
//        $org_id = substr($org_id, 0, strpos($org_id, ' '));
        $data = $this->input->post();
//        echo ($org_id);
//        echo ($role_id);
        //popup and role_id to only left user_id 
//        array_shift($data);
        array_shift($data);

        foreach ($data as $key => $user_id) {
//               echo " data : ".$value;
            $this->M_role_user->insert_user($role_id, $user_id);
            $role_privileges = $this->M_role_privilege->get_role_privilege($role_id);
            foreach ($role_privileges as $role_privilege) {
                $privilege_id = $role_privilege->privilege_id;
//                echo "uid is ".$user_id." privilege_id is  ".$privilege_id;
                $this->M_user_privilege->update_user_privilege($user_id, $privilege_id, 1);
            }
        }
    }

    function remove_alreadyuser_off_role() {
        $role_id = $this->input->post("role_id");

//        echo  $role_id;

        $data = $this->input->post();
        array_shift($data);

        foreach ($data as $key => $user_id) {
//               echo " data : ".$value;
            $this->M_role_user->delete_user($role_id, $user_id);
//            $this->M_role_->delete_user($role_id, $user_id);
//            get_role_privilege

            $role_privileges = $this->M_role_privilege->get_role_privilege($role_id);
            foreach ($role_privileges as $role_privilege) {
                $privilege_id = $role_privilege->privilege_id;
//                echo "uid is " . $user_id . " privilege_id is  " . $privilege_id;
                $this->M_user_privilege->update_user_privilege($user_id, $privilege_id, 0);
            }
        }
    }

}

//end of class


