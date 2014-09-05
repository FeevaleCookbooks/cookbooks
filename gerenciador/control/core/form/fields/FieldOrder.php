<?php
class FieldOrder extends Field {
	function FieldOrder($tmp_params) {
		parent::Field("order", ($tmp_params[0] != "") ? $tmp_params[0] : "ordem");
		
		$this->testRequiredType(array("int"));
		
		$this->label = ($tmp_params[1] != '') ? $tmp_params[1] : "Ordem";
		
		$this->list_width = 63;
		$this->flags_accepted = "LO";
	}
	
	//private functions
	function getInput() {
		$html = "";
		
		return $html;
	}
	
	function getFilter() {
		$html = "";
		$sql = "";
		
		return array("html" => $html, "sql" => $sql);
	}
	
	function getHtmlList($tmp_extra) {
		global $rs_list;
		global $form;
		global $records_total;
		global $i;
		
		$tmp = explode("onclick", $tmp_extra);
		
		$is_first = (($rs_list->absolutepage == 1) && ($i == 1));
		$is_last = (($rs_list->absolutepage == $rs_list->pagecount) && ($i == $records_total));
		
		$html = "<td " . $tmp[0] . " align='center'>";
		
		$order = $form->_getOrderValue();
		$order_parsed = explode("#", $order);
		
		if ($order_parsed[0] == $this->name) {
			if (!$is_last) {
				$html .= "<img  onclick=\"javascript: orderSwap('" . $this->name . "', '" . $rs_list->fields($form->key_field) . "', '1');\" style='cursor: pointer;' src='../img/icons/arow_down2.gif'>&nbsp;&nbsp;";
			} else {
				$html .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			
			if (!$is_first) {
				$html .= "<img onclick=\"javascript: orderSwap('" . $this->name . "', '" . $rs_list->fields($form->key_field) . "', '-1');\" style='cursor: pointer;' src='../img/icons/arow_up2.gif'>";
			} else {
				$html .= "&nbsp;&nbsp;&nbsp;&nbsp;";
			}
		} else {
			$html .= $this->value . "";
		}
		
		$html .= "</td>" . LF;
		
		return $html;
	}
	
	function onPosPost() {
		global $form;
		global $routine;
		
		if (($routine == "insert") || (($routine == "update") && (($form->fields[$this->name] == "") || ($form->fields[$this->name] == "0")))) {			
			$form->fields[$this->name] = $form->fields[$form->key_field];
			$form->update();
		}
	}
	
	function ajaxRoutine($tmp_routine) {
		global $routine;
		global $input;
		global $db;
		global $form;
		
		//Set order values
		$sql = "select count(" . $form->key_field . ") as total from " . $form->table . " where (" . $this->name . " = '' or " . $this->name . " = '0' or " . $this->name . " <= 0 or " . $this->name . " is null);";
		$rs = $db->execute($sql);
		
		if (!$rs->EOF) {
			if ($rs->fields("total") > 0) {
				$sql = "update " . $form->table . " set " . $this->name . " = " . $form->key_field . " where (" . $this->name . " = '' or " . $this->name . " = '0' or " . $this->name . " <= 0 or " . $this->name . " is null);";
				$db->execute($sql);
			}
		}
		
		//Swap orders
		$direction = $input->get("direction");
		$sql_list = base64_decode($input->post("sql"));
		
		//.From id/order
		$from_id = $input->get("tmp_id",false,'int');
		
		$sql = "select " . $this->name . " from " . $form->table . " where " . $form->key_field . " = '" . $from_id . "';";
		$rs = $db->execute($sql);
		
		if (!$rs->EOF) {
			$from_order = $rs->fields($this->name);
			
			//.To id/order
			$rs = $db->execute($sql_list);
			
			$to_id = 0;
			$to_order = 0;
			$tmp = 0;
			
			if ($direction == "-1") {
				while (!$rs->EOF) {
					if ($rs->fields($form->key_field) != $from_id) {
						$to_id = $rs->fields($form->key_field);
						$to_order = $rs->fields($this->name);
						$to_order = $to_order == $from_order ? $to_order - 1 : $to_order;
					} else {
						break;
					}
					
					$rs->moveNext();
				}
			} else {
				while (!$rs->EOF) {				
					if ($rs->fields($form->key_field) == $from_id) {
						$rs->moveNext();
						
						$to_id = $rs->fields($form->key_field);
						$to_order = $rs->fields($this->name);
						$to_order = $to_order == $from_order ? $to_order + 1 : $to_order;
						
						break;
					} 
					
					$rs->moveNext();
				}
			}
			
			$sql = "update " . $form->table . " set " . $this->name . " = '" . $to_order . "' where " . $form->key_field . " = '" . $from_id . "'";
			$db->execute($sql);
			
			$sql = "update " . $form->table . " set " . $this->name . " = '" . $from_order . "' where " . $form->key_field . " = '" . $to_id . "'";
			$db->execute($sql);
			
			echo $direction . "\n";
			
			echo $from_order . " - " . $from_id . "\n";
			echo $to_order . " - " . $to_id;
		}
	}
}
?>