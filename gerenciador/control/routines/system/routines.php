<?php
include("../../app.php");

$routine = $input->get("routine");

switch ($routine) {
	case 'login':
			$profile = new Profile();
			
			if ($profile->login()) {
				redir("../");
			} else {
				redir("login.php?r=1");
			}
		break;
		
	case 'logout':
			$profile = new Profile();
	
			$profile->logout();
			
			redir("login.php");
		break;
		
	case 'esqueciminhasenha':
			$profile = new Profile();
			
			$retorno = $profile->sendNewPassword($input->post('usuariosenha'));
			
			$input->setSession("session_retorno", $retorno);
			
			redir("login.php");
		break;
		
	case 'alterarsenha':
			$profile = new Profile();
			
			$retorno = $profile->updatePassword($input->post('novasenha'));
			
			$input->setSession("session_retorno", $retorno);
			
			redir("../");
		break;
}
?>