<?php
class FieldForm extends Field {
	var $default_order;
	
	var $_field_rel;
	var $_field_parent_id;
	
	var $_flags2; //Permission flags [IUD]
	
	var $_fieldset; //Fields loaded from config
	var $_fields_index; //Index of fields for addField method
	
	var $db_table; //Class DBTabele of table
	
	function FieldForm($tmp_params) {
		parent::Field("form", $tmp_params[0]);
		
		$this->label = $tmp_params[1];
		$this->is_sql_affect = false;
		$this->flags_accept = "IU";
		$this->is_required = false;
		
		$this->_flags2 = $tmp_params[2];
		
		$this->_field_rel = $tmp_params[3];
		
		global $form;
		$this->_field_parent_id = $form->key_field;
		
		$this->db_table = new DBTable($tmp_params[0]);
	}
	
	function newField($tmp_type, $tmp_params = array()) {
		global $form;
		
		$this->_fields_index++;
		
		if (!in_array($tmp_type, $form->_fields_loaded)) {
			global $load;
			$include = $load->manager("core/form/fields/Field" . ucfirst($tmp_type) . ".php", false);
			
			if (!$include) {
				$load->config("exceptions/fields/Field" . ucfirst($tmp_type) . ".php");
			}
			
			$form->_fields_loaded[] = $tmp_type;
		}
		
		if ($tmp_params == array()) {
			$tmp_params = array("", "");
		}
		
		$class = "Field" . $tmp_type;
		$f = new $class($tmp_params);
		
		$f->index_list = $this->_fields_index;
		$f->index_filter = $this->_fields_index;
		$f->index_form = $this->_fields_index;
		
		//Set value
		$f->value = $this->db_table->fields($f->name);
		$f->formatValue();
		$f->value_static = $f->value;
		
		return $f;
	}
	
	function addField(&$tmp_field, $tmp_flags = "") {
		if ($tmp_field->is_html) {
			$tmp_flags = "IU";
		}
		
		$tmp_field->flags = $tmp_flags;
		
		if ($tmp_field->is_static) {
			$tmp_field->is_required = false;
			
			if ($tmp_field->value_static == "") {
				$tmp_field->is_sql_affect = false;
			}
		}
		
		$this->_fieldset[] = $tmp_field;
	}
	
	//private functions
	function testFlag2($tmp_flag) {
		if (strpos($this->_flags2, $tmp_flag) !== false) {
			return true;
		} else {
			return false;
		}
	}
	
	function getInput() {
		$html = $this->_getList();
		
		return $html;
	}
	
	function _getList() {
		global $form;
		global $db;
		global $routine;
		
		$old_routine = $routine;
		$routine = "list";
		
		$headers = $this->getHeaders();
		
		$sql = "select * from " . $this->name . " where " . $this->_field_rel . " = '" . $form->fields($form->key_field) . "' " . $headers["sql"];
		$rs_list = $db->execute($sql);
		
		$html = '
			<table cellpadding="0" cellspacing="1" width="768" class="listagem">
					<thead>
						<tr>
							';
		if ($this->testFlag2("D")) { 
			$html .= '<td class="header_cinza" width="30"><input id="chk_todos" type="checkbox" onClick="javascript: check(this); "></td>';
		}
		
		$html .= $headers["html"];
		
		$html .= '</tr>
					</thead>
					<tbody>
					';
		if (!$rs_list->EOF) {
			$css = 2;
			$i = 1;
						
			$fields = $this->_fieldset;
			
			while (!$rs_list->EOF) {
				$css = 3 - $css;
				
				$html .= "<tr id='tr_" . $i . "' onmouseover=\"javascript: listOverOut('over', '" . $i . "');\" onmouseout=\"javascript: listOverOut('out', '" . $i . "');\">" . CRLF;
							
				$extra = "class='td" . $css . "' ";
				if ($this->testFlag2("U")) {
					$extra .= "onclick=\"javascript: listUpdate('" . $rs_list->fields($this->db_table->key_field) . "');\"";
				} else {
					$extra .= "style=\"cursor: default;\"";
				}
				
				if ($this->testFlag2("D")) {
					$html .= "	<td align='center'><input type='checkbox' name='chk_" . $i . "' id='chk_" . $i . "' value='" . $rs_list->fields($this->db_table->key_field) . "' onclick=\"javascript: { checkMostrar(); listOverOut('over', '" . $i . "'); }\"></td>" . CRLF;
				}
				
				$this->db_table->setValuesFromRs($rs_list);
				
				foreach ($fields as $k => $v) {
					if ($v->testFlag("L")) {
						$v->value = $rs_list->fields($v->name);
						$v->is_formated = false;
						
						$html .= "	" . trim($v->getHtmlList($extra)) . LF;
					}
				}
				
				$html .= "</tr>";
				
				$rs_list->moveNext();
				$i++;
			}
		} else {
			$html .= '<tr><td colspan="100%" align="center" style="height: 40px; background: #ECD9D5;"><strong style="color: #9D412C;">Nenhum registro encontrado</strong></td></tr>';
		}
		
		$html .= '</table>';
		
		$routine = $old_routine;
		
		return $html;
	}
	
	function getHeaders() {
		$order = $this->_getOrderValue();
		$order_parsed = explode("#", $order);
		
		if (sizeof($order_parsed) > 1) {
			$order_name = $order_parsed[0];
			$order_direction = $order_parsed[1];
			$sql = " order by " . $order_name . " " . $order_direction;
		} else {
			$order_name = "";
			$order_direction = "";
			$sql = "";
		}
		
		$fields = $this->_fieldset;
		
		$html = "";
		foreach($fields as $k => $v) {
			if ($v->testFlag("L")) {
				$css = "";
				$a = "";
				if ($v->testFlag("O")) {
					if ($v->name == $order_name) {
						if ($order_direction == "asc") {
							$css = "_down";
							$a = "onclick=\"javascript: listOrder('" . $v->name . "#desc');\" style='cursor: pointer;' title='Ordem decrescente'";	
						} else {
							$css = "_up";
							$a = "onclick=\"javascript: listOrder('" . $v->name . "#asc');\" style='cursor: pointer;' title='Ordem crescente'";
						}
					} else {
						$a = "onclick=\"javascript: listOrder('" . $v->name . "#asc');\" style='cursor: pointer;' title='Ordem crescente'";
					}
				}
				
				if ($v->list_width > 0) {
					$a .= " width='" . $v->list_width . "'";
				}
				
				$html .= "<td class='header" . $css . "' " . $a . ">" . $v->label . "</td>" . LF;
			}
		}
		
		return array("html" => $html, "sql" => $sql);
	}
	
	function _getOrderValue() {
		global $input;
		global $menu;
		
		$sub = $menu->index . "-" . $menu->index_sub . " : " . $this->name;
		
		if ($input->post("order") != "") {
			$r = $input->post("order");
		} elseif ($input->session($sub . " order") != "") {
			$r = $input->session($sub . " order");
		} elseif ($this->default_order != "") {
			$r = $this->default_order;
		} else {
			$r = "";
		}
		
		$input->setSession($sub . " order", $r);
		
		return $r;
	}
}
?>