<?php
class FieldChar extends Field {
	function FieldChar($tmp_params) {
		parent::Field("char", $tmp_params[0]);
		
		$this->testRequiredType(array("varchar", "blob", "text", "int(10) unsigned"));
		
		$this->label = $tmp_params[1];
		$this->validation = "TXT";
		$this->setInputType("input");
	}
	
	function setInputType($tmp_type) {
		switch ($tmp_type) {
			default:
			case "input":
				$this->input_type = "input";
				$this->size_cols = 66;
				$this->maxlength = 255;
				
				break;
			case "textarea":
				$this->input_type = "textarea";
				$this->size_cols = 65;
				$this->size_rows = 7;
				$this->maxlength = 10000;
				$this->minlength = 0;
				
				break;
		}
	}
	
	function loadConfig($tmp_type) {
		switch ($tmp_type) {
			default:
			case "email":
				$this->config_type = "email";
				$this->validation = "EML";
				$this->size_cols = 60;
				$this->maxlength = 255;
				$this->label = "E-mail";
				
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
			$html .= "maxlength='" . $this->maxlength . "' ";
			$html .= "style='height: " . ($this->size_rows * 15) . "px;' ";
			$html .= $this->input_extra . ">";
			$html .= $this->getValue();
			$html .= "</textarea>";
			if($this->show_maxlength){
				$html .= "<div id='" . $this->_getFormatedId() . "_counter'></div>";
			}
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
		
		$this->setInputType("input");
		
		$html .= "	<td class='input'>" . $this->getInput() . "</td>" . LF;
		$html .= "</tr>" . LF;
		
		if ($filter_value != "") {
			$sql = " and " . $old_name . " LIKE '%" . $filter_value . "%'";
		}
		
		return array("html" => $html, "sql" => $sql);
	}
	
	function getValueUnformated() {
		global $cfg;
		global $load;
		$load->system('functions/text.php');
		
		$this->value = formatSpecialCaracter($this->value);
		
		return $this->value;
	}	
}
?>