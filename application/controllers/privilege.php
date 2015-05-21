<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of privilege
 *
 * @author Leon
 */
class Privilege extends CI_Controller {

    //put your code here


    public function __construct() {
        parent::__construct();
        $this->load->helper(array("form", "url"));
        $this->load->library("form_validation");
        $this->load->library('table');
//

        $this->load->model("userrolematrix/m_privilege");
        $this->load->model("userrolematrix/M_org");
        $this->load->model("userrolematrix/M_org_user");

        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {
            $this->session->set_userdata('url',current_url());
            redirect('/auth/login/');
        }
    }
    

    
    public function index() {
//            $this->session->set_userdata('leonurl',current_url());

       // var_dump(  $this->session->all_userdata() );

        $this->load->view('inc/header');

//               $this->form_validation->set_rules("userprivilege","User Privilege","required");
        $this->load->view("userrolematrix/main");
    }

    //privilege management
    public function add_privilege() {
        $this->load->view('inc/header');
        $data['entry'] = $this->m_privilege->get_all_entry();
        $this->load->view("userrolematrix/privilege", $data);
    }

    public function user_data_submit() {
//        echo "true";
        $privilege_input = $this->input->post("privilege_input");
//        echo $privilege_input;
        $this->m_privilege->insert_entry($privilege_input);
        $data['entry'] = $this->m_privilege->get_all_entry();
        echo json_encode($data);
    }

    //user_privilege management
    public function get_user_privilege_pre() {
        $this->load->view('inc/header');


        $this->load->model('user');

        $role_id = $this->session->userdata('role_id'); //== 1
        $user_id = $this->session->userdata('user_id'); //== 1
        //org admin can only see admin managed org
        if ($role_id == 5) {
            $data['users'] = $this->user->get_all_user_name_id();
            $data['org_id'] = '%';
        } else if ($role_id == 1) {
            $data["org"] = $this->M_org->get_all_admin_org($user_id);
            $org_id = $data["org"][0]->id;
            $data['users'] = $this->M_org_user->get_user($org_id);
            $data['org_id'] = $org_id;
        }



//        $this->load->model('userrolematrix/m_user_privilege');
//        $user_id = '';//$this->session->userdata('user_id');
//        $data["result"]=$this->m_user_privilege->get_user_privilege($user_id);
        $this->load->view('userrolematrix/v_user_privilege', $data);
    }

    //user_privilege management
    public function get_user_privilege($user_id = "") {
        $org_id = ($this->input->post('org_id'));
        $role_id = $this->session->userdata('role_id'); //== 1
        // super admin could assign any privilege to any user; org admin only assign privileges which assigned to org then to user 
        if ($role_id == 5) {
            $this->load->model('userrolematrix/m_user_privilege');
            $data["result"] = $this->m_user_privilege->get_user_privilege($user_id);
        } else if ($role_id == 1) {
            $data["result"] = $this->M_org_user->get_org_user_privilege($org_id, $user_id);
        }
        echo json_encode($data);
    }

    public function get_user_privilege_feedback() {

        $this->load->model('userrolematrix/m_user_privilege');

        $arr = $this->input->post();
//        var_dump($arr);
        $userid = $arr['userid'];
//        echo strpos($userid,' ');
//        $userid = substr($userid, 0, strpos($userid, ' '));
//        $this->session->set_flashdata('message_success', "Privilege Modified");
        foreach ($this->input->post() as $name => $value) {
            if ($name !== 'userid') {
                $this->m_user_privilege->update_user_privilege($userid, $name, $value);
            }
        };

        //$this->load->view('inc/footer'); 
    }

}

//end of class
?>
