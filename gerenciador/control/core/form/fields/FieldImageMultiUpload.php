<?php

class FieldImageMultiUpload extends Field {
	var $path;
	var $thumbs;
	
	var $extensions_accept;
	
	var $path_tmp;
	
	var $max;
	
	// TABELA PARA AS IMAGENS
	var $tableimage; // Tabela onde ficará as imagens
	var $fieldsrel; // Campo que relaciona as imagens com o conteudo principal
	var $arr_fieldsimage; // Armazena os valores dos campos para trocar o nome das imagens
	var $indeximage; // Campo do indice (ID) da imagem
	var $nameimage; // Campo que armazena o nome da imagem
	var $captionexists; // Flag para identificar se tem legenda ou não
	var $captionimage; // Campo que armazena a legenda da imagem
	var $orderimage; // Campo para armazenar a ordenação das imagens
	
	function FieldImageMultiUpload($tmp_params) {
		ini_set("memory_limit","40M");
		
		parent::Field("imageMultiUpload", $tmp_params[0]);
		
		$this->flags_accept = "IU";
		
		$this->label = $tmp_params[1];
		$this->validation = "TXT";
		$this->is_sql_affect = false;
		
		$this->extensions_accept = array("jpg");
		
		if (isset($tmp_params[2])) {
			$this->setPath($tmp_params[2]);
		}
		
		$this->setTmpPath("upload/tmp/");
		
		global $routine;
		if ($routine == "update") {
			$this->is_required = false;
		}
		
		$this->max = 1000;
		
		$this->captionexists = false;
	}
	
	function setPath($tmp_path) {
		$this->path = "../../../" . $tmp_path;
	}
	
	function setTmpPath($tmp_path) {
		$this->path_tmp = "../../../" . $tmp_path;
	}
	
	function addThumb($tmp_name, $tmp_w = 0, $tmp_h = 0, $tmp_method = 0) {
		$thumb = array();
		
		$thumb["name"] = $tmp_name;
		$thumb["w"] = $tmp_w;
		$thumb["h"] = $tmp_h;
		$thumb["method"] = $tmp_method;
		
		$this->thumbs[] = $thumb;
	}
	
	function setConfigImage($tmp_tableimage,$tmp_fieldsrel,$tmp_captionexists = true,$tmp_indeximage = 'id',$tmp_nameimage = 'nome',$tmp_captionimage = 'legenda',$tmp_orderimage = 'ordem') {
		$this->arr_fieldsimage = array();
		$this->tableimage = $tmp_tableimage;
		$this->fieldsrel = $tmp_fieldsrel;
		$this->captionexists = $tmp_captionexists;		
		$this->indeximage = $tmp_indeximage;
		$this->nameimage = $tmp_nameimage;
		
		$this->arr_fieldsimage['totalimagens'] = 0;
		if ($tmp_captionexists) {
			$this->captionimage = $tmp_captionimage;
			$this->orderimage = $tmp_orderimage;
		} else {
			$this->captionimage = '';
			$this->orderimage = '';
		}
	}
	
	//private functions		
	function getInput() {
		global $routine;

		$required_backup = $this->is_required;
		$label_backup = $this->label;

		$this->is_required = false;
		$this->label = rand(1, 100000000);
		$html = '';

		$html = "
			<script type='text/javascript'>
				var uploader = new multiUpload('uploader', 'uploader_files', {
					multi:          true,
					caption: ".(($this->captionexists)?'true':'false').",
					order: ".(($this->orderimage != '')?'true':'false').",
					fileDescription: 'Extensões limitadas (.".implode(",.", $this->extensions_accept).")',
					fileExtensions:  '*.".implode(";*.", $this->extensions_accept)."',
					maximage: ".$this->max.",
					auto: true,					
					data: {
						menu: menu,
						routine: routine,
						routine_field:'upload',
						name: '".$this->name."',
						tmp_id: tmp_id,
						id: id,
						random: Math.round(Math.random() * 999999)								
					 }
				});
			</script>			
			";		
		$html .= "
		<input type='hidden' name='total_imagem' id='Total Imagens_HDN0' value='0' />
		<table class='topoupload'>
			<tr>
				<td><div id='uploader'></div></td>
				<td align='right' style='padding-right:15px;'><a href='javascript:uploader.onClearAll();'><img src='../inc/multiupload/bt_excluirtodas.jpg' alt='Excluir todas' title='Excluir todas' /></a></td>
			</tr>
		</table>
		<div class='divisor'></div>
		<div class='headertable'>
			<div class='bold uploadimagem'>Imagem</div>
			<div class='bold uploadarquivo'>Arquivo</div>
			<div class='ac bold uploadtamanho'>Tamanho</div>";		
			if ($this->captionexists) {
				$html .= '<div class="bold uploadlegenda">Legenda</div>';
			}
			
			if ($this->orderimage != '') {
				$html .= '<div class="c70p ac bold">Ordem</div>';
			}
			$html .= "
			<div class='c70p ac bold'>Excluir</div>
		</div>
		<div id='uploader_files'>			
			<div id='files_list'>";
			if ($routine == 'update') {				
				$html .= $this->getImageList();
			}			
			$html .= "</div>
		</div>
		<div class='divisor'></div>
		<div style='padding:4px;height:20px;'>
			<div style='float:left;'><a href='javascript:uploader.clearUploadQueue();'><img src='../inc/multiupload/bt_desfazerupload.jpg' alt='Desfazer upload' title='Desfazer upload' /></a></div>
			<div style='float:right;width:108px;'>Total de imagens: <span id='totalimagens'>".$this->arr_fieldsimage['totalimagens']."</span></div>
			<div style='float:right;width:140px;'>Imagens adicionadas: <span id='totalupload'>0</span></div>
		</div>
		";
		$this->is_required = $required_backup;
		$this->label = $label_backup;

		return $html;
	}
	
	function findListImage() {
		global $db;
		global $form;
		
		if ($this->orderimage != '') {
			$orderby = " ORDER BY " . $this->orderimage;
		} else {
			$orderby = " ORDER BY " . $this->indeximage;
		}
		
		$sql = "SELECT * FROM ".$this->tableimage . " WHERE ".$this->fieldsrel ." = ".$form->fields('id') . $orderby;
		return $db->execute($sql);
	}
	
	function getImageList() {
		global $file;
		
		$html = '';

		$path = $this->_getPath();		
		
		$css = 1;
		$contador = 0;
		
		
		if ($this->tableimage != '') {
			$rowsImagem = $this->findListImage();			
			while(!$rowsImagem->EOF) {
					$this->arr_fieldsimage = $rowsImagem->fields;
				
					$arquivo = str_replace("../", "",$this->_findFile($path.$this->_getFile($rowsImagem->fields('id'))));
					
					$html .= '
						<div class="linhaupload linhatable'.$css.'" id="table_file_'.$rowsImagem->fields('id').'">
							<table cellpadding="0" cellspading="0" style="padding-left:10px;">
								<tr>
									<td id="div_table_imagem_'.$rowsImagem->fields('id').'" class="uploadimagem"><input type="hidden" value="'.$rowsImagem->fields('id').'" name="table_idimagem_'.$rowsImagem->fields('id').'"><img src="../../_system/scripts/image.php?w=100&amp;h=80&amp;resize=4&amp;file='.$arquivo.'&amp;rd='.rand(0,50000).'" /></td>
									<td class="uploadarquivo" style="overflow:hidden;"><div class="uploadarquivo" style="overflow:hidden;">'.basename($arquivo).'<br /><a href="javascript:abreimagem(\''.$arquivo.'\');" >visualizar</a></div></td>
									<td class="uploadtamanho ac">'.$file->fileSizeFormated('../../../'.$arquivo).'</td>';
									if ($this->captionexists) {
										$html .= '<td class="uploadlegenda"><input type="text" style="width: 210px;" class="input" id="Legenda Imagem Alterar '.$rowsImagem->fields('id').'_TXT0" value="'.$rowsImagem->fields($this->captionimage).'" name="table_legendaimagem_'.$rowsImagem->fields('id').'"></td>';
									}									
									if ($this->orderimage != '') {							
										$html .= '<td class="c70p ac"><input type="text" style="width: 30px; text-align: center;" name="table_ordemimagem_'.$rowsImagem->fields('id').'" id="Ordem Imagem Alterar '.$rowsImagem->fields('id').'_NUM0" value="'.$rowsImagem->fields($this->orderimage).'" class="input"></td>';
									}
									$html .= '<td class="c70p ac"><a id="table_removeImagem_'.$rowsImagem->fields('id').'" href="javascript:uploader.removeUpload('.$rowsImagem->fields('id').',\'update\');"><img src="../inc/multiupload/bt_excluir.jpg" alt="X" title="Excluir" /></a></td>									
								</tr>
							</table>
						</div>';
				$css = 3 - $css;
				$contador++;
				$rowsImagem->moveNext();
			}
		} else {
			$arr_list = $this->_getListFiles();
			$html .= '<input type="hidden" name="totalimagens_upload" value="'.count($arr_list).'">';
			for($x=0,$total=count($arr_list);$x<$total;$x++) {
				$arquivo = str_replace("../", "",$arr_list[$x][0]);
				
				$html .= '
					<div class="linhatable'.$css.'" style="border-bottom:3px solid #FFFFFF;padding-top:3px;padding-bottom:3px;width:100%;" id="table_file_'.$x.'">
						<table cellpadding="0" cellspading="0" style="padding-left:10px;">
							<tr>
								<td id="div_table_imagem_'.$x.'" class="uploadimagem">
									<input type="hidden" value="'.$arquivo.'" name="table_idimagem_'.$x.'">
									<img src="../../_system/scripts/image.php?w=100&amp;h=80&amp;resize=4&amp;file='.$arquivo.'&amp;rd='.rand(0,50000).'" />
								</td>
								<td class="uploadarquivo" style="overflow:hidden;">
									<div class="uploadarquivo" style="overflow:hidden;">
										'.basename($arquivo).'<br />
										<a href="javascript:abreimagem(\''.$arquivo.'\');">visualizar</a>
									</div>
								</td>
								<td class="uploadtamanho ac">'.$file->fileSizeFormated('../../../'.$arquivo).'</td>
								<td class="c70p ac">
									<a id="table_removeImagem_'.$x.'" href="javascript:uploader.removeUpload('.$x.',\'update\');"><img src="../inc/multiupload/bt_excluir.jpg" alt="X" title="Excluir" /></a>
								</td>
							</tr>
						</table>
					</div>';				
				$contador++;
			}
		}
		
		$this->arr_fieldsimage['totalimagens'] = $contador;
		
		return $html;
	}
	
	
	function getHtml() {
		global $routine;
		global $form;
		
		$html = "<tr>";
		
		//Label
		if ($this->label != "") {
			$html .= "<td class='label'>";
			
			$html .= $this->label . ": ";
			
			if ($this->is_required) {
				$html .= "<font class='red'>*</font>";
			}
			
			$html .= "</td>" . LF;
		}
		
		$this->formatValue();
		
		//Input
		$html .= "<td class='input' style='background-color:#F5F5F5;padding:0px;'>";
		
		if ($this->is_static) {
			error(1, "Um campo 'upload' não pode ser estático.", "FieldMultiUpload", "getHtml");
		}
		
		$html .= $this->getInput();

		
		$html .= "</td></tr>" . LF;
		
		return $html;
	}
	
	function insertCaption($index) {
		global $input;
		global $db;
		global $form;
		global $file;
		global $load;
		$load->system('functions/text.php');
		
		$this->arr_fieldsimage = array(); // Usado para quando for nomear a imagem. Quando tiver "#NOME#", "#ID#"
		$this->arr_fieldsimage[$this->fieldsrel] = $form->fields('id');
		$arr_aux = explode('.',$input->post('nomeimagem_'.$index));
		unset($arr_aux[count($arr_aux)-1]);
		$this->arr_fieldsimage[$this->nameimage] = formatNameFile(implode('.',$arr_aux));
		
		if ($this->captionexists) {
			$this->arr_fieldsimage[$this->captionimage] = $input->post('legendaimagem_'.$index);
			$this->arr_fieldsimage[$this->orderimage] = $input->post('ordemimagem_'.$index,false,'int');
			
			$sql = "INSERT INTO " . $this->tableimage . " (".$this->fieldsrel.",".$this->nameimage.",".$this->captionimage.",".$this->orderimage.") VALUES (".$form->fields('id').",'".$this->arr_fieldsimage[$this->nameimage]."','".$input->post('legendaimagem_'.$index)."','".$input->post('ordemimagem_'.$index,false,'int')."')";
		} elseif ($this->orderimage != '') {
			$this->arr_fieldsimage[$this->orderimage] = $input->post('ordemimagem_'.$index,false,'int');
			
			$sql = "INSERT INTO " . $this->tableimage . " (".$this->fieldsrel.",".$this->nameimage.",".$this->orderimage.") VALUES (".$form->fields('id').",'".$this->arr_fieldsimage[$this->nameimage]."','".$input->post('ordemimagem_'.$index,false,'int')."')";
		} else {
			$sql = "INSERT INTO " . $this->tableimage . " (".$this->fieldsrel.",".$this->nameimage.") VALUES (".$form->fields('id').",'".$this->arr_fieldsimage[$this->nameimage]."')";
		}
		$db->execute($sql);
		
		$this->arr_fieldsimage[$this->indeximage] = mysql_insert_id();
		
		return $this->arr_fieldsimage[$this->indeximage];
	}
	
	function checkNameFile($filename,$extension) {
		$path = $this->_getPath();
		
		$arquivo = $path . $filename . '.' . $extension;
		
		$contador = 0;
				
		while(file_exists($arquivo)) {
			$contador++;
			
			$arquivo = $path . $filename . '_' . $contador . '.' . $extension;
		}
		
		if ($contador == 0) {
			return $filename;
		} else {
			$this->arr_fieldsimage[$this->nameimage] = $contador . '_' .$this->arr_fieldsimage[$this->nameimage];
			return $filename . '_' . $contador;
		}
	}
	
	function onPosPost() {
		global $routine;
		global $file;
		global $form;
		global $input;
		global $db;
				
		// Alteração
		$this->_alterImagePosPost();
		
		// Novas imagens
		$this->_insertImagePosPost();
		
		//delete old files from tmp folder
		$this->_clearTmp();		
	}
	
	function _alterImagePosPost() {
		global $input;
		global $db;
		global $file;
		
		// Busca imagens da pasta TMP
		$path = $this->_getPath();
			
		if ($this->tableimage != '') {
			$rowsListaImagem = $this->findListImage();			
			
			while (!$rowsListaImagem->EOF) {
					$sql = '';
					
					$this->arr_fieldsimage = $rowsListaImagem->fields;					
				
					if ($input->post('table_idimagem_'.$rowsListaImagem->fields('id')) != '') {
						if ($this->captionexists) {
							$sql = "UPDATE " . $this->tableimage . " SET ".$this->captionimage."='".$input->post('table_legendaimagem_'.$rowsListaImagem->fields('id'))."',".$this->orderimage."=0".$input->post('table_ordemimagem_'.$rowsListaImagem->fields('id'))." WHERE id = " . $rowsListaImagem->fields('id');
						} elseif($this->orderimage != '') {
							$sql = "UPDATE " . $this->tableimage . " SET ".$this->orderimage."=0".$input->post('table_ordemimagem_'.$rowsListaImagem->fields('id'))." WHERE id = " . $rowsListaImagem->fields('id');
						}
					} else {
						foreach ($this->thumbs as $k => $v) {
							$file->deleteFile($this->_findFile($path . $this->_getFile($rowsListaImagem->fields('id'),$k)));
						}
						
						
						$sql = "DELETE FROM " . $this->tableimage . " WHERE id = " . $rowsListaImagem->fields('id');
					}
					
					if ($sql != '') {
						$db->execute($sql);
					}
				$rowsListaImagem->moveNext();
			}
		} else {
			$arr_list = $this->_getListFiles();
	
			$arr_aux = array();
			for($x=0,$total=count($arr_list);$x<$total;$x++) {
				$arr_aux[$arr_list[$x][0]] = $x;
			}
			
			for($x=0,$total=$input->post('totalimagens_upload');$x<$total;$x++) {
				unset($arr_aux['../../../'.$input->post('table_idimagem_'.$x)]);
			}

			foreach($arr_aux as $indice) {
				for($x=0,$total=count($arr_list[$indice]);$x<$total;$x++) {
					$file->deleteFile($arr_list[$indice][$x]);
				}				
			}
			
			$this->_sortFiles();
		}
	}
	
	function _insertImagePosPost() {
		global $input;
		global $file;
		global $db;
		
		// Busca imagens da pasta TMP
		$path = $this->_getPath();
		
		for($x=1,$total=$input->post('total_imagem',false,'int');$x<=$total;$x++) {
			if ($input->post('caminhoimagem_'.$x) != '') {
				$arr_images = explode('###',$input->post('caminhoimagem_'.$x));
				
				// Insere a legenda e ordem, caso tenha
				if ($this->tableimage != '') {
					$idimage = $this->insertCaption($x);
				} else {
					$idimage = $this->max - $x;
				}			
				
				for($i=0,$totalimagens=count($arr_images);$i<$totalimagens;$i++) {
					$tmp_image = "../../../" . $arr_images[$i];
					
					if (file_exists($tmp_image)) {
						$ext = $file->getExtension($tmp_image);
						
						$filename = $this->_getFile($idimage,$i);
						$new_filename = $this->checkNameFile($filename,$ext);
						
						$file->copyFile($tmp_image, $path . $new_filename . "." . $ext);
						
						$file->deleteFile($tmp_image);
						
						if ($filename != $new_filename) {
							if ($this->tableimage != '') {
								$sql = "UPDATE ".$this->tableimage." SET ".$this->nameimage." = '".$this->arr_fieldsimage[$this->nameimage]."' WHERE ".$this->indeximage." = ".$idimage;
								$db->execute($sql);
							}					
						}
					}
				}
			}
		}
		
		// Insere a legenda e ordem, caso tenha
		if ($this->tableimage == '') {
			$this->_sortFiles();
		}	
	}
	
	function _clearTmp() {
		global $file;
		
		//delete old files from tmp folder
		$list = $file->listFolder($this->path_tmp);
		
		if (is_array($list)) {
			foreach ($list as $v) {
				$path = $this->path_tmp . $v;
				
				$arr2 = explode(".", $v);
				$arr = explode("_", $arr2[0]);
				$date_modified = (float)$arr[1];
				
				//2 hours limit
				if (time() > ($date_modified + (2 * 60 * 60))) {
					$file->deleteFile($path);
				}
			}
		}
	}
	
	function onDelete() { //OK
		global $file;
		
		$path = $this->_getPath();
		
		for ($i = 1; $i < $this->max; $i++) {
			foreach ($this->thumbs as $k => $v) {
				$file->deleteFile($path . $this->_getFile($i, $k));
			}
		}
	}
	
	//Ajax functions
	function ajaxRoutine($tmp_routine) {
		global $file;
		global $routine;
		global $load;
		global $input;
	
		$html = "";
		
		switch ($tmp_routine) {
			case "upload":			
				if (array_key_exists('Filedata', $_FILES)) {
					$file_dest = $this->_getTempFile();
					
					$ext = $file->getExtension($_FILES['Filedata']["name"]);
					
					if (array_search($ext, $this->extensions_accept) !== false) {
						if (move_uploaded_file($_FILES['Filedata']["tmp_name"], $file_dest . "." . $ext)) {							
							$load->setOverwrite(true);
							$load->system("library/Image.php");
							
							$list = array();
							
							$img = new Image();
							$path = $file_dest . "." . $ext;
							$path_from = $path;
							
							foreach ($this->thumbs as $k => $v) {
								if ($k > 0) {
									$path = $this->_getTempFile($k) . "." . $ext;							
								}
								
								$img->load($path_from);
								
								$list[] = str_replace('../','',$path);
								
								$img->resize($v["w"], $v["h"], $v["method"]);
								
								$img->save($path);
							}
							
							$html = implode("###",$list);
						} else {
							$html = "ERRO: Erro ao fazer upload.";
						}
					} else {
						$html = "ERRO: Extensão não permitida.<br>Utilize somente '" . implode(", ", $this->extensions_accept) . "'";
					}
				}
				
				break;
			
		}
		
		
		
		return $html;
	}
	
	function _findFile($tmp_path) {
		foreach ($this->extensions_accept as $v) {
			$file_path = $tmp_path . "." . $v;
			
			if (file_exists($file_path)) {
				return $file_path;
			}
		}
		
		return '';
	}
	
	function _sortFiles() { //Test
		global $file;
		
		$list = $this->_getListFiles();
		
		$i = 1;
		foreach ($list as $v) {
			foreach ($v as $k => $v2) {
				$file->rename($v[$k],$this->_getPath().$this->_getFile($i, $k).'.'.$file->getExtension($v[$k]));
			}
			
			$i++;
		}
	}
	
	function _getTempFile() { //OK
		global $file;
	
		$file_name = substr("00000" . rand(1, 999999), -6) . "_" . time();
		
		$exists = false;
		
		foreach ($this->extensions_accept as $v) {
			if (file_exists($this->path_tmp . $file_name . "." . $v)) {
				$exists = true;
			}
		}
		
		if ($exists) {
			$file_name = $this->_getTempFile();
		}
		
		
		//create tmp folder(s)
		$arr = explode("/", $this->path_tmp);
		$path = "";
		foreach ($arr as $name) {
			if (strlen($name) > 0) {
				$path .= $name . "/";
				
				if (substr($path, -3) != "../") {
					$file->makeFolder($path);
				}
			}
		}
		
		return $this->path_tmp . $file_name;
	}
	
	function _getNewNumberFile() { //OK
		$path = $this->_getPath();
		
		$r = 1;
		$ok = false;
		for ($i = 1; $i < $this->max; $i++) {
			$arq = $path . $this->_getFile($i);
			
			$r = $i;
			
			foreach ($this->extensions_accept as $v) {
				if (!file_exists($arq . "." . $v)) {
					$ok = true;
				}
			}
			
			if ($ok) {
				break;
			}
		}
		
		return $r;
	}
	
	function _getListFiles() { //OK
		global $file;
		
		$path = $this->_getPath();
		
		$list = array();
		
		for ($i = 1; $i < $this->max; $i++) {
			$imgs = array();
			
			$img = $this->_getFile($i);
			$img_ext = "";
			foreach ($this->extensions_accept as $v) {
				if (file_exists($path . $img . "." . $v)) {
					$img_ext = $v;
					
					break;
				}
			}
			
			if ($img_ext != "") {
				foreach ($this->thumbs as $k => $v) {
					$imgs[] = $path . $this->_getFile($i, $k) . "." . $img_ext;
				}
				
				$list[] = $imgs;
			}
		}
		
		return $list;
	}
		
	function _getFile($tmp_n = 1, $tmp_thumb = 0) { //OK
		$file_name = $this->thumbs[$tmp_thumb]["name"];
		
		$file_name = str_replace("#N#", $tmp_n, $file_name);
		
		if (isset($this->arr_fieldsimage)) {
			foreach ($this->arr_fieldsimage as $k => $v) {
				$file_name = str_replace("#" . strtoupper($k) . "#", $v, $file_name);
			}
		}
			
		return $file_name;
	}
	
	function _getPath() { //OK
		global $form;
		global $file;
		
		$path = $this->path;
		
		foreach ($form->fields as $k => $v) {
			$path = str_replace("#" . strtoupper($k) . "#", $v, $path);
		}
		
		//create folder(s)
		$arr = explode("/", $path);
		$path = "";
		foreach ($arr as $name) {
			if (strlen($name) > 0) {
				$path .= $name . "/";
				
				if (substr($path, -3) != "../") {
					$file->makeFolder($path);
				}
			}
		}
		
		return $path;
	}
}
?>