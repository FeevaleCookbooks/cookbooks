<?php
class Log {
	var $is_manager;
	var $idprojeto;
	var $fields;
	var $fieldsold;
	var $ip;
	
	var $idusuario;
	var $nomeusuario;
	var $nomemenu;
	
	var $idregister;
	var $descricao;
	
	function Log($tmp_ismanager = false){
		global $db;
		
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) { // No novo APACHE se usa isso
			$this->ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$this->ip = $_SERVER['REMOTE_ADDR'];
		}
		$this->is_manager = $tmp_ismanager;
		$this->idregister = 0;
		$this->idprojeto = 1;
		$this->descricao = '';
		$this->nomemenu = '';
	}
	
	function setFieldsOut($tmp_object) {
		$this->fieldsold = $tmp_object;
	}
	
	function insertLog($tmp_routine) {
		global $db;
		
		if (($this->is_manager) && ($this->nomemenu == '')) {
			$this->setValueManager();
		}
		
		if ($this->descricao == '') {
			$descricao = '';
			
			switch ($tmp_routine) {
				case 'insert':
						if ($this->is_manager) {
							$descricao .= "O usuбrio " . $this->nomeusuario . " inseriu um novo registro na seзгo " . $this->nomemenu .". ";
						} else {
							$descricao .= "O usuбrio " . $this->ip . " inseriu um novo registro. ";
						}
						$descricao .= LF . "Dados inseridos: " . $this->getFields();
					break;
					
				case 'delete':
						if ($this->is_manager) {
							$descricao .= "O usuбrio " . $this->nomeusuario . " deletou o registro ".$this->idregister." na seзгo " . $this->nomemenu .". ";
						} else {
							$descricao .= "O usuбrio " . $this->ip . " deletou um registro. ";
						}
						$descricao .= LF . "Dados deletados: " . $this->getFields();
					break;
					
				case 'select':
						if ($this->is_manager) {
							if ($this->idregister > 0) {
								$descricao .= "O usuбrio " . $this->nomeusuario . " acessou o registro ".$this->idregister." na seзгo " . $this->nomemenu .".";
							} else {
								$descricao .= "O usuбrio " . $this->nomeusuario . " acessou a seзгo " . $this->nomemenu .".";
							}
						} else {
							if ($this->idregister > 0) {
								$descricao .= "O usuбrio " . $this->ip . " acessou o registro ".$this->idregister.".";
							} else {
								$descricao .= "O usuбrio " . $this->ip . " acessou a seзгo " . $this->nomemenu .".";
							}
						}
					break;
					
				case 'update':
						$this->testChange();
						if ($this->is_manager) {
							$descricao .= "O usuбrio " . $this->nomeusuario . " alterou o registro ".$this->idregister." na seзгo " . $this->nomemenu .".";
						} else {
							$descricao .= "O usuбrio " . $this->ip . " alterou o registro ".$this->idregister. " na seзгo " . $this->nomemenu .".";
						}
						if (sizeof($this->fields) > 0) {
							$descricao .= LF . "Dados alterados: " . LF .  $this->getFields();
						} else {
							$descricao .= LF . "Nenhum dado alterado.";
						}
					break;
			}
			
			$this->descricao = $descricao;
		}
			
		if ($this->is_manager) {
			$sql = "INSERT INTO admin_log (id_usuario,datahora,acao,descricao,query,ip) VALUES (0".$this->idusuario.",NOW(),'".$tmp_routine."','".str_replace("'", "`",$this->descricao)."','".str_replace("'", "`",$db->sql->sql)."','".$this->ip."')";
		} else {
			$sql = "INSERT INTO global_log (id_projeto,datahora,acao,descricao,query,ip,pagina) VALUES (0".$this->idprojeto.",NOW(),'".$tmp_routine."','".str_replace("'", "`",$this->descricao)."','".str_replace("'", "`",$db->sql->sql)."','".$this->ip."','".$_SERVER['REQUEST_URI']."')";
		}
		$db->execute($sql);
		
		$this->descricao = '';
	}
	
	function getFields() {
		$return = '';
		
		foreach($this->fields as $label=>$value) {
			$return .= $label . ": " . $value . LF;
		}
		
		return $return;
	}
	
	function testChange() {
		foreach($this->fields as $label=>$value) {
			if (isset($this->fieldsold[$label])) {
				if ($this->fieldsold[$label] == $value) {
					unset($this->fields[$label]);
				} else {
					$this->fields[$label] = $this->fieldsold[$label] . " -> " . $this->fields[$label];
				}
			}
		}
	}

	function setValueManager() {
		global $profile;
		global $menu;
		
		if (isset($menu)) {
			$nomemenu = '';
			$sub = $menu->getSub();
			if (isset($sub->name)) {
				$this->nomemenu = $sub->name;
			}
		}
		
		$this->idusuario = $profile->fields('id');
		$this->nomeusuario = $profile->fields('nome');
	}
}
?>