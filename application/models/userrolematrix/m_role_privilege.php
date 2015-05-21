<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_org_privilege
 *
 * @author leon
 */
class M_role_privilege extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function get_privilege($org_id, $role_id) {
        $sql = "select a.privilege_id, b.privilege_value,a.privilege_name from (SELECT privilege_id, privilege_value, privilege_name FROM org_privilege ,privilege WHERE org_id=$org_id  and privilege_value=1 and org_privilege.privilege_id=privilege.id) as a LEFT JOIN (SELECT privilege_id, privilege_value from role_privilege where role_id=$role_id) AS b on a.privilege_id=b.privilege_id";
        $query = $this->db->query($sql);
        $result = $query->result();
//       var_dump($sql);
        return $result;
    }

    function update_privilege( $role_id, $privilege_id, $value) {
//insert into role_privilege(role_id,privilege_id,privilege_value) VALUES (37,127,1) ON DUPLICATE KEY UPDATE privilege_value=VALUES(privilege_value)
//        $sql = "insert into role_privilege(org_id,privilege_id,privilege_value) VALUES ($org_id, $priviliege_id, $value) ON DUPLICATE KEY UPDATE privilege_value=VALUES(privilege_value)";
        $sql = "insert into role_privilege(role_id,privilege_id,privilege_value) VALUES ($role_id, $privilege_id,$value) ON DUPLICATE KEY UPDATE privilege_value=VALUES(privilege_value)";
//        echo $sql;
        $this->db->query($sql);
    }

//    function update_privilege($org_id, $priviliege_id, $value) {
//        $sql = "insert into org_privilege(org_id,privilege_id,privilege_value) VALUES ($org_id, $priviliege_id, $value) ON DUPLICATE KEY UPDATE privilege_value=VALUES(privilege_value)";
//        $query = $this->db->query($sql);
//    }

    
    function get_role_privilege($role_id){
        $sql = " select privilege_id from role_privilege where role_id=$role_id and privilege_value=1";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    
    
} //End of class M_org_privilege
