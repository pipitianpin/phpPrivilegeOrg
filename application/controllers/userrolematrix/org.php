<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of organization
 *
 * @author leon
 */
class Org extends CI_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->helper(array("form", "url"));
        $this->load->library("form_validation");
        $this->load->library('table');

        $this->load->model("userrolematrix/m_privilege");
        $this->load->model('userrolematrix/m_org');
        $this->load->model("userrolematrix/M_org_user");



        $this->load->library('tank_auth');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }
    }

    function create_org() {
        $this->load->view('inc/header');

        $data['org'] = $this->m_org->get_all_org();
//        var_dump($data['org']);

        $this->load->view('userrolematrix/v_create_org', $data);

        $this->load->view('inc/footer');
        return true;
    }

    function result() {
        $org_name = $this->input->post("org_name");
//         $this->load->model("userrolematrix/m_org");
        $data["result"] = $this->m_org->insert($org_name);
        echo json_encode($data);
    }

    //temporary used by leon
    function suborg_management() {
        $this->load->view('inc/header');


        $data["org"] = $this->m_org->get_all_org();
        $this->load->view("userrolematrix/v_suborg_management", $data);
//        foreach ( $arr as $)
        $this->load->view('inc/footer');
    }

    function update_org_name() {
//        echo 'dd';
//        var_dump( $this->input->post());
        $org_id = $this->input->post('org_id');
        $org_name = $this->input->post('org_name');



        $this->m_org->update_org($org_id, $org_name);
        echo '<div class="alert alert-success" id="alertFadeout">Category edited successfully</div>';
    }

//    function delete_org() {
////        echo 'leon';
//        $org_id = $this->input->post("org_id");
//        $this->m_org->delete_org($org_id);
//    }

    function delete_org() {
//        echo 'leon';
        $org_id = $this->input->post("org_id");
        $this->delete_end_org($org_id);
    }

    function delete_end_org($id) {
//        echo $id."<br>";
        $arr = $this->m_org->select_suborg($id);
        if (is_array($arr) && count($arr) != 0) {
            foreach ($arr as $org) {
                $this->delete_end_org($org->id);
            }
        }
//        $org_id = $this->input->post("org_id");
        $this->m_org->delete_org($id);
    }

    function display_suborg() {
//        echo 'leon';
        $out = "<ul style='list-style-type: inherit'>";
        if ($_POST) {
            $org_id = $this->input->post('org_id');
            $parent_id = $this->input->post('parent_id');
//                $out += "$org_id";//"<ul>";
            $suborg = $this->m_org->select_suborg($org_id);
            if (is_array($suborg) && count($suborg) != 0) {
                foreach ($suborg as $one_org) {
//                    echo $one_org->org_name;
                    $out .= '<li id="delete' . $one_org->id . '"><span id="name' . $one_org->id . '">' . $one_org->org_name . '</span>';
                    $out .= '<small>';
                    $out .="(<a href='#' onclick='edit_org(" . $one_org->id . "," . '"' . $one_org->org_name . '"); return false; ' . "'" .
                            " class='glyphicon glyphicon-edit' title='Edit'></a> ";



                    $out.=')';

                    $out .='</li>';
                }
            }//end of if
//                var_dump($suborg);
            $out .="</ul>";
        }//end of if
        echo $out;
    }

//end of function display_suborg

    function sub_org() {
        $save = '';
        $org_id = '';
        $this->load->view('inc/header');
        $role_id = $this->session->userdata('role_id'); //== 1
        $user_id = $this->session->userdata('user_id'); //== 1
        if ($role_id != 1 and $role_id != 5) {
            redirect('');
        }
//org admin only create sub-org base on the org grant to him in table org_admin
        if ($role_id == 1) {
            $org_id = $this->m_org->select_admin_org($user_id);
            if($org_id == NULL) {
                            redirect('');
            }
            $org_id = $org_id[0]->org_id;
//            var_dump($org_id);
            $save = $this->get_admin_suborg(NULL, $org_id);
        } else if ($role_id == 5) {
            $save = $this->get_suborg();
        }
        $data['save'] = $save;
        $this->load->view("userrolematrix/v_suborg", $data);
        $this->load->view('inc/footer');
    }

    function get_suborg($id = NULL) {
        $out = '<ul style="list-style-type:circle">';
        $arr = $this->m_org->select_suborg($id);
        if (is_array($arr) && count($arr) != 0) {
            foreach ($arr as $sub) {
                $out .= "<li id='delete" . $sub->id . "'>";
                $out .= "<span id='name" . $sub->id . "'>" . $sub->org_name . "</span>";
                $out .= "<small>";
                $out .= "(<a href='#' onclick='edit_org(" . $sub->id . ',"' . $sub->org_name . '")' . "; return false;' class='glyphicon glyphicon-edit' title='Edit'></a>";
                $out .= ", <a href='#' onclick='delete_org(" . $sub->id . "); return false;' class='glyphicon glyphicon-trash' title='Delete'></a>)";
                $out .='</small>';
                $out .= '<div id="return_suborg' . $sub->id . '"></div>';
                $out .="</li>";
                $out .=$this->get_suborg($sub->id);
            }
        }
//        echo '<br>';
        $out .= '<div><a href="#" onclick="add_suborg(' . $id . ')" style="color:brown"> + add sub organization<br></a></div>';
        $out .= '<div id="new_org' . $id . '"></div>';
        $out .="</ul>";
//        var_dump($arr);
//        echo '---';
        return $out;
    }

    function get_admin_suborg($id = NULL, $org_id=NULL) {
        $out = '<ul style="list-style-type:circle">';
        $arr = $this->m_org->select_admin_suborg($id, $org_id);
        if (is_array($arr) && count($arr) != 0) {
            foreach ($arr as $sub) {
                $out .= "<li id='delete" . $sub->id . "'>";
                $out .= "<span id='name" . $sub->id . "'>" . $sub->org_name . "</span>";
                $out .= "<small>";
                $out .= "(<a href='#' onclick='edit_org(" . $sub->id . ',"' . $sub->org_name . '")' . "; return false;' class='glyphicon glyphicon-edit' title='Edit'></a>";
                $out .= ", <a href='#' onclick='delete_org(" . $sub->id . "); return false;' class='glyphicon glyphicon-trash' title='Delete'></a>)";
                $out .='</small>';
                $out .= '<div id="return_suborg' . $sub->id . '"></div>';
                $out .="</li>";
                $out .=$this->get_admin_suborg($sub->id, NULL);
            }
        }
//        echo '<br>';
        if( $org_id == NULL) {
            $out .= '<div><a href="#" onclick="add_suborg(' . $id . ')" style="color:brown"> + add sub organization<br></a></div>';
        }
        $out .= '<div id="new_org' . $id . '"></div>';
        $out .="</ul>";
//        var_dump($arr);
//        echo '---';
        return $out;
    }

    function add_suborg() {
//        echo 'add suborg';
        $org_name = $this->input->post('org_name');
        $parent_id = $this->input->post('parent_id');
        if ($parent_id == NULL) {
            $parent_id = NULL;
        }
        echo $org_name;
        echo $parent_id;

        $this->m_org->insert_with_orgname_parentid($org_name, $parent_id);
    }

    //start  of used for add user into sub org
    function add_user_into_sub_org() {
        $this->load->view('inc/header');
        $save = "<h3 align='center'>Add users into sub-org</h3><label>Choose one org or sub-org: </label><form role='form'>";
        
        $org_id = '';
        $role_id = $this->session->userdata('role_id'); //== 1
//        echo $role_id;
        $user_id = $this->session->userdata('user_id'); //== 1
//        echo $user_id;
        if ($role_id != 1 and $role_id != 5) {
            redirect('');
        }
//org admin only create sub-org base on the org grant to him in table org_admin
        if ($role_id == 1) {
            $org_id = $this->m_org->select_admin_org($user_id);
            if($org_id == NULL) {
                            redirect('');
            }
            $org_id = $org_id[0]->org_id;
//            var_dump($org_id);
            $save .= $this->get_admin_suborg2(NULL, $org_id);
        } else if ($role_id == 5) {
            $save .= $this->get_suborg2();
        }
//        $save .= $this->get_suborg2();
        $save .= "</form>";
        $data['save'] = $save;
        $this->load->view("userrolematrix/v_suborg2", $data);
        $this->load->view('inc/footer');
    }

    function get_suborg2($id = NULL) {
        $out = '<ul>';
        $arr = $this->m_org->select_suborg($id);
        if (is_array($arr) && count($arr) != 0) {
            foreach ($arr as $sub) {
                $out .= "<li id='delete" . $sub->id . "'>";
                $out .= "<div class='radio'> <a href='#' onclick='list_user(" . $sub->id . ")'> <label> <input type='radio' name='optradio' id='" . $sub->id . "'>" . $sub->org_name . "</label></a></div>";
                $out .="</li>";
                $out .=$this->get_suborg2($sub->id);
            }
        }
        $out .="</ul>";
        return $out;
    }

    
        function get_admin_suborg2($id = NULL, $org_id = NULL) {
        $out = '<ul>';
        $arr = $this->m_org->select_suborg($id, $org_id);
        if (is_array($arr) && count($arr) != 0) {
            foreach ($arr as $sub) {
                $out .= "<li id='delete" . $sub->id . "'>";
                $out .= "<div class='radio'> <a href='#' onclick='list_user(" . $sub->id . ")'> <label> <input type='radio' name='optradio' id='" . $sub->id . "'>" . $sub->org_name . "</label></a></div>";
                $out .="</li>";
                $out .=$this->get_admin_suborg2($sub->id, NULL);
            }
        }
        $out .="</ul>";
        return $out;
    }

    //end of used for add user into sub org
}

//end of class Organization
