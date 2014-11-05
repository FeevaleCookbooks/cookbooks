<?php

class comentario_model extends CI_Model {


	public function insert($dados){

		$this->db->insert("comentario", $dados);

	}

    public function delete($id){

    	$this->db->delete("comentario", $id);

    }
   

}