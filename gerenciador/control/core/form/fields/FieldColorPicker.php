<?php
class FieldColorPicker extends Field {
	function FieldColorPicker($tmp_params) {
		parent::Field("colorPicker", $tmp_params[0]);
		
		$this->testRequiredType(array("varchar"));
		
		$this->label = $tmp_params[1];
		$this->validation = "TXT";
	}
	
	
	//private functions
	function getInput() {
		$html = "<div id='div_color_".$this->_getFormatedId()."' onClick=\"javascript:ColorPicker('".$this->_getFormatedId()."', document.getElementById('".$this->_getFormatedId()."').value, '".$this->_getFormatedId()."',event);\" style='float:left;height:16px;width:16px;_height:19px;_width:19px;background-color:".$this->_escapeValue($this->getValue()).";border:1px solid #000000;margin-right:5px;cursor:pointer;'>&nbsp;</div>";
		$html .= "<input ";
		$html .= "class='input' ";
		$html .= "type='text' ";
		$html .= "id='" . $this->_getFormatedId() . "' ";
		$html .= "name='" . $this->name . "' ";
		$html .= "size='" . $this->size_cols . "' ";
		$html .= "maxlength='" . $this->maxlength . "' ";
		$html .= "value=\"" . $this->_escapeValue($this->getValue()) . "\" ";
		$html .= " " . $this->input_extra;
		$html .= ">";
		
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
				
		$html .= "	<td class='input'>" . $this->getInput() . "</td>" . LF;
		$html .= "</tr>" . LF;
		
		if ($filter_value != "") {
			$sql = " and " . $old_name . " LIKE '%" . $filter_value . "%'";
		}
		
		return array("html" => $html, "sql" => $sql);
	}
}
?>