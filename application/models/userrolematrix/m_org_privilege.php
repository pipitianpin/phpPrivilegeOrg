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
class M_org_privilege extends CI_Model {

    //put your code here
    function __construct() {
        parent::__construct();
    }

    function get_privilege($org_id) {
        $sql = "select g.privilege_value, privilege.id, privilege.privilege_name  from privilege left join  (select privilege_id, privilege_value from org_privilege where org_id=" . $org_id . ") as g on  privilege.id = g.privilege_id
 order by privilege.id";
        $query = $this->db->query($sql);
        $result = $query->result();
//       var_dump($result);
        return $result;
    }

    function update_privilege($org_id, $priviliege_id, $value) {
        $sql = "insert into org_privilege(org_id,privilege_id,privilege_value) VALUES ($org_id, $priviliege_id, $value) ON DUPLICATE KEY UPDATE privilege_value=VALUES(privilege_value)";
        $query = $this->db->query($sql);
    }

}

//End of class M_org_privilege
