<?php
class Profile extends DBTable {
	var $nivel;
	
	var $_session_key;
	
	var $arrMenu;
	
	function Profile() {
		log_message("[profile] é instanciado.");
		
		parent::DBTable("admin_usuario");
		
		$this->_session_key = "system_id_usuario";
		$this->nivel = 2;
		
		$this->arrMenu = array();
	}
	
	function login() {
		global $input;
		global $db;
		global $log;		
		global $cfg;
		
		$user = $input->post("usuario");
		$pass = $this->encryptPassword($input->post("senha"));
		
		$wherePass = sprintf("senha = '%s'",$pass);
		
		if ($this->select("usuario = '" . $user . "' and " . $wherePass . " and status = 1")) {
			//cria registro no LOG
			//Descricao, Data, Hora
			$sql = "SELECT * FROM admin_usuario WHERE id = " . $this->fields("id");
			$rsUsuarioLog = $db->execute($sql);
			if (!$rsUsuarioLog->EOF) {
				/*******  INSERE O LOG  ********/
				$log->descricao = 'LOGIN EFETUADO NO CONTROL PELO USUARIO: '. $rsUsuarioLog->fields("nome");
				$log->insertLog("select");
				/******* / INSERE O LOG  ********/
			}
			// Verifica se é o usuário Webtrading
			if ($this->fields('id') != 1) {
				$sql = "SELECT id_sessao FROM admin_usuario_sessao WHERE id_usuario = " . $this->fields("id");
				$rsMenu = $db->execute($sql);
	
				if (!$rsMenu->EOF) {				
					$_SESSION[$this->_session_key] = $this->fields("id");
					return true;
				} else {
					return false;
				}
			} else {
				$_SESSION[$this->_session_key] = $this->fields("id");
				return true;
			}
		} else {
			//cria registro no LOG
			//Descricao, Data, Hora
			/*******  INSERE O LOG  ********/
			$log->descricao = 'TENTATIVA MAL SUCEDIDA DE LOGIN COM O USUARIO: '. $user;
			$log->insertLog("select");
			/******* / INSERE O LOG  ********/
			return false;
		}
	}
	
	function isLogged() {
		global $db;
		
		if(isset($_SESSION[$this->_session_key])){
			if ($_SESSION[$this->_session_key] > 0) {
				$this->fields["id"] = $_SESSION[$this->_session_key];
				$this->select();
				
				$sql = "SELECT id_sessao FROM admin_usuario_sessao WHERE id_usuario = " . $this->fields("id");
				$rsMenu = $db->execute($sql);				
			
				while(!$rsMenu->EOF) {
						$this->arrMenu[] = $rsMenu->fields('id_sessao');
					
					$rsMenu->moveNext();
				}

				$this->nivel = $this->fields("nivel");
				
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	function logout() {
		global $log;
		global $input;
		$this->fields['id'] = $input->session($this->_session_key);
		$this->select();
		
		/*******  INSERE O LOG  ********/
		$log->descricao = 'USUÁRIO '.$this->fields('nome').' FEZ LOGOUT.';
		$log->insertLog("select");
		/******* / INSERE O LOG  ********/		
		
		unset($_SESSION[$this->_session_key]);
	}
	
	function updatePassword($tmp_string) {
		global $db;
		global $log;
		global $input;
		
		$this->fields['id'] = $input->session($this->_session_key);
		$this->select();
		
		$this->fields['senha'] = $this->encryptPassword($tmp_string);
		$this->update();
				
		/*******  INSERE O LOG  ********/
		$log->descricao = 'USUÁRIO '.$this->fields('nome').' ALTEROU A SENHA.';
		$log->insertLog("select");
		/******* / INSERE O LOG  ********/

		return 'Senha alterada com sucesso.';
	}
	
	function sendNewPassword($tmp_user) {
		global $db;
		global $cfg;
		global $log;
		global $load;
		$load->system('library/Email.php');
		
		
		$sql = "SELECT id,email FROM admin_usuario WHERE usuario = '".$tmp_user."'";
		$rowUsuario = $db->execute($sql);
		
		if (!$rowUsuario->EOF) {
			$arr_newpass = $this->createPassword();
			
			$sql = "UPDATE admin_usuario SET senha = '".$arr_newpass[1]."' WHERE id=".$rowUsuario->fields('id');
			$db->execute($sql);
			
			/*******  INSERE O LOG  ********/
			$log->descricao = 'NOVA SENHA CRIADA PARA O USUÁRIO '.$tmp_user.'.';
			$log->insertLog("update");
			/******* / INSERE O LOG  ********/
			
			$o_email = new Email();
			$o_email->subject = "Nova senha de acesso";
			$o_email->to = $rowUsuario->fields('email');
			$o_email->from = $cfg['email_remetente'];
			$o_email->content = "Uma nova senha foi gerada para acessar o manager da " . $cfg["system_title"].".<br />Sua nova senha é: " . $arr_newpass[0];
			
			if ($o_email->send()) {
				/*******  INSERE O LOG  ********/
				$log->descricao = 'NOVA SENHA ENVIADA COM SUCESSO PARA O USUÁRIO '.$tmp_user.'.';
				$log->insertLog("send");
				/******* / INSERE O LOG  ********/
				
				return "Nova senha enviada com sucesso para o seu e-mail.";
			} else {
				/*******  INSERE O LOG  ********/
				$log->descricao = 'ERRO PARA ENVIAR A NOVA SENHA PARA O USUÁRIO '.$tmp_user.'.';
				$log->insertLog("send");
				/******* / INSERE O LOG  ********/
				
				return "Erro para enviar a nova senha para o seu e-mail. Tente novamente mais tarde, ou entre em contato com o administrador do sistema.";
			}
		} else {
			/*******  INSERE O LOG  ********/
			$log->descricao = 'ERRO NA RECUPERAÇÃO DE SENHA. USUÁRIO '.$tmp_user.' NÃO EXISTE.';
			$log->insertLog("select");
			/******* / INSERE O LOG  ********/
			
			return 'Usuário não encontrado.';
		}
	}
	
	function checkMenu($value) {
		if ($this->fields('id') != 1) {
			if (in_array($value, $this->arrMenu)) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	
	/*
	 * Cria nova senha e retorno um array com o indice 0 = a senha não criptografada e o indice 1 = a senha criptografada
	 * */
	function createPassword() {
		$arr_newpass[0] = substr(md5(time()),-10);
		$arr_newpass[1] = $this->encryptPassword($arr_newpass[0]);
		
		return $arr_newpass;
	}
	
	function encryptPassword($tmp_string) {
		global $cfg;
		
		if ($cfg["criptografia"] == "HASH") {
			$tmp_string = hash($cfg["metodo_criptografia"],$tmp_string);
		} elseif ($cfg["criptografia"] == "SIMPLE" && $cfg["metodo_criptografia"] == "SHA1") {
			$tmp_string = sha1($tmp_string);
		} elseif ($cfg["criptografia"] == "SIMPLE" && $cfg["metodo_criptografia"] == "MD5") {
			$tmp_string = md5($tmp_string);
		}
		
		return $tmp_string;
	}
	
	function getPermission($ip) {
		global $db;
		global $log;
		
		//separa o IP em partes
		$ip = explode('.', $ip);
				
		$login = true;
		
		//BUSCA NIVEL 0
		$sql = "SELECT status FROM admin_ip WHERE (ip1 = '%') AND 
													(ip2 = '%') AND 
													(ip3 = '%') AND 
													(ip4 = '%') ";
		$o_sql = $db->execute($sql);
		if ($o_sql->recordcount > 0) {
			if ($o_sql->fields('status') == 0) {
				$login = false;
			}
		}
		
		//BUSCA NIVEL 1
		$sql = "SELECT status FROM admin_ip WHERE (ip1 = '".$ip[0]."') AND 
													(ip2 = '%') AND 
													(ip3 = '%') AND 
													(ip4 = '%') ";
		$o_sql = $db->execute($sql);
		if ($o_sql->recordcount > 0) {
			if ($o_sql->fields('status') == 0) {
				$login = false;
			} else {
				$login = true;
			}
		}
		
		//BUSCA NIVEL 2
		$sql = "SELECT status FROM admin_ip WHERE (ip1 = '".$ip[0]."') AND 
													(ip2 = '".$ip[1]."') AND 
													(ip3 = '%') AND 
													(ip4 = '%') ";
		$o_sql = $db->execute($sql);
		if ($o_sql->recordcount > 0) {
			if ($o_sql->fields('status') == 0) {
				$login = false;
			} else {
				$login = true;
			}
		}
		
		//BUSCA NIVEL 3
		$sql = "SELECT status FROM admin_ip WHERE (ip1 = '".$ip[0]."') AND 
													(ip2 = '".$ip[1]."') AND 
													(ip3 = '".$ip[2]."') AND 
													(ip4 = '%') ";
		$o_sql = $db->execute($sql);
		if ($o_sql->recordcount > 0) {
			if ($o_sql->fields('status') == 0) {
				$login = false;
			} else {
				$login = true;
			}
		}
		
		//BUSCA NIVEL 4
		$sql = "SELECT status FROM admin_ip WHERE (ip1 = '".$ip[0]."') AND 
													(ip2 = '".$ip[1]."') AND 
													(ip3 = '".$ip[2]."') AND 
													(ip4 = '".$ip[3]."') ";
		$o_sql = $db->execute($sql);
		if ($o_sql->recordcount > 0) {
			if ($o_sql->fields('status') == 0) {
				$login = false;
			} else {
				$login = true;
			}
		}

		return $login;

	}
}
?>