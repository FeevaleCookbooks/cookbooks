<?php
$uriQuery = (empty($_SERVER['QUERY_STRING']) ? '' : '?'.$_SERVER['QUERY_STRING']);

header("HTTP/1.1 301 Moved Permanently");
header("Location: routines/system/login.php{$uriQuery}");
?>