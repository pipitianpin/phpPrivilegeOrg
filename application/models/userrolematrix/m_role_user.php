<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_role_user
 *
 * @author leon
 */
class M_role_user extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function get_avaiable_user($org_id, $role_id) {
        $sql = "select a.id, a.email , a.first_name, a.last_name from (select users.id, users.email, users.first_name, users.last_name from org_user, users  where  users.activated=1 and org_user.user_id = users.id and org_id=$org_id ) as a 
left join 
(select users.id,users.email from role_user, users where role_user.user_id= users.id and role_user.role_id=$role_id) as b 
on a.id=b.id
where b.id is NULL";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function get_hasprivilege_user($role_id) {
        $sql = "select users.id,users.email , users.first_name, users.last_name from role_user, users where  users.activated=1 and role_user.user_id= users.id and role_user.role_id=" . $role_id;
        $query = $this->db->query($sql);
        $result = $query->result();
//       var_dump($result);
        return $result;
    }

    function insert_user($role_id, $user_id) {
        $sql = "insert into role_user(role_id, user_id ) VALUES ($role_id, $user_id)"; // ON DUPLICATE KEY UPDATE privilege_value=VALUES(privilege_value)";
        $query = $this->db->query($sql);
    }

    function delete_user($role_id, $user_id) {
        $sql = "delete from role_user where role_id=$role_id and user_id=$user_id"; // ON DUPLICATE KEY UPDATE privilege_value=VALUES(privilege_value)";
        $query = $this->db->query($sql);
    }
    function delete_user_role( $user_id) {
        $sql = "delete from role_user where user_id=$user_id"; // ON DUPLICATE KEY UPDATE privilege_value=VALUES(privilege_value)";
        $query = $this->db->query($sql);
    }

}

//End of class 
