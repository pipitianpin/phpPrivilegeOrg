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
class M_org_user extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function get_user($org_id) {
        $sql = "select users.id,users.email, users.first_name, users.last_name from org_user, users where org_user.user_id= users.id and users.activated=1 and org_id=" . $org_id;
        $query = $this->db->query($sql);
        $result = $query->result();
//       var_dump($result);
        return $result;
    }

    //changed on 03-13 to show user email while user name. so make a backup
//    function get_user($org_id) {
//        $sql = "select users.id,username from org_user, users where org_user.user_id= users.id and org_id=" . $org_id ;
//        $query = $this->db->query($sql);
//        $result = $query->result();
////       var_dump($result);
//        return $result;
//    }
//    


    function get_avaiable_user($org_id) {
        $sql = "select a.id,a.email, a.first_name, a.last_name from (select id, email, first_name, last_name from  users where users.activated=1 ) as a 
left join 
(select users.id, email from org_user, users where org_user.user_id= users.id and org_id=$org_id ) as b
on a.id=b.id
where b.id is NULL";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

//    function update_privilege($org_id, $priviliege_id, $value) {
//        $sql = "insert into org_privilege(org_id,privilege_id,privilege_value) VALUES ($org_id, $priviliege_id, $value) ON DUPLICATE KEY UPDATE privilege_value=VALUES(privilege_value)";
//        $query = $this->db->query($sql);
//    }
    function insert_user($org_id, $value) {
        $sql = "insert into org_user(org_id, user_id ) VALUES ($org_id, $value)"; // ON DUPLICATE KEY UPDATE privilege_value=VALUES(privilege_value)";
        $query = $this->db->query($sql);
    }

    function delete_org_user($org_id, $value) {
        $sql = "delete  from  org_user where org_id=$org_id and user_id=$value";
        $query = $this->db->query($sql);
    }

    function get_org_user_role($org_id, $user_id) {
        $sql = "select b.role_name, a.role_id from (select role_name , role_id from role_user, org_role where role_user.role_id = org_role.id  and org_id=$org_id and user_id=$user_id ) as a
right  join (select * from org_role where org_id=$org_id) as b
on a.role_id = b.id";
        $query = $this->db->query($sql);
        $result = $query->result();
//       var_dump($sql);
        return $result;
    }

    function get_org_user_privilege($org_id, $user_id) {
        $sql = "select a.privilege_name, a.privilege_value from (select privilege_id, user_id, privilege_value , privilege_name from user_privilege, privilege where user_id=$user_id 
 and  user_privilege.privilege_id=privilege.id) as a
left join 
(select privilege_id, org_id, privilege_value from org_privilege where org_id like '".$org_id."' and privilege_value=1) as b
on  a.privilege_id = b.privilege_id
where b.privilege_value=1";
        $query = $this->db->query($sql);
        $result = $query->result();
//       var_dump($sql);
        return $result;
    }

    function get_orgid_by_userid($user_id) {
        $sql = "select org_id  from org_user where user_id='".$user_id."'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

     //coded for preeti so she could get the users highese org which will insert into embeded video which ensure even user
    //is deleted, the org info is still there , so when the org is un subscribed, we could delete the embed video and token

    function get_highest_org($user_id) {
        $sql = "select a.org_id  from org_user a left join org  b on a.org_id = b.id where b.parent_id is null and a.user_id=$user_id ";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    
    function get_profile($user_id){
        $sql = "select first_name, last_name, email from users where id=$user_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    
    function update_myprofile($user_id, $first_name, $last_name,$email){
        $sql = "update users set first_name='".$first_name."', last_name='".$last_name."', email='".$email."'  where id=$user_id";
        $query = $this->db->query($sql);
       return  $query;
    }
    
    function delete_user_from_org($user_id){
        $sql = "delete from org_user where user_id=$user_id";
        $query = $this->db->query($sql);
       return  $query;
    }
    
    
}

//End of class M_org_privilege
