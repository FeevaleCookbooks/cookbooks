<?
function getStates($tmp_key = "uf", $tmp_order_by = "nome asc") {
	global $db;
	
	$sql = "select " . $tmp_key . ", nome from estados order by " . $tmp_order_by;
	$rs = $db->execute($sql);
	
	$arr = array();
	while (!$rs->EOF) {
		$arr[$rs->fields($tmp_key)] = $rs->fields("nome");
	
		$rs->moveNext();
	}
	
	return $arr;
}
?>