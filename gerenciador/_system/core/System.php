<?
class System {
	function System() {
		log_message("[system] é instanciado.");
	}
	
	function formatConfig() {
		global $cfg;
		
		$cfg["folder_manager"] = (isset($cfg["folder_manager"])) ? $cfg["folder_manager"] : "manager";
		
		if (!array_key_exists("database_connect", $cfg)) {
			$cfg["database_connect"] = true;
		}
		
		if (!array_key_exists("system_sitelink", $cfg)) {
			$cfg["system_sitelink"] = "/";
		}
		
		if (!array_key_exists("root", $cfg)) {
			$cfg["root"] = "http://" . $_SERVER['HTTP_HOST'] . "/";
		}
		
		if (!array_key_exists("develop", $cfg)) {
			$cfg["develop"] = false;
		}
	}
	
	function testServer($tmp_server) {
		if (str_replace($tmp_server, "", $_SERVER['HTTP_HOST']) != $_SERVER['HTTP_HOST']) {
			return true;
		} else {
			return false;
		}
	}
	
	function isManager() {
		global $cfg;
		
		return ((strpos($_SERVER["PHP_SELF"], "anager")) || (strpos($_SERVER["PHP_SELF"], $cfg["folder_manager"])));
	}
	
	function getFaviconHeader($cfg_page = "") {
		global $cfg;
		
		$path = "";
		
		$root = "../../";
		if ($cfg_page == "login") {
			$root = "../../../";
		}
		
		$path_default = $root . $cfg["folder_manager"] . "/img/favicon.ico";
		$path_custom = $root . "_config/exceptions/favicon.ico"; 
		
		if (file_exists($path_custom)) {
			$path = $path_custom;
		} elseif (file_exists($path_default)) {
			$path = $path_default;
		}
		
		if ($path != "") {
			echo "<link rel=\"shortcut icon\" href=\"" . $path . "\" type=\"image/x-icon\" />";
		}
	}
}
?>