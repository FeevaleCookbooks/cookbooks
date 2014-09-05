function swf(src, w, h, vars, bg, mode, cssclass, id, not_ffv) {
	var html;
	
	if (!bg) {
		bg = '';	
	}
	
	
	if (src.indexOf("?") > 0) {
		var arr = src.split("?");
		
		src = arr[0];
		vars = arr[1];
	}
	
	a = new String(" " + id);
	a = a.replace(" ", "");
	
	if (!(!(!not_ffv))) {
		vars = formatFlashVars(vars);
	}
	
	html = '';
	
	html += '<OBJECT class='+ cssclass +' codeBase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0 \n';
	html +='height='+ h +' width='+ w +' align=middle \n';
	html +='classid=clsid:d27cdb6e-ae6d-11cf-96b8-444553540000 id="swf_' + a + '"> \n';
	html +='<PARAM NAME="_cx" VALUE="18627"> \n';
	html +='<PARAM NAME="_cy" VALUE="1640"> \n';
	html +='<PARAM NAME="FlashVars" VALUE="' + vars + '"> \n'
	
	html +='<PARAM NAME="Movie" VALUE="' + src +  '"> \n';
	html +='<PARAM NAME="Src" VALUE="' + src +  '"> \n';
	
	html +='<PARAM NAME="WMode" VALUE="'+ mode +'"> \n';
	html +='<PARAM NAME="Play" VALUE="-1"> \n';
	html +='<PARAM NAME="Loop" VALUE="-1"> \n';
	html +='<PARAM NAME="Quality" VALUE="High"> \n';
	html +='<PARAM NAME="SAlign" VALUE=""> \n';
	html +='<PARAM NAME="Menu" VALUE="-1"> \n';
	html +='<PARAM NAME="Base" VALUE=""> \n';
	html +='<PARAM NAME="allowFullScreen" VALUE="true"> \n';

	html +='<PARAM NAME="Scale" VALUE="ShowAll"> \n';
	html +='<PARAM NAME="DeviceFont" VALUE="0"> \n';
	html +='<PARAM NAME="EmbedMovie" VALUE="0"> \n';
	html +='<PARAM NAME="BGColor" VALUE="'+ bg +'"> \n';
	html +='<PARAM NAME="SWRemote" VALUE=""> \n';
	html +='<PARAM NAME="MovieData" VALUE=""> \n';
	html +='<PARAM NAME="SeamlessTabbing" VALUE="false"> \n';
	html +='<PARAM NAME="AllowScriptAccess" VALUE="always"> \n';
	
	html +=' <embed \n';
	html +=' src="' + src  + '"\n';
	html +=' FlashVars="' + vars + '"  \n';
	html +=' quality="high" bgcolor="#'+ bg +'" width="'+ w +'" height="'+ h +'" \n';
	html +=' name="swf_'+ id +'" align="middle" allowScriptAccess="always" SeamlessTabbing="false" allowFullScreen="true" \n';
	html +=' wmode="'+ mode +'" type="application/x-shockwave-flash" \n';
	html +=' pluginspage="http://www.macromedia.com/go/getflashplayer" id="swf_' + a + '" /> \n';
	html +='</OBJECT> \n';
	
	if ((a.length > 3) && (id)) {
		document.getElementById(a).innerHTML = html;
	} else {
		document.write(html);	
	}
}

function formatFlashVars(tmp_string) {
	var words = new Array();
	var i = 0;
	var control_string = "";
	
	tmp_string = new String(tmp_string);
	
	words[0] = new Array("!","\"","#","$","'","\(","\)","\*","\+",",","\"",":",";","<",">","\?","@","\[","\]","\^","\`","\{","|","\}","~","","€","‚","ƒ","„","…","†","‡","ˆ","‰","Š","‹", "Œ","Ž","‘","’","“","”","•","–", "—","˜","™","š","›","œ","ž","Ÿ","¡","¢","£","¤","¥","¦","§","¨","©","ª","«","¬","­","®",	"¯","°","±","²","³","´","µ","¶","·","¸","¹","º","»","¼","½","¾","¿","À","Á","Â","Ã","Ä","Å","Æ","Ç","È","É","Ê","Ë","Ì","Í","Î","Ï","Ð","Ñ","Ò","Ó","Ô","Õ","Ö","×","Ø","Ù","Ú","Û","Ü","Ý","Þ","ß","à","á","â","ã","ä","å","æ","ç","è","é","ê","ë","ì","í","î","ï","ð","ñ","ò","ó","ô","õ","ö","÷","ø","ù","ú","û","ü","ý","þ","ÿ");
	words[1] = new Array("%21","%22","%23","%24","%27","%28","%29","*","%2B","%2C","%2F","%3A","%3B","%3C","%3E","%3F","%40","%5B","%5D","%5E","%60","%7B","%7C","%7D","%7E","%7F","%80","%82","%83","%84","%85","%86","%87","%88","%89","%8A","%8B","%8C","%8E","%91","%92","%93","%94","%95","%96","%97","%98","%99","%9A","%9B","%9C","%9E","%9F","%A1","%A2","%A3","%A4","%A5","%A6","%A7","%A8","%A9","%AA","%AB","%AC","%AD","%AE","%AF","%B0","%B1","%B2","%B3","%B4","%B5","%B6","%B7","%B8","%B9","%BA","%BB","%BC","%BD","%BE","%BF","%C0","%C1","%C2","%C3","%C4","%C5","%C6","%C7","%C8","%C9","%CA","%CB","%CC","%CD","%CE","%CF","%D0","%D1","%D2","%D3","%D4","%D5","%D6","%D7","%D8","%D9","%DA","%DB","%DC","%DD","%DE","%DF","%E0","%E1","%E2","%E3","%E4","%E5","%E6","%E7","%E8","%E9","%EA","%EB","%EC","%ED","%EE","%EF","%F0","%F1","%F2","%F3","%F4","%F5","%F6","%F7","%F8","%F9","%FA","%FB","%FC","%FD","%FE","%FF");

	for (; i < words[0].length; i++) {
		do {
			control_string = tmp_string;
			tmp_string = tmp_string.replace(words[0][i], words[1][i]);
		} while (control_string != tmp_string);
	}
	
	return tmp_string; 
}

function swfVersao(versao_exigida) {
	var versao, tipo, axo, versao_exigida, pagina;	
	
	if (navigator.plugins && navigator.mimeTypes.length) {
		var x = navigator.plugins["Shockwave Flash"];
		if (x && x.description) {
			versao = x.description.replace(/([a-z]|[A-Z]|\s)+/,"").replace(/(\s+r|\s+b[0-9]+)/,".").split(".");
			versao = versao[0];
		}
	} else {
		try	{
			try {
				var axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
			} catch (e) { }
			
			for (var i = 3; axo != null; i++) {
				axo = new ActiveXObject("ShockwaveFlash.ShockwaveFlash." + i);
				versao = i;
			}
		} catch (e) { }
		
		try {
			versao = axo.GetVariable("$version").split(" ")[1].split(",").split(",");
			versao = versao[0];
		} catch (e) { }
	}
	
	if (parseInt(versao) < versao_exigida) {
		if (confirm("Você precisa de uma versão mais nova do Flash Player para acessar este site.\n Clique em 'OK' para ser redirecionado direto para a página de download.")) {
			document.location = "http://www.macromedia.com/go/getflashplayer";
		}
	}
}
swfVersao(8);