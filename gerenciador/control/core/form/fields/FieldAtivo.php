<?php
class FieldAtivo extends Field {
	function FieldAtivo($tmp_params) {
		parent::Field("ativo", ($tmp_params[0] != "") ? $tmp_params[0] : "status");
		
		$this->testRequiredType(array("int"));
		
		$this->label = ($tmp_params[1] != '') ? $tmp_params[1] : "Ativo";
		
		$this->list_width = 48;
		
		global $routine;
		if ($routine == "L") {
			$this->addElement(1, "<img src='../img/icons/accept.gif' style='cursor: pointer;' onclick=\"javascript: ativoSwap(this, '" . $this->name . "', '#ID#'); \" title='Alterar para inativo'>");
			$this->addElement(0, "<img src='../img/icons/cancel.gif' style='cursor: pointer;' onclick=\"javascript: ativoSwap(this, '" . $this->name . "', '#ID#'); \" title='Alterar para ativo'>");
		} else {
			if (!array_key_exists(2, $tmp_params)) {
				$this->addElement(1, "<font color='#009900'>Ativo</font>");
				$this->addElement(0, "<font color='#990000'>Inativo</font>");
			} else {
				$this->addElementsByArray($tmp_params[2]);
			}
		}
	}
	
	//private functions
	function getInput() {
		$html = "";
		
		$i = 1;
		foreach ($this->elements as $k => $v) {
			
			
			if ($k == $this->value) {
				$s = " checked";
			} else {
				$s = "";
			}
			
			$id = $this->_getFormatedId($i);
			
			$html .= "<div class='item'>";
			$html .= "<div id='input'>";
			$html .= "<input type='radio' id='" . $id . "' name='" . $this->name . "' value='" . $k . "'" . $s . " " . $this->input_extra . ">";
			$html .= "</div><div id='label'>";
			$html .= "<label for='" . $id . "'>" . $v . "</label>";
			$html .= "</div>";
			$html .= "</div>" . LF;
			
			$i++;
		}
		
		$this->element_key = $this->value;
		if ($this->value != "") {
			$this->value = $this->elements[$this->value];
		}
		
		return $html;
	}
	
	function getFilter() {
		global $input;
		
		$html = "";
		$sql = "";
		
		$filter_name = $this->_getFilterName();
		$filter_value = $this->_getFilterValue();
		$filter_chk = $this->_getFilterChecked();
		$old_name = $this->name;
		
		$html = "<tr class='fieldset'>" . LF;
		$html .= "	<td class='label'>" . $this->label . ":</td>" . LF;
		$html .= "	<td class='label' style='width: 30px; text-align: center;'><input type='checkbox' name='" . $filter_name . "-chk' id='" . $filter_name . "-chk' value='1' " . $filter_chk . "></td>" . LF;
		
		//crete filter input
		$this->name = $filter_name;
		$this->value = $filter_value;
		$this->is_required = false;
		if ($this->input_type == "select") {
			$this->input_extra = "onChange=\"javascript: { if (this.value != '') { document.getElementById('" . $filter_name . "-chk').checked = true; } else { document.getElementById('" . $filter_name . "-chk').checked = false; } }\"";
		} elseif ($this->input_type == "radio") {
			$this->input_extra = "onClick=\"javascript: { if (this.value != '') { document.getElementById('" . $filter_name . "-chk').checked = true; } else { document.getElementById('" . $filter_name . "-chk').checked = false; } }\"";
		}
		
		
		$html .= "	<td class='input'>" . $this->getInput() . "</td>" . LF;
		$html .= "</tr>" . LF;
		
		if ($filter_value != "") {
			$sql = " and " . $old_name . " = '" . $filter_value . "'";
		}
		
		return array("html" => $html, "sql" => $sql);
	}
	
	function getHtmlList($tmp_extra) {
		global $rs_list;
		global $form;
	
		$this->formatValue();
		
		$this->element_key = $this->value;
		$this->value = $this->elements[$this->value];
		
		if ($this->value == "") {
			if ($this->element_key == "") {
				$this->value = "<font color='silver'>(vazio)</font>";
			} else {
				$this->value = "<font color='silver'>[" . $this->element_key . "]</font>";
			}
		}
		
		$tmp = explode("onclick", $tmp_extra);
		
		$html = "<td " . $tmp[0] . " align='center'>" . str_replace("#ID#", $rs_list->fields($form->key_field), $this->value) . "</td>" . LF;
		
		return $html;
	}
}
?>