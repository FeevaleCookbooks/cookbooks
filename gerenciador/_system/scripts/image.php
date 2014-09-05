<?
$cfg["database_connect"] = "false";

include("../app.php");

$load->system("library/Image.php");

$resize = (($input->get('resize',false,'int') == '')?2:$input->get('resize',false,'int'));

$img = new Image("../../" . $input->get("file"));
$img->resize($input->get("w",false,'int'), $input->get("h",false,'int'), $resize);
$img->header();
?>