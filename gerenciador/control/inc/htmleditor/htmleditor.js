/*
TODO:
	- Tag do youtube
	- Ver botão de excluir elemento quando selecionado (img, retirar link...)(estudar isso)
	- Ver editar url(estudar isso)
	- Ver se tem como dar resize por php nas imagems
	
Lembrar:
	- Na hora de gravar no banco, dar resize no php nas imagems
	- Limpar o html
*/

//Requires include default.js
try { var _test_htmleditor = __include_default; }
catch(e) {
	alert("htmleditor.js : Include '_system/js/default.js' é obrigatório");
}

var __include_htmleditor = true;

var HtmlEditor_ROOT = "../inc/htmleditor/";

function HtmlEditor() {
	this.class_name = ""; //Name of instancied js var
	this.field_id = ""; //Textarea hidden id
	this.buttons = []; //array of removed buttons
	this.width = '100%';
	this.height = '300';
	this.images_path = "";
	this.root_path = "";
	this.is_window_opened = false;
	
	this.onLoad = new Function();
	
	this._toolbar = ["viewhtml", "|", "removeformat", "|", "bold", "italic", "underline", "|", "justifyleft", "justifycenter", "justifyright", "justifyfull", "|", "insertorderedlist", "insertunorderedlist", "|", "createlink", "unlink", "|", "image"];
	this._content = '';
	this._image_aba = 0;
	this._list_refresh = false;
	this._key_status = []; //Remember keys status
	this._is_view_html = false;
	this._last_range = null;
	this.make = function () {
		var html = '';
		
		html += '<table cellspacing="0" cellpadding="0" width="'+this.width+'">';
		html += '<tr><td class="bto_bar" id="' + this.class_name + '_td_bar"><table cellspacing="0" cellpadding="0"><tr>';
		
		var toolbar_ = this._toolbar.remove(this.buttons); //Remove buttons
		var self = this;
		var tab_order_ = 200;
		toolbar_.each(function (k, v) {
			if (v == '|') {
				html += '<td>&nbsp;&nbsp;</td>';
			} else {
				html += '<td><div class="bto_ext" onmouseover="javascript: { this.setAttribute(\'class\', \'bto_ext_over\'); this.setAttribute(\'className\', \'bto_ext_over\'); }" onmouseout="javascript: { this.setAttribute(\'class\', \'bto_ext\'); this.setAttribute(\'className\', \'bto_ext\'); }"><a taborder="' + tab_order_ + '" class="bto_' + v + '" href="javascript: nothing_func();" onclick="javascript: ' + self.class_name + '._command(\'' + v + '\')" title="' + self._getDescription(v) + '"><span>' + v + '</span></a></div>';
				
				if (v == 'image') {
					html += '<div id="' + self.class_name + '_image_box" class="image_box" style="display: none;">';
					html += '<table cellspacing="0" cellpadding="0"><tr><td>';
					html += '<div id="' + self.class_name + '_image_box_aba0" class="aba_sel" onmouseover="javascript: ' + self.class_name + '._imageAbaEvent(\'over\', 0);" onmouseout="javascript: ' + self.class_name + '._imageAbaEvent(\'out\', 0);" onclick="javascript: ' + self.class_name + '._imageAbaEvent(\'click\', 0);">Informações</div>';
					html += '<div id="' + self.class_name + '_image_box_aba1" class="aba" onmouseover="javascript: ' + self.class_name + '._imageAbaEvent(\'over\', 1);" onmouseout="javascript: ' + self.class_name + '._imageAbaEvent(\'out\', 1);" onclick="javascript: ' + self.class_name + '._imageAbaEvent(\'click\', 1);">Selecionar</div>';
					html += '<div id="' + self.class_name + '_image_box_aba2" class="aba"  onmouseover="javascript: ' + self.class_name + '._imageAbaEvent(\'over\', 2);" onmouseout="javascript: ' + self.class_name + '._imageAbaEvent(\'out\', 2);" onclick="javascript: ' + self.class_name + '._imageAbaEvent(\'click\', 2);">Upload</div>';
					html += '<div class="aba_fechar" onclick="javascript: ' + self.class_name + '._command(\'image\');" title="Fechar">x</div>';
					html += '</td></tr><tr><td>';
					html += '<div id="' + self.class_name + '_image_box_content0" class="content">';
					html += 'Url:<br><input class="input" type="text" style="width: 285px;" id="' + self.class_name + '_image_box_url" onblur="javascript: ' + self.class_name + '._imageThumb();">';
					html += '<table cellspacing="0" cellpadding="0" width="100%">';
					html += '<tr><td width="140" height="140"><div class="thumb" id="' + self.class_name + '_image_thumb"><br><br><br><br>sem imagem</div></td>';
					html += '<td valign="top">';
					html += '<div class="bt bt_action" style="width: 100%;" onclick="javascript: ' + self.class_name + '._imageAbaEvent(\'click\', 1);">Selecionar do servidor</div>';
					html += '<div class="bt bt_action" style="width: 100%;" onclick="javascript: ' + self.class_name + '._imageAbaEvent(\'click\', 2);">Fazer upload para o servidor</div>';			
					html += '<div style="width: 100%;margin-top:10px;">Posição da imagem<br /><input type="radio" checked name="floatalign' + self.class_name + '" value=""> Normal<br /><input type="radio" name="floatalign' + self.class_name + '" value="left"> Esquerda<br /><input type="radio" name="floatalign' + self.class_name + '" value="right"> Direita</div>';			
					html += '</td></tr>';
					html += '</table>';
					html += '</div>';
					html += '<div id="' + self.class_name + '_image_box_content1" class="content" style="display: none; overflow: auto;">carregando...</div>';
					html += '<div id="' + self.class_name + '_image_box_content2" class="content" style="display: none;">';
					html += '<form id="' + self.class_name + '_image_box_form">Arquivo:<br><input class="input" type="file" size="39" style="_width: 284px;" id="' + self.class_name + '_image_box_file" name="file"></form>';
					html += '<div class="alert">Apenas arquivos .jpg, .gif e .png</div>';
					html += '<div align="right"><div class="bt bt_action" id="' + self.class_name + '_image_box_upload" onclick="javascript: ' + self.class_name + '._imageUpload();">Enviar</div></div>';
					html += '</div>';
					html += '</td></tr>';
					html += '<tr><td height="34" align="right" valign="bottom"><div class="bt" style="margin-top: 0px;" onclick="' + self.class_name + '._imageOK();">OK</div></td></tr>';
					html += '</table>';
					html += '</div>';
				} else if (v == 'createlink') {
					html += '<div id="' + self.class_name + '_link_box" class="link_box" style="display: none;">';
					html += '<table cellspacing="0" cellpadding="0"><tr><td>';
					html += '<div id="' + self.class_name + '_link_box_aba0" class="aba_sel" onmouseover="javascript: ' + self.class_name + '._imageAbaEvent(\'over\', 0);" onmouseout="javascript: ' + self.class_name + '._imageAbaEvent(\'out\', 0);" onclick="javascript: ' + self.class_name + '._imageAbaEvent(\'click\', 0);">Informações</div>';
					html += '<div class="aba_fechar" onclick="javascript: ' + self.class_name + '._command(\'createlink\');" title="Fechar">x</div>';
					html += '</td></tr><tr><td>';
					html += '<div class="content">';
					html += 'Url:<br><input class="input" type="text" value="http://" style="width: 285px;" id="' + self.class_name + '_link_box_url"></td></tr>';
					html += '<tr><td align="right" valign="bottom"><div class="bt" id="' + self.class_name + '_link_box_ok" onclick="javascript: ' + self.class_name + '._linkOK();">OK</div>';
					html += '</div></td></tr></table>';
					html += '</div>';
				}
				
				html += '</td>';
				
				tab_order_++;
			}
		}, this);
		
		this._toolbar = toolbar_;
		
		html += '</tr></table></td></tr>';
		
		html += '<tr><td style="background: #FFF;" id="' + this.class_name + '_td_iframe">';
		html += '	<iframe id="' + this.class_name + '_iframe" width="' + this.width + '" height="' + this.height + '" frameborder="0"></iframe>';
		html += '</td></tr>';
		
		html += '<tr><td style="background: #FFF; display: none;" id="' + this.class_name + '_td_codehtml">';
		html += '	<table cellspacing="0" cellpadding="0" width="100%">';
		html += '		<tr><td class="bto_bar"><a class="bto_voltar" href="javascript: nothing_func();" onclick="javascript: ' + this.class_name + '._command(\'viewhtml\')">Voltar</a></td></tr>';
		html += '		<tr><td><textarea id="' + this.class_name + '_codehtml" style="width: ' + this.width + '; height: ' + this.height + ';"></textarea></td></tr>';
		html += '	</table>';
		html += '</td></tr>';
		
		html += '</html>';
		
		var d = document.createElement('div');
		d.setAttribute('id', this.class_name + '_div');
		d.setAttribute('className', 'html_editor');
		d.setAttribute('class', 'html_editor');
		d.innerHTML = html;
		document.getElementById(this.field_id).parentNode.appendChild(d);
		
		//get content from textarea element
		this._content = document.getElementById(this.field_id).value;
		
		//enable design mode to iframe
		setTimeout(this._enableIframe.bind(this), 50);
		
		//hidden textarea element
		document.getElementById(this.field_id).style.display = 'none';
	}
	
	this.loadFile = function (tmp_path) {
		var a = new Ajax();
		var self = this;
		
		a.onLoad = function () {
			this.html = this.html.replace(new RegExp('#ROOT#', 'g'), self.root_path);
			
			self._getIframeDocument().body.innerHTML = this.html;
			self._insertHTML('');
		}
		a.get(tmp_path);
	}
	
	this.getContent = function () {
		return document.getElementById(this.field_id).value;
	}
	
	this._enableIframe = function () {
		this._getIframeDocument().designMode = 'on';
		
		if (this._getIframeDocument().body) {
			this._getIframeDocument().body.innerHTML = '';
		}
		
		//set content to iframe
		setTimeout(this._initContent.bind(this), 300);
		
		//enable timer for copy text from iframe to textarea
		setTimeout(this._updateField.bind(this), 350);
		
		//set ok events for boxes
		var self = this;
		addEvent(document.getElementById(this.class_name + '_link_box_url'), "keydown", function (e) { self._okEvent(e, self.class_name + '._linkOK()'); });
		addEvent(document.getElementById(this.class_name + '_image_box_url'), "keydown", function (e) { self._okEvent(e, self.class_name + '._imageOK()'); });
	}
	
	this._initContent = function () {
		var self = this;
		
		this._getIframeDocument().body.innerHTML = this._content;
		this._insertHTML('');
		
		addEvent(this._getIframeDocument(), "keydown", function (e) { self._fireEvent('keydown', e); });
		addEvent(this._getIframeDocument(), "keyup", function (e) { self._fireEvent('keyup', e); });
		
		if (document.all) {
			addEvent(this._getIframeDocument(), "selectionchange", function (e) { self._fireEvent('selectionchange', e || event); });
		} else {
			addEvent(this._getIframeDocument(), "mouseup", function (e) { self._fireEvent('selectionchange', e || event); });
		}
		
		this.onLoad();
	}
	
	this._fireEvent = function (tmp_type, tmp_e) {	
		var k = tmp_e.keyCode;
		
		switch (tmp_type) {
			case "keydown":
				this._key_status[k] = true;
				
				if (this._key_status[17] && (k == 13)) {
					//this._insertHTML('<h1>teste!</h1>');
				}
				
				break;
			
			case "keyup":
				this._key_status[k] = false;
				
				break;
			
			case "selectionchange":
				
				break;
		}
	}
	
	this._okEvent = function (tmp_e, tmp_func) {
		var k = tmp_e.keyCode;
		
		if (k == 13) {
			eval(tmp_func);
		}
	}
	
	this._getIframeDocument = function () {
		if (document.getElementById(this.class_name + '_iframe').contentDocument) {
			return document.getElementById(this.class_name + '_iframe').contentDocument;
		} else {
			return document.frames[this.class_name + '_iframe'].document;
		}
	}
	
	this._updateField = function () {
		if (document.getElementById(this.class_name + '_iframe') && (!this._is_view_html)) {
			var content = this._getIframeDocument().body.innerHTML;
			
			//clean content
			if (content.substr(-4) == '<br>') {
				content = content.substr(0, content.length - 4);
			}
			
			content = content.replace('<p class="MsoPlainText">', '<p>');
			content = content.replace('<o:p></o:p>', '');
			
			if (content == '<P>&nbsp;</P>') {
				content = '';
			}
			
			document.getElementById(this.field_id).value = content.trim();
		}
		
		setTimeout(this._updateField.bind(this), 500);
	}
	
	this._insertHTML = function (tmp_html) {
		if (document.all) {
			this._getIframeDocument().body.setActive();
			
			var r = this._last_range;
			
			if (r == null) {
				r = this._getIframeDocument().selection.createRange();
			}
			
			r.select();
			r.collapse(false);
			r.pasteHTML(tmp_html);
		} else {
			var rnd_str = "insert_html_" + Math.round(Math.random()*100000000);
			this._getIframeDocument().execCommand('insertimage', false, rnd_str);
			this._getIframeDocument().body.innerHTML = this._getIframeDocument().body.innerHTML.replace(new RegExp('<[^<]*' + rnd_str + '[^>]*>'), tmp_html);
		}
	}
	
	this._command = function (tmp_command) {
		switch (tmp_command) {
			case 'image':
				if (document.getElementById(this.class_name + '_image_box').style.display == 'none') {
					if (document.all) {
						this._getIframeDocument().body.setActive();
						this._last_range = this._getIframeDocument().selection.createRange();
					}
										
					document.getElementById(this.class_name + '_image_box').style.display = '';
					screenLock(true);
					
					this.is_window_opened = true;
				} else {
					document.getElementById(this.class_name + '_image_box').style.display = 'none';
					screenLock(false);
					
					this.is_window_opened = false;
				}
				
				break;
			case 'createlink':
				if (document.getElementById(this.class_name + '_link_box').style.display == 'none') {
					if (document.all) {
						this._last_range = this._getIframeDocument().selection.createRange();
					}

					document.getElementById(this.class_name + '_link_box').style.display = '';
					screenLock(true);
					
					this.is_window_opened = true;
				} else {
					document.getElementById(this.class_name + '_link_box').style.display = 'none';
					screenLock(false);
					
					this.is_window_opened = false;
				}
				
				break;
			case 'viewhtml':
				if (!this._is_view_html)
				{
					document.getElementById('botoes').onclick = function()
					{
						setTimeout('prePost()',400);
					};
							
					document.getElementById(this.class_name + '_td_iframe').style.display = 'none';
					
					document.getElementById(this.class_name + '_td_bar').style.display = 'none';
					
					document.getElementById(this.class_name + '_td_codehtml').style.display = '';
					
					document.getElementById(this.class_name + '_codehtml').value = this._getIframeDocument().body.innerHTML.replace(new RegExp("<br>", "gi"), "<br>\n").replace(new RegExp("<\p>", "gi"), "<\p>\n");
					
					document.getElementById(this.class_name + '_codehtml').focus();
					
					this._is_view_html = true;
					
					document.getElementById(this.class_name + '_codehtml').onblur = function()
					{
						 htmleditor1._command('viewhtml');
					};
				}
				else
				{		
					this._is_view_html = false;
					
					document.getElementById(this.class_name + '_td_iframe').style.display = '';
					
					document.getElementById(this.class_name + '_td_bar').style.display = '';
					
					document.getElementById(this.class_name + '_td_codehtml').style.display = 'none';
					
					this._getIframeDocument().body.innerHTML = document.getElementById(this.class_name + '_codehtml').value;
					this._insertHTML('');
				}
				
				break;
			default:
				document.getElementById(this.class_name + '_iframe').focus();
				this._getIframeDocument().execCommand(tmp_command, false, '');
				
				break;
		}
		
		try {
			document.getElementById(this.class_name + '_iframe').contentWindow.focus();
		} catch (e) { }
	}
	
	this._getDescription = function (tmp_button) {
		switch (tmp_button) {
			case "removeformat": return "Remover formatação"; break;
			case "bold": return "Aplicar/Retirar negrito"; break;
			case "italic": return "Aplicar/Retirar itálico"; break;
			case "underline": return "Aplicar/Retirar underline"; break;
			case "justifyleft": return "Alinhar à esquerda"; break;
			case "justifylright": return "Alinhar ao centro"; break;
			case "justifylright": return "Alinhar à direita"; break;
			case "justifyfull": return "Justificar"; break;
			case "insertorderedlist": return "Inserir/Remover lista ordenada"; break;
			case "insertunorderedlist": return "Inserir/Remover lista não ordenada"; break;
			case "createlink": return "Inserir link"; break;
			case "unlink": return "Remover link"; break;
			case "image": return "Inserir imagem"; break;
			case "viewhtml": return "Editar html"; break;
			default: return ""; break;
		}
	}
	
	//Image
	this._imageAbaEvent = function (tmp_event, tmp_index) {
		this._image_aba++; this._image_aba--;
		tmp_index++; tmp_index--;
		
		switch (tmp_event) {
			case 'over':
				if (tmp_index != this._image_aba) {
					document.getElementById(this.class_name + '_image_box_aba' + tmp_index).setAttribute('className', 'aba_over');
					document.getElementById(this.class_name + '_image_box_aba' + tmp_index).setAttribute('class', 'aba_over');
				}
				
				break;
			case 'out':
				if (tmp_index != this._image_aba) {
					document.getElementById(this.class_name + '_image_box_aba' + tmp_index).setAttribute('className', 'aba');
					document.getElementById(this.class_name + '_image_box_aba' + tmp_index).setAttribute('class', 'aba');
				}
				
				break;
			case 'click':
				if (tmp_index != this._image_aba) {
					document.getElementById(this.class_name + '_image_box_aba' + this._image_aba).setAttribute('className', 'aba');
					document.getElementById(this.class_name + '_image_box_aba' + this._image_aba).setAttribute('class', 'aba');
					document.getElementById(this.class_name + '_image_box_content' + this._image_aba).style.display = 'none';
					
					this._image_aba = tmp_index;
					
					document.getElementById(this.class_name + '_image_box_aba' + tmp_index).setAttribute('className', 'aba_sel');
					document.getElementById(this.class_name + '_image_box_aba' + tmp_index).setAttribute('class', 'aba_sel');
					document.getElementById(this.class_name + '_image_box_content' + tmp_index).style.display = '';
					
					if ((this._image_aba == 1) && (!this._list_refresh)) {
						this._list_refresh = true;
						
						this._imageListRefresh();
					}
				}
				
				break;
		}
	}
	
	this._imageThumb = function () {
		var url = document.getElementById(this.class_name + '_image_box_url').value;
		var ext = url.substr(url.length - 3, 3).toLowerCase();
		var html = '<br><br><br><br>sem imagem';
		
		url = url.replace(this.root_path, '');
		
		if ((ext == 'jpg') || (ext == 'gif')) {
			html = '<img src="' + HtmlEditor_ROOT + 'routines.php?routine=thumb&file=' + url + '&w=118&h=118">';
		}
		
		document.getElementById(this.class_name + '_image_thumb').innerHTML = html;
	}
	
	this._imageListRefresh = function () {
		var a = new Ajax();
		var self = this;
		
		a.onLoad = function () {
			var ext, html = '';
			var arr = this.html.split('##');
			
			arr.each(function (k, v) {
				if (v != '') {
					ext = v.substr(v.length - 3, 3).toLowerCase();
					
					if ((ext == 'jpg') || (ext == 'gif') || (ext == 'png')) {
						html += '<div class="thumb_list" onclick="javascript: ' + self.class_name + '._imageSelect(\'' + v + '\');"><img src="' + HtmlEditor_ROOT + 'routines.php?routine=thumb&method=2&file=' + v + '&w=70&h=70" width="70" height="70" title="' + v + '"></div>';
					}
				}
			}, this);
			
			document.getElementById(self.class_name + '_image_box_content1').innerHTML = html;
		}
		a.get(HtmlEditor_ROOT + "routines.php?routine=list&path=" + this.images_path);
	}
	
	this._imageSelect = function (tmp_path) {
		document.getElementById(this.class_name + '_image_box_url').value = tmp_path;
		
		this._imageAbaEvent('click', 0);
		this._imageThumb();
	}
	
	this._imageUpload = function () {
		var onload, input, form, iframe, self, ext;
		
		self = this;
		
		iframe = document.createElement("iframe");
		iframe.setAttribute("id","ifr_tmp");
		iframe.setAttribute("name","ifr_tmp");
		iframe.setAttribute("width","0");
		iframe.setAttribute("height","0");
		iframe.setAttribute("border","0");
		iframe.setAttribute("style","width: 0; height: 0; border: none;");
		document.getElementById(this.field_id).parentNode.appendChild(iframe);
		window.frames["ifr_tmp"].name = "ifr_tmp"; //Ie sux
		
		//Verify if input file is not empty
		input = document.getElementById(this.class_name + '_image_box_file');
		
		if (input.value != '') {
			//Verify extension
			ext = input.value.substr(input.value.length - 3, 3).toLowerCase();
			
			if ((ext == 'jpg') || (ext == 'gif') || (ext == 'png')) {
				onload = function () {
					self._imageAbaEvent('click', 1);
					
					//Removes iframe element
					setTimeout(function () { removeElement(document.getElementById('ifr_tmp')); }, 250);
					
					document.getElementById(self.class_name + '_image_box_upload').style.display = '';
					removeElement(document.getElementById(self.class_name + '_image_box_carregando'));
					
					self._imageListRefresh();
				}
				addEvent(document.getElementById('ifr_tmp'), "load", onload);
				
				//Config form element
				form = document.getElementById(this.class_name + '_image_box_form');
				form.setAttribute("target", "ifr_tmp");
				form.setAttribute("action", HtmlEditor_ROOT + "routines.php?routine=upload&path=" + this.images_path);
				form.setAttribute("method", "post");
				form.setAttribute("enctype", "multipart/form-data");
				form.setAttribute("encoding", "multipart/form-data");
				
				form.submit();
				
				var d = document.createElement("div");
				d.id = this.class_name + "_image_box_carregando";
				d.innerHTML = "Carregando...";
				document.getElementById(this.class_name + '_image_box_upload').parentNode.appendChild(d);
				
				document.getElementById(this.class_name + '_image_box_upload').style.display = 'none';
			} else {
				alert("Arquivo inválido.\nSão permitidos apenas arquivos .jpg, .gif e .png");	
			}
		} else {
			alert("O campo 'Arquivo' está vazio");
			
			input.focus();
		}
	}
	
	this._imageOK = function () {
		var url = document.getElementById(this.class_name + '_image_box_url').value;
		var ext = url.substr(url.length - 3, 3).toLowerCase();
		
		if ((ext == 'jpg') || (ext == 'gif')) {			
			if (url.indexOf('http://') == -1) {
				url = this.root_path + url;	
			}
			
			valoralign = '';			
			var el = document.getElementsByName('floatalign'+this.class_name);		
			for (i_el=0; i_el < el.length; i_el++) {
				
				if (el[i_el].checked) {					
					if (el[i_el].value != '') {
						valoralign = 'align="' + el[i_el].value + '" style="margin:7px;"';
					}
				}
			}
			
			this._insertHTML('<img src="' + url + '" '+valoralign+' border="0">');
			
			this._command('image');
			
			this._imageThumb();
		} else {
			alert('Imagem inválida, verifique a url informada.');
		}
	}
	
	//Link
	this._linkOK = function () {
		var url = document.getElementById(this.class_name + '_link_box_url').value;
		var http = url.substr(0, 4);
		
		if (http == 'http') {			
			if (document.all) {
				this._getIframeDocument().body.setActive();
				
				var r = this._last_range;
			
				if (r == null) {
					r = this._getIframeDocument().selection.createRange()
				}
				
				r.select();
				r.collapse(false);
			}
			
			this._getIframeDocument().execCommand('createlink', false, url);
			
			this._command('createlink');
			
			document.getElementById(this.class_name + '_link_box_url').value = 'http://';
		} else {
			alert('Link inválido, verifique a url informada.');
		}
	}
}