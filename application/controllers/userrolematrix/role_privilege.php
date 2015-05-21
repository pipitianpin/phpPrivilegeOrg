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
class Role_privilege extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->helper(array("url"));

        $this->load->model("userrolematrix/M_org");
        $this->load->model("userrolematrix/M_org_role");
        $this->load->model("userrolematrix/M_role_privilege");
//        $this->load->model("userrolematrix/m_org");

        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }
    }

    function index() {
        $this->create_role();
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

        $this->load->view("userrolematrix/v_role_privilege", $data);
        $this->load->view('inc/footer');
    }

    function select_privilege_to_role() {
        $org_id = $this->input->post("org_id");
//        $org_id = substr($org_id, 0, strpos($org_id, ' '));
//        var_dump($org_id);
        $role_id = $this->input->post("role_id");
//        var_dump($role_id);
        
        $data["role_privilege"] = $this->M_role_privilege->get_privilege($org_id,$role_id);
        echo json_encode($data);
    }

    function assign_privilege_to_role() {
//        $org_id = $this->input->post("org_id");
        $role_id = $this->input->post("role_id");
//        var_dump( $this->input->post());
        
       $sumdata = $this->input->post();
        foreach ($sumdata as $key => $value) {
            if ( $key !== "role_id") {
//               echo $key."   --".$value."/n/t";
                $this->M_role_privilege->update_privilege($role_id, $key, $value);
            }
        }
    }

    
}//end of class
