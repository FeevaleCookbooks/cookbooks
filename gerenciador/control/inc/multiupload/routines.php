<?php
include("../../app.php");
$input->setSession('system_id_usuario',1); // Precisa disso para "logar" o usuario quando a página é chamada pelo Flash
include("../../inc/inc.restrict.php");
include("../../inc/inc.menu.php");

ini_set("max_execution_time", 60*20); //20 Minutes

$output->ajaxHeader();

global $routine;

$routine = $input->get("routine");
$routine_field = $input->get("routine_field");

//form class
$sub = $menu->getSub();
if (isset($sub)) {
	if($sub->module != ""){
		$load->config("forms/Form" . ucfirst($sub->class) . ".php");
		$class = "Form" . $sub->class;
		$form = new $class();
	}
}

//fields routines
if ($routine_field != "") {
	$output->ajaxHeader();
	
	if ($routine == "update") {
		$id = $input->get("id",false,'int');
		if ($id != "") {
			$form->fields[$form->key_field] = $id;
			$form->select();
		}
	}
	$f =& $form->getFieldByName($input->request("name"));
	
	echo $f->ajaxRoutine($routine_field);
}
?>