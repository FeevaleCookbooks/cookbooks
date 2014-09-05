<?php

global $cfg;

header('Content-type: text/html; charset=iso-8859-1');
//Develop?
//$cfg["develop"] = true;
//Database
if (IS_LOCAL) {
    error_reporting(E_ERROR);
    ini_set('display_errors', 'On');
    ini_set('display_startup_errors', 'On');

    $cfg["database_type"][0] = "mysql";
    $cfg["database_server"][0] = "localhost";
    $cfg["database_user"][0] = "root";
    $cfg["database_password"][0] = "";
    $cfg["database_database"][0] = "pakua";

    $cfg["root"] = "";
} else {
    error_reporting(0);
    $cfg["develop"] = false;

    $cfg["database_type"][0] = "mysql";
    $cfg["database_server"][0] = "";
    $cfg["database_user"][0] = "";
    $cfg["database_password"][0] = "";
    $cfg["database_database"][0] = "";

    $cfg["root"] = "";
}

$cfg["download_extension"][] = array("pdf","gif", "jpg", "png");

//Language
$cfg["language1"] = "pt";

//Control
$cfg["folder_manager"] = "control";
$cfg["system_title"] = "";
$cfg["system_sitelink"] = "";
$cfg["system_logo"] = "images/logo.png"; //caminho do logo a partir do _config


$cfg["site_title"] = "";
//E-mails
$cfg['email_remetente'] = '';

//Security

/* Metodos de criptografia para senhas do control:
 * 
 * $cfg["criptografia"] = "HASH"; ? usada a fun??o hash para criptografar os dados (PHP 5 >= 5.1.2, PECL hash >= 1.1)
 * 	neste caso deve ser passado o metodo de criptografia conforme parametros aceitos pela fun??o hash
 * 	ex.:
 * 		"sha512" | "whirlpool" | "salsa20"
 * 
 * $cfg["criptografia"] = "SIMPLE"; s?o usadas as fun??es de criptografia SHA1 ou MD5 do PHP (PHP 4, PHP 5)
 * 	neste caso deve ser passado qual dos 2 tipos, SHA1 ou MD5, dever? ser utilizado
 */
$cfg["criptografia"] = "HASH"; // "HASH" | "SIMPLE" | ""
$cfg["metodo_criptografia"] = "whirlpool"; // HASH -> "sha512" | "whirlpool" | "salsa20" // SIMPLE -> "SHA1" | "MD5"
?>