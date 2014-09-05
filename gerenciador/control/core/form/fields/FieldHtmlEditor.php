<?php
class FieldHtmlEditor extends Field {
	var $js_object;
	var $images_path;
	
	var $width;
	var $height;
	
	var $buttons;
	
	function FieldHtmlEditor($tmp_params) {
		parent::Field("htmlEditor", $tmp_params[0]);
		
		$this->testRequiredType(array("varchar", "blob", "text"));
		
		$this->label = $tmp_params[1];
		$this->validation = "TXT";
		if(isset($tmp_params[2]))
			$this->images_path = $tmp_params[2];
		else
			$this->images_path = "";
		
		global $htmleditor_count;
		$this->js_object = "htmleditor" . $htmleditor_count;
		$htmleditor_count++;
		
		$this->width = "100%";
		$this->height = "300";
		
		$this->buttons = array();
	}
	
	//private functions
	function loadJSPrePost() { 
		?>
		if (<?php echo $this->js_object; ?>.is_window_opened) {
			ok = false;
		}
		<?php
	}
	
	function getInput() {
		global $cfg;
	
		$html = "<textarea ";
		$html .= "id='" . $this->_getFormatedId() . "' ";
		$html .= "name='" . $this->name . "' ";
		$html .= $this->input_extra . " style='display: block;'>";
		$html .= $this->getValue();
		$html .= "</textarea>";
		
		$buttons = "[]";
		if(sizeof($this->buttons) > 0){
			$buttons = "['" . implode("','",$this->buttons) . "']";
		}
		
		$html .= "
			<script>
			" . $this->js_object . " = new HtmlEditor();
			" . $this->js_object . ".class_name = '" . $this->js_object . "';
			" . $this->js_object . ".field_id = '" . $this->_getFormatedId() . "';
			" . $this->js_object . ".images_path = '" . $this->images_path . "';
			" . $this->js_object . ".root_path = '" . $cfg["root"] . "';
			" . $this->js_object . ".width = '" . $this->width . "';
			" . $this->js_object . ".height = '" . $this->height . "';
			" . $this->js_object . ".buttons = " . $buttons . ";
			" . $this->js_object . ".make();
			</script>
		";
		
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
		
		$html .= "	<td class='input'>" . $this->getFilterInput() . "</td>" . LF;
		$html .= "</tr>" . LF;
		
		if ($filter_value != "") {
			$sql = " and " . $old_name . " LIKE '%" . $filter_value . "%'";
		}
		
		return array("html" => $html, "sql" => $sql);
	}
	
	function getFilterInput() {
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
		
		return $html;
	}
	
	function getValueFormated($tmp_value = "") {
		global $cfg;
		
		if (isset($this)) {
			$v = $this->value;
		} else if ($tmp_value != "") { 
			$v = $tmp_value; 
		}
		
		return str_replace("#ROOT#", $cfg["root"], $v);
	}
	
	function getValueUnformated() {
		global $cfg;
		global $load;
		$load->system('functions/text.php');
		
		$this->value = formatSpecialCaracter($this->value);
		
		return str_replace($cfg["root"], "#ROOT#", $this->value);
	}
}
?>