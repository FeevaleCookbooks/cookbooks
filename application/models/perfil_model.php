<?php

	class perfil_model extends CI_Model {

		public function getForId(){

		$query = $this->db->query("SELECT * FROM usuario WHERE id_usuario = " . $this->session->userdata('id')."");
		
        return $query->result_array();

	}


	}
?>