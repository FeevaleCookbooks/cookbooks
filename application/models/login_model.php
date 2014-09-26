<?php

class login_model extends CI_Model {

    public function logar($user, $pass){

        $this->db->where('email', $user);
        $this->db->where('senha', $pass);
        $sql = $this->db->get('tbl_user');

        return $sql->result_array();

    }

}

?>
