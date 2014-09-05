<?
session_start();
//Defines
define("LF", "\n");
define("CRLF", "\r\n");

//Diretories
if (!defined("DIR_ROOT")) {
	define("DIR_ROOT", str_replace("/_system", "", str_replace("\\", "/", dirname(__FILE__))) . "/");
}
define("DIR_SYSTEM", DIR_ROOT . "_system/");
define("DIR_CONFIG", DIR_ROOT . "_config/");


//Globals
global $load;
global $error;
global $cfg;
global $input;
global $output;
global $menu;
global $file;
global $system;

//Debug class
include(DIR_SYSTEM . "core/Debug.php");

//Error handle
include(DIR_SYSTEM . "core/Error.php");

//System base
include(DIR_SYSTEM . "core/System.php");
$system = new System();



//Load
include(DIR_SYSTEM . "core/Load.php");
$load = new Load();
define("IS_LOCAL", ($system->testServer("localhost") || $system->testServer("server") || (strpos($_SERVER['HTTP_HOST'],'192.168.') !== false) || $system->testServer("200.160.153.121")));


//Config
if (!isset($cfg["database_connect"])) { // Check if can connect base
	$cfg = array();
}
$load->config('config.php');
$system->formatConfig();

define("DIR_MANAGER", $cfg["folder_manager"] . "/");
define("IS_MANAGER", $system->isManager());
define("IS_DEVELOP", ($cfg["develop"]) ? ($cfg["develop"] && IS_LOCAL) : false);


//Database
if (array_key_exists("database_type", $cfg)) {
	// To old versions' Framework
	if (!is_array($cfg["database_type"])) {
		$arr_tmp = array($cfg["database_type"],$cfg["database_server"],$cfg["database_user"],$cfg["database_password"],$cfg["database_database"]);
		$cfg["database_type"] = array();
		$cfg["database_server"] = array();
		$cfg["database_user"] = array();
		$cfg["database_password"] = array();
		$cfg["database_database"] = array();
		
		$cfg["database_type"][0] = $arr_tmp[0];
		$cfg["database_server"][0] = $arr_tmp[1];
		$cfg["database_user"][0] = $arr_tmp[2];
		$cfg["database_password"][0] = $arr_tmp[3];
		$cfg["database_database"][0] = $arr_tmp[4];
	}
	
	for($x=0,$total=sizeof($cfg["database_type"]);$x<$total;$x++) {
		// Create an object: $db, $db2,$db3, ...
		$newvar = "db".(($x == 0)?'':$x+1);
		$$newvar = $load->database($x);
				
		//.connect	
		if (!($cfg["database_connect"][$x] === false)) {
			$$newvar->connect($cfg,$x);	
		}
	}
}


//Color
//.input
$load->system("core/Input.php");
$input = new Input();

//.output
$load->system("core/Output.php");
$output = new Output();

//.file
$load->system("core/File.php");
$file = new File();

//.log
$load->system("core/Log.php");
$log = new Log(IS_MANAGER);

//.DBTable
$load->system("core/DBTable.php");


//Functions
$load->system("functions/url.php");
$load->system("functions/debug.php");
?>