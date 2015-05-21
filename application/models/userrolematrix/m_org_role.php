<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mo_user_privilege
 *
 * @author leon
 */
class M_org_role extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    function get_privilege($org_id) {
        $sql = "select id,role_name from org_role where org_id=$org_id";
        $query = $this->db->query($sql);
        $result = $query->result();
//       var_dump($result);
        return $result;
    }
    
    function insert($org_id, $role_name)
    {
        $sql = "INSERT INTO `org_role`(`org_id`, `role_name`) VALUES ($org_id, '$role_name')";
//        var_dump($sql);
        $this->db->query($sql);
//        return $sql;
    }
    
    function get_role_id($org_id, $role_name)
    {
        $sql = "select id from org_role where org_id=$org_id and role_name = '".$role_name."'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function delete_role($org_id,$role_id)
    {
        $sql = "delete from org_role where id='$role_id' and  org_id='$org_id'";
        $this->db->query($sql);
    }
}//end of class M_org_role
