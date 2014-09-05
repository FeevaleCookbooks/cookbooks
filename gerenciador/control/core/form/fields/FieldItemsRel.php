<?php
class FieldItemsRel extends Field {
	var $menu;
	
	// Param
	// 0 = campo
	// 1 = label
	// 2 = id do campo 'pai'

	function FieldItemsRel($tmp_params) {
		parent::Field("itemsRel", $tmp_params[0]);
		
		$this->testRequiredType(array("varchar", "int"));
		
		$this->label = $tmp_params[1];
		$this->input_type = "select";
		$this->validation = "CMB";
		
		$this->id_field_rel = $tmp_params[2];
	
		$this->table_rel = $tmp_params[3];
		$this->value_in_table = ((isset($tmp_params[4]))?$tmp_params[4]:'id');
		$this->name_in_table = ((isset($tmp_params[5]))?$tmp_params[5]:'nome');
	}
	
	//private functions
	function getInput() {
		$value = $this->getValue();
	
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
		
		$this->input_extra = "onChange=\"javascript: { if (this.value != '') { document.getElementById('" . $filter_name . "-chk').checked = true; } else { document.getElementById('" . $filter_name . "-chk').checked = false; } }\"";
		
		
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
	
	function loadInit() {
		global $routine;
		
		if (($routine == 'insert') || ($routine == 'update')) {
		?>
			<script language="javascript">		
				var change<?php echo $this->name ?> = function () {
					// Chama a funcao que vai trocar o select
					findRel<?php echo $this->name ?>(this.value,this.name,'<?php echo $this->table_rel ?>','<?php echo $this->value_in_table ?>','<?php echo $this->name_in_table ?>','');
					document.getElementById('<?php echo $this->_getFormatedId() ?>').disabled = false;
				}
				
				// PARAM
				// value = valor do campo 'pai'
				// name_field = nome do campo 'pai' para ser buscado na tabela
				// table_rel = nome da tabela onde os valores serão buscados
				// value_field_rel = valor que ficará no campo value no select
				// name_field_rel = texto que aparecerá para o usuário no select
				// value_select = valor atual do campo
				
				function findRel<?php echo $this->name ?>(value,name_field,table_rel,value_field_rel,name_field_rel,value_select) {
					var a = new Ajax();
					
					a.onLoad = function() {
						values = this.html;
						
						arr_options = values.split('#');
						
						selected = '';
						
						for(x=0,total = arr_options.length;x<total;x++) {
							value_option = arr_options[x].split('+');
							
							document.getElementById('<?php echo $this->_getFormatedId() ?>').options[x] = new Option(value_option[1],value_option[0]);
						
							if (value_option[0] == value_select) {
								selected = x;
							}
						}
						
						document.getElementById('<?php echo $this->_getFormatedId() ?>').selectedIndex = selected;
					}
					
					document.getElementById('<?php echo $this->_getFormatedId() ?>').innerHTML = '';
	
					a.get('../../control/routines/form/routines.php?routine=refresh_combo&value='+value+'&name_fields='+name_field+'&table_rel='+table_rel+'&value_field_rel='+value_field_rel+'&name_field_rel='+name_field_rel+'&value_select='+value_select);
				}
			
				if (document.getElementById('<?php echo $this->id_field_rel ?>_CMB1')) {
					sufixo_rel = '_CMB1';
				} else {
					sufixo_rel = '_CMB0';
				}
							
				addEvent(document.getElementById('<?php echo $this->id_field_rel ?>'+sufixo_rel), 'change', change<?php echo $this->name ?>);
				
				if (document.getElementById('<?php echo $this->id_field_rel ?>'+sufixo_rel).value != '') {
					// Acrescente no onchange do campo 'pai' a função para trocar esta combo
					findRel<?php echo $this->name ?>(document.getElementById('<?php echo $this->id_field_rel ?>'+sufixo_rel).value,document.getElementById('<?php echo $this->id_field_rel ?>'+sufixo_rel).name,'<?php echo $this->table_rel ?>','<?php echo $this->value_in_table ?>','<?php echo $this->name_in_table ?>','<?php echo $this->getValue(); ?>');
				} else {
					document.getElementById('<?php echo $this->_getFormatedId() ?>').disabled = true;
				}
			</script>
		<?php
		}
	}
}
?>