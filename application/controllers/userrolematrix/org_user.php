<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of org_privilege
 *
 * @author leon
 */
class Org_user extends CI_Controller {
    //put your code here

    /**
     * 
     * used for upload_user function
     * @var string $fileds 
     * @var string $separator 
     * @var string $enclosure 
     * 
     */
    private $fields;
    private $separator = ',';
    private $enclosure = '"';
    private $max_row_size = 0;

    function __construct() {
        parent::__construct();
        $this->load->helper(array("form", "url"));

        $this->load->model("userrolematrix/M_org");
        $this->load->model("userrolematrix/M_org_user");
        $this->load->model("userrolematrix/M_org_role");
        $this->load->model("userrolematrix/M_role_privilege");
        $this->load->model("userrolematrix/M_user_privilege");
        $this->load->model("userrolematrix/M_role_user");
        $this->load->model("user");

//        $this->load->model("userrolematrix/m_org");

        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }
    }

    function add_user_into_org($para = null) {
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

        $this->load->view("userrolematrix/v_org_user", $data);
        $this->load->view('inc/footer');
    }

    function get_current_user() {
        $org_id = $this->input->post("org_id");
//        $org_id = substr($org_id, 0, strpos($org_id, ' '));
        $data["org_user"] = $this->M_org_user->get_user($org_id);
        $data["available_user"] = $this->M_org_user->get_avaiable_user($org_id);
        echo json_encode($data);
    }

    function get_org_user() {
        $org_id = $this->input->post("org_id");
        $data["org_user"] = $this->M_org_user->get_user($org_id);
        echo json_encode($data);
    }

    function update_org_user() {
        $org_id = $this->input->post("org_id");
//        $org_id = substr($org_id, 0, strpos($org_id, ' '));
        $data = $this->input->post();
        array_shift($data);

        $this->update_org_user_recursive($org_id, $data);
    }

    function update_org_user_recursive($org_id, $data) {


        foreach ($data as $key => $value) {
            $this->M_org_user->insert_user($org_id, $value);
        }
        echo $org_id;
        $parent_orgid = $this->M_org->get_parent_orgid($org_id)[0]->parent_id;
        if ($parent_orgid != null) {
            var_dump($parent_orgid);
//            isset($this->M_org->get_parent_orgid($org_id)[0]->parent_id) && ($this->M_org->get_parent_orgid($org_id)[0]->parent_id)) {
            $this->update_org_user_recursive($parent_orgid, $data);
        }
    }

    function remove_user() {
        $org_id = $this->input->post("org_id");
//        $org_id = substr($org_id, 0, strpos($org_id, ' '));
        $data = $this->input->post();
        array_shift($data);
        $this->remove_user_recursive($org_id, $data);
    }

    function remove_user_recursive($org_id, $data) {

        foreach ($data as $key => $value) {
            $this->M_org_user->delete_org_user($org_id, $value);
        }

        $children_orgid = $this->M_org->get_children_orgid($org_id);
        if (!empty($children_orgid)) {

            foreach ($this->M_org->get_children_orgid($org_id) as $orgarr) {
                $this->remove_user_recursive($orgarr->id, $data);
            }
        }
    }

//    //temporary used by leon
//    function suborg_management() {
//        $this->load->view('inc/header');
//
//
//        $data["org"] = $this->M_org->get_all_org();
//        $this->load->view("userrolematrix/v_suborg_management", $data);
////        foreach ( $arr as $)
//        $this->load->view('inc/footer');
//    }
    //temporary used by leon
    function test_create_suborg() {
        $level = 1;
        echo str_repeat('', 0) . "33" . "<br>";
        $this->get_suborg(33, 1);
    }

    //temporary used by leon
    function get_suborg($parent_id, $level) {
        $arr = $this->M_org->select_suborg($parent_id, $level);
//        var_dump($arr);
        foreach ($arr as $key => $value) {
            echo str_repeat('- ', $level) . ($value->id . $value->org_name . "<br>");
            $this->get_suborg($value->id, $level + 1);
        }
    }

    //used for select potential user who belong to org which as 'user in the org but donnot has the privilege'
    //     and also select user who has the privilege as the "users already has the privilege"
    function get_org_role_user() {
        $org_id = $this->input->post("org_id");
        $role_id = $this->input->post("role_id");
//        echo $org_id."  -  ".$role_id;
        $data["available_user"] = $this->M_role_user->get_avaiable_user($org_id, $role_id);
        $data["org_user"] = $this->M_role_user->get_hasprivilege_user($role_id);
        echo json_encode($data);
    }

    function get_user_roleandprivilege() {
        $this->load->view('inc/header');


        $role_id = $this->session->userdata('role_id'); //== 1
        $user_id = $this->session->userdata('user_id'); //== 1
        //org admin can only see admin managed org
        if ($role_id == 5) {
            $data["org"] = $this->M_org->get_all_org();
        } else if ($role_id == 1) {
            $data["org"] = $this->M_org->get_all_admin_org($user_id);
        }

//        $data["org"] = $this->M_org->get_all_org();

        $this->load->view("userrolematrix/v_get_user_roleandprivilege", $data);

        $this->load->view('inc/footer');
    }

    function get_user_privilege() {
        $org_id = $this->input->post("org_id");
        $user_id = $this->input->post("user_id");

        $data["user_role"] = $this->M_org_user->get_org_user_role($org_id, $user_id);
        $data["user_privilege"] = $this->M_org_user->get_org_user_privilege($org_id, $user_id);
//        $data["user_privilege"] = $this->M_org_user->get_org_user_role($org_id,$user_id);
        echo json_encode($data);
    }

    function myprofile() {
        $this->load->view('inc/header');
        $user_id = $this->session->userdata('user_id');
        $data['user_profile'] = $this->M_org_user->get_profile($user_id);
        $this->load->view('userrolematrix/v_user_update_myprofile', $data);
        $this->load->view('inc/footer');
    }

    function update_myprofile() {
        $user_id = $this->session->userdata('user_id');
        $first_name = $this->input->post('first_name');
        $last_name = $this->input->post('last_name');
        $email = $this->input->post('email');
//        var_dump( $this->input->post() );
        $result = $this->M_org_user->update_myprofile($user_id, $first_name, $last_name, $email);
        if ($result) {
            $this->session->set_flashdata('message_success', "Successful update my profile");
            echo 'true';
        } else {
            $this->session->set_flashdata('message_error', "Email is duplicated with current users, please use different email");
            echo 'false';
        }
    }

    //starting of upload user function, which include 3 related functions
    function upload_user() {
        $this->load->view('inc/header');
        $this->load->view('userrolematrix/v_upload_user', array('error' => ''));
        $this->load->view('inc/footer');
    }

    function upload_user_process() {
        $config['upload_path'] = './assets/temporary_uploaded_user';
        $config['allowed_types'] = 'csv';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('inc/header');
            $this->load->view('userrolematrix/v_upload_user', $error);
            $this->load->view('inc/footer');
        } else {
            $data = $this->upload->data();
//            var_dump($data['full_path']);
            $this->parse_file($data['full_path']);

        }
        
    }

    function parse_file($p_filepath) {
 
        $file = fopen($p_filepath, 'r');
        $csvData = file_get_contents($p_filepath);
        $lines = explode(PHP_EOL, $csvData);
        $array = array();
        foreach ($lines as $line) {
            $array[] = str_getcsv($line);
        }
        array_shift($array);
//        echo "<pre>";
//        print_r($array[0]);
//        echo "</pre>";

        foreach ($array as $user) {
            if ($user != null) {
                $this->insert_user($user);
            }
        }
        $this->session->set_flashdata( 'message_success', 'Successful upload users');
        header("Location: ".current_url(), true, 302);

    }

    function insert_user($row) {
        $random_password = rand(11111111, 99999999);
        $is_email_available = $this->tank_auth->is_email_available($row[2]);

        $admin_id = $this->session->userdata('user_id');
        $org_admin = $this->M_org->select_admin_org($admin_id);
        $parent_org_id = $org_admin[0]->org_id;
        //echo $parent_org_id;


        if ($is_email_available) { //new email
            $user = $this->tank_auth->create_user("", $row[2], $random_password, 1, 3, true, $row[0], $row[1]);
            $user_id = $user['user_id'];
//            echo '<pre>';
//            var_dump($user);
//
//            echo '</pre>';
        } else {  //email already in the system
            $old_user = $this->user->get_userid($row[2]);
            $user_id = $old_user[0]->id;
//            echo 'old  user id is =' . $user_id;
        }


        //echo 'user id =' . $user_id;
        //step 1. active the user
        $this->user->active_user($user_id);

        //step2 add the user into the group
        $org_name = $row[3];
        $org_id_array = $this->M_org->get_orgid($parent_org_id, $org_name);
        if ($org_id_array != null) {
            $org_id = $org_id_array[0]->id;

            $this->M_org_user->delete_user_from_org($user_id);
            $this->M_org_user->insert_user($parent_org_id, $user_id);
            $this->M_org_user->insert_user($org_id, $user_id);
        }

        //step3 assign the user the role and corresponding privilege
        $role_name = $row[4];
        $role_id_array = $this->M_org_role->get_role_id($parent_org_id, $role_name);

        if ($role_id_array != null) {
            $role_id = $role_id_array[0]->id;

            //step 3.1 delete legacy role and add new role
            $this->M_role_user->delete_user_role($user_id);
            $this->M_role_user->insert_user($role_id, $user_id);

            //step 3.2 delete legacy privilege and add new privilge
            //delete previous privilege
            $this->M_user_privilege->update_privilege($user_id, 0);

            $privilege_array = $this->M_role_privilege->get_role_privilege($role_id);
            foreach ($privilege_array as $privilege) {
//             var_dump($privilege);
                $privilege_id = $privilege->privilege_id;

                //add latest privilege
                $this->M_user_privilege->update_user_privilege($user_id, $privilege_id, 1);
            }

//            $this->M_org_user->delete_user_from_org($user_id);
//            $this->M_org_user->insert_user($parent_org_id, $user_id);
//            $this->M_org_user->insert_user($org_id, $user_id);
        }
    }

    //ending of upload user function, which include 3 related functions
}

//end of class Org_privilege
