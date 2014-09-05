<?php
class FieldTree extends Field {
	var $menu;
	var $args = array();
	var $arr_pais = array();
	/* 0 - idcategoria (campo a ser salvo na tabela que ele se encontra)
	 * 1 - label (label do campo e name do hidden)
	 * 2 - id (campo a ser buscado na tabela)
	 * 3 - idPai (campo que se relaciona com o id)
	 * 4 - nome (campo que será mostrado nos outros combos)
	 * 5 - tabela (tabela)
	 */
	
	function FieldTree($tmp_params) {
		parent::Field("items", $tmp_params[0]);
		
		$this->testRequiredType(array("varchar", "int"));
		
		$this->label = $tmp_params[1];
		$this->setInputType("select");
		$this->args = array($tmp_params[2],$tmp_params[3],$tmp_params[4],$tmp_params[5]);
	}
	
	function setInputType($tmp_type) {
		switch ($tmp_type) {
			default:
			case "select":
				$this->input_type = "select";
				$this->validation = "CMB";
				
				break;
		}
	}
	
	//private functions
	function getInput() {
		$value = $this->getValue();
	
		switch ($this->input_type) {
			default:
			case "select":
				/* 0 - id (campo a ser buscado na tabela)
				 * 1 - idPai (campo que se relaciona com o id)
				 * 2 - nome (campo que será mostrado nos outros combos)
				 * 3 - tabela (tabela)
				 */
				 //print_r2($this->$args);
				$args_line = implode(",",$this->args);
				$html = "<input type='hidden' id='".$this->name."_id' name='".$this->name."' value='".$value."'>".LF;//hidden que o sistema "verá"
				$html .= "<input type='hidden' id='".$this->label."_filhos' name='".$this->label."_filhos' value=''>".LF;//hidden com os filhos separados por "!!!"
				$html .= '<input type=\'hidden\' id=\''.$this->label.'_linha_pais\' name=\''.$this->label.'_linha_pais\' value=\'$ARR_PAIS$\'>'.LF;
				$html .= "<input type='hidden' id='".$this->label."_args' name='".$this->label."_args' value='".$args_line."'>".LF;//hidden com os argumentos para se utilizar na rotina de atualização
				$html .= "".LF;
				
				$html .= "<select class='input' id='".$this->label."_pai' name='".$this->label."_pai' onchange='javascript: ai(this,\"".$this->name."_id\");' ".$this->input_extra.">".LF;
				$html .= 	"<option value=''>Selecione</option>".LF;
				$html .= 	"<option value=''>------</option>".LF;
				$passou = false;
				foreach ($this->elements as $k => $v) {
					if ($k == $value) {
						$s = " selected";
						$passou = true;
					} else {
						$s = "";
					}
					$html .= "<option value='".$k."'".$s.">".$v."</option>".LF;
				}
				
				$html .= "</select>" . LF;
				$html .= "<BR>".LF;
				$html .= "<div id='".$this->label."_pai_div' style='padding-top: 5px;'></div>";
				
				if(!$passou) {
					$this->loadByChild($value); //descobre os pais do cara que está selecionado e põe no arr_pais da classe
					$this->arr_pais = array_reverse($this->arr_pais);
					$this->arr_pais[] = $value;
					//echo "<BR><BR>valor atual: ".$value."<BR>";
					//print_r2($this->arr_pais);
					//die;
					
					$pais_line = implode(",",$this->arr_pais);
					//echo $pais_line."<BR>";
					$html = str_replace('$ARR_PAIS$',$pais_line, $html);
					$html .= "<script type='text/javascript'>".LF;
					$html .= "loadFromFilho($$('".$this->label."_pai'));".LF;
					$html .= "</script>".LF;
				}else{
					$html = str_replace('$ARR_PAIS$',"", $html);
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
	function loadByChild($idComparar = "", $clearArray = true) {
		global $db;
		
		if ($clearArray) {
			$this->arr_pais = array();
		}
		
		//se entrou aqui, significa que não encontrou o valor atual dentro da primeira lista (pai)
		/* 0 - id (campo a ser buscado na tabela)
		 * 1 - idPai (campo que se relaciona com o id)
		 * 2 - nome (campo que será mostrado nos outros combos)
		 * 3 - tabela (tabela)
		 */
		$sql = "select distinct ".$this->args[0].",".$this->args[2].",".$this->args[1]." from ".$this->args[3]." where ".$this->args[0]."=".$idComparar;
		//echo $sql."<BR>";
		if ($idComparar != "") {
			$rs_pais = $db->execute($sql);
		} else {
			return;
		}
		
		if ($rs_pais->recordcount > 0){
			if ($rs_pais->fields($this->args[1]) == $idComparar){
				return;
			}else{
				if($rs_pais->fields($this->args[1]) > 0) {
					$this->arr_pais[] = $rs_pais->fields($this->args[1]);
					$this->loadByChild($rs_pais->fields($this->args[1]),false);
				}else{
					return;
				}
			}
		}
	}
	function getFilter() {
		global $input;
		
		$html = "";
		$sql = "";
		
		$filter_name = $this->_getFilterName();
		$filter_value = $this->_getFilterValue();
		$filter_chk = $this->_getFilterChecked();
		$old_name = $this->input_name;
		
		$html = "<tr class='fieldset'>" . LF;
		$html .= "	<td class='label'>" . $this->label . ":</td>" . LF;
		$html .= "	<td class='label' style='width: 30px; text-align: center;'><input type='checkbox' name='" . $filter_name . "-chk' id='" . $filter_name . "-chk' value='1' " . $filter_chk . "></td>" . LF;
		
		//crete filter input
		$this->input_name = $filter_name;
		$this->value = $filter_value;
		$this->is_required = false;
		if ($this->input_type == "select") {
			$this->input_extra = "onChange=\"javascript: { if (this.value != '') { $$('" . $filter_name . "-chk').checked = true; } else { $$('" . $filter_name . "-chk').checked = false; } }\"";
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
			//não está na primeira lista de objetos carregados.
			$this->loadByChild($this->value); //descobre os pais do cara que está selecionado e põe no arr_pais da classe
			$this->arr_pais = array_reverse($this->arr_pais); //coloca os pais por ordem crescente
			$this->arr_pais[] = $this->value; //adiciona o último, que é o valor real
			
			$this->value = $this->getNames($this->value);
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
	function getNames($valor_atual) {
		global $db;
		/* 0 - id (campo a ser buscado na tabela)
		 * 1 - idPai (campo que se relaciona com o id)
		 * 2 - nome (campo que será mostrado nos outros combos)
		 * 3 - tabela (tabela)
		 */
		$names = "";
		for($x=0;$x < sizeof($this->arr_pais);$x++){
			$sql = "select ".$this->args[2].",".$this->args[0]." from ".$this->args[3]." where ".$this->args[0]." = ".$this->arr_pais[$x];
			//echo $sql."<BR><BR>";
			$rs = $db->execute($sql);
			
			if($rs->recordcount > 0) {
				$atual = $rs->fields($this->args[2]);
				if ($rs->fields($this->args[0]) == $valor_atual)
					$atual = "<b>".$atual."</b>";
					
				if($names != "")
					$names .= " > ".$atual;
				else
					$names = $atual;
			}
		}
		return $names;
	}
}
?>