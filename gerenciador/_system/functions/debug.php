<?
function print_r2($tmp_var) {
	echo "<pre>";
	echo htmlentities(print_r($tmp_var,true));
	echo "</pre>";
}
?>