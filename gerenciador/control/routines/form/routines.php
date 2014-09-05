<?php
include("../../app.php");
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

//insert / update / delete
if ($routine_field == "") {
	switch($routine) {
		case 'insert':
				$form->postInsert();
				
				redir("list.php?menu=" . $input->request("menu"), false, "", false);
			
			break;
		
		case 'update':
				$form->fields[$form->key_field] = $input->get("id",false,'int');
				$form->select();
				
				$form->postUpdate();
		
				redir("list.php?menu=" . $input->request("menu"), false, "", false);
			
			break;
			
		case 'delete':
				$form->fields[$form->key_field] = $input->get("id",false,'int');
				$form->select();
				
				$form->postDelete();
				
				redir("list.php?menu=" . $input->request("menu"), false, "", false);
			
			break;
			
		case 'delete_checks':
				foreach ($_POST as $k => $v) {
					$form->fields[$form->key_field] = $v;
					$form->select();
					
					$form->postDelete();
				}
				
				redir("list.php?menu=" . $input->request("menu"));
			
			break;
		
		case 'ativo':
				$id = $input->get("id",false,'int');
				
				$form->fields[$form->key_field] = $id;
				$form->select();
				
				$name = $input->get("name");
				$v = 1 - $form->fields[$name];
				$form->fields[$name] = $v;
				
				$form->update();
				
				if ($v == 1) {
					echo "<img src='../img/icons/accept.gif' style='cursor: pointer;' onclick=\"javascript: ativoSwap(this, '" . $name . "', '" . $id . "'); \" src='' title='Alterar para inativo'>";
				} else {
					echo "<img src='../img/icons/cancel.gif' style='cursor: pointer;' onclick=\"javascript: ativoSwap(this, '" . $name . "', '" . $id . "'); \" src='' title='Alterar para ativo'>";
				}
			
			break;
	
		case 'refresh_combo':
				$value = $input->get('value');
				$name_fields = $input->get('name_fields');
				$table_rel = $input->get('table_rel');
				$value_field_rel = $input->get('value_field_rel');
				$name_field_rel = $input->get('name_field_rel');
				$value_select = $input->get('value_select');

				$sql = "SELECT DISTINCT(" . $value_field_rel . "), " . $name_field_rel . " FROM " . $table_rel . " WHERE " . $name_fields . " LIKE '". $value."' ORDER BY ". $name_field_rel . " ASC";
				$rs = $db->execute($sql);
				
				if (!$rs->EOF) {
					echo("+ Selecione #+-------------");
					while(!$rs->EOF) {
							echo("#".$rs->fields($value_field_rel)."+".$rs->fields($name_field_rel));
						$rs->moveNext();
					}
				} else {
					echo("+Nenhum elemento relacionado");
				}
			break;
	
		case 'refresh_tree':
				/*
				 * 2 - id (campo a ser buscado na tabela)
				 * 3 - idPai (campo que se relaciona com o id)
				 * 4 - nome (campo que será mostrado nos outros combos)
				 * 5 - tabela (tabela)
				 */
				$args = array();
				$args[] = $input->get('arg0');
				$args[] = $input->get('arg1');
				$args[] = $input->get('arg2');
				$args[] = $input->get('arg3');
				$id = $input->get('id',false,'int');
				
				$sql = "SELECT DISTINCT ".$args[0].",".$args[2]." FROM ".$args[3]." WHERE ".$args[1]." = ".$id." ORDER BY ". $args[2] . " ASC";
				//echo $sql;
				$rs = "";
				if ($id != "") {
					$rs = $db->execute($sql);
				}else{
					break;
				}
				
				if ((!$rs->EOF)&&($rs->recordcount > 0)){
					echo("+ Selecione #+-------------");
					//print_r2($rs);
					while(!$rs->EOF) {
							echo("#".$rs->fields($args[0])."+".$rs->fields($args[2]));
						$rs->moveNext();
					}
				}/* else {
					echo("");
				}*/
			break;
			
		case 'goToTabUpdate':
				$input->setSession('id_register',$input->get("id",false,'int'));
		
				foreach($menu->_itens as $indice=>$menus) {
					foreach($menus['subs'] as $indice2=>$submenus) {
						if (strtolower($submenus->class) == strtolower($input->get("menu"))) {
							$url_menu = $indice . '-' . $indice2;
						}
					}
				}
		
				echo("?menu=" . $url_menu);
			break;
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