<?php

class receita_model extends CI_Model {


	public function getAllRecipes(){
		$id_usuario = $this->session->userdata("id");
        return $this->db->get_where('receita', array("id_usuario"=> $id_usuario))->result();
	}


    public function getAllRecipesArray(){
        $this->db->select('r.id_receita, r.id_usuario, r.nome, r.ingredientes, r.modo_preparo, r.categoria, r.foto, r.observacao, r.ativo, u.nome as nome_user, u.foto as foto_user, c.nome as nome_categoria');
        $this->db->from('receita as r');
        $this->db->join('usuario as u', "r.id_usuario = u.id_usuario");
        $this->db->join('categoria as c', "c.id_categoria = r.categoria");
        $this->db->where('r.ativo', 1);
        $this->db->where("r.id_usuario", $this->session->userdata("id"));
        $this->db->order_by('r.id_receita', 'DESC');

        return $this->db->get()->result_array();
    }

    public function getAllRecipesSemIdUsuario() 
    {
        return $this->db->get('receita')->result();
    }

	public function getAllRecipesAndUser($limit = ""){


        /* usado na HOME
        pegar as 6 primeiras para o banner
        ou
        pegar as proximas 12 para a listagem
        */
        if($limit){
            $this->db->limit(12, $limit);
        } else {
            $this->db->limit(6);
        }

		$this->db->select('r.id_receita, r.id_usuario, r.nome, r.ingredientes, r.modo_preparo, r.categoria, r.foto, r.observacao, r.ativo, u.nome as nome_user, u.foto as foto_user, c.nome as nome_categoria');
        $this->db->from('receita as r');
        $this->db->join('usuario as u', "r.id_usuario = u.id_usuario");
        $this->db->join('categoria as c', "c.id_categoria = r.categoria");
        $this->db->where('r.ativo', 1);
        $this->db->order_by('r.id_receita', 'DESC');

        $sql = $this->db->get();

        //echo $this->db->last_query();
        
        return $sql->result_array();

	}

	public function getForId($id){

        $this->db->select('r.id_receita, r.id_usuario, r.nome, r.ingredientes, r.modo_preparo, r.categoria, r.foto, r.observacao, r.ativo, u.nome as nome_user, u.foto as foto_user, c.nome as nome_categoria');
        $this->db->from('receita as r');
        $this->db->join('usuario as u', "r.id_usuario = u.id_usuario");
        $this->db->join('categoria as c', "c.id_categoria = r.categoria");
        $this->db->where('r.ativo', 1);
        $this->db->where('r.id_receita', $id);
        return $this->db->get('receita')->row_array();

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

    public function getCategoriasReceitas(){

        return $this->db->from("categoria")->get()->result_array();
    }

}

?>