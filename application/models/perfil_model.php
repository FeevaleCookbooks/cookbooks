<?php

	class perfil_model extends CI_Model {

		public function getForId(){

		$query = $this->db->query("
                    SELECT  usuario.id_usuario,
                            usuario.nome,
                            usuario.email,
                            usuario.senha,
                            usuario.cidade,
                            usuario.profissao,
                            usuario.foto,
                            usuario.observacao,
                            usuario.ativo,
                            COUNT(receita.id_receita) AS quantidade_receitas
                    FROM usuario 
                    JOIN receita ON receita.id_usuario = usuario.id_usuario
                    WHERE usuario.id_usuario = " . $this->session->userdata('id')."
                    GROUP BY usuario.id_usuario
                    ");
		
        return $query->result_array();
		
		}

		public function getReceitasByPerfil(){

			return $this->db->from("receita")->where("", )

		}

	}
?>