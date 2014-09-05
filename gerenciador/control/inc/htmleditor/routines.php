<?php
$cfg["database_connect"] = "false";
include("../../../_system/app.php");
$load->system('functions/text.php');

$routine = $input->get("routine");

//thumb
if ($routine == "thumb") {
	$w = $input->get("w",false,'int');
	$h = $input->get("h",false,'int');
	
	$w = ($w) ? $w : 80;
	$h = ($h) ? $h : 80;
	
	$load->system("library/Image.php");
	
	$path = strtolower($input->get("file"));
	
	if (substr($path, 0, 4) != "http") {
		$path = "../../../" . $path;
	}
	
	$method = ($input->get("method",false,'int')) ? $input->get("method",false,'int') : 3;
	
	$img = new Image($path);
	$img->resize($w, $h, $method);
	$img->header();
}

//list
function doList($tmp_path) {
	global $file;
	
	$arr = $file->listFolder($tmp_path . "/");
	foreach ($arr as $v) {
		$path = $tmp_path . "/" . $v;
		
		if (is_dir($path)) {
			doList($path);
		} elseif (is_file($path)) {
			echo str_replace("../../../", "", $path) . "##";
		}
	}
}

if ($routine == "list") {
	$path = $input->get('path');
	
	if (substr($path, -1) == "/") {
		$path = substr($path, 0, strlen($path) - 1);
	}
	
	doList("../../../" . $path);	
}

//upload
if ($routine == "upload") {
	$folder = "../../../" . $input->get("path");
	
	$file->makeFolder($folder);
	
	$f = $_FILES["file"]["name"];
	$ext = $file->getExtension($f);
	$file_n = formatNameFile(substr($f, 0, strlen($f) - 4));
	
	$file_name = $file_n . "." . $ext;
	
	$i = 0;
	do {
		$c = "";
		if ($i > 0) {
			$c = "(" . $i . ")";
		}
		
		$file_name = $file_n . $c . ".jpg";
		
		$i++;
	} while ((file_exists($folder . $file_name)) && ($i < 20));
	
	$file_name = $file_n . $c . "." . $ext;
	
	if (move_uploaded_file($_FILES["file"]["tmp_name"], $folder . $file_name)) {
		$load->system("library/Image.php");
		
		$img = new Image($folder . $file_name);
		$img->save($folder . $file_name);
		
		if ($ext != "jpg" && $ext != "gif" && $ext != "png") {
			unlink($folder . $file_name);
		}
		echo 1;
	} else {
		echo 0;
	}
}
?>