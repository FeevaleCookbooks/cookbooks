<?
function redir($tmp_url, $tmp_force_js = false, $tmp_frame = "", $tmp_execute_js = true) {
	//If it`s redirect to a frame, only javascript can do this
	if ($tmp_frame != "") {
		echo "<script>window.open('" . $tmp_url . "', '" . $tmp_frame . "', '');</script>";
		return "";
	}

	//Encode gets
	$tmp = parse_url($tmp_url);
	
	if (array_key_exists("query", $tmp)) {
		$tmp2 = explode("&", $tmp["query"]);
		$query = "";
		foreach($tmp2 as $v) {
			if ($query != "") {
				$query .= "&";
			}
			
			$tmp3 = explode("=", $v);
			
			$query .= $tmp3[0] . "=" . rawurlencode($tmp3[1]);
		}
		$tmp_url = str_replace($tmp["query"], $query, $tmp_url);
	}
	
	//Finaly, redirect
	if ($tmp_force_js) {
		echo "<script>document.location = '" . $tmp_url . "';</script>";
	} else {		
		if (!(@header("location: " . $tmp_url))) {
			if ($tmp_execute_js) {
				echo "<script>document.location = '" . $tmp_url . "';</script>";
			}
		}
	}
	die;
}
?>