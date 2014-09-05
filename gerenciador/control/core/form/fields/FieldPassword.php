<?php
class FieldPassword extends Field {
	var $second_field;
	var $encrypt;

	function FieldPassword($tmp_params) {
		parent::Field("password", $tmp_params[0]);
		
		$this->testRequiredType(array("varchar"));
		
		$this->flags_accept = "LOIU";
		
		if (isset($tmp_params[1])) {
			$this->label = $tmp_params[1];
		} else {
			$this->label = "Senha";
		}
		$this->validation = "PW1";
		$this->size_cols = 30;
		$this->maxlength = 30;
		$this->second_field = false;
		$this->encrypt = true;
		
		global $routine;
		if (($this->value != "") && ($routine == "update")) {
			$this->is_required = false;
		}
	}
	
	
	//private functions
	function getInput() {
		$html = "<input ";
		$html .= "class='input' ";
		$html .= "type='password' ";
		$html .= "id='" . $this->_getFormatedId() . "' ";
		$html .= "name='" . $this->name . "' ";
		$html .= "size='" . $this->size_cols . "' ";
		$html .= "maxlength='" . $this->maxlength . "' ";
		$html .= "value=\"" . $this->_escapeValue($this->getValue()) . "\" ";
		$html .= " " . $this->input_extra;
		$html .= ">";
		
		return $html;
	}
	
	function getHtml() {
		$html = "<tr>";
		
		if ($this->label != "") {
			$html .= "<td class='label'>";
			
			$html .= $this->label . ": ";
			
			if ($this->is_required) {
				$html .= "<font class='red'>*</font>";
			}
			
			$html .= "</td>" . LF;
		}
		
		$html .= "<td class='input'>";
		
		if ($this->is_static) {
			$html .= "<font color='#59748E'>" . $this->getValue() . "</font>";
		} else {
			$this->value = "";
			
			$html .= $this->getInput();
		}
		
		$html .= "</td></tr>" . LF;
		
		if ((!$this->is_static) && (!$this->second_field)) {
			$this->validation = "PW2";
			$this->second_field = true;
			$this->label = "Confirmação de " . strtolower($this->label);
			
			$html .= $this->getHtml();
		}
		
		return $html;
	}
	
	function onPrePost() {
		if ($this->value == "") {
			$this->is_sql_affect = false;
		}
	}
	
	function unformatValue() {
		global $cfg;
		
		//aqui começam os metodos para criptografia
		if ($this->encrypt) {
			if ($this->value != "") {
				if ($cfg["criptografia"] == "HASH") {
					$this->value = hash($cfg["metodo_criptografia"], $this->value);
				} elseif ($cfg["criptografia"] == "SIMPLE" && $cfg["metodo_criptografia"] == "SHA1") {
					$this->value = sha1($this->value);
				} elseif ($cfg["criptografia"] == "SIMPLE" && $cfg["metodo_criptografia"] == "MD5") {
					$this->value = md5($this->value);
				}
			}
		}			
		//fim dos metodos para criptografia
	}
	
}
?>