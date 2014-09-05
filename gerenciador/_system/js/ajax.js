/*
Ajax handler
by Ramon Fritsch (www.ramonfritsch.com)

Ex.:
var a = new Ajax();
a.onLoad = function () {
	alert(this.html);
}
a.get("url.php");
*/


//Requires include default.js
try { var _test_ajax = __include_default; } 
catch(e) { alert("ajax.js : Include '_system/js/default.js' é obrigatório"); }

var __include_ajax = true;

//class Ajax
function Ajax() {
	var obj;
	
	var unique = true;
	
	var html;
	var xml;
	
	var response_type = "html";
	
	var onLoad = new Function();
	var onPreLoad = new Function();
	
	this.createObject = function () {
		var parent = this;
		
		obj = this.getAjaxObj();
		obj.onreadystatechange = function() {
			if(obj.readyState == 4) {
				var arr;
				
				//xml
				if (response_type == "xml") {
					//need test
					if (obj.responseXml != undefined) {
						try {
							parent.xml = obj.responseXml;
						} catch (e) { }
					} else {
						try {
							parent.xml = parent.parseXML(obj.responseText);	
						} catch (e) { }
					}
				} else {				
					//html
					parent.html = obj.responseText;
				}
				
				obj = null;
				
				parent.onLoad();
				
				Ajax_unique = false;
			}
		}
	}
	
	this.get = function (tmp_url) {
		if (tmp_url == '') {
			alert("Ajax.get() : Url vazia");
			
			return;
		}
		
		if (this.isFree()) {
			this.createObject();
			
			if (typeof(this.onPreLoad) == "function") {
				this.onPreLoad();
			}
			
			obj.open('GET', tmp_url);
			obj.setRequestHeader("Content-type", "text/html;charset=iso-8859-1");
			obj.setRequestHeader("Connection", "close");
			obj.send(null);
		}
	}
	
	this.post = function (tmp_url, tmp_parameters, tmp_content_type) {
		if (tmp_url == '') {
			alert("Erro - Ajax.post() : Url vazia");
			
			return;
		}
		
		if (tmp_content_type == undefined) {
			tmp_content_type = "application/x-www-form-urlencoded";
		}
		
		if (this.isFree()) {
			this.createObject();
			
			if (typeof(this.onPreLoad) == "function") {
				this.onPreLoad();
			}
			
			obj.open('POST', tmp_url);
			obj.setRequestHeader("Content-type", tmp_content_type);
			obj.setRequestHeader("Content-length", tmp_parameters.length);
			obj.setRequestHeader("Connection", "close");
			obj.send(tmp_parameters);
		}
	}
	
	this.sendForm = function(tmp_id) {
		var p = "";
		var field;
		var form = document.getElementById(tmp_id);
		
		for (i = 0; i < form.length; i++) {
			field = form.elements[i];
			
			if (field.type == 'checkbox' || field.type == 'radio') {
				if (field.checked) {
					p += '&' + field.name + '=' + this.formatString(field.value);
				}
			} else {
				p += '&' + field.name + '=' + this.formatString(field.value);
			}
		}
		
		this.post(form.action, p);
	}
	
	//Unique
	this.isFree = function () {		
		var r = (!(this.unique && Ajax_unique)) || !this.unique;
		
		if (r) {
			Ajax_unique = true;	
		}
		
		return r;
	}
	
	this.setUnique = function (tmp_valor) {
		this.unique = tmp_valor;
	}
	
	//Funções auxiliares
	this.getAjaxObj = function () {
		var xmlhttp;
		try {
			xmlhttp = new XMLHttpRequest();
		} catch (e) {
			try {
				xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (ex) {
				try {
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				} catch(exc) {
					alert("Erro - Ajax.getAjaxObj() : " + exc.error);
				}
			}
		}
		return xmlhttp?xmlhttp:false;
	}
	
	this.parseXML = function (tmp_string) {
		var xml;
		
		try {
			xml = new ActiveXObject("Microsoft.XMLDOM");
			xml.async="false";
			xml.loadXML(tmp_string);
		} catch(e) {
			try {
				Parser = new DOMParser();
				xml = Parser.parseFromString(tmp_string,"text/xml");
			} catch(ex) {
				alert("Erro - Ajax.parseXML('" + tmp_string.substr(0, 16) + "...') : " + ex.message);
			}
		}
		
		return xml;
	}
	
	this.runJS = function (tmp_html) {
		var el = document.createElement('div');
		el.innerHTML = '<div style="display: none">content</div>' + tmp_html; //Ie sucx!
		
		var scripts = el.getElementsByTagName('script');
		var js_exec = "";
		var total_eval = scripts.length;
		var i_eval = 0;
		
		for (; i_eval < total_eval; i_eval++) {
			if (isIE) {
					js_exec = scripts[i_eval].text;
			} else if (isMoz) {
					js_exec = scripts[i_eval].textContent;
			} else {
					js_exec = scripts[i_eval].innerHTML;
			}
			
			try {
				eval(js_exec);
			} catch(e) { 
				alert("Erro - Ajax.runJS('" + tmp_html.substr(0, 16) + "...') : " + e.message);
			}
		}
	}
	
	this.formatString = function (tmp_string) {
		if (!(!(!tmp_string))) {
			tmp_string = '';
		}
		
		var words = new Array();
		var i = 0;
		var new_string = "";
		var control_string = "";
		
		words[0] = new Array("!","\"","#","$","&","'","\(","\)","\*","\+",",","\"",":",";","<","=",">","\?","@","\[","\]","\^","\`","\{","|","\}","~","","€","‚","ƒ","„","…","†","‡","ˆ","‰","Š","‹", "Œ","Ž","‘","’","“","”","•","–", "—","˜","™","š","›","œ","ž","Ÿ","¡","¢","£","¤","¥","¦","§","¨","©","ª","«","¬","­","®",	"¯","°","±","²","³","´","µ","¶","·","¸","¹","º","»","¼","½","¾","¿","À","Á","Â","Ã","Ä","Å","Æ","Ç","È","É","Ê","Ë","Ì","Í","Î","Ï","Ð","Ñ","Ò","Ó","Ô","Õ","Ö","×","Ø","Ù","Ú","Û","Ü","Ý","Þ","ß","à","á","â","ã","ä","å","æ","ç","è","é","ê","ë","ì","í","î","ï","ð","ñ","ò","ó","ô","õ","ö","÷","ø","ù","ú","û","ü","ý","þ","ÿ");
		words[1] = new Array("%21","%22","%23","%24","%26","%27","%28","%29","*","%2B","%2C","%2F","%3A","%3B","%3C","%3D","%3E","%3F","%40","%5B","%5D","%5E","%60","%7B","%7C","%7D","%7E","%7F","%80","%82","%83","%84","%85","%86","%87","%88","%89","%8A","%8B","%8C","%8E","%91","%92","%93","%94","%95","%96","%97","%98","%99","%9A","%9B","%9C","%9E","%9F","%A1","%A2","%A3","%A4","%A5","%A6","%A7","%A8","%A9","%AA","%AB","%AC","%AD","%AE","%AF","%B0","%B1","%B2","%B3","%B4","%B5","%B6","%B7","%B8","%B9","%BA","%BB","%BC","%BD","%BE","%BF","%C0","%C1","%C2","%C3","%C4","%C5","%C6","%C7","%C8","%C9","%CA","%CB","%CC","%CD","%CE","%CF","%D0","%D1","%D2","%D3","%D4","%D5","%D6","%D7","%D8","%D9","%DA","%DB","%DC","%DD","%DE","%DF","%E0","%E1","%E2","%E3","%E4","%E5","%E6","%E7","%E8","%E9","%EA","%EB","%EC","%ED","%EE","%EF","%F0","%F1","%F2","%F3","%F4","%F5","%F6","%F7","%F8","%F9","%FA","%FB","%FC","%FD","%FE","%FF");

		for (; i < words[0].length; i++) {
			do {
				control_string = tmp_string;
				tmp_string = tmp_string.replace(words[0][i], words[1][i]);
			} while (control_string != tmp_string);
		}
		
		return tmp_string; 
	}
}
var Ajax_unique = false;