<?php
class Menu {
	var $index;
	var $index_sub;

	var $_itens;

	function Menu() {
		global $input;
		
		log_message("[menu] é instanciado.");
		
		$this->_itens = array();
		
		$r = $input->request("menu");
		
		if (($r !== "")) {
			$r = explode("-", $r);
			
			if(sizeof($r) > 1){
				$this->index = $r[0];
				$this->index_sub = $r[1];
			}
		}
	}
	
	function add($tmp_label, $tmp_subs, $tmp_iconpath = "", $tmp_default_sub = 0) {
		$i = sizeof($this->_itens);
		
		$this->_itens[$i]["subs"] = $tmp_subs;
		$this->_itens[$i]["default"] = $tmp_default_sub;
		$this->_itens[$i]["label"] = ($tmp_label);
		$this->_itens[$i]["icon_path"] = "../../_config/".$tmp_iconpath;
	}
	
	function loadMenu() {
		$html = "";
		
		if (($this->index > -1) and ($this->index != "")) {
			$sel = true;
		} else {
			$sel = false;
		}
		
		$onMenu = " onmouseover='onMenu(\"#K#\",true);' onmouseout='onMenu(\"#K#\",false);' ";
		
		foreach ($this->_itens as $k => $v) {
			if (($k == $this->index) && ($sel)) {
				$s = " menu_sel ";
			} else {
				$s = '';
			}
			
			$image = "";
			if ($v["icon_path"] != "") {
				$image = "<tr><td align='center'><img src='".$v["icon_path"]."' /></td></tr>";
			}
			$over = str_replace("#K#",$k,$onMenu);
			if($s != "")
				$over = "";
			
			$html .= "<td>
						<div id='div_".$k."' style='display:block;' >
						<table style='border:1px solid #8B9F5D;' id='tbl_menu_".$k."' ".$over." class='menu".$s."' cellspacing='0' cellpadding='0' onclick=\"window.location = '"."?menu=".$k."-".$v["default"]."';\">
							".$image."
							<tr>
								<td>".$v["label"]."</td>
							</tr>
						</table>
						</div>
					</td>".LF;
		}
		
		return $html;
	}
	
	function loadSubs() {
		//$html = '<td style="border:0px solid #CCCCCC;">';
		$html = '';
		
		if (isset($this->_itens[$this->index])) {
			$arr = $this->_itens[$this->index];
			
			$subs = $arr["subs"];
		} else {
			$subs = "";
		}
		
		if (($this->index > -1) and ($this->index != "")) {
			$sel = true;
		} else {
			$sel = false;
		}
		
		$onSubmenu = " onmouseover='onSubmenu(\"#K#\",true);' onmouseout='onSubmenu(\"#K#\",false);' ";
		
		if (is_array($subs)) {
			if (sizeof($subs) > 1) {
				foreach ($subs as $k => $v) {
					if ($k == $this->index_sub) {
						$s = " submenu_sel ";
					} else {
						$s = "";
					}
					
					$html .= "<div id='div_submenu_".$k."' class='submenu".$s."' ".str_replace("#K#",$k,$onSubmenu)." ><table cellspacing='0' cellpadding='0' onclick=\"window.location = '?menu=" . $this->index . "-" . $k . "';\"><tr><td>" . $v->name . "</td></tr></table></div>";
				}
			}
		} else {
			if ($sel) {
				error(2, "Menu " . $this->index . " não possui sub-menus.", "Menu", "loadSubs");
			}
		}
		
		return $html;
	}
	
	
	function getInclude() {
		$sub = $this->getSub();
		$pag = $this->_getInclude($sub->module);
		
		return $pag;
	}
	
	function getSub() {
		$r = "";
		
		if (isset($this->_itens[$this->index])) {
			$r = $this->_itens[$this->index]["subs"][$this->index_sub];
		} else {
			$r->module = '';	
		}
		
		return $r;
	}
	
	function formatUrl($tmp_url, $tmp_gets = "") {
		return $tmp_url . "?menu=" . $this->index . "-" . $this->index_sub . "&" . $tmp_gets;
	}
	
	
	function _getInclude($tmp_module) {
		switch ($tmp_module) {
			case "form":
				return "form/list.php";
				
				break;
			default:
				if ($tmp_module != "") {
					return "../../_config/exceptions/pages/" . $tmp_module;
				} else {
					return "../../_config/exceptions/home.php";
				}
				
				break;
		}
	}
}


class Menu_sub {
	var $class;
	var $name;
	var $module;
	
	function Menu_sub($tmp_class, $tmp_name, $tmp_url_or_module = "form") {
		$this->class = $tmp_class;
		$this->name = $tmp_name;
		$this->module = $tmp_url_or_module;
	}
}
?>