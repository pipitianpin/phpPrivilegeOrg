<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of privilege
 *
 * @author preeti
 */

class M_privilege extends CI_Model
{
     public $privilege_name ='';
    
    
    function __construct() {
        parent::__construct();
        
    }
    
    public function get_all_entry()
    {
        $query = $this->db->get('privilege');
        $result = $query->result();
        return $result;
    }
    
    
    public function insert_entry($privilege_input)
    {
//            $this->privilege_name = $this->input->post('privilegeinput');
//            $this->db->insert('privilege', $this);
//     echo $privilege_input;
        $sql = 'INSERT INTO `privilege`(`privilege_name`) VALUES ("'.$privilege_input.'") ';
        $this->db->query($sql);
     }
    
} //end of class
?>