<?php
class FieldItems extends Field {
	var $menu;

	function FieldItems($tmp_params) {
		parent::Field("items", $tmp_params[0]);
		
		$this->testRequiredType(array("varchar", "int"));
		
		$this->label = $tmp_params[1];
		$this->setInputType("select");
	}
	
	function loadConfig($tmp_type) {
		switch ($tmp_type) {
			default:
			case "simnao":
				$this->setInputType("radio");
				
				$this->elements = array();
				$this->addElementsByArray(array(1 => "Sim", 0 => "Não"));
				
				$this->list_width = 110;
				
				break;
		}
	}
	
	function setInputType($tmp_type) {
		switch ($tmp_type) {
			default:
			case "select":
				$this->input_type = "select";
				$this->validation = "CMB";
				
				break;
			case "radio":
				$this->input_type = "radio";
				$this->validation = "RDO";
				
				break;
		}
	}
	
	//private functions
	function getInput() {
		$value = $this->getValue();
	
		switch ($this->input_type) {
			default:
			case "select":
				$html = "<select class='input' id='" . $this->_getFormatedId() . "' name='" . $this->name . "' " . $this->input_extra . ">" . LF;
				
				$html .= "<option value=''>Selecione</option>";
				$html .= "<option value=''>------</option>";
				
				foreach ($this->elements as $k => $v) {
					if ($k == $value) {
						$s = " selected";
					} else {
						$s = "";
					}
					
					$html .= "<option value='" . $k . "'" . $s . ">" . $v . "</option>" . LF;
				}
				
				$html .= "</select>" . LF;
				
				break;
			case "radio":
				$i = 1;
				
				$html = "";
				
				foreach ($this->elements as $k => $v) {
					if ($k == $value) {
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
				
				break;
		}
		
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
				$html .= "<img title='Editar registros' align='top' onclick=\"javascript: { document.location = '?menu=" . $n . "'; }\" src='../img/icons/table_edit.gif' style='cursor: pointer; margin: 1 2 0 3px; _margin: 2 2 0 3px;'>";
			}
		}
		
		$this->element_key = $value;
		if ($value != "") {
			if (array_key_exists($value, $this->elements)) {
				$this->value = $this->elements[$value];
			}
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