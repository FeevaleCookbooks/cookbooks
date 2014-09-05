<?php
define("DIR_ROOT", str_replace("/control", "", str_replace("\\", "/", dirname(__FILE__))) . "/");

include(DIR_ROOT . "_system/app.php");

$load->manager("core/form/Form.php");

if (file_exists(DIR_ROOT . "_config/exceptions/classes/Profile.php")) {
	$load->config("exceptions/classes/Profile.php");
} else {
	$load->manager("core/Profile.php");
}
?>