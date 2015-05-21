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
class M_user_privilege extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_user_privilege($userid = "") {
        if ($userid !== "") {
            $sql = "SELECT a.id,a.privilege_name, b.privilege_value, b.user_id FROM  privilege as a
                    LEFT JOIN (select * from  user_privilege  where user_privilege.user_id=" . $userid . ") as b
                  ON a.id=b.privilege_id order by a.privilege_name";

            $query = $this->db->query($sql);
            $result = $query->result();
            return $result;
        } else {
            return false;
        }
    }

    public function update_user_privilege($userid, $name, $value) {
        $sql = "insert into user_privilege(user_id,privilege_id,privilege_value) VALUES ($userid,$name, $value) ON DUPLICATE KEY UPDATE privilege_value=VALUES(privilege_value)";
        $query = $this->db->query($sql);
//        $result = $query->result();
//        return $result;
    }
    
    
    public function check_user_privilege($user_id, $privilege_id) {
//        $sql = "select 1 from user_privilege where user_id=$user_id and privilege_id=$privilege_id";
        $sql = "select 1 from user_privilege where user_id=$user_id and privilege_id=$privilege_id and privilege_value=1";
        $query = $this->db->query($sql);
        $result = $query->result();
        if ($result) {
            return TRUE;
        } else {
//            return NULL; //previous is null , i changed it for lee's want it , it may affect my code lead my code doesn't work. leon need double check the function
            return FALSE;
        }
    }
    
    public function update_privilege($user_id,$privilege_value){
        $sql = "update user_privilege set privilege_value =$privilege_value  where user_id=$user_id";
        $query =$this->db->query($sql) ;
        
    }
}
