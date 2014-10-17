<?php

class receita_model extends CI_Model {


	public function getAllRecipes(){
		$id_usuario = $this->session->userdata("id");

        return $this->db->get_where('receita', array("id_usuario"=> $id_usuario))->result();

	}

	public function getForId($id){

		$this->db->where('id_receita', $id);
        $sql = $this->db->get('receita');

        return $sql->row_array();

	}

	public function getForIdUser($id){

		$this->db->where('id_usuario', $id);
        $sql = $this->db->get('receita');

        return $sql->result_array();

	}

	public function updateRecipe($id, $arr_dados = array()){

		$this->db->where('id_receita', $id);
		$this->db->update('receita', $arr_dados); 

	}

	public function insertRecipe($arr_dados = array()){

        $this->db->insert('receita', $arr_dados); 
        return $this->db->insert_id();

    }

    public function deleteRecipe($id){

    	$this->db->where('id_receita', $id);
        $this->db->delete('receita'); 

    }

}

?>