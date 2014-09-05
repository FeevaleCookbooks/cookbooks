<?
class Xml extends Xml_node {
	var $encoding;
	var $version;
	var $_utf8_encode;
	var $_usetab;
	
	function Xml() {
		$this->encoding = "utf-8";
		$this->version = "1.0";
		
		$this->_utf8_encode = false;
		$this->_usetab = true;
		
		parent::Xml_node("");
	}
	
	function getXML() {	
		$r = '<?xml version="' . $this->version . '" encoding="' . $this->encoding . '"?>' . "\r\n";
		
		$this->_utf8_encode = ($this->encoding == "utf-8");
		
		//nodes
		$i = 0;
		$total = sizeof($this->_nodes);
		while ($i < $total) {
			$r .= $this->_getXMLNode($this->_nodes[$i]);
			$i++;
		}
		
		return $r;
	}
	
	function _getXMLNode(&$tmp_node, $tmp_tab = "") {
		$tab = "	";
		$r = '';
		
		if (!$this->_usetab) {
			$tmp_tab = "";
			$tab = "";
		}
	
		$r .= $tmp_tab . '<' . $tmp_node->name;
		
		$total = sizeof($tmp_node->_properties);
		for ($i = 0; $i < $total; $i++) {
			$r .= ' ' . $tmp_node->_properties[$i][0] . '="' . $this->_formatProperty($tmp_node->_properties[$i][1]) . '"';
		}
		
		if (($tmp_node->value != "") || (sizeof($tmp_node->_nodes) > 0)) {
			$r .= '>';
			if ($tmp_node->value == "") {
				$r .= "\r\n";
			}
		} else {
			$r .= '/>';
		}
		
		//nodes
		$total = sizeof($tmp_node->_nodes);
		for ($i = 0; $i < $total; $i++) {
			$r .= $this->_getXMLNode($tmp_node->_nodes[$i], $tmp_tab . "	");
		}

		//cdata
		if (($tmp_node->value != "") && (sizeof($tmp_node->_nodes) == 0)) {
			if ($tmp_node->_is_cdata) {
				
				
				$r .= $tmp_tab . $tab . "<![CDATA[";
			}
			
			$r .= $this->_formatValue($tmp_node->value);
			
			if ($tmp_node->_is_cdata) {
				$r .= "]]>";
			}
		}
		
		//fecha tag
		if (($tmp_node->value != "") || (sizeof($tmp_node->_nodes) > 0)) {
			if ($tmp_node->value == "") {
				$r .= $tmp_tab;
			}
			
			$r .= '</' . $tmp_node->name . '>';
		}		
		
		$r .= "\r\n";
		
		return $r;
	}
	
	
	//======================================
	//	Formatações
	//======================================
	function _formatProperty($tmp_value) {
		$tmp_value = str_replace(chr(10), "", $tmp_value);
		$tmp_value = str_replace(chr(13), "", $tmp_value);
		$tmp_value = str_replace("\"", "`", $tmp_value);
		$tmp_value = str_replace("'", "`", $tmp_value);
		$tmp_value = str_replace("&", "e", $tmp_value);
		
		if ($this->_utf8_encode) {
			return utf8_encode($tmp_value);
		} else {
			return $tmp_value;
		}
	}
	
	function _formatValue($tmp_value) {
		$tmp_value = str_replace(chr(10), "", $tmp_value);
		$tmp_value = str_replace(chr(13), "", $tmp_value);
		
		if ($this->_utf8_encode) {
			return utf8_encode($tmp_value);
		} else {
			return $tmp_value;
		}
	}
	
	
	//======================================
	//	Salva em arquivo
	//======================================
	function save($tmp_path) {
		$p = fopen($tmp_path, "w");
		fwrite($p, $this->getXML());
		fclose($p);
	}
}

class Xml_node {
	var $name;
	var $value;
	var $_is_cdata;
	var $_properties;
	var $_nodes;
	var $_parent;
	var $last_node;
	
	function Xml_node($tmp_name) {
		$this->name = $tmp_name;
		$this->value = "";
		
		$this->_nodes = array();
		$this->_properties = array();
		$this->_is_cdata = true;
		$this->_parent = NULL;
		
		$this->last_node = NULL;
	}
	
	function setValue($tmp_value, $tmp_is_cdata = true) {
		$this->value = $tmp_value;
		$this->_is_cdata = $tmp_is_cdata;
	}	
	
	//Properties
	function addProperty($tmp_name, $tmp_value = "") {
		$p = array();
		$p[0] = $tmp_name;
		$p[1] = $tmp_value;
		
		$this->_properties[] = $p;
	}
	
	function removeProperty($tmp_name) {
		$i = 0;
		$r = false;
		while ($i < sizeof($this->_properties)) {
			if ($this->_properties[$i][0] == $tmp_name) {
				unset($this->_properties[$i]);
			}
			
			$i++;
		}
		
		$this->_properties = array_merge($this->_properties, array());
		
		return $r;
	}
	
	//child nodes
	function createNode($tmp_name) {
		return new Xml_node($tmp_name);
	}
	
	function appendChild($tmp_node) {
		$tmp_node->_parent = &$this;
		$this->_nodes[] = $tmp_node;
		$this->last_node = $tmp_node;
		
		return $tmp_node;
	}	
	
	//Gets
	function getIndexByNodeName($tmp_name) {
		$i = 0;
		$index = -1;
		while ($i < sizeof($this->_nodes)) {
			if ($this->_nodes[$i]->nome == $tmp_name) {
				$index = $i;
			}
			
			$i++;
		}
		
		return $index;
	}
	
	function &getNodeByName($tmp_name, $tmp_index = 0) {
		$tmp_name = strtolower($tmp_name);
		
		$i = 0;
		$node = NULL;
		$qnt = 0;
		while ($i < sizeof($this->_nodes)) {
			if (strtolower($this->_nodes[$i]->name) == $tmp_name) {
				if ($qnt == $tmp_index) {
					return $this->_nodes[$i];
				}
				$qnt++;
			}
			
			$i++;
		}
	}
	
	function &getNodeByIndex($tmp_index) {
		return $this->_nodes[$tmp_index];
	}
	
	function &getParentNode() {
		return $this->_parent;
	}
	
	function &getLastNode() {
		return $this->_nodes[sizeof($this->_nodes) - 1];
	}

	function setLastNode($tmp_node) {
		$this->nodes[sizeof($this->_nodes) - 1] = $tmp_node;
	}
}
?>