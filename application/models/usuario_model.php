<?php

class usuario_model extends CI_Model {

	public function getForId() {
		$sql = $this->db->select('u.*, r.foto as foto_receita')
					->join("receita as r", "r.id_usuario = u.id_usuario AND r.foto is not null", "LEFT")
					->group_by('u.id_usuario')
					->get('usuario as u');
					//echo $this->db->last_query();
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

	public function updateById($params) {
		$this->db->where('id_usuario', $this->session->userdata('id'));
        $this->db->update('usuario', $params); 
	}
}


