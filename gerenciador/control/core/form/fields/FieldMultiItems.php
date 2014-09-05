<?php
class FieldMultiItems extends Field {
	var $menu;
	
	var $_table_rel;
	var $_table_rel_from_index;
	var $_table_rel_to_index;
	
	var $number_cols;
	
	function FieldMultiItems($tmp_params) {
		parent::Field("multiItems", $tmp_params[0]);
		
		$this->label = $tmp_params[1];
		$this->validation = "CHK";
		
		if (isset($tmp_params[2])) {
			$this->_table_rel = $tmp_params[2];
		}
		
		if (isset($tmp_params[3])) {
			$this->_table_rel_from_index = $tmp_params[3];
		}
		
		if (isset($tmp_params[4])) {
			$this->_table_rel_to_index = $tmp_params[4];
		}
		
		$this->is_required = false;
		$this->is_sql_affect = false;
		$this->number_cols = 4;
		
		$this->accept_flags = "IUL";
	}
	
	//private functions
	function getInput() {
		global $routine;
		global $db;
		global $form;
		
		//get values
		$arr_values = array();
		
		if ($routine == "update") {
			$sql = "select " . $this->_table_rel_to_index . " as k from " . $this->_table_rel . " where " . $this->_table_rel_from_index . " = '" . $form->fields("id") . "'";
			$rs = $db->execute($sql);
			
			while (!$rs->EOF) {
				$arr_values[$rs->fields("k")] = true;
			
				$rs->moveNext();
			}
		}
		
		
		//list
		$i = 1;
		$s = "";
		$html = "<table cellspaccing='0' cellpadding='0' width='100%'><tr><td>";
		
		foreach ($this->elements as $k => $v) {
			if (array_key_exists($k, $arr_values)) {
				$s = " checked";
			} else {
				$s = "";
			}
			
			$id = $this->_getFormatedId($i);
			
			$html .= "<div class='item' style='width:". floor(100 / $this->number_cols) ."%;'>";
			$html .= "<div id='input'>";
			$html .= "<input type='checkbox' id='" . $id . "' name='" . $this->name . "_" . $i . "' value='" . $k . "'" . $s . " " . $this->input_extra . ">";
			$html .= "</div><div id='label' style='width:auto;'>";
			$html .= "<label for='" . $id . "'>" . $v . "</label>";
			$html .= "</div>";
			$html .= "</div>" . LF;
			
			$i++;
		}
		
		$html .= "<input type='hidden' name='" . $this->name . "_total' id='" . $this->_getFormatedId() . "' value='" . ($i-1) . "'>";
		
		if (($this->menu != "") && (!$this->is_static)) {
			global $menu;
			
			$n = "";
			
			foreach ($menu->_itens as $k => $v) {
				foreach ($v["subs"] as $k2 => $v2) {
					if ($v2->class == $this->menu) {
						$n = $k . "-" . $k2;
						
						break;
					}
				}
			}
			
			if ($n != "") {
				$html .= "</td><td align='right' valign='top' width='0'><img style='position: absolute; margin-left: -12px; cursor: pointer;' title='Editar registros' align='top' onclick=\"javascript: { document.location = '?menu=" . $n . "'; }\" src='../img/icons/table_edit.gif'>";
			}
		}
		
		$html .= "</td></tr></table>";
		
		return $html;
	}
	
	function onPosPost() {
		global $db;
		global $form;
		global $routine;
		global $input;
		
		if ($this->_table_rel != "") {
			if ($routine == "update") {
				$this->onDelete();
			}
			
			$total = $input->post($this->name . "_total");
			$i = 1;
			$id = $form->fields("id");
			
			$inserts = array();
			
			while ($i <= $total) {
				$v = $input->post($this->name . "_" . $i);
				
				if ($v != "") {
					 $inserts[] = "('" . $id . "', '" . $v . "')";
				}
				
				$i++;
			}
			
			if (sizeof($inserts) > 0) {
				$sql = "insert into " . $this->_table_rel . " (" . $this->_table_rel_from_index . ", " . $this->_table_rel_to_index . ") values " . implode(", ", $inserts) . ";";
				$db->execute($sql);
			}
		}
	}
	
	function onDelete() {
		global $form;
		global $db;
		
		$sql = "delete from " . $this->_table_rel . " where " . $this->_table_rel_from_index . " = '" . $form->fields("id") . "'";
		$db->execute($sql);
	}
	
	function getHtmlList($tmp_extra) {
		$this->formatValue();
		
		$this->element_key = $this->value;
		if (array_key_exists($this->value, $this->elements)) {
			$this->value = $this->elements[$this->value];
		} else {
			$this->value = "";
		}
		
		if ($this->value == "") {
			if ($this->element_key == "") {
				$this->value = "<font color='silver'>(vazio)</font>";
			} else {
				$this->value = "<font color='silver'>[" . $this->element_key . "]</font>";
			}
		}
		
		$html = "<td " . $tmp_extra . ">" . $this->value . "</td>" . LF;
		
		return $html;
	}
}
?>