<?php

class usuario_model extends CI_Model {

	public function getForId() {
		$sql = $this->db->get('usuario');
        return $sql->result_array();
	}	

	public function insertUser($arr_dados = array() ) {
		$this->db->insert('usuario', $arr_dados);
		return $this->db->insert_id();
	}

        public function updateUser($id, $arr_dados = array()){

        $this->db->where('id_usuario', $id);
        $this->db->update('usuario', $arr_dados); 

	}
}