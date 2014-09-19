<?php

class recipes_model extends CI_Model {


	public function getAllRecipes(){

        $sql = $this->db->get('receita');
        return $sql->result_array();

	}

	public function getForId($id){

		$this->db->where('id_receita', $id);
        $sql = $this->db->get('receita');

        return $sql->result_array();

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

    	$this->db->where('id', $id);
        $this->db->delete('receita'); 

    }

}

?>