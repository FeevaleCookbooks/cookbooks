var __include_default = true;

//Browser detector
var isIE = false, isMoz = false, isSaf = false;
(function () {
	if ((navigator.userAgent.indexOf('Safari') != -1)) { isSaf = true; }
	else if ((navigator.appName == 'Netscape')) { isMoz = true; }
	else { isIE = true; }
}());

//Get element(s) by id, #id or .classname
function $$(tmp_query, tmp_root) {
	if (tmp_query.indexOf('.') > -1) {
		var r = [], elms, i = 0, i2 = 0, r2;

		tmp_query = tmp_query.substr(1, tmp_query.length - 1);

		tmp_root = (tmp_root != null) ? tmp_root : document;
		elms = (tmp_root.all) ? tmp_root.all : tmp_root.getElementsByTagName('*');

		for (; i < elms.length; i++) {
			if (tmp_query == elms[i].className) {
				r.push(elms[i]);
			}
		}

		return r;
	} else if (tmp_query.indexOf('#') > -1) {
		var r = [], elms, i = 0, i2 = 0, r2;

		tmp_query = tmp_query.substr(1, tmp_query.length - 1);

		tmp_root = (tmp_root != null) ? tmp_root : document;
		elms = (tmp_root.all) ? tmp_root.all : tmp_root.getElementsByTagName('*');

		for (; i < elms.length; i++) {
			if (tmp_query == elms[i].id) {
				r.push(elms[i]);
			}
		}

		return r;
	} else {
		if (document.getElementById(tmp_query)) {
			return document.getElementById(tmp_query);
		} else {
			return null;
		}
	}
}

//Nothing function for href property of tag <a>
function nothing_func() { }

//Alert describe object
function alert_r(tmp_obj, tmp_alert) {
	var msg = '';

	for (var v in tmp_obj) {
		msg += '	' + v + ' = \'' + (new String(tmp_obj[v])) + '\'\n';
	}

	if (tmp_alert == true) {
		alert('Object (' + tmp_obj + '):\n' + msg);
	} else {
		var div = document.createElement('div');
		div.id = 'alert_r_' + Math.round(Math.random() * 99999);
		div.style.position = 'absolute';
		div.style.top = '0px';
		div.style.left = '0px';
		div.style.background = '#EEEEEE';
		div.innerHTML = '<pre style="font-family: Verdana; font-size: 10px;">' + msg + '</pre>';

		document.getElementsByTagName('body')[0].appendChild(div);

		addEvent(div, 'click', function () { removeElement(this); });
	}
}

//Add tmp_function event for tmp_object
function addEvent(tmp_obj, tmp_event, tmp_function) {
	var f = function (e) {
		tmp_function.apply(tmp_obj, [e || event]);
	};

	if (typeof tmp_event == "string") {
		if (tmp_event.indexOf(" ") > -1) {
			var arr = tmp_event.split(" ");
			for (var i = 0; i < arr.length; i++) {
				addEvent(tmp_obj, arr[i], tmp_function);
			}

			return true;
		}
	} else if (typeof tmp_event == "object") {
		for (var i = 0; i < tmp_event.length; i++) {
			addEvent(tmp_obj, tmp_event[i], tmp_function);
		}

		return true;
	}

	if (tmp_obj) {
		try {
			tmp_obj.addEventListener(tmp_event, f, false);
		} catch (e) {
			try {
				tmp_obj.attachEvent("on" + tmp_event, f);
			} catch (e2) {
				return false;
			}
		}

		return true;
	} else {
		return false;
	}
}

function removeEvent(tmp_obj, tmp_type, tmp_function) {
	if (isIE) {
		tmp_obj.detachEvent("on" + tmp_type, tmp_function);
	} else {
		tmp_obj.removeEventListener(tmp_type, tmp_function, false);
	}
}

function removeElement(tmp_obj) {
	tmp_obj.parentNode.removeChild(tmp_obj);
}

function redir(tmp_pagina) {
	document.location = tmp_pagina;
}

function openPopup(tmp_url, tmp_w, tmp_h, tmp_name) {
	var x = (screen.width - tmp_w) / 2;
	var y = (screen.height - tmp_h) / 2;

	if (!tmp_name) {
		var rnd = Math.round(Math.random() * 99999);
		tmp_name = "nova_janela" + rnd;
	}

	var v = window.open(tmp_url, tmp_name,'height=' + tmp_h + ', width=' + tmp_w + ', left=' + x + ', top=' + y);
}

//Prototypes
String.prototype.trim = function () {
	var r = /\s*((\S+\s*)*)/g;
	var r2 = /((\s*\S+)*)\s*/g;

	return this.replace(r, "$1").replace(r2, "$1");
}

Function.prototype.bind = function(tmp_object) {
	var tmp_method = this;

	return function() { return tmp_method.apply(tmp_object, arguments); }
}

Array.prototype.each = function (tmp_func) {
	var i = 0;
	var length = this.length;

	var ev = "tmp_func(i, this[i])";

	for (; i < length; i++) {
		eval(ev);
	}
}

if (!Array.prototype.indexOf) Array.prototype.indexOf = function(tmp_item, tmp_i) {
  var length = this.length;

  tmp_i || (tmp_i = 0);
  if (tmp_i < 0) tmp_i = length + tmp_i;

  for (; tmp_i < length; tmp_i++) { if (this[tmp_i] === tmp_item) return tmp_i; }

  return -1;
}

Array.prototype.remove = function (tmp_itens) {
	if (typeof(tmp_itens) != "object") {
		tmp_itens = [tmp_itens];
	}

	var i = 0; i2 = 0;
	var new_array = [];

	for (; i < this.length; i++) {
		if (tmp_itens.indexOf(this[i]) == -1) {
			new_array[i2] = this[i];
			i2++;
		}
	}

	return new_array;
}


//Window Position class
function WindowPosition() {
	this.x = 0;
	this.y = 0;
	this.w = 0;
	this.h = 0;

	if (typeof(window.pageYOffset) == 'number') {
		this.x = window.pageXOffset;
		this.y = window.pageYOffset;
	} else if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
		this.x = document.body.scrollLeft;
		this.y = document.body.scrollTop;
	} else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
		this.x = document.documentElement.scrollLeft;
		this.y = document.documentElement.scrollTop;
	}

	if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
		// Se o DOCTYPE foi retirado da pagina, as 2 linhas de cima devem ser comentadas e deixar as duas abaixa descomentada
		// Caso contrario, descomentar as 2 de cima e comentar as 2 linhas de baixo

		this.w = document.documentElement.clientWidth;
		this.h = document.documentElement.clientHeight;
		//this.w = document.body.clientWidth;
		//this.h = document.body.clientHeight;
	} else if (typeof(window.innerWidth) == 'number') {
		this.w = window.innerWidth;
		this.h = window.innerHeight;
	} else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
		this.w = document.body.clientWidth;
		this.h = document.body.clientHeight;
	}
}


function hiddenShow(id_hidden,id_show) {
	if (document.getElementById(id_hidden)) {
		document.getElementById(id_hidden).style.display = 'none';
	}

	if (document.getElementById(id_show)) {
		document.getElementById(id_show).style.display = '';
	}
}