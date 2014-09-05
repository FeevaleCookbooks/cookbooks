/**
 * multiUpload v0.3
 * 
 * @author Fredi Machado <fredisoft at gmail dot com>
 * @link http://fredimachado.com.br
 * @date 08/17/2009
 **/
function multiUpload(id, filesdiv, options)
{
	/**
	 * Default function to add files to the default base html
	 **/
	this.onSelected = function(e)
	{
		total = parseInt(document.getElementById('totalimagens').innerHTML) + e.files.length;

		if (total <= e.maximage) {
			for (var file in e.files)
			{
				var info = e.files[file];
				
				if (!(!(info.name))) {
					if (info.id % 2 == 0) {
						css = 1;
					} else {
						css = 2;
					}
					
					var divfile = document.createElement("div");
					divfile.id = "file_"+info.id;
					divfile.className = 'linhaupload linhainsert'+css;
					
					document.getElementById('Total Imagens_HDN0').value = info.id;
					
					html = '<table cellpadding="0" cellspading="0" style="padding-left:10px;">';
					html += '<tr>';
					html += '<td id="div_imagem_'+info.id+'" class="uploadimagem"><div id="progress_'+info.id+'" class="processoupload">0%</div></td>';
					html += '<td class="uploadarquivo" style="overflow:hidden;"><div class="uploadarquivo" style="overflow:hidden;"><input type="hidden" name="nomeimagem_'+info.id+'" value="'+info.name+'" />'+info.name+'</div></td>'; 
					html += '<td class="uploadtamanho ac">'+size(info.size)+'</td>';
					
					if (e.caption) {
						html += '<td class="uploadlegenda"><input type="text" style="width: 210px;" class="input" id="Legenda Imagem '+info.id+'_TXT0" value="" name="legendaimagem_'+info.id+'"></td>';
					}
					if (e.order) {
						var ordem = parseInt(document.getElementById('totalimagens').innerHTML) + parseInt(info.id);
						html += '<td class="c70p ac"><input type="text" style="width: 30px; text-align: center;" name="ordemimagem_'+info.id+'" id="Ordem Imagem '+info.id+'_NUM0" value="'+ordem+'" class="input"></td>';
					}
					html += '<td class="c70p ac"><a href="javascript:'+id+'.cancelUpload('+info.id+');" id="removeImagem_'+info.id+'"><img src="../inc/multiupload/bt_excluir.jpg" alt="X" title="Excluir" /></a></td>';
					html += '</tr>';
					html += '</table>';
					
					divfile.innerHTML = html;
					
					document.getElementById("files_list").appendChild(divfile);
				}
			}
		} else {
			alert('Número máximo de imagens é '+e.maximage+'.');
		}
	}

	/**
	 * Default function to remove the file from the default base html
	 **/
	this.onCancel = function(e)
	{
		var divfile = document.getElementById("file_"+e.id);
		document.getElementById("files_list").removeChild(divfile);		
		
		document.getElementById('totalimagens').innerHTML = parseInt(document.getElementById('totalimagens').innerHTML) - 1;
		document.getElementById('totalupload').innerHTML = parseInt(document.getElementById('totalupload').innerHTML) - 1;
	}

	/**
	 * Default function to show the upload progress
	 **/
	this.onProgress = function(e)
	{
		var progress = Math.ceil(Number(e.bytesLoaded / e.bytesTotal * 100));
		var div = document.getElementById("progress_"+e.id);
		var val = String(progress)+"%";
		div.innerHTML = val;
	}
	
	/**
	 * Default function to clear the list of files are queue
	 **/
	this.onClearQueue = function(e)
	{
		totalimagens = document.getElementById('Total Imagens_HDN0').value;
		for(x=1;x<=totalimagens;x++) {
			if (document.getElementById("file_"+x)) {
				document.getElementById("files_list").removeChild(document.getElementById("file_"+x));				
				
			}
		}
		
		document.getElementById('totalimagens').innerHTML = parseInt(document.getElementById('totalimagens').innerHTML) - parseInt(document.getElementById('totalupload').innerHTML);			
		document.getElementById('totalupload').innerHTML = 0;
	}

	/**
	 * Default function to clear the list of all files
	 **/
	this.onClearAll = function(e)
	{
		document.getElementById("files_list").innerHTML = "";
		
		document.getElementById('totalimagens').innerHTML = 0;			
		document.getElementById('totalupload').innerHTML = 0;	
	}
	
	this.onError = function(e)
	{
		alert('Algum erro ocorreu para fazer download das imagens.');
	}
	
	
	this.onComplete = function(e) {
		retorno = e.data;
		
		if (retorno.indexOf("ERRO") == -1) {
			src_image = retorno.split('###');
			document.getElementById("div_imagem_"+e.id).innerHTML = '<input type="hidden" name="caminhoimagem_'+e.id+'" value="'+retorno+'"><img src="../../_system/scripts/image.php?w=100&h=80&resize=4&file='+src_image[0]+'" />';
			document.getElementById("removeImagem_"+e.id).href = "javascript:"+id+".removeUpload("+e.id+",'insert');";
			
			document.getElementById('totalimagens').innerHTML = parseInt(document.getElementById('totalimagens').innerHTML) + 1;			
			document.getElementById('totalupload').innerHTML = parseInt(document.getElementById('totalupload').innerHTML) + 1;
		} else {
			document.getElementById("progress_"+e.id).innerHTML = "<font color='#009900'>"+retorno+"</font>";			
		}
	}

	this.prepareData = function(data)
	{
		var strData = '';
		for (var name in data)
			strData += '&' + name + '=' + data[name];
		return escape(strData.substr(1));
	}

	/**
	 * Default options
	 */
	this.op = {
		swf:               '../inc/multiupload/multiUpload.swf', // path to the swf file
		script:            '../inc/multiupload/routines.php', // path to the upload script
		expressInstall:    '../inc/multiupload/expressInstall.swf',
		scriptAccess:      'sameDomain',
		width:             122, // flash button width
		height:            20, // flash button height
		wmode:             'opaque', // flash button wmode
		method:            'GET', // method to send vars to the upload script
		data:              {}, // data object to send with each upload. ex.: { foo: 'bar' }
		caption:           false, // legenda
		order:             false, // Ordenação
		maxsize:           0, // maximum file size in bytes (0 = any size)
		maximage:          10000, // maximum file size in bytes (0 = any size)
		fileDescription:   '', // text to show in the combo box on the bottom of the selection window
		fileExtensions:    '', // Extension to allow ex.: '*.jpg;*.gif;*.png'
		createBaseHtml:    this.createBaseHtml, // Base html
		onMouseClick:      function() {}, // function to execute when the user has clicked the uploader swf
		onSelectionCancel: function() {}, // function to execute when the user presses "Cancel" in the selection window
		onSelected:        this.onSelected, // function to execute when the user makes the selection
		onStart:           function() {}, // function to execute when the uploader starts sending a file
		onError:           this.onError, // function to execute when an Error occurs
		onProgress:        this.onProgress, // function to execute on every progress change of a single file upload
		onCancel:          this.onCancel, // function to execute when a file upload is canceled
		onComplete:        this.onComplete, // function to execute when a file upload is complete
		onAllComplete:     function() {}, // function to execute when every file from the queue was sent
		onClearQueue:      this.onClearQueue, // function to execute when the queue is cleared
		onClearAll:		   this.onClearAll, // function to execute when the queue is cleared
		callback:          function() {} // function to execute when the swf object is embeded
	}

	this.op = mergeRecursive(this.op, options);

	var op = this.op;
	
	var path = location.pathname;
	path = path.split('/');
	path.pop();
	path = path.join('/') + '/';

	var params = {};

	params.id      = id;
	params.path    = path;
	params.script  = op.script;
	params.method  = op.method;
	if (op.multi)  params.multi = true;
	if (op.auto)   params.auto  = true;
	params.maxsize = op.maxsize;
	params.desc    = op.fileDescription;
	params.ext     = op.fileExtensions;
	params.maximage = op.maximage;
	if (op.caption)   params.caption  = true;
	if (op.order)   params.order  = true;
	
	if (op.data)
		params.scriptData = this.prepareData(op.data);
	
	swfobject.embedSWF(op.swf, id, op.width, op.height, '9.0.24', op.expressInstall, params, {'quality':'high','wmode':op.wmode,'allowScriptAccess':op.scriptAccess}, null, op.callback);

	this.el = function()
	{
		return document.getElementById(id);
	}

	this.setData = function(data)
	{
		this.el().setData(this.prepareData(data));
	}

	this.startUpload = function()
	{
		this.el().startUpload();
	}

	this.cancelUpload = function(fileid)
	{
		this.el().cancelUpload(fileid);
	}
	
	this.removeUpload = function(fileid,tipo) {
		if (tipo == 'update') { // Verifica se é uma imagem que já esta no banco.
			document.getElementById("files_list").removeChild(document.getElementById("table_file_"+fileid));
			
			document.getElementById('totalimagens').innerHTML = parseInt(document.getElementById('totalimagens').innerHTML) - 1;			
		} else {
			document.getElementById("files_list").removeChild(document.getElementById("file_"+fileid));
			
			document.getElementById('totalimagens').innerHTML = parseInt(document.getElementById('totalimagens').innerHTML) - 1;			
			document.getElementById('totalupload').innerHTML = parseInt(document.getElementById('totalupload').innerHTML) - 1;	
		}
	}

	this.clearUploadQueue = function()
	{
		this.el().clearUploadQueue();
	}
}


function mergeRecursive(obj1, obj2)
{
	for (var p in obj2)
	{
		try
		{
			if (obj2[p].constructor == Object)
				obj1[p] = mergeRecursive(obj1[p], obj2[p]);
			else
				obj1[p] = obj2[p];
		}
		catch(e)
		{
			obj1[p] = obj2[p];
		}
	}

	return obj1;
}

//function checkExtensions(filename) {
//	var arr_nomearquivo = filename.split('.');
//	var ext = arr_nomearquivo[arr_nomearquivo.length - 1];
//	
//	var extension = document.getElementById('ExtensionsAccept').value;
//	arr_extension = extension.split(', ');
//		
//	for(x=0,total=arr_extension.length;x<total;x++) {
//		if (arr_extension[x] == ext) {
//			return '';
//		}		
//	}
//	
//	return "ERRO: Extensão não permitida.<br>Utilize somente '" +extension+ "'";
//}

function DOMReady(f)
{
	if (/(?!.*?compatible|.*?webkit)^mozilla|opera/i.test(navigator.userAgent))
		document.addEventListener("DOMContentLoaded", f, false);
	else
		window.setTimeout(f,0);
}

function size(val)
{
	var kb = Number(Number(val)/1024).toFixed(1);
	return kb >= 1000 ? Number(kb/1024).toFixed(1) + " MB" : kb + " KB";
}
