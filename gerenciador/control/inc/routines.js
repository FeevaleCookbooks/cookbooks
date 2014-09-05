//Common
function showLoading() {
	document.getElementById('conteudo').innerHTML = '<center><div class="padding: 10px;"><img src="../img/loading.gif"></div></center>';	
}

function ajaxGet(tmp_url) {
	var arr = tmp_url.split("?");
	
	tmp_url = arr[0] + "?menu=" + menu;
	
	if (arr[1] != undefined) {
		tmp_url += "&" + arr[1];
	}
	
	var a = new Ajax();
	a.onLoad = function () {
		document.getElementById('conteudo').innerHTML = this.html;
		
		debugHtml(this.html);
		
		this.runJS(this.html);
	}
	a.get(tmp_url);
	
	showLoading();
}

function debugHtml(tmp_html) {
	if (document.getElementById('box_html')) {
		document.getElementById('box_html').innerHTML = "<pre>" + tmp_html.replace(/</g, "&lt;").replace(/>/g, "&gt;") + "\n<b>" + (new String(Math.round((tmp_html.length / 1024) * 100) / 100)).replace(".", ",") + " Kb</b></pre>";
	}
}

function listOrder(tmp_order) {
	document.getElementById('input_order').value = tmp_order;
	
	listSubmitFilters();
}

function listPage(tmp_page) {
	document.getElementById('input_page').value = tmp_page;
	
	listSubmitFilters();
}


function listInsert() {
	ajaxGet('form/form.php?routine=insert');	
}

function listUpdate(tmp_id) {
	ajaxGet('form/form.php?routine=update&id=' + tmp_id);	
}

//filters
function showHideFilters() {
	if (document.getElementById('div_filtros').style.display == '') {
		document.getElementById('img_filter').src = '../img/buttons/filter.jpg';
		document.getElementById('div_filtros').style.display = 'none';
	} else {
		document.getElementById('img_filter').src = '../img/buttons/filter_disabled.jpg';
		document.getElementById('div_filtros').style.display = '';
	}
}

function preListSubmitFilters() {
	document.getElementById('input_page').value = "";
	
	listSubmitFilters();
}

function listSubmitFilters() {	
	if (f.send('frm_filters', true)) {
		var a = new Ajax();
		a.onLoad = function () {
			document.getElementById('conteudo').innerHTML = this.html;
			
			debugHtml(this.html);
			
			this.runJS(this.html);
		}
		a.sendForm('frm_filters');
		
		showLoading();
	}
}


//over list
function listOverOut(tmp_acao, tmp_i) {
	var tds = document.getElementById('tr_' + tmp_i).getElementsByTagName('td');
	var obj;
	var css = '';
	var i;
	var class_name = 'td' + (2 - (tmp_i % 2));
	
	if (delete_enabled) {
		i = 1;
		
		if (document.getElementById('chk_' + tmp_i).checked) {
			class_name = 'td3';
		}
	} else {
		i = 0;
	}
	
	tds[i].className = class_name;
	
	for (; i < (tds.length); i++) {
		obj = tds[i];
		
		if (css == '') {
			switch (tmp_acao) {
				case "over":
						css = obj.className.replace("-over", "") + '-over';
					break;
				case "out":
						css = obj.className.replace("-over", "");
					break;
			}	
		}
		
		obj.className = css;
	}
}

//checks
function check(tmp_obj) {
	var i = 1;
	var r;
	
	if (tmp_obj.checked) {
		r = true;
	} else {
		r = false;
	}
	
	while (document.getElementById('chk_' + i)) {
		document.getElementById('chk_' + i).checked = r;
		
		i++;
	}
	
	checkMostrar();
}

function checkMostrar() {
	var i = 1;
	var ok = false;
	
	while (document.getElementById('chk_' + i)) {
		if (document.getElementById('chk_' + i).checked) {
			ok = true;
		}
		
		listOverOut('out', i); 
		
		i++;
	}
	
	if (ok) {
		document.getElementById('div_botao_excluir').style.display = '';
	} else {
		document.getElementById('div_botao_excluir').style.display = 'none';
	}
}

function checkExcluir() {
	if (confirm("Deseja realmente excluir este(s) item(ns)?")) {
		if (f.send('frm_list', true)) {
			var a = new Ajax();
			a.onLoad = function () {
				document.getElementById('conteudo').innerHTML = this.html;
				
				debugHtml(this.html);
				
				this.runJS(this.html);
			}
			a.sendForm('frm_list');
		}
	}
}

//buttons
function listButton(tmp_name) {
	var ifr = createHiddenIframe('ifr_button_' + tmp_name, 'button_bar');
	var cfg = new Array();
	
	var onload = function () {
		//Removes iframe element
		//setTimeout(function () { removeElement('ifr_button_' + tmp_name); alert("remove: " + 'ifr_button_' + tmp_name); }, 250); 
	}
	addEvent(ifr, "load", onload);
	
	cfg["target"] = document.getElementById('frm_filters').target;
	cfg["action"] = document.getElementById('frm_filters').action;
	
	document.getElementById('frm_filters').target = "ifr_button_" + tmp_name;
	document.getElementById('frm_filters').action = "form/list.php?routine=list_button&name=" + tmp_name;
	
	if (f.send('frm_filters', true)) {
		document.getElementById('frm_filters').submit();
	} else {
		//setTimeout(function () { removeElement('ifr_button_' + tmp_name); alert("remove: " + 'ifr_button_' + tmp_name); }, 250);
	}
	
	document.getElementById('frm_filters').setAttribute('target', cfg["target"]);
	document.getElementById('frm_filters').setAttribute('action', cfg["action"]);
}

//Form
var customPrePost;
function prePost() {
	try {
		customPrePost();
	} catch(e) { alert("Erro - prePost() : " + e); }
}

function formSubmit() {
	if (f.send('frm_form', true)) {
		var a = new Ajax();
		a.onLoad = function () {
			document.getElementById('conteudo').innerHTML = this.html;
			
			debugHtml(this.html);
			
			this.runJS(this.html);
		}
		a.sendForm('frm_form');
		
		showLoading();
	}
}

//Aux functions
function createHiddenIframe(tmp_id, tmp_id_parent) {	
	var iframe = document.createElement("iframe");
	iframe.setAttribute("id",tmp_id);
	iframe.setAttribute("name",tmp_id);
	if (!document.getElementById('box_html')) {
		iframe.setAttribute("width","0");
		iframe.setAttribute("height","0");
		iframe.setAttribute("border","0");
		iframe.setAttribute("style","width: 0; height: 0; border: none; visibility: hidden; display: none;");
	}
	document.getElementById(tmp_id_parent).parentNode.appendChild(iframe);
	window.frames[tmp_id].name = tmp_id; //Ie sux
	
	return iframe;
}

function screenLock(tmp_lock) {
	if (tmp_lock == null) { tmp_lock = false; }
	
	if (!document.getElementById('div_lock')) {
		var div = document.createElement('div');
		div.setAttribute('id', 'div_lock');
		div.setAttribute('style', 'position: absolute; top: 0; left: 0; z-index: 90; width: 100%; height: 500px; background-color: #000; -moz-opacity:0.6;opacity:.60;filter:alpha(opacity=60);');
		div.style.position = 'absolute';
		div.style.background = '#000';
		div.style.filter = 'alpha(opacity=60)';
		div.innerHTML = '&nbsp;';
		document.getElementsByTagName('body')[0].appendChild(div);
	}
	
	if (tmp_lock) {
		document.getElementById('div_lock').style.display = '';

		addEvent(window, 'scroll', screenLock_scroll);
		screenLock_scroll();
	} else {
		document.getElementById('div_lock').style.display = 'none';
		
		removeEvent(window, 'scroll', screenLock_scroll);
	}
}

function screenLock_scroll(e) {
	var obj = document.getElementById('div_lock');
	
	if (obj) {
		var pos = new WindowPosition();

		obj.style.left = pos.x + "px";
		obj.style.top = pos.y + "px";
		obj.style.width = pos.w + "px";
		obj.style.height = pos.h + "px";
	}
}

function setCSS(tmp_css, tmp_id) {
	var s;
	
	if (!tmp_id) {
		tmp_id = "css_" + Math.round(Math.random() * 10000);	
	}
	
	if (document.all) {
		if (document.getElementById(tmp_id)) {
			s = document.getElementById(tmp_id);
		} else {
			s = document.createStyleSheet();
		}
		s.cssText = tmp_css;
	} else {
		if (document.getElementById(tmp_id)) {
			s = document.getElementById(tmp_id);
		} else {
			s = document.createElement('style');
			s.type = 'text/css';
		}
		s.innerHTML = tmp_css;
	}
	
	if (!document.getElementById(tmp_id)) {
		try {
			document.getElementsByTagName('head')[0].appendChild(s);
		} catch (e) { }
	}
}

//Upload
function uploadSubmit(tmp_name) {
	var iframe
	var onload;
	var configs = new Array();
	var div;
	var input;
	
	//Verify if input file is not empty
	div = document.getElementById(tmp_name + '_div_input');
	input = div.getElementsByTagName("input")[0];
	
	if (input.value != '') {	
		//Create iframe element
		iframe = createHiddenIframe('ifr_tmp', 'frm_form');
		onload = function () {
			uploadList(tmp_name);
			
			document.getElementById(tmp_name + '_div_loading').style.display = 'none';
			
			//Removes iframe element
			if (!document.getElementById('box_html')) {
				setTimeout(function () { removeElement(document.getElementById('ifr_tmp')); }, 250); 
			}
		}
		addEvent(document.getElementById('ifr_tmp'), "load", onload);
		
		document.getElementById(tmp_name + '_div_input').style.display = 'none';
		document.getElementById(tmp_name + '_div_loading').style.display = '';
		
		//Save configuration
		configs["target"] = document.getElementById('frm_form').target;
		configs["action"] = document.getElementById('frm_form').action;
		configs["method"] = document.getElementById('frm_form').method;
		configs["enctype"] = document.getElementById('frm_form').enctype;
		configs["encoding"] = document.getElementById('frm_form').encoding;
		
		//Config form element
		document.getElementById('frm_form').setAttribute("target", "ifr_tmp");
		document.getElementById('frm_form').setAttribute("action", 'form/routines.php?menu=' + menu + '&routine=' + routine + '&routine_field=upload&name=' + tmp_name + "&tmp_id=" + tmp_id + "&id=" + id + "&random=" + Math.round(Math.random() * 999999));
		document.getElementById('frm_form').setAttribute("method", "post");
		document.getElementById('frm_form').setAttribute("enctype", "multipart/form-data");
		document.getElementById('frm_form').setAttribute("encoding", "multipart/form-data");
		
		document.getElementById('frm_form').submit();
		
		//Remember old configuration
		document.getElementById('frm_form').setAttribute("target", configs["target"]);
		document.getElementById('frm_form').setAttribute("action", configs["action"]);
		document.getElementById('frm_form').setAttribute("method", configs["method"]);
		document.getElementById('frm_form').setAttribute("enctype", configs["enctype"]);
		document.getElementById('frm_form').setAttribute("encoding", configs["encoding"]);
	}
}

function uploadList(tmp_name) {
	document.getElementById(tmp_name + '_div_loading').style.display = '';
	
	var a = new Ajax();
	a.onLoad = function () {
		document.getElementById(tmp_name + '_div_list').innerHTML = this.html;
		
		debugHtml(this.html);
		
		this.runJS(this.html);
		
		document.getElementById(tmp_name + '_div_loading').style.display = 'none';
	}
	a.get('form/routines.php?menu=' + menu + '&routine=' + routine + '&routine_field=list&name=' + tmp_name + "&tmp_id=" + tmp_id + "&id=" + id);
}

function uploadDelete(tmp_name, tmp_n) {
	document.getElementById(tmp_name + '_div_loading').style.display = '';
	
	var a = new Ajax();
	a.onLoad = function () {	
		debugHtml(this.html);
		
		this.runJS(this.html);
		
		document.getElementById(tmp_name + '_div_loading').style.display = 'none';
	}
	a.get('form/routines.php?menu=' + menu + '&routine=' + routine + '&routine_field=delete&name=' + tmp_name + "&tmp_id=" + tmp_id + "&id=" + id + "&n=" + tmp_n);
}

//Ativo
function ativoSwap(tmp_obj, tmp_field_name, tmp_id) {
	var container = tmp_obj.parentNode;
	var a = new Ajax();
	
	container.innerHTML = '<img src=\'../img/icons/time.gif\'>';
	
	a.onLoad = function () {
		container.innerHTML = this.html;
	}
	a.get('form/routines.php?menu=' + menu + '&routine=ativo&name=' + tmp_field_name + "&id=" + tmp_id + "&rnd=" + rnd);
}

//Ordem
function orderSwap(tmp_name, tmp_id, tmp_direction) {
	var cfg = Array();
	var a = new Ajax();
	
	if (f.send('frm_filters', true)) {
		cfg["action"] = document.getElementById('frm_filters').action;
		
		document.getElementById('input_extra').value = tmp_id + "#" + tmp_direction;
		
		document.getElementById('frm_filters').action = 'form/routines.php?menu=' + menu + '&routine_field=order&name=' + tmp_name + "&tmp_id=" + tmp_id + "&direction=" + tmp_direction;
		
		a.onLoad = function () {			
			listSubmitFilters();
		}
		a.sendForm('frm_filters');
		
		document.getElementById('input_extra').value = '';
		
		document.getElementById('frm_filters').setAttribute('action', cfg["action"]);
	}
}

function statusSwap(tmp_obj, tmp_field_name, tmp_id) {
	var container = tmp_obj.parentNode;
	var a = new Ajax();
	
	container.innerHTML = '<img src=\'../img/icons/time.gif\'>';
	
	a.onLoad = function () {
		container.innerHTML = this.html;
	}
	a.get('../../_config/exceptions/routines/routines.php?menu=' + menu + '&routine=status&name=' + tmp_field_name + "&id=" + tmp_id + "&rnd=" + rnd);
}


// Abre um registro no modo update vindo de outra aba
function goToTabUpdate(tmp_id,tmp_name_tab) {
	var a = new Ajax();
	
	a.onLoad = function() {
		document.location = this.html;	
	}
	
	a.get('form/routines.php?menu=' + tmp_name_tab + '&routine=goToTabUpdate&id=' + tmp_id);
}
function abreimagem(src){
	var popup = new Popup(965,400);
	popup.valign = 'top';
	popup.open('../inc/multiupload/verimagem.php?url='+src);
}