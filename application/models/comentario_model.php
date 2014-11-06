<?php

class comentario_model extends CI_Model {


	public function insert($dados){

		$this->db->insert("comentario", $dados);

	}

	public function get($id){


		return $this->db->from("comentario")->where('id_receita', $id)->get()->result_array();

	}

    public function delete($id){

    	$this->db->delete("comentario", $id);

    }
   

}