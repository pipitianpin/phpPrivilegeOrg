<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_org
 *
 * @author leon
 */
class M_org extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function get_all_org() { //first level org
        $sql = "select id,org_name, parent_id from org where parent_id IS NULL";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
	
	function is_org_exist($org_id="%") { //first level org
        $sql = "select id,org_name, parent_id from org where parent_id IS NULL and id = ".$org_id." and isActive=1";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
	
    function get_all_admin_org($user_id) { //first level org
        $sql = "select  org.id,org.org_name, org.parent_id  from org_admin, org where org_admin.org_id=org.id and parent_id IS NULL and user_id=$user_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function insert($org_name) {
        $sql = "INSERT IGNORE INTO org SET org_name= '" . $org_name . "'";
        $query = $this->db->query($sql);

        $sql = "select id,org_name from org order by id desc";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function insert_with_orgname_parentid($org_name, $parent_id) {
        if ($parent_id == NULL) {
            $sql = "INSERT INTO org(org_name, parent_id) values('" . $org_name . "',NULL)";
        } else {
            $sql = "INSERT INTO org(org_name, parent_id) values('" . $org_name . "'," . $parent_id . ")";
        }
        echo $sql;
        $query = $this->db->query($sql);
    }

//    function select_suborg($parent_id, $level)
    function select_suborg($parent_id = NULL, $org_id = NULL) {
        if ($org_id == NULL) {
            if ($parent_id == NULL) {
                $sql = "select id,org_name, parent_id from org where parent_id IS NULL order by org_name ASC";
            } else {
                $sql = "select * from org where parent_id = $parent_id order by org_name ASC";
            }
        } else {
            $sql = "select id,org_name, parent_id from org where parent_id IS NULL and id=$org_id";
        }
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function select_admin_suborg($parent_id = NULL, $org_id = NULL) {
        if ($org_id == NULL) {
            if ($parent_id == NULL) {
                $sql = "select id,org_name, parent_id from org where parent_id IS NULL order by org_name ASC";
            } else {
                $sql = "select * from org where parent_id = $parent_id order by org_name ASC";
            }
        } else {

            if ($parent_id == NULL) {
                $sql = "select id,org_name, parent_id from org where parent_id IS NULL and id=$org_id order by org_name ASC";
            } else {
                $sql = "select * from org where parent_id = $parent_id order by org_name ASC";
            }
            //select specific org only managed by the admin
            $org_id = NULL;
        }

        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function select_admin_org($user_id = NULL) {
        $sql = "select org_id from org_admin where user_id=$user_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function update_org($org_id, $org_name) {
        $sql = "update org set org_name ='" . $org_name . "' where  id=$org_id";
        $query = $this->db->query($sql);
//                echo $sql;
    }

    function delete_org($org_id) {
        $sql = "delete from org where id=$org_id";
//        echo $sql;
        $this->db->query($sql);
    }

    function get_parent_orgid($org_id) {
        $sql = "select parent_id from org where id=$org_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }

    function get_children_orgid($org_id) {
        $sql = "select id from org where parent_id=$org_id";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
    function get_orgid($parent_id, $org_name) {
        $sql = "select id from org where parent_id=$parent_id and org_name='".$org_name."'";
        $query = $this->db->query($sql);
        $result = $query->result();
        return $result;
    }
    
}//end of class M_org
