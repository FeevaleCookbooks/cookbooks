<?php

class login_model extends CI_Model {

    public function logar($user, $pass){

        $this->db->where('email', $user);
        $this->db->where('senha', $pass);
        $this->db->where('status', 1);
        $sql = $this->db->get('tbl_usuario');

        return $sql->result_array();

    }

}

?>
