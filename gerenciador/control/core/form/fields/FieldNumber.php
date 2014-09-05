<?php
class FieldNumber extends Field {
	function FieldNumber($tmp_params) {
		parent::Field("number", $tmp_params[0]);
		
		$this->testRequiredType(array("int", "double", "float"));
		
		$this->label = $tmp_params[1];
		$this->validation = "NUM";
		$this->size_cols = 70;
		$this->maxlength = 255;
		$this->loadConfig("int");
	}
	
	function loadConfig($tmp_type) {
		switch ($tmp_type) {
			default:
			case "int":
				$this->config_type = "int";
				$this->validation = "NUM";
				$this->size_cols = 60;
				$this->maxlength = 255;
				
				break;
			case "fone":
				$this->config_type = "fone";
				$this->validation = "TEL";
				$this->size_cols = 20;
				$this->maxlength = 14;
				$this->minlength = 14;
				$this->label = "Telefone";
				
				break;
			case "cpf":
				$this->config_type = "cpf";
				$this->validation = "CPF";
				$this->size_cols = 25;
				$this->maxlength = 14;
				$this->minlength = 14;
				$this->label = "Cpf";
				
				break;
			case "money":
				$this->config_type = "money";
				$this->validation = "DIN";
				$this->size_cols = 20;
				$this->list_width = 100;
				$this->maxlength = 20;
				
				break;
			case "float":
				$this->config_type = "float";
				$this->validation = "FLO";
				$this->size_cols = 20;
				$this->list_width = 100;
				$this->maxlength = 20;
				
				break;
		}
	}
	
	//private functions
	function getInput() {		
		if ($this->input_type == "textarea") {
			$html = "<textarea ";
			$html .= "class='input' ";
			$html .= "id='" . $this->_getFormatedId() . "' ";
			$html .= "name='" . $this->name . "' ";
			$html .= "cols='" . $this->size_cols . "' ";
			$html .= "rows='" . $this->size_rows . "' ";
			$html .= "style='height: " . ($this->size_rows * 15) . "px;' ";
			$html .= $this->input_extra . ">";
			$html .= $this->getValue();
			$html .= "</textarea>";
		} else {
			$html = "<input ";
			$html .= "class='input' ";
			$html .= "type='text' ";
			$html .= "id='" . $this->_getFormatedId() . "' ";
			$html .= "name='" . $this->name . "' ";
			$html .= "size='" . $this->size_cols . "' ";
			$html .= "maxlength='" . $this->maxlength . "' ";
			$html .= "value=\"" . $this->_escapeValue($this->getValue()) . "\" ";
			$html .= " " . $this->input_extra;
			$html .= ">";
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
		$this->input_extra = "onKeyUp=\"javascript: { if (this.value != '') { document.getElementById('" . $filter_name . "-chk').checked = true; } else { document.getElementById('" . $filter_name . "-chk').checked = false; } }\"";
		$this->is_required = false;
		
		if (($this->config_type == "email") || ($this->config_type == "fone")) {
			$this->validation = "TXT";
		}
		
		$html .= "	<td class='input'>" . $this->getInput() . "</td>" . LF;
		$html .= "</tr>" . LF;
		
		if ($filter_value != "") {
			$sql = " and " . $old_name . " LIKE '%" . $filter_value . "%'";
		}
		
		return array("html" => $html, "sql" => $sql); 
	}
	
	function getHtml() {
		$this->is_formated = false;
			
		$html = "<tr>";
		
		if ($this->label != "") {
			$html .= "<td class='label'>";
			
			$html .= $this->label . ": ";
			
			if ($this->is_required) {
				$html .= "<font class='red'>*</font>";
			}
			
			$html .= "</td>" . LF;
		}
		
		$this->formatValue();
		
		$html .= "<td class='input'>";
		
		if ($this->is_static) {
			$this->getInput();
			
			$html .= "<font color='#59748E'>" . $this->getValue() . "</font>";
		} else {
			$html .= $this->getInput();
		}
		
		$html .= "</td></tr>" . LF;
		
		return $html;
	}
	
	function getValueFormated() {
		if ($this->config_type == "money") {
			global $load;
			
			$load->setOverwrite(true);
			$load->system("functions/text.php");
			
			return formatMoney($this->value);
		} elseif ($this->config_type == "float") {			
			global $load;
			
			$load->setOverwrite(true);
			$load->system("functions/text.php");
			
			return formatFloat($this->value);
		} else {
			return $this->value;
		}
	}
	
	function getValueUnformated() {
		if (($this->config_type == "money") || ($this->config_type == "float")){
			$tmp_value = str_replace(".", "", $this->value);
			
			return str_replace(",", ".", $tmp_value);
		} else {
			return $this->value;
		}
	}
}
?>