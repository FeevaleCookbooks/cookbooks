var splitFilhos = "!!!";
var splitArgs = ",";
var filhoPadraoIni = "<select class='input' id='$ID$' name='$NAME$' onchange='javascript: ai(this, \"$HDNPAI$\");'>";
var filhoPadraoOp1 = 	"<option value=''>Selecione</option>";
var filhoPadraoOp2 = 	"<option value=''>------</option>";
var filhoPadraoFim = "</select><div id='$ID$_div' style='padding-top: 5px;'></div>"
var routinePath = "../../control/routines/form/routines.php";

function selectValue(select,value){
	for (x=0;x<select.length;x++){
		if (select.options[x].value == value){
			select.selectedIndex = x;
			return;
		}
	}
}
function selecionaPaiAtual(paiAtual) {
	line_pais = document.getElementById(getLabelPai(paiAtual)+"_linha_pais").value;
	//alert("line_pais\n\n"+line_pais);
	if (line_pais != "") {
		arr_pais = line_pais.split(splitArgs);
		pai_atual = "";
		if (arr_pais) {
			if (arr_pais.length > 0) {
				pai_atual = arr_pais.shift();
				line_pais = arr_pais.join(splitArgs);
				document.getElementById(getLabelPai(paiAtual)+"_linha_pais").value = line_pais;
				//alert("pai_atual:\n\n"+pai_atual+"\n\nnova line_pais:\n\n"+line_pais);
				
				selectValue(paiAtual, pai_atual);
			}
		}
	}
}
function ai(paiAtual, hdnPai) {
	selecionaPaiAtual(paiAtual);
	
	if ((paiAtual.value != "0") && (paiAtual.value != ""))
		document.getElementById(hdnPai).value = paiAtual.value;
		
	zeraFilhos(paiAtual);
	var a = new Ajax();
	
	a.onLoad = function() {
		if (this.html != "") {
			//verificar se existem filhos, se existe mais de um, deve-se apaga-los
			//zerar ou criar o próximo filho
			var newFilhoId = newFilho(paiAtual, hdnPai);
			//alert(newFilhoId);
			//alert(this.html);

			values = this.html;
			arr_options = values.split('#');
			selected = 0;
			
			for(x=0,total = arr_options.length;x<total;x++) {
				value_option = arr_options[x].split('+');
				document.getElementById(newFilhoId).options[x] = new Option(value_option[1],value_option[0]);
			}
			if (document.getElementById(getLabelPai(paiAtual)+"_linha_pais").value != "")
				document.getElementById(newFilhoId).onchange();
		}else{
			
		}
	}
	strArgs = getStrArgs(paiAtual);
	strArgs = strArgs+"&id="+paiAtual.value;
	a.get(routinePath+strArgs);
}
function zeraFilhos(paiAtual) {
	if (document.getElementById(getLabelPai(paiAtual)+'_filhos')) {
		if (document.getElementById(getLabelPai(paiAtual)+'_filhos').value != '') {
			oldFilhos = document.getElementById(getLabelPai(paiAtual)+'_filhos').value;
			pos = oldFilhos.search(paiAtual.id);
			//alert("pos: \n\n"+pos);
			if (pos > -1) {
				filhos = oldFilhos.substr(0, parseInt(pos+paiAtual.id.length));
				//alert("velhos filhos:\n"+oldFilhos+"\n\nfilhos novos\n"+filhos);
				document.getElementById(getLabelPai(paiAtual)+'_filhos').value = filhos;
			}else{
				filhos = "";//se não encontrou nos filhos, é o pai
				document.getElementById(getLabelPai(paiAtual)+'_filhos').value = filhos;
			}
		}
	}
	document.getElementById(paiAtual.id+"_div").innerHTML = "";
}
function getLabelPai(campo) {
	arr_names = campo.id.split('_');
	return arr_names[0];
}
function getLabel(campo) {
	//alert("em getLabel, campo.id = "+campo.id);
	arr_names = campo.id.split('_');
	name = "";
	
	for(x=0;x<arr_names.length-1;x++){
		name = name+arr_names[x];
	}
	return name;
}
function getFilhos(paiAtual) {
	var arr_filhos = new Array();
	if (document.getElementById(getLabelPai(paiAtual)+'_filhos')) {
		if (document.getElementById(getLabelPai(paiAtual)+'_filhos').value != '') {
			arr_filhos = document.getElementById(getLabelPai(paiAtual)+'_filhos').value.split(splitFilhos);
		}
	}
	return arr_filhos;
}
function newFilho(paiAtual, hdnPai) {
	newFilhoId = newHtmlFilho(paiAtual, hdnPai);	
	return newFilhoId;
}
function newHtmlFilho(paiAtual, hdnPai) {
	ultimoFilhoIndex = getUltimoFilhoIndex(paiAtual);
		
	newFilhoId = getLabel(paiAtual)+"_"+ultimoFilhoIndex;
	filhoIni = filhoPadraoIni.replace("$ID$", newFilhoId);
	filhoIni = filhoIni.replace("$HDNPAI$", hdnPai);
	filhoIni = filhoIni.replace("$NAME$", getLabel(paiAtual)+"_"+ultimoFilhoIndex);
	filhoFim = filhoPadraoFim.replace("$ID$", getLabel(paiAtual)+"_"+ultimoFilhoIndex);
	//alert("novo filho\n\n"+filhoIni+filhoPadraoOp1+filhoPadraoOp2+filhoFim);
	
	divPai = document.getElementById(paiAtual.id+'_div');
	//alert("div do novo filho:\n\n"+paiAtual.id+'_div');
	hdnFilhos = document.getElementById(getLabel(paiAtual)+'_filhos');
	
	//alert("hdn filhos: "+hdnFilhos.value+"\n\ndivPai innerHtml: "+divPai.innerHTML);
	
	divPai.innerHTML = filhoIni+filhoPadraoOp1+filhoPadraoOp2+filhoFim
	arr_filhos = getFilhos(paiAtual);
	arr_filhos.push(newFilhoId);
	hdnFilhos.value = arr_filhos.join(splitFilhos);
	
	//alert("hdn filhos: "+hdnFilhos.value+"\n\ndivPai innerHtml: "+divPai.innerHTML);
	
	
	return newFilhoId;
}
function getUltimoFilhoIndex(paiAtual) {
	var arr_filhos = getFilhos(paiAtual);
	
	ultimoFilhoIndex = 0;
	//alert(arr_filhos);
	if (arr_filhos.length > 0) {
		ultimoFilho = arr_filhos[arr_filhos.length-1];
		arr_ultimoFilho = ultimoFilho.split('_');
		ultimoFilhoIndex = (parseInt(arr_ultimoFilho[arr_ultimoFilho.length-1])+1);
	}
	
	//alert(ultimoFilhoIndex);
	
	return ultimoFilhoIndex;
}
function newFilhoIndex(paiAtual){
	return getUltimoFilhoIndex(paiAtual)+1;
}
function getArgs(paiAtual){
	var arr_args = new Array();
	if (document.getElementById(getLabel(paiAtual)+'_args')) {
		if (document.getElementById(getLabel(paiAtual)+'_args').value != '') {
			arr_args = document.getElementById(getLabel(paiAtual)+'_args').value.split(splitArgs);
		}
	}
	return arr_args;
}
function getStrArgs(paiAtual){
	var str = "?routine=refresh_tree";
	var arg = "&arg";
	var arr_args = getArgs(paiAtual);
	for (x=0;x<arr_args.length;x++) {
		str = str + arg+x+"="+arr_args[x];
	}
	return str;
}
function loadFromFilho(paiAtual) {
	paiAtual.onchange();
}