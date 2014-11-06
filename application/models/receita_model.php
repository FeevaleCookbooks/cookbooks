<?php

class receita_model extends CI_Model {


	public function getAllRecipes(){
		$id_usuario = $this->session->userdata("id");
        return $this->db->get_where('receita', array("id_usuario"=> $id_usuario))->result();

	}

    public function getAllRecipesSemIdUsuario() 
    {
        return $this->db->get('receita')->result();
    }

	public function getAllRecipesAndUser(){

		$this->db->select('r.id_receita, r.id_usuario, r.nome, r.ingredientes, r.modo_preparo, r.categoria, r.foto, r.observacao, r.ativo, u.nome as nome_user');
        $this->db->from('receita as r');
        $this->db->join('usuario as u', "r.id_usuario = u.id_usuario");
        $this->db->where('r.ativo', 1);
        $this->db->order_by('r.id_receita', 'DESC');

        $sql = $this->db->get();
        
        return $sql->result_array();

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