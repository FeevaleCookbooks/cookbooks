<?php
	/*
	 * Está classe servirá para todos os cadastros default do site
	 */
	class _Global { 
		
		// tabela global_pais
		private $global_pais_id;
		private $global_pais_sigla;
		private $global_pais_nome;
		
		// tabela global_estado
		private $global_estado_id;
		private $global_estado_id_pais;
		private $global_estado_nome;
		private $global_estado_sigla;
		
		// tabela global_cidade
		private $global_cidade_id;
		private $global_cidade_id_estado;
		private $global_cidade_nome;
		
		
		private $sql;
		private $sqlaux;
		private $whereaux;
		private $orderby;
		private $limit;
		
		private function setPesquisaGlobalPais($arr_global_pais){
		
			$this->global_pais_id		=		isset($arr_global_pais['id']) ? $arr_global_pais['id'] : '';
			$this->global_pais_sigla	=		isset($arr_global_pais['sigla']) ? $arr_global_pais['sigla'] : '';
			$this->global_pais_nome		=		isset($arr_global_pais['nome']) ? $arr_global_pais['nome'] : '';
			
			$this->whereaux				=		isset($arr_global_pais['whereaux']) ? $arr_global_pais['whereaux'] : '';
			$this->orderby				=		isset($arr_global_pais['orderby']) ? $arr_global_pais['orderby'] : '';
			$this->limit				=		isset($arr_global_pais['limit']) ? $arr_global_pais['limit'] : '';
					
			$this->sqlaux				=		" WHERE 1 = 1 ";
			
			if( !empty($this->global_pais_id) ) {
				$this->sqlaux		.=	" AND id = {$this->global_pais_id} ";		
			}
				
			if( !empty($this->global_pais_sigla) ){
				$this->sqlaux		.=	" AND sigla = {$this->global_pais_sigla} ";		
			}
			
			if( !empty($this->global_pais_nome) ){
				$this->sqlaux		.=	" AND nome LIKE '%{$this->global_pais_nome}%' ";		
			}
			
			if(	!empty($this->whereaux) ){
				$this->sqlaux		.=	$this->whereaux;		
			}
			
			if(	!empty($this->orderby) ){
				$this->sqlaux		.=	" ORDER BY {$this->orderby} ";		
			}
			
			if(	!empty($this->limit) ){
				$this->sqlaux		.=	" LIMIT {$this->limit} ";		
			}
		}
		
		private function findGlobalPais(){
			
			global $db;
			
			$this->sql	=	" SELECT 
									*
							  FROM
							  		global_pais
							";
							
			if( (strlen($this->sqlaux) > 0) && (isset($this->sqlaux)) ){
				$this->sql	.=	$this->sqlaux;
			}
			
			return	$db->execute($this->sql);
			
		}
		
		private function setPesquisaGlobalEstado($arr_global_estado){			
			$this->global_estado_id			=		isset($arr_global_estado['id']) ? $arr_global_estado['id'] : '';
			$this->global_estado_id_pais	=		isset($arr_global_estado['id_pais']) ? $arr_global_estado['id_pais'] : '';
			$this->global_estado_nome		=		isset($arr_global_estado['nome']) ? $arr_global_estado['nome'] : '';
			$this->global_estado_sigla		=		isset($arr_global_estado['sigla']) ? $arr_global_estado['sigla'] : '';
			
			$this->whereaux					=		isset($arr_global_estado['whereaux']) ? $arr_global_estado['whereaux'] : '';
			$this->orderby					=		isset($arr_global_estado['orderby']) ? $arr_global_estado['orderby'] : '';
			$this->limit					=		isset($arr_global_estado['limit']) ? $arr_global_estado['limit'] : '';
			
			$this->sqlaux					=		" WHERE 1 = 1 ";
			
			if( !empty($this->global_estado_id) ){
				$this->sqlaux		.=	" AND id = {$this->global_estado_id} ";		
			}
			
			if( !empty($this->global_estado_id_pais) ){
				$this->sqlaux		.=	" AND id_pais = {$this->global_estado_id_pais} ";		
			}
			
			if( !empty($this->global_estado_nome) ){
				$this->sqlaux		.=	" AND nome LIKE '%{$this->global_estado_nome}%' ";		
			}
			
			if( !empty($this->global_estado_sigla) ){
				$this->sqlaux		.=	" AND sigla = {$this->global_estado_sigla} ";		
			}
			
			if(	!empty($this->whereaux) ){
				$this->sqlaux		.=	$this->whereaux;		
			}
			
			if(	!empty($this->orderby) ){
				$this->sqlaux		.=	" ORDER BY {$this->orderby} ";		
			}
			
			if(	!empty($this->limit) ){
				$this->sqlaux		.=	" LIMIT {$this->limit} ";		
			}
		}
		
		
		private function findGlobalEstado(){
			
			global $db;
			
			$this->sql	=	" SELECT 
									*
							  FROM
							  		global_estado
							";
							
			if( (strlen($this->sqlaux) > 0) && (isset($this->sqlaux)) ){
				$this->sql	.=	$this->sqlaux;
			}
			
			return	$db->execute($this->sql);
			
		}
	
		private function setPesquisaGlobalCidade($arr_global_cidade){
		
			$this->global_cidade_id			=		isset($arr_global_cidade['id']) ? $arr_global_cidade['id'] : '';
			$this->global_cidade_id_estado	=		isset($arr_global_cidade['id_estado']) ? $arr_global_cidade['id_estado'] : '';
			$this->global_cidade_nome		=		isset($arr_global_cidade['nome']) ? $arr_global_cidade['nome'] : '';
			
			$this->whereaux					=		isset($arr_global_cidade['whereaux']) ? $arr_global_cidade['whereaux'] : '';
			$this->orderby					=		isset($arr_global_cidade['orderby']) ? $arr_global_cidade['orderby'] : '';
			$this->limit					=		isset($arr_global_cidade['limit']) ? $arr_global_cidade['limit'] : '';
			
			$this->sqlaux					=		" WHERE 1 = 1 ";
			
			if( !empty($this->global_cidade_id) ){
				$this->sqlaux		.=	" AND id = {$this->global_cidade_id} ";		
			}
			
			if( !empty($this->global_cidade_id_estado) ) {
				$this->sqlaux		.=	" AND id_estado = {$this->global_cidade_id_estado} ";		
			}
			
			if( !empty($this->global_cidade_nome) ) {
				$this->sqlaux		.=	" AND nome LIKE '%{$this->global_cidade_nome}%' ";		
			}
			
			if(	!empty($this->whereaux) ){
				$this->sqlaux		.=	$this->whereaux;		
			}
			
			if(	!empty($this->orderby) ){
				$this->sqlaux		.=	" ORDER BY {$this->orderby} ";		
			}
			
			if(	!empty($this->limit) ){
				$this->sqlaux		.=	" LIMIT {$this->limit} ";		
			}
		}
		
		private function findGlobalCidade(){
			global $db;
			$this->sql	=	" SELECT 
									*
							  FROM
							  		global_cidade
							";
							
			if( !empty($this->sqlaux) ){
				$this->sql	.=	$this->sqlaux;
			}
			
			return	$db->execute($this->sql);
			
		}
		
		//Este metodo poderá ser alterado conforme sua necessidade, por ele eh que irá setar os atributos para pesquisa e chamar o metodo da pesquisa
		public final function setGlobalPais($arr_pais){
			$this->setPesquisaGlobalPais($arr_pais);
			return $this->findGlobalPais();
		}
		
		
		//Este metodo poderá ser alterado conforme sua necessidade, por ele eh que irá setar os atributos para pesquisa e chamar o metodo da pesquisa
		public final function setGlobalEstado($arr_estado){
			$this->setPesquisaGlobalEstado($arr_estado);
			return $this->findGlobalEstado();
		}
		
		//Este metodo poderá ser alterado conforme sua necessidade, por ele eh que irá setar os atributos para pesquisa e chamar o metodo da pesquisa
		public final function setGlobalCidade($arr_cidade){
			$this->setPesquisaGlobalCidade($arr_cidade);
			return $this->findGlobalCidade();
		}
		
		//Retorna o nome do país de acordo com o ID dele
		public final function getNomePais($idpais){			
			$this->setPesquisaGlobalPais(array('id' => $idpais));
			$rowPais = $this->findGlobalPais();
			
			if (!$rowPais->EOF) {
				return $rowPais->fields('nome');
			} else {
				return '';
			}
		}
		
		//Retorna o nome do estado de acordo com o ID dele
		public final function getNomeEstado($idestado){			
			$this->setPesquisaGlobalEstado(array('id' => $idestado));
			$rowEstado = $this->findGlobalEstado();
			
			if (!$rowEstado->EOF) {
				return $rowEstado->fields('nome');
			} else {
				return '';
			}
		}
		
		//Retorna o nome da cidade de acordo com o ID dela
		public final function getNomeCidade($idcidade){			
			$this->setPesquisaGlobalCidade(array('id' => $idcidade));
			$rowCidade = $this->findGlobalCidade();
			
			if (!$rowCidade->EOF) {
				return $rowCidade->fields('nome');
			} else {
				return '';
			}
		}
	}
?>