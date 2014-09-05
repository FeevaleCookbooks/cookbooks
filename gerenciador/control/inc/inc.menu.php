<?php
global $load;
global $menu;

//.menu
$load->manager("core/Menu.php");
$menu = new Menu();

$load->config("menu.php");
?>