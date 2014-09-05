<?php
class FieldHtml extends Field {
	var $html;
	var $extra_style;

	function FieldHtml($tmp_params) {
		parent::Field("html", "campo_html");
	
		$this->is_html = true;
		$this->is_sql_affect = false;
		$this->is_static = true;
				
		$this->setType($tmp_params[0]);
		
		$this->extra_style = '';

		if (isset($tmp_params[1])) {
			$this->setLabel($tmp_params[1]);
		}
	}
	
	function setType($tmp_type) {
		$this->type = "html_" . $tmp_type;
	}
	
	function setLabel($tmp_label) {
		$this->label = $tmp_label;
	}
	
	function setHTML($tmp_html) {
		$this->html = $tmp_html;
	}
	
	//private functions
	function getHTML() {
		$type = substr($this->type, 5);
		
		switch ($type) {
			case "box":
				echo "</table></td></tr></table></div><div class='form' style='margin-top: 5px;".$this->extra_style."' id='".$this->label."'><table cellspacing='0' cellpadding='0' width='100%' height='100%'>" . LF;
				echo "<tr><td width='49%' valign='top'><table cellspacing='3' cellpadding='0' width='100%'>" . LF;

				break;
		
			case "separador":
				echo "</table></td><td width='2%' align='center'>" . LF;
				echo "<table cellspacing='0' cellpadding='0' height='100%' style='border-left: 1px solid #E4E4E4;'><tr><td></td></tr></table>" . LF;
				echo "</td><td width='49%' valign='top'><table cellspacing='3' cellpadding='0' width='100%' id='".$this->label."' style='".$this->extra_style."'>" . LF;

				break;
			case "html":
				echo $this->html;
				
				break;
			case "label":
				echo "<tr class='fieldset'><td class='custom' colspan='100%'><strong>" . $this->label . "</strong></td></tr>";
				
				break;
			case "custom":
				echo "<tr class='fieldset'><td class='label'>" . $this->label . ":</td><td class='input'>" . $this->html . "</td></tr>";
		}
	}
}
?>