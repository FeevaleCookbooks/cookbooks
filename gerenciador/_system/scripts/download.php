<?
include("../../_config/config.php");

// Se não tiver o caminho do arquivo, tranca o script
if (isset($_GET["file"])) {
	$file = $_GET["file"];
} else {
	die("Caminho do arquivo não informado.");
}

if (strpos($file, "upload") === false) {
	die("Não é permitido download fora da pasta upload.");
}

if (!file_exists("../../" . $file)) {
	die("Arquivo não existe.");
}

if (isset($_GET["name"])) {
	$name = $_GET["name"];
} else {
	$arr = split("/", $file);
	$name = $arr[sizeof($arr) - 1];
}

if (isset($_GET["indice"])) {
	$indice = $_GET["indice"];
} else {
	$indice = 0;
}

if (!isset($cfg["download_extension"][$indice])) {
	$indice = 0;

	if (!isset($cfg["download_extension"][$indice])) {
		$arr_extension = array("jpg","gif");
	} else {
		$arr_extension = $cfg["download_extension"][$indice];
	}
}else {
	$arr_extension = $cfg["download_extension"][$indice];
}

$arr_aux = explode(".", $file);
$ext = $arr_aux[sizeof($arr_aux)-1];

if (in_array($ext,$arr_extension)) {
 	switch(strtolower($ext)) { // verifica a extensão do arquivo para pegar o tipo
         case "pdf": $tipo="application/pdf"; break;
         case "zip": $tipo="application/zip"; break;
         case "doc": $tipo="application/msword"; break;
         case "xls": $tipo="application/vnd.ms-excel"; break;
         case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
         case "gif": $tipo="image/gif"; break;
         case "png": $tipo="image/png"; break;
         case "jpg": $tipo="image/jpg"; break;
         case "mp3": $tipo="audio/mpeg"; break;
         case "php":
         case "asp":
         case "htm":
         case "html": $tipo="application/x-msdownload";break;
         default: $tipo="application/octet-stream"; break;
    }

	header('Content-Description: File Transfer');
	header('Content-Type: '.$tipo);

	header("Content-Disposition: attachment; filename=" . $name);
	header("Content-Length: ".filesize("../../" . $file));
	header('Content-Transfer-Encoding: binary');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	header('Expires: 0');

	readfile("../../" . $file);
} else {
	die("Extensão não permitida.");
}
?>