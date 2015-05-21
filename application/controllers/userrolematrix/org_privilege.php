<?php

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
class Org_privilege extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->helper(array("url"));

        $this->load->model("userrolematrix/M_org");
        $this->load->model("userrolematrix/M_org_privilege");

//        $this->load->model("userrolematrix/m_org");

        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }
    }

    function select_org() {
        $this->load->view('inc/header');

        $data["org"] = $this->M_org->get_all_org();
        $this->load->view("userrolematrix/v_org_privilege", $data);

        $this->load->view('inc/footer');
    }

    function assign_privilege_to_org() {
        $org_id = $this->input->post("org_id");
//        $org_id = substr($org_id, 0, strpos($org_id, ' '));
        $data["org_privilege"] = $this->M_org_privilege->get_privilege($org_id);
        echo json_encode($data);
    }

    function update_org_privilege() {
        $org_id = $this->input->post("org_id");
//        $org_id = substr($org_id, 0, strpos($org_id, ' '));
//        echo $org_id;

        $sumdata = $this->input->post();
        foreach ($sumdata as $key => $value) {
            if ($key !== "org_id") {
//               echo $key.$value;
                $this->M_org_privilege->update_privilege($org_id, $key, $value);
            }
        }
    }
    
    function test($id)
    {
        $this->load->library("check_privilege");
       var_dump( $this->check_privilege->get_user_privilege($id) );
    }

}

//end of class Org_privilege
