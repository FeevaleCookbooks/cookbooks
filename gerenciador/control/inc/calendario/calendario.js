var objcalendario = new Calendario();

function Calendario() {
	this.div;
	this.id = '_calendario_div';
	this.input_id = '';
	this.valor = '';
	this.valor_inicial = '';
	this.date = new Date();
	this.date_valor = new Date();
	this.date_hoje = new Date();
	this.combos = new Array();
	this.drag = false;
	
	this.mouse_x = 0;
	this.mouse_y = 0;
	
	this.offset_x = 20;
	this.offset_y = 5;
	
	this.open = function(tmp_id) {
		this.create();
		
		this.bugCombos('hidden');
		
		//Seta a data
		if (document.getElementById(tmp_id).value != "") {
			this.valor = document.getElementById(tmp_id).value;
			this.valor_inicial = this.valor;
		} else {
			var d = new Date();
			this.valor_inicial = '';
			this.valor = this.formatNumber(d.getDate(), 2) + "/" + this.formatNumber((d.getMonth()) + 1, 2) + "/" + d.getFullYear();
		}
		
		//Coloca html no pai do elemento
		this.input_id = tmp_id;
		document.getElementById(tmp_id).parentNode.appendChild(this.div);
		
		//Mostra data atual
		this.date_valor = this.parseData(this.valor);
		this.date = this.parseData(this.valor);
		this.showData();
		
		//Mostra o calendário
		this.div.style.display = '';
	}
	
	this.bugCombos = function (tmp_display) {
		var i = 0;
		while (i < this.combos.length) {
			this.combos[i].style.visibility = tmp_display;
			
			i++;	
		}
	}
	
	this.close = function () {
		this.div.style.display = 'none';
		
		this.bugCombos('visible');

		if (this.valor_inicial == document.getElementById(this.input_id).value) {
			this.setValor();
		}
	}
	
	this.closeForce = function () {
		//Botão x
		this.valor_inicial = (Math.random() * 10000) + '...';
		
		this.close();
	}
	
	this.create = function () {
		if (!document.getElementById(this.id)) {	
			this.div = document.createElement('div');
			this.div.id = this.id;
			this.div.style.position = 'absolute';
			
			var html = '<table cellspacing="0" cellpadding="0"><tr><td colspan="4" class="mes" id="_calendario_div_mes" onmousedown="javascript: objcalendario.startDrag();" onmouseup="javascript: objcalendario.stopDrag();"></td><td class="fechar" onclick="javascript: objcalendario.closeForce();"  onmouseover="javascript: objcalendario.setAlt(\'Fechar\');" onmouseout="javascript: objcalendario.clearAlt();" width="20">x</td></tr>';
			html += '<tr><td class="nav" onclick="javascript: objcalendario.clickAno(\'-\');" onmouseover="javascript: objcalendario.setAlt(\'Ano anterior\');" onmouseout="javascript: objcalendario.clearAlt();"><<</td><td class="nav" onclick="javascript: objcalendario.clickMes(\'-\');" onmouseover="javascript: objcalendario.setAlt(\'Mês anterior\');" onmouseout="javascript: objcalendario.clearAlt();"><</td>';
			html += '<td class="data" id="_calendario_div_data"></td>';
			html += '<td class="nav" onclick="javascript: objcalendario.clickMes(\'+\');" onmouseover="javascript: objcalendario.setAlt(\'Próximo mês\');" onmouseout="javascript: objcalendario.clearAlt();">></td><td class="nav" onclick="javascript: objcalendario.clickAno(\'+\');" onmouseover="javascript: objcalendario.setAlt(\'Próximo ano\');" onmouseout="javascript: objcalendario.clearAlt();">>></td></tr>';
			html += '<tr><td colspan="5" class="dias_t"><table cellpadding="0" cellspacing="0"><tr><td>D</td><td>S</td><td>T</td><td>Q</td><td>Q</td><td>S</td><td>S</td></tr></table></td></tr>';
			html += '<tr><td colspan="5" id="_calendario_div_dias" class="dias"></td></tr>';
			html += '<tr><td colspan="5" id="_calendario_div_status" class="status"></td></tr></table>';
			
			this.div.innerHTML = html;
			this.div.style.display = 'none';
			this.div.className = 'calendario';
			
			//Acha as combos
			var cmb = document.getElementsByTagName('select');
			var i = 0;
			var i2 = 0;
			while (i < cmb.length) {				
				if (cmb[i].style.display != 'none') {
					this.combos[i2] = cmb[i];
					i2++;
				}
				
				i++;
			}
		}
	}
	
	this.startDrag = function () {
		var x = this.div.style.left.replace("px", "");
		var y = this.div.style.top.replace("px", "");
		
		x++; x--;
		y++; y--;
		
		if (x > 0) {
			if (isIE) {
				this.offset_x = this.mouse_x - x;
				this.offset_y = this.mouse_y - y;
			}
		}
		
		this.drag = true;
	}
	
	this.stopDrag = function () {
		this.drag = false;
	}
	
	this.refreshDrag = function () {
		if (this.drag) {
			this.div.style.left = this.mouse_x - this.offset_x + getScrollWidth();
			this.div.style.top = this.mouse_y - this.offset_y + getScrollHeight();
		}
	}
	
	this.clickDia = function (tmp_dia) {
		//seta valor
		this.date_valor.setDate(tmp_dia);
		this.date_valor.setMonth(this.date.getMonth());
		this.date_valor.setFullYear(this.date.getFullYear());
		
		this.close();
	}
	
	this.clickMes = function (tmp_direcao) {	
		var tmp;
		
		//navega
		if (tmp_direcao == "+") {
			tmp = this.date.getMonth();	
			
			if (tmp == 11) {
				this.date.setMonth(0);
				this.date.setFullYear(this.date.getFullYear() + 1);
			} else {
				this.date.setMonth(tmp + 1);
			}
		} else {
			tmp = this.date.getMonth();	
			
			if (tmp == 0) {
				this.date.setMonth(11);
				this.date.setFullYear(this.date.getFullYear() - 1);
			} else {
				this.date.setMonth(tmp - 1);
			}
		}
		
		this.showData();
	}
	
	this.clickAno = function (tmp_direcao) {
		//navega
		if (tmp_direcao == "+") {
			this.date.setFullYear(this.date.getFullYear() + 1);
		} else {
			this.date.setFullYear(this.date.getFullYear() - 1);
		}
		
		this.showData();
	}
	
	this.setValor = function () {
		document.getElementById(this.input_id).value = this.formatNumber(this.date_valor.getDate(), 2) + "/" + this.formatNumber((this.date_valor.getMonth()+1), 2) + "/" + this.date_valor.getFullYear();
		if (document.getElementById(this.input_id).onchange) {
			document.getElementById(this.input_id).onchange();
		}
		
		if (document.getElementById(this.input_id).onkeyup) {
			document.getElementById(this.input_id).onkeyup();
		}
		
		if (document.getElementById(this.input_id).onkeydown) {
			document.getElementById(this.input_id).onkeydown();
		}
	}
	
	this.showData = function () {
		document.getElementById('_calendario_div_mes').innerHTML = this.getMes(this.date.getMonth()) + " - " + this.date.getFullYear();
		
		var html = '<table cellspacing="0" cellpadding="0"><tr>';
		
		var m = this.getTabelaDias();
		var i = 0;
		while (i < m.length) {			
			html += m[i].html;
			
			i++;
			
			if (m[i - 1].diasemana == 6) {
				html += "</tr>\n";	
				
				if (i < m.length) {
					html += '<tr>';
				}
			}
		}
		
		html += "</tr></table>";
		
		document.getElementById('_calendario_div_dias').innerHTML = html;
		
		document.getElementById('_calendario_div_data').innerHTML = this.formatNumber(this.date.getDate(), 2) + "/" + this.formatNumber((this.date.getMonth()+1), 2) + "/" + this.date.getFullYear();
	}
	
	this.getMes = function (tmp_mes) {
		var meses = new Array("Janeiro",
		 "Fevereiro",
		 "Março",
		 "Abril",
		 "Maio",
		 "Junho",
		 "Julho",
		 "Agosto",
		 "Setembro",
		 "Outubro",
		 "Novembro",
		 "Dezembro");
		
		return meses[tmp_mes];
	}
	
	this.formatNumber = function (tmp_numero, tmp_casas) {
		var r = new String(tmp_numero);
		
		while (r.length < tmp_casas) {
			r += '0' + r;
		}
		
		return r.substr((r.length-tmp_casas), r.length);
	}
	
	this.parseData = function (tmp_valor) {
		var tmp = tmp_valor.split("/");
		var d = new Date();
		
		d.setDate(tmp[0]);
		d.setMonth(tmp[1]-1);
		d.setFullYear(tmp[2]);	
		
		return d;
	}
	
	this.getTabelaDias = function () {
		var arr = new Array();
		var dia = 1;
		var d = new Date(this.date);
		var tmp = '';
		var max;
		
		d.setDate(1);
		
		i = 0;
		while (i < d.getDay()) {
			
			arr[i] = new Object();
			arr[i].dia = 0;
			arr[i].diasemana = i;
			arr[i].html = '<td style="cursor: default;">&nbsp;</td>';
			
			i++;
		}
		
		dia = 1;
		max = this.getQndDias(d.getMonth());
		while (dia <= max) {
			d.setDate(dia);
			
			arr[i] = new Object();
			arr[i].dia = dia;
			arr[i].diasemana = d.getDay();
			
			//Se é hoje
			tmp = '';
			if ((d.getDate() == this.date_hoje.getDate()) && (d.getMonth() == this.date_hoje.getMonth()) && (d.getFullYear() == this.date_hoje.getFullYear())) {
				tmp = 'style="background: #C7CED1;"';
			}
			
			//Se é dia selecionado
			if ((d.getDate() == this.date_valor.getDate()) && (d.getMonth() == this.date_valor.getMonth()) && (d.getFullYear() == this.date_valor.getFullYear())) {
				tmp += ' class="data"';
			}
			
			arr[i].html = '<td ' + tmp + ' onClick="javascript: objcalendario.clickDia(\'' + arr[i].dia + '\');">' + arr[i].dia + '</td>';
			
			i++;
			dia++;
		}
		
		dia = arr[i-1].diasemana + 1;
		while (dia <= 6) {
			arr[i] = new Object();
			arr[i].dia = 0;
			arr[i].diasemana = dia;
			arr[i].html = '<td style="cursor: default;">&nbsp;</td>';
			
			i++;
			dia++;
		}
		
		return arr;
	}
	
	this.getQndDias = function (tmp_mes) {
		var dia = 1000 * 60 * 60 * 24;
		var data = new Date();
		var esteMes = new Date(data.getFullYear(), tmp_mes, 1);
		var proximoMes = new Date(data.getFullYear(), tmp_mes + 1, 1);
		return Math.ceil((proximoMes.getTime() - esteMes.getTime())/dia);
	}
	
	this.setAlt = function (tmp_alt) {
		document.getElementById('_calendario_div_status').innerHTML = tmp_alt;	
	}
	
	this.clearAlt = function () {
		document.getElementById('_calendario_div_status').innerHTML = '';	
	}
}

function Calendario_mousemove(e) {
	if (e.clientX > 0) {
		objcalendario.mouse_x = e.clientX;
		objcalendario.mouse_y = e.clientY;
	} else {
		objcalendario.mouse_x = e.offsetX;
		objcalendario.mouse_y = e.offsetY;
	}
	
	objcalendario.refreshDrag();
}

function getScrollWidth() {
   var w = window.pageXOffset ||
           document.body.scrollLeft ||
           document.documentElement.scrollLeft;
           
   return w ? w : 0;
}

function getScrollHeight() {
   var h = window.pageYOffset ||
           document.body.scrollTop ||
           document.documentElement.scrollTop;
           
   return h ? h : 0;
}

document.onmousemove = function (e) {
	Calendario_mousemove(e||event);
}