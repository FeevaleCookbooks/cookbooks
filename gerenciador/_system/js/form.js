/*
Form validation
by Ramon Fritsch (www.ramonfritsch.com)

Types: TXT, NUM, CEP, TEL, PW1, PW2, DAT, HOR, EML, CPF, CMB, RDO, CNP, DIN, FLO, INT
Required: 1 = true, 0 = false

Sintax: (Label)[#Index]_(Type)(Required)[_(Minchars)]

Ex.:
id="CPF_CPF1" //Simple
id="Nome#2_TXT1_255" //Complex
*/


//Requires include default.js
try { var _test_form = __include_default; }
catch(e) { alert("form.js : Include '_system/js/default.js' é obrigatório"); }

var __include_form = true;

//class Form
function Form() {
	this.linguage = 1; //1 => port

	this.send = function (tmp_id, tmp_return) {
		if (tmp_return == undefined) {
			tmp_return = false;
		}

		var i = 0;
		var error = false;
		var form = document.getElementById(tmp_id);
		var valid_numbers = '0123456789,.';
		var valid_telphone = '0123456789. ()';
		var valid_cep = '0123456789-';
		var tmp_pass = '';
		var param_id;
		var param_type;
		var param_name;
		var param_value;
		var obj;
		var r_parse;

		var label;
		var type;
		var required;
		var minchars;


		form.onsubmit = function () { return false; }


		//elements loop
		while (form.elements[i]) {
			obj = form.elements[i];

			param_id = obj.id;
			param_type = obj.type;
			param_name = obj.name;
			param_value = obj.value;
			param_testDV = false;

			if(obj.attributes["testDV"]){
				if(obj.attributes["testDV"].value != "")
					param_testDV = true;
			}

			r_parse = this._parseId(param_id);

			label = r_parse[0];
			type = r_parse[1];
			required = r_parse[2];
			minchars = r_parse[3];

			switch (type) {
				case "FIL":
					if ((required) && (!param_value)) {
						this._showMessage(0, label);
						obj.focus();
						return false;
					} else if((required) || (param_value)) {
						arr_types = Array();
						if (obj.accept != ""){
							arr_types = obj.accept.split(",");
							arr_file = param_value.split(".");
							valid = false;
							if (arr_file.length > 1){
								for (cont = 0; cont<arr_types.length;cont++) {
									if(arr_types[cont] == arr_file[1]){
										valid = true;
									}
								}
							}
							if (!valid) {
								obj.value = "";
								this._showMessage(12, label, arr_types);
								obj.focus();
								return false;
							}
						}
					}
					break;
				case "TXT":
				case "NUM":
				case "DIN":
				case "FLO":
				case "TEL":
				case "CEP":
				case "INT":
					if (((required) && (!param_value)) || ((required) && ((param_testDV) && (param_value == obj.defaultValue)))) {
						this._showMessage(0, label);
						obj.focus();
						return false;
					}

					break;
				case "PW1":
					if ((required) && (!param_value)) {
						this._showMessage(0, label);
						obj.focus();
						return false;
					} else {
						tmp_pass = param_value;
					}

					break;
				case "PW2":
					if (param_value != tmp_pass) {
						this._showMessage(3);
						obj.focus();
						return false;
					}

					break;
					
				case "DAT"://((required) && ((param_testDV) && (param_value == obj.defaultValue)))
					if ((param_value) && ((param_testDV) && (param_value != obj.defaultValue))) {
						var day = param_value.split('/')[0]*1;
						var month = param_value.split('/')[1]*1;
						var year = param_value.split('/')[2]*1;

						if ((param_value.length == 10) && (param_value.charAt(2) == '/') && (param_value.charAt(5) == '/') && (day <= 31) && (day > 0) && (month <= 12) && (month > 0) && (year >= 1800)) {
							//Valid Date
						} else {
							this._showMessage(4, label);
							obj.focus();
							return false;
						}
					} else if (required && (((param_testDV) && (param_value == obj.defaultValue)) || (param_value == "" ))) {
						this._showMessage(0, label);
						obj.focus();
						return false;
					}

					break;
					
				case "HOR":
					if (param_value) {
						if ((param_value.length == 5) && (param_value.charAt(2) == ':') && (param_value.split(':')[0]*1 <= 24) && (param_value.split(':')[1]*1 <= 59)) {
							//Valid Hour
						} else {
							this._showMessage(8, label);
							obj.focus();
							return false;
						}
					} else if (required) {
						this._showMessage(0, label);
						obj.focus();
						return false;
					}

					break;
				case "HO2":
					if (param_value) {
						if ((param_value.length == 8) && (param_value.charAt(2) == ':') && (param_value.charAt(5) == ':') && (param_value.split(':')[0]*1 <= 24) && (param_value.split(':')[1]*1 <= 59) && (param_value.split(':')[2]*1 <= 59)) {
							//Valid Hour
						} else {
							this._showMessage(10, label);
							obj.focus();
							return false;
						}
					} else if (required) {
						this._showMessage(0, label);
						obj.focus();
						return false;
					}

					break;
				case "EML":
					if ((param_value) && ((param_testDV) && (param_value != obj.defaultValue)) || ((!param_testDV) && (param_value))) {
						if ((param_value.indexOf(".") > 0) && (param_value.indexOf("@") > 0) && (param_value.length > 3) && (param_value != "@.")) {
							//Valid e-mail
						} else {
							this._showMessage(5, label);
							obj.focus();
							return false;
						}
					} else if (required) {
						this._showMessage(0, label);
						obj.focus();
						return false;
					}

					break;
				case "CPF":
					if (param_value) {
						var p1 = param_value.substring(0,3);
						var p2 = param_value.substring(4,7);
						var p3 = param_value.substring(8,11);
						var p4 = param_value.substring(12,14);
						var cpf = p1 + p2 + p3 + p4;
						var cpf_verif = cpf.substring(9,11);
						var c = 0;
						var position=1;

						for (cont=0;cont<9;cont++) {
							c+=cpf.substring(cont,position)*(10-cont);
							position++;
						}

						c = (11-(c % 11));
						if (c > 9) { c=0; }
						if (cpf_verif.substring(0,1) != c) {
							this._showMessage(6);
							obj.focus();
							return false;
						}

						c *= 2;
						position = 1;
						for (cont=0; cont<9; cont++) {
							c+=cpf.substring(cont,position)*(11-cont);
							position++;
						}

						c = (11-(c % 11));
						if (c > 9) { c = 0; }

						if (cpf_verif.substring(1,2) != c) {
							this._showMessage(6);
							obj.focus();
							return false;
						}

						if ((cpf == '99999999999') || (cpf == '88888888888') || (cpf == '77777777777') || (cpf == '66666666666') || (cpf == '55555555555') || (cpf == '44444444444') || (cpf == '33333333333') || (cpf == '22222222222') || (cpf == '11111111111')) {
							this._showMessage(6);
							obj.focus();
							return false;
						}
					} else if (required) {
						this._showMessage(0, label);
						obj.focus();
						return false;
					}

					break;

				case "CNP":
						if (param_value) {
							var p1 = param_value.substring(0,2);
							var p2 = param_value.substring(3,6);
							var p3 = param_value.substring(7,10);
							var p4 = param_value.substring(11,15);
							var digitoverificador = param_value.substring(16,18);
							var cnpj = p1 + p2 + p3 + p4;
							var position=1;
							var arr_multiplicadores1 = new Array(5,4,3,2,9,8,7,6,5,4,3,2);
							var arr_multiplicadores2 = new Array(6,5,4,3,2,9,8,7,6,5,4,3,2);
							var soma = 0;
							var divisao = 0;
							var resto = 0;
							var verificador1;
							var verificador2;

							//---------- PRIMEIRO DIGITO -----------------
							for (cont=0;cont<12;cont++) {
								soma += (cnpj.substring(cont,position)*(arr_multiplicadores1[cont]));
								position++;
							}

							divisao = parseInt(soma / 11);
							resto = soma % 11;

							if (resto > 1) {
								verificador1 = 11 - resto
							} else {
								verificador1 = 0;
							}
							//---------- / PRIMEIRO DIGITO -----------------

							//---------- SEGUNDO DIGITO -----------------
							soma = 0;
							position = 1;
							for (cont=0;cont<12;cont++) {
								soma += (cnpj.substring(cont,position)*(arr_multiplicadores2[cont]));
								position++;
							}

							soma += verificador1 * arr_multiplicadores2[12];

							divisao = parseInt(soma / 11);
							resto = soma % 11;

							if (resto > 1) {
								verificador2 = 11 - resto
							} else {
								verificador2 = 0;
							}
							//---------- SEGUNDO DIGITO -----------------

							if (digitoverificador != (verificador1+''+verificador2)) {
								this._showMessage(11);
								obj.focus();
								return false;
							}
						} else if (required) {
							this._showMessage(0, label);
							obj.focus();
							return false;
						}
					break;
				case "CMB":
						if (((obj.selectedIndex == 0) || (obj.selectedIndex == 1)) && (required)) {
							this._showMessage(7, label);
							obj.focus();
							return false;
						}

					break;
				case "RDO":
					var ok = 0;
					var el = document.getElementsByName(param_name);

					for (i_el=0; i_el < el.length; i_el++) {
						var tmp = el[i_el].checked;
						if (tmp) { ok = 1; }
					}

					if ((required) && (ok == 0)) {
						this._showMessage(7, label);
						obj.focus();
						return false;
					}

					break;
			}

			//filter min chars
			if ((minchars > 0) && (param_value.length < minchars) && (required)) {
				this._showMessage(9, label, minchars);
				obj.focus();
				return false;
			}

			// filter the same name as the label is
			if((!required) && param_value == label) {
				obj.value = "";
			}

			i++;
		}

		if (tmp_return) {
			return true;
		} else {
			form.submit();
		}
	}

	this.maskFields = function () {
		var inputs = document.getElementsByTagName('input');
		var textareas = document.getElementsByTagName('textarea');
		var length = inputs.length;
		var el;
		var type;
		var id;
		var r_parse;

		for (var i = 0; i < textareas.length; i++) {
			el = textareas[i];
			id = el.id;

			r_parse = f._parseId(id);
			type = r_parse[1];
			switch (type) {
				case "TXT":
					addEvent(el, 'keyup blur', function() { f._maxlength(this.id); });

					break;
			}
		}

		for (i = 0; i < length; i++) {
			el = inputs[i];
			id = el.id;

			r_parse = f._parseId(id);

			type = r_parse[1];
			switch (type) {
				case "CPF":
					addEvent(el, 'keyup keypress keydown', function() { f._mask('CPF', this.id); });
					el.maxLength = 14;

					break;
				case "DAT":
					addEvent(el, 'keyup keypress keydown', function() { f._mask('DAT', this.id); });
					el.maxLength = 10;

					break;
				case "HOR":
					addEvent(el, 'keyup keypress keydown', function() { f._mask('HOR', this.id); });
					el.maxLength = 5;

					break;

				case "HO2":
					addEvent(el, 'keyup keypress keydown', function() { f._mask('HO2', this.id); });
					el.maxLength = 8;

					break;

				case "TEL":
					addEvent(el, 'keyup keypress keydown', function() { f._mask('TEL', this.id); });
					el.maxLength = 14;

					break;
				case "CNP":
					addEvent(el, 'keyup keypress keydown', function() { f._mask('CNP', this.id); });
					el.maxLength = 18;

					break;
				case "CEP":
					addEvent(el, "keyup keypress keydown", function() { f._mask('CEP', this.id); });
					el.maxLength = 9;

					break;
				case "NUM":
					addEvent(el, 'keyup', function() { f._mask('NUM', this.id); });

					break;
				case "FLO":
					addEvent(el, 'keyup', function() { f._mask('FLO', this.id); });

					break;
				case "DIN":
					addEvent(el, 'keyup', function() { f._mask('DIN', this.id); });
					el.maxLength = 15;

					break;
			}
		}
	}

	this._showMessage = function (tmp_index) {
		msgs = Array();

		if (this.linguage == 1) {
			msgs[0] = 'Por favor complete o campo "%1"';
			msgs[1] = 'Caracter inválido colocado no campo %1';
			msgs[2] = 'Você precisa digitar uma senha.';
			msgs[3] = 'A confirmação da senha não é válida.';
			msgs[4] = 'Por favor complete o campo "%1" com formato dd/mm/aaaa';
			msgs[5] = 'Dados inválidos colocados no campo %1';
			msgs[6] = 'CPF Inválido!';
			msgs[7] = 'Por favor selecione uma opção para o campo "%1"';
			msgs[8] = 'Por favor complete o campo "%1" com formato hh:mm';
			msgs[9] = 'O campo "%1" deve conter pelo menos %2 caracteres.' ;
			msgs[10] = 'Por favor complete o campo "%1" com formato hh:mm:ss';
			msgs[11] = 'CNPJ Inválido!';
			msgs[12] = 'Tipo de arquivo inválido. \nO campo "%1" aceita somente arquivos com as extensões "%2".';
		}
		//TODO: Make strings of different languages. (English, Spanish...)

		var r = String(msgs[tmp_index]);
		for (i = 1; i <= 5; i++) {
			r = r.replace("%" + i, arguments[i]);
		}

		alert(r);
	}

	this._parseId = function (tmp_id) {
		var i = 0;
		var underscore = 0;
		var qnt = 0;
		var type = '';
		var required;
		var label = '';
		var minchars = '';

		while (i < tmp_id.length) {
			if ((tmp_id.charAt(i) != '_') && (!underscore)) {
				label = label + tmp_id.charAt(i);
			} else if (tmp_id.charAt(i) == '_') {
				underscore++;
			} else if (underscore == 1) {
				if (type.length < 3) {
					type = type + tmp_id.charAt(i);
				} else {
					if (tmp_id.charAt(i) == '0') {
						required = false;
					} else {
						required = true;
					}
				}
			} else if (underscore == 2) {
				minchars = minchars + '' + tmp_id.charAt(i);
			}
			i++;
		}

		//format minchars
		if (minchars == '') {
			minchars = 0;
		}
		minchars = parseInt(minchars);

		//parse name
		var arr = label.split("**");
		label = arr[0].trim();

		return Array(label, type, required, minchars);
	}


	this._mask = function (tmp_type, tmp_id) {
		var obj = document.getElementById(tmp_id);

		switch (tmp_type) {
			case "CPF":
				var value = f._filterChars(obj.value, "0123456789");
				value = f._filterMask(value, "XXX.XXX.XXX-XX");
				obj.value = value;

				break;
			case "DAT":
				var value = f._filterChars(obj.value, "0123456789");
				value = f._filterMask(value, "XX/XX/XXXX");
				obj.value = value;

				break;
			case "HOR":
				var value = f._filterChars(obj.value, "0123456789");
				value = f._filterMask(value, "XX:XX");
				obj.value = value;

				break;
			case "HO2":
				var value = f._filterChars(obj.value, "0123456789");
				value = f._filterMask(value, "XX:XX:XX");
				obj.value = value;

				break;
			case "TEL":
				var value = f._filterChars(obj.value, "0123456789");
				value = f._filterMask(value, "(XX) XXXX-XXXX");

				obj.value = value;

				break;
			case "CNP":
				var value = f._filterChars(obj.value, "0123456789");
				value = f._filterMask(value, "XX-XXX-XXX/XXXX-XX");
				obj.value = value;

				break;
			case "CEP":
				var value = f._filterChars(obj.value, "0123456789");
				value = f._filterMask(value, "XXXXX-XXX");
				obj.value = value;

				break;
			case "NUM":
				var value = f._filterChars(obj.value, "0123456789");
				obj.value = value;

				break;

			case "FLO":
				var value = f._filterChars(obj.value, "0123456789,");
				obj.value = value;

				break;
			case "DIN":
				var possui_menos = false; var n = '__0123456789-'; var d = obj.value; var l = d.length; var r = ''; var len = 15;
				var wa, wb, w, verificador, z, c, n, a;
				if (l > 0) { z = d.substr(0,l-1); s = ''; a = 2;
					for (i=0; i < l; i++) { c=d.charAt(i); if (n.indexOf(c) > a) {	a=1;s+=c; if (c == '-') {	possui_menos = true; }; }; }; l=s.length;	t=len-1; if (l > t) { l=t; s=s.substr(0,t); };
					if (l > 2) { r=s.substr(0,l-2)+','+s.substr(l-2,2); } else { if (l == 2) { r='0,'+s; } else { if (l == 1) { r='0,0'+s; }; }; };
					if (r == '') { r='0,00'; } else { l=r.length; if (possui_menos) { verificador = 7; } else { verificador = 6; } if (l > verificador) { j=l%3; w=r.substr(0,j); wa=r.substr(j,l-j-6); wb=r.substr(l-6,6); if (j > 0) { w+='.'; }; k=(l-j)/3-2; for (i=0; i < k; i++) { w+=wa.substr(i*3,3)+'.'; }; r=w+wb; }; };
				};
				if (r.length <= len) { obj.value=r; } else { obj.value=z; };

				break;

		}
	}

	//Mask functions
	this._filterChars = function (tmp_valor, tmp_mask) {
		var txt = "";
		var i = 0;
		var c;

		while (i < tmp_valor.length) {
			c = tmp_valor.charAt(i);

			if (tmp_mask.indexOf(c) != -1) {
				txt += c;
			}

			i++;
		}

		return txt;
	}

	this._filterMask = function (tmp_valor, tmp_mask) {
		var txt = "";
		var txt2 = "";
		var i = 0;
		var c;
		var i2 = 0;
		var i_ultimo;
		var i_ultimo2 = 0;
		var i_ultimo_fake = true;

		while (i < tmp_mask.length) {
			c = tmp_mask.charAt(i);

			if (c == 'X') {
				if (tmp_valor.charAt(i2) != '') {
					txt += tmp_valor.charAt(i2);
					txt2 += tmp_valor.charAt(i2);
					i2++;
					i_ultimo = i;
					i_ultimo2 = i2;
				} else {
					i_ultimo_fake = false;
				}
			} else {
				if (i_ultimo2 < tmp_valor.length) {
					txt2 += c;
				}
				txt += c;
			}

			i++;
		}

		if (i_ultimo_fake) {
			txt2 = txt;
		}

		return txt2;
	}

	//Max length
	this._maxlength = function (tmp_id) {
		var obj = document.getElementById(tmp_id);

		var max = obj.attributes['maxlength'].value;
		var content = obj.value;
		var counter = document.getElementById(obj.id+'_counter');
		max++;max--;
		if (obj.value.length < (max+1)) {
			if(counter)
				counter.style.color = "#006400";
		} else {
			if(counter)
				counter.style.color = "#CC0000";
			obj.value = content.substr(0,max);
		}
		if(counter){
			counter.innerHTML = "("+obj.value.length+" / "+max+")";
		}
	}
}
var f = new Form();
var f2 = new Form();
addEvent(window, 'load', f.maskFields);