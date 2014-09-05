<?php
global $profile;

$profile = new Profile();

if (!$profile->isLogged()) {
	redir("../", true);
}
?>