<?php
class FieldHidden extends Field {
	function FieldHidden($tmp_params) {
		parent::Field("char", $tmp_params[0]);
		
		$this->testRequiredType(array("varchar", "blob"));
		
		if (isset($tmp_params[1])) {
			$this->label = $tmp_params[1];
		} else {
			$this->label = $tmp_params[0];
		}
		$this->validation = "TXT";
	}
	
	//private functions
	function getInput() {
		$html = "<input ";
		$html .= "type='hidden' ";
		$html .= "id='" . $this->_getFormatedId() . "' ";
		$html .= "name='" . $this->name . "' ";
		$html .= "value=\"" . $this->_escapeValue($this->getValue()) . "\" ";
		$html .= " " . $this->input_extra;
		$html .= ">";
		
		return $html;
	}
	
	function getHtml() {		
		$html = $this->getInput() . LF;
		
		return $html;
	}
}
?>