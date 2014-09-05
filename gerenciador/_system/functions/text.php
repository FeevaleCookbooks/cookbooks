<?
function formatHtmlFieldTableless($tmp_html) {	
	global $cfg;
	
	$r = str_replace("#ROOT#", $cfg["root"], $tmp_html);
	
	$r = formatSpecialCaracter($r,true);
	$r = str_replace('<p', '<br><p', $r);
	$r = str_replace('<div', '<br><div', $r);
	$r = str_replace('<span', '<br><span', $r);
	
	return strip_tags($r,'<br>');
}
function text_limit($tmp_text, $tmp_limit) {
	$len = strlen($tmp_text);
	
	if ($len > $tmp_limit) {
		$tmp_text = substr($tmp_text, 0, ($tmp_limit - 3)) . "...";
	}
	
	return $tmp_text;
}

function formatHtmlField($tmp_html, $tmp_root = "", $useEcho = true) {
	global $cfg;

	if ($tmp_root != "") {
		$bkp = $cfg["root"];
		$cfg["root"] = $tmp_root;
	}

	$r = str_replace("#ROOT#", $cfg["root"], $tmp_html);

	if ($tmp_root != "") {
		$cfg["root"] = $bkp;
	}

	$r = formatSpecialCaracter($r,true);

	if($useEcho){
		echo $r;
	} else {
		return $r;
	}
}

function escreveTitulosComClasse($string,$classe1,$classe2,$exceptions="<br> <b> <strong> <span>",$limit=70)
{
	$texto = strip_tags($string,$exceptions);
	$arrTexto = explode('#',$texto);
	$teste = false;
	
	foreach($arrTexto as $k => $texto)
	{	
		if (strlen($texto) < $limit)
		{
			echo '<span class="'.$classe1.'">'.$texto.'</span>';
			$teste = true;
		}
		else
		{
			if($teste === true)
			{
				$texto =  str_replace("\n","",trim($texto));
				$texto =  preg_replace("/<br><br>/","<br>",trim($texto),1);
			}
			
			echo '<span class="'.$classe2.'">'.trim($texto).'</span>';
					
			$teste = false;
		}
	}
}

function formatFloat($tmp_value) {
	return str_replace(".",",",((float)($tmp_value)));
}

function formatMoney($tmp_value) {
	return number_format($tmp_value, 2, ",", ".");
}

function formatUrlComplete($url) {
	if ((strpos($url,'http://') === false) && (strpos($url,'https://') === false) && (strpos($url,'ftp://') === false) && (strpos($url,'mailto') === false)) {
		return 'http://' . $url;
	} else {
		return $url;
	}
	
}

function formatNameFile($name, $lower = true) {
	$name = clearAcents($name,$lower);
	
	$name = str_replace(' ','_',$name);
	
	return $name;
}

function clearAcents($tmp_string, $lower = true) {
	if ($lower) {
		$tmp_string = strtolower($tmp_string);
	} else {
		$acents = "ÂÀÁÄÃÊÈÉËÎÍÌÏÔÕÒÓÖÛÙÚÜÇ";
		$normal = "AAAAAEEEEIIIIOOOOOUUUUC";
	
		$tmp_string = strtr($tmp_string,$acents,$normal);
	}
			
	$acents = "áàâãäªéèêëîíìïóòôõºúùûüç";
	$normal = "aaaaaaeeeeiiiiooooouuuuc";
	
	$tmp_string = strtr($tmp_string,$acents,$normal);
	
	return $tmp_string;
}

function formatSpecialCaracter($string, $encode = true) {
	$arr_caracter = array(
		chr(145),chr(150),chr(148),chr(147),'×','÷','“','”','Œ','‡','¢',chr(128),'™','‰','ƒ','†','¼','½','¾','©','®','ª','²','³','¹','¯','°','¡','£','º'
	);
	
	$arr_code = array(
		chr(96),chr(45),chr(34),chr(34),'&times;','&divide;','&#147;','&#148;','&#140;','&#135;','&cent;','&euro;','&#153;','&#137;','&#131;','&#134;','&frac14;','&frac12;','&frac34;','&copy;','&reg;','&ordf;','&sup2;','&sup3;','&sup1;','&macr;','&deg;','&iexcl;','&pound;','&ordm;'
	);
	
	if ($encode) {
		return str_replace($arr_caracter,$arr_code,$string);
	} else {
		return str_replace($arr_code,$arr_caracter,$string);
	}
}

function getNameFile($name){
	$arr_aux = explode(".",$name);
	
	if (sizeof($arr_aux) > 1){
		$extensao = $arr_aux[sizeof($arr_aux)-1];
	} else {
		$extensao = "";
	}
	
	if (strlen($extensao) > 0){
		$arquivo = substr($name,0, strlen($name)-(1+strlen($extensao)));
		$arr_aux = array($arquivo,$extensao);
	} else {
		$arr_aux = array($name);
	}
	
	return $arr_aux;
}

function strtoupper2($tmp_string) {
	$tmp_string = strtoupper($tmp_string);

	$minuscula = "áàâãäéèêëîíìïóòôõöúùûüç";
	$maiuscula = "ÁÀÂÃÄÉÈÊËÎÍÌÏÓÒÔÕÖÚÙÛÜÇ";
	
	return strtr($tmp_string,$minuscula,$maiuscula);
}


function formatSpecialCaracter2($string) {
	$arr_caracter = array(
		"'",chr(145),chr(150),chr(148),chr(147),'×','÷','“','”','Œ','‡','¢',chr(128),'™','‰','ƒ','†','¼','½','¾','©','®','ª','²','³','¹','¯','°','¡','£','º'
	);
	
	$arr_code = array(
		"\'",chr(96),chr(45),chr(34),chr(34),'&times;','&divide;','&#147;','&#148;','&#140;','&#135;','&cent;','&euro;','&#153;','&#137;','&#131;','&#134;','&frac14;','&frac12;','&frac34;','&copy;','&reg;','&ordf;','&sup2;','&sup3;','&sup1;','&macr;','&deg;','&iexcl;','&pound;','&ordm;'
	);
	
	return str_replace($arr_caracter,$arr_code,$string);
}
?>