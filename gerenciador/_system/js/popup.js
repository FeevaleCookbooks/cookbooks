//Requires include default.js
try { var _test_popup = __include_default; }
catch(e) { alert("popup.js : Include '_system/js/default.js' é obrigatório"); }

//Requires include ajax.js
try { var _test_popup2 = __include_ajax; }
catch(e) { alert("popup.js : Include '_system/js/ajax.js' é obrigatório"); }

var __include_popup = true;

var Popup_atual = false;

function Popup(tmp_w, tmp_h) {
	this.title = "";
	this.bg_alpha = 60;

	this.width = tmp_w;
	this.height = tmp_h;

	this.overflow = 'auto';
	this.template = 1;

	this.valign = "middle";
	this.align = "center";

	this.ownTop = 0;
	this.ownLeft = 0;

	this.position = "relative";

	this.onLoad = new Function();

	this._id_bg = "";
	this._id_box = "";

	this.open = function (tmp_url) {
		var b = document.getElementsByTagName('body')[0];
		var self = this;

		//Create ids
		this._id_bg = this._genId();
		this._id_box = this._genId();

		//Create bg
		var bg = document.createElement('div');
		bg.setAttribute('id', this._id_bg);
		bg.setAttribute('style', 'position: absolute; top: 0; left: 0; z-index: 999; width: '+this.setWidthBox()+'; height: ' + this.setHeightBox() + '; background-color: #000000; -moz-opacity:0.' + this.bg_alpha + ';opacity:.' + this.bg_alpha + ';filter:alpha(opacity=' + this.bg_alpha + ');');
		bg.style.position = 'absolute';
		bg.style.left = "0px";
		bg.style.top = "0px";
		bg.style.width = this.setWidthBox();
		bg.style.height = this.setHeightBox();
		bg.style.background = '#000';
		bg.style.filter = 'alpha(opacity=' + this.bg_alpha + ')';
		bg.innerHTML = '&nbsp;';
		b.appendChild(bg);

		//Adjust positions
		this.Popup_f = function (e, n) {
			var pos = new WindowPosition();
			var div = document.getElementById(self._id_bg);
			var box = document.getElementById(self._id_box);
			var box2 = document.getElementById(self._id_box + "_ext");

			if (div) {
				var x;
				var y;

				switch(self.valign){
					case "top":
						y = pos.y + self.ownTop + 50;
						break;
					case "middle":
						y = pos.y + (pos.h / 2) - ((self.height) / 2) + self.ownTop;
						break;
					case "bottom":
						y = pos.y + pos.h - self.height + self.ownTop;
						break;
				}

				switch(self.align){
					case "left":
						x = pos.x + self.ownLeft;
						break;
					case "center":
						x = pos.x + (pos.w / 2) - ((self.width) / 2) + self.ownLeft;
						break;
					case "right":
						x = pos.x + (pos.w / 2) - ((self.width) / 2) + self.ownLeft;
						break;
				}

				box.style.left = x + "px";
				box.style.top = y + "px";

				if ((self.template == 1) || (self.template == 3)) {
					box2.style.left = (x - 5) + "px";
					box2.style.top = (y - 20) + "px";
				}

				div.style.display = '';
				box.style.display = '';
				div.style.zIndex = 999;

				if ((n == undefined) && (window.Popup_f)) {
					window.Popup_f(e, 1);
				}
			}
		}
		if(self.position != "fixed")
			addEvent(window, "scroll resize", this.Popup_f);
		window.Popup_f = this.Popup_f;

		//Create html
		switch (this.template) {
			default:
			case 1:
				var html = '<div onclick="javascript: Popup_atual.close();" id="' + this._id_box + '_ext" style="width: ' + (this.width+10) + 'px; height: ' + (this.height+25) + 'px; z-index: 1000; background: #999; position: absolute; -moz-opacity:0.' + this.bg_alpha + ';opacity:.' + this.bg_alpha + ';filter:alpha(opacity=' + this.bg_alpha + ');">';
				html += '<div onclick="javascript: Popup_atual.close();"  style="width: ' + (this.width + 5)  + 'px; margin-top: 3px; text-align: right; z-index: 1005;"><a href="javascript: Popup_atual.close();" style="color: #000; text-decoration: none; font-family: Verdana; font-size: 10px;">Fechar</a></div></div>';
				html += '<div id="' + this._id_box + '" style="display: none; width: ' + (this.width) + 'px; height: ' + (this.height) + 'px; background: #FFFFFF; overflow: ' + this.overflow + '; position: absolute; z-index: 1005;">';
				html += '<div style="margin-top: 45%; font-family: Verdana; font-size: 10px; color: #CCC;"><center>Carregando janela</center></div>';
				html += '</div>';

				tn = document.createElement('div');
				tn.innerHTML = html;
				b.appendChild(tn);

				var box = document.getElementById(this._id_box);
				box.style.width = this.width + 'px';
				box.style.height = this.height + 'px';
				box.style.overflow = this.overflow;

				var box2 = document.getElementById(this._id_box + "_ext");
				box2.style.filter = 'alpha(opacity=' + this.bg_alpha + ')';
				box2.style.width = (this.width + 10) + 'px';
				box2.style.height = (this.height + 25) + 'px';

				break;
			case 2:
				var html = '<div id="' + this._id_box + '" style="display: none; width: ' + (this.width) + 'px; height: ' + (this.height) + 'px; background: #FFFFFF; overflow: ' + this.overflow + '; position: absolute; z-index: 1001;">';
				html += '<div style="margin-top: 50%; font-family: Verdana; font-size: 10px; color: #CCC;"><center>Carregando janela</center></div>';
				html += '</div>';

				tn = document.createElement('div');
				tn.innerHTML = html;
				b.appendChild(tn);

				var box = document.getElementById(this._id_box);
				box.style.width = this.width + 'px';
				box.style.height = this.height + 'px';
				box.style.overflow = this.overflow;

				break;
			case 3:
				var html = '<div id="' + this._id_box + '_ext" style="width: ' + (this.width+10) + 'px; height: ' + (this.height+25) + 'px; z-index: 1000; background: #FFFFFF; position: absolute;">';
				html += '<div style="width: ' + (this.width-5)  + 'px; margin-top:8px; text-align: right; z-index: 1005;"><a href="javascript: Popup_atual.close();"><img src="../../../_system/img/bt-xfechar.gif"></a></div></div>';
				html += '<div id="' + this._id_box + '" style="display: none; width: ' + (this.width) + 'px; height: ' + (this.height) + 'px; background: #FFFFFF; overflow: ' + this.overflow + '; position: absolute; z-index: 1005;">';
				html += '<div style="margin-top: 45%; font-family: Verdana; font-size: 10px; color: #CCC;"><center>Carregando janela</center></div>';
				html += '</div>';

				tn = document.createElement('div');
				tn.innerHTML = html;
				b.appendChild(tn);

				var box = document.getElementById(this._id_box);
				box.style.width = this.width + 'px';
				box.style.height = this.height + 'px';
				box.style.overflow = this.overflow;

				var box2 = document.getElementById(this._id_box + "_ext");
				box2.style.filter = 'alpha(opacity=' + this.bg_alpha + ')';
				box2.style.width = (this.width + 10) + 'px';
				box2.style.height = (this.height + 25) + 'px';

				break;
			case 4:
				var html = '<div id="' + this._id_box + '" style="display: none; width: ' + (this.width) + 'px; height: ' + (this.height) + 'px; background: transparent; overflow: ' + this.overflow + '; position: absolute; z-index: 1001;">';
				html += '<div style="margin-top: 50%; font-family: Verdana; font-size: 10px; color: #CCC;"><center>Carregando janela</center></div>';
				html += '</div>';

				tn = document.createElement('div');
				tn.innerHTML = html;
				b.appendChild(tn);

				var box = document.getElementById(this._id_box);
				box.style.width = this.width + 'px';
				box.style.height = this.height + 'px';
				box.style.overflow = this.overflow;

				break;
		}

		this.Popup_f();
		setTimeout(Popup_f, 50);
		setTimeout(Popup_f, 100);
		setTimeout(Popup_f, 150);
		setTimeout(Popup_f, 300);
		setTimeout(Popup_f, 500);

		var a = new Ajax();
		a.onLoad = function () {
			document.getElementById(self._id_box).innerHTML = this.html;

			this.runJS(this.html);

			with(parent){
				if(f){
					f.maskFields();
				}
			}

			if (self.onLoad) {
				self.onLoad();
			}
		}
		a.get(tmp_url);

		Popup_atual = this;
	}

	this.close = function () {
		var box = document.getElementById(this._id_bg);
		var div = document.getElementById(this._id_box);
		var div2 = document.getElementById(this._id_box + "_ext");
		var b = document.getElementsByTagName('body')[0];

		if (div) { removeElement(div); }
		if (div2) { removeElement(div2); }
		if (box) { removeElement(box); }

		removeEvent(window, "scroll", this.Popup_f);
		removeEvent(window, "resize", this.Popup_f);
		window.Popup_f = undefined;
	}

	this._genId = function () {
		var id = "popup" + new String(Math.round(Math.random() * 1000));

		if (document.getElementById(id)) {
			id = this._genId();
		}

		return id;
	}

	this.setHeightBox = function() {
		var heightBody = document.body.parentNode.clientHeight;
		var heightScroll = document.body.parentNode.scrollHeight;

		if (heightBody > heightScroll) {
			return "100%";
		} else {
			return heightScroll+'px';
		}
	}

	this.setWidthBox = function() {
		var widthBody = document.body.clientWidth;
		var widthScroll = document.body.scrollWidth;

		if (widthBody > widthScroll) {
			return "100%";
		} else {
			return widthScroll+'px';
		}
	}
}