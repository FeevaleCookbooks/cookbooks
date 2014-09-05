<?
function swf($src, $width, $height, $vars = '', $bg = '', $mode = 'opaque', $cssclass = '', $id = '', $not_ffv = false){
	$html = '';
	
	if (strpos($src,"?") > 0) {
		$arr = explode("?",$src);
		
		$src = $arr[0];
		$vars = $arr[1];
	}
	
	$id = " " . $id;
	$id = str_replace(" ", "",$id);
	
	if ($not_ffv) {
		$vars = formatFlashVars($vars);
	}
	
	$html = '<OBJECT class='. $cssclass .' codeBase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0 height='. $height .' width='. $width .' align=middle classid=clsid:d27cdb6e-ae6d-11cf-96b8-444553540000 id="swf_' . $id . '">';
	$html .= '<PARAM NAME="_cx" VALUE="18627"> ';
	$html .= '<PARAM NAME="_cy" VALUE="1640"> ';
	$html .= '<PARAM NAME="FlashVars" VALUE="' . $vars . '"> ';
	
	$html .= '<PARAM NAME="Movie" VALUE="' . $src .  '"> ';
	$html .= '<PARAM NAME="Src" VALUE="' . $src .  '"> ';
	
	$html .= '<PARAM NAME="WMode" VALUE="'. $mode .'"> ';
	$html .= '<PARAM NAME="Play" VALUE="-1"> ';
	$html .= '<PARAM NAME="Loop" VALUE="-1"> ';
	$html .= '<PARAM NAME="Quality" VALUE="High"> ';
	$html .= '<PARAM NAME="SAlign" VALUE=""> ';
	$html .= '<PARAM NAME="Menu" VALUE="-1"> ';
	$html .= '<PARAM NAME="Base" VALUE=""> ';
	$html .= '<PARAM NAME="allowFullScreen" VALUE="true"> ';

	$html .= '<PARAM NAME="Scale" VALUE="ShowAll"> ';
	$html .= '<PARAM NAME="DeviceFont" VALUE="0"> ';
	$html .= '<PARAM NAME="EmbedMovie" VALUE="0"> ';
	$html .= '<PARAM NAME="BGColor" VALUE="'. $bg .'"> ';
	$html .= '<PARAM NAME="SWRemote" VALUE=""> ';
	$html .= '<PARAM NAME="MovieData" VALUE=""> ';
	$html .= '<PARAM NAME="SeamlessTabbing" VALUE="false"> ';
	$html .= '<PARAM NAME="AllowScriptAccess" VALUE="always"> ';
	
	$html .= ' <embed src="' . $src  . '" FlashVars="' . $vars . '" quality="high" bgcolor="#'. $bg .'" width="'. $width .'" height="'. $height .'" name="swf_'. $id .'" align="middle" allowScriptAccess="always" SeamlessTabbing="false" allowFullScreen="true" wmode="'. $mode .'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" id="swf_' . $id . '" />';
	$html .= '</OBJECT> ';
		
	echo($html);
}


function formatFlashVars($tmp_string) {
	$words = array();
	$i = 0;
	$control_string = "";
	
	$words[0] = array("!","\"","#","$","'","\(","\)","\*","\+",",","\"",":",";","<",">","\?","@","\[","\]","\^","\`","\{","|","\}","~","","€","‚","ƒ","„","…","†","‡","ˆ","‰","Š","‹", "Œ","Ž","‘","’","“","”","•","–", "—","˜","™","š","›","œ","ž","Ÿ","¡","¢","£","¤","¥","¦","§","¨","©","ª","«","¬","­","®",	"¯","°","±","²","³","´","µ","¶","·","¸","¹","º","»","¼","½","¾","¿","À","Á","Â","Ã","Ä","Å","Æ","Ç","È","É","Ê","Ë","Ì","Í","Î","Ï","Ð","Ñ","Ò","Ó","Ô","Õ","Ö","×","Ø","Ù","Ú","Û","Ü","Ý","Þ","ß","à","á","â","ã","ä","å","æ","ç","è","é","ê","ë","ì","í","î","ï","ð","ñ","ò","ó","ô","õ","ö","÷","ø","ù","ú","û","ü","ý","þ","ÿ");
	$words[1] = array("%21","%22","%23","%24","%27","%28","%29","*","%2B","%2C","%2F","%3A","%3B","%3C","%3E","%3F","%40","%5B","%5D","%5E","%60","%7B","%7C","%7D","%7E","%7F","%80","%82","%83","%84","%85","%86","%87","%88","%89","%8A","%8B","%8C","%8E","%91","%92","%93","%94","%95","%96","%97","%98","%99","%9A","%9B","%9C","%9E","%9F","%A1","%A2","%A3","%A4","%A5","%A6","%A7","%A8","%A9","%AA","%AB","%AC","%AD","%AE","%AF","%B0","%B1","%B2","%B3","%B4","%B5","%B6","%B7","%B8","%B9","%BA","%BB","%BC","%BD","%BE","%BF","%C0","%C1","%C2","%C3","%C4","%C5","%C6","%C7","%C8","%C9","%CA","%CB","%CC","%CD","%CE","%CF","%D0","%D1","%D2","%D3","%D4","%D5","%D6","%D7","%D8","%D9","%DA","%DB","%DC","%DD","%DE","%DF","%E0","%E1","%E2","%E3","%E4","%E5","%E6","%E7","%E8","%E9","%EA","%EB","%EC","%ED","%EE","%EF","%F0","%F1","%F2","%F3","%F4","%F5","%F6","%F7","%F8","%F9","%FA","%FB","%FC","%FD","%FE","%FF");

	$tmp_string = str_replace($words[0],$words[1],$tmp_string);
	
	return $tmp_string; 
}

?>