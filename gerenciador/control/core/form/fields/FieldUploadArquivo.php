<?php
class FieldUploadArquivo extends Field {
	var $path;
	var $file_name;
	
	var $extensions_accept;
	
	var $path_tmp;
	
	function FieldUploadArquivo($tmp_params) {
		parent::Field("uploadArquivo", $tmp_params[0]);
		
		$this->flags_accept = "LIU";
		
		$this->label = $tmp_params[1];
		$this->validation = "TXT";
		$this->is_sql_affect = false;
		
		$this->file_name = "";
		$this->extensions_accept = array("txt", "php");
		
		if (isset($tmp_params[2])) {
			$this->setPath($tmp_params[2]);
		}
		
		if (isset($tmp_params[3])) {
			$this->setFileName($tmp_params[3]);
		}
		
		$this->setTmpPath("upload/tmp/");
		
		global $routine;
		if ($routine == "update") {
			$this->is_required = false;
		}
	}
	
	function setPath($tmp_path) {
		$this->path = "../../../" . $tmp_path;
	}
	
	function setTmpPath($tmp_path) {
		$this->path_tmp = "../../../" . $tmp_path;
	}
	
	function setFileName($tmp_template) {			
		$this->file_name = $tmp_template;
	}
	
	
	//private functions	
	function getInput() {
		$required_backup = $this->is_required;
		$label_backup = $this->label;
		
		$this->is_required = false;
		$this->label = rand(1, 100000000);
	
		$html = "<input ";
		$html .= "class='input' ";
		$html .= "type='file' ";
		$html .= "id='" . $this->_getFormatedId() . "' ";
		$html .= "name='" . $this->name . "' ";
		$html .= "style='width: 230px;' ";
		$html .= ">";
		$html .= "<a href='javascript:void(0);' onclick=\"javascript: uploadSubmit('" . $this->name . "')\">upload</a>";
		
		$this->is_required = $required_backup;
		$this->label = $label_backup;
		
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
		$html .= "<td class='input'>";
		
		if ($this->is_static) {
			error(1, "Um campo 'upload' não pode ser estático.", "FieldUpload", "getHtml");
		}
		
		//.input
		$html .= "<div id='" . $this->name . "_div_input' class='box_silver'>";
		$html .= $this->getInput();
		$html .= "</div>";
		
		//.loading message
		$html .= "<div id='" . $this->name . "_div_loading' class='box_silver' style='display: none; height: 15px; margin-top: 5px;'>Carregando...</div>";
		
		//.error box
		$html .= "<div id='" . $this->name . "_div_error' class='box_red' style='display: none; height: 20px; margin-top: 5px;'></div>";
		
		//.list
		if (IS_DEVELOP) {
			$html .= "<a href='javascript:void(0);' onclick=\"javascript: uploadList('" . $this->name . "');\">refresh list</a><br>";
		}
		$html .= "<table width='100%' style='margin-top: 5px;'><tr><td class='box_yellow' id='" . $this->name . "_div_list' style='display: none;'></td></tr></table>";		
		
		//.list of tmp files
		if ($routine == "insert") {
			$html .= "<input type='hidden' id='" . $this->_getFormatedId() . "' value=''>";
		}
		
		//.if update, upload list of files
		if ($routine == "update") {
			$html .= "<script>uploadList('" . $this->name . "');</script>";
		} 
		
		$html .= "</td></tr>" . LF;
		
		return $html;
	}
	
	function onPosPost() {		
		global $routine;
		global $file;
		global $form;
		global $input;
		
		if ($routine == "insert") {
			if (!is_dir($this->path.$form->fields('id').'/')) {
				mkdir($this->path.$form->fields('id').'/',0777);
			}
		
			$file_tmp = $input->session($this->name . "_file");
			
			$i = 1;
			if ($file_tmp != "") {
				if (file_exists($file_tmp)) {
					$ext = $file->getExtension($file_tmp);
					
					$file->copyFile($file_tmp, $this->path . $this->_getFile() . "." . $ext);
					//echo $file_tmp . " --- " . $this->path . $this->_getFile() . "." . $ext;
					//die();
					
					
					$file->deleteFile($file_tmp);
					
					$i++;
				}
			}
			
			$input->unsetSession($this->name . "_file");
		}
	}
	
	function onDelete() {
		global $file;
		
		$this->_deleteFile($this->path . $this->_getFile());
	}
	
	//Ajax functions
	function ajaxRoutine($tmp_routine) {
		global $file;
		global $routine;
		global $input;
	
		$html = "";
		
		switch ($tmp_routine) {
			case "upload":
				if ($routine == "insert") {
					$file_dest = $this->_getTempFile();
				} else {
					$file_dest = $this->path . $this->_getFile();
				}
				
				$this->_deleteFile($path);
				
				$ext = $file->getExtension($_FILES[$this->name]["name"]);
				
				if (array_search($ext, $this->extensions_accept) !== false) {
					if (move_uploaded_file($_FILES[$this->name]["tmp_name"], $file_dest . "." . $ext)) {
						$html .= "<script>";
						$html .= "window.parent.document.getElementById('" . $this->name . "_div_error').style.display = 'none';" . LF;
						
						if ($routine == "insert") {
							$html .= "window.parent.document.getElementById('" . $this->_getFormatedId() . "').value = '" . $file_dest . "." . $ext . "';";
							
							$_SESSION[$this->name . "_file"] = $file_dest . "." . $ext;
						}
						
						$html .= "</script>";
					} else {
						$html .= "<script>";
						$html .= "window.parent.document.getElementById('" . $this->name . "_div_error').style.display = '';" . LF;
						$html .= "window.parent.document.getElementById('" . $this->name . "_div_error').innerHTML = 'Erro ao fazer upload.';" . LF;
						$html .= "</script>";
					}
				} else {
					$html .= "<script>";
					$html .= "window.parent.document.getElementById('" . $this->name . "_div_error').style.display = '';" . LF;
					$html .= "window.parent.document.getElementById('" . $this->name . "_div_error').innerHTML = \"Extensão não permitida.<br>Utilize somente '" . implode(", ", $this->extensions_accept) . "'\";" . LF;
					$html .= "</script>";
				}
				
				break;
			case "list":	
				if ($routine == "insert") {
					$path = $_SESSION[$this->name . "_file"];
				} else {
					$path = $this->_findFile($this->path . $this->_getFile());
				}
				
				if ($path != "") {
					$path_clean = str_replace("../../../", "", $path);
					
					$html .= "<div class='upload_item'>";
					$html .= "<div class='label'><a href='../../_system/scripts/download.php?file=" . $path_clean . "' target='ifr_aux'>" . $path_clean . "</a></div>";
					$html .= "<div class='buttons'><a href='javascript:void(0);' onclick=\"uploadDelete('" . $this->name . "');\">del</a></div>";
					$html .= "</div>";
					
					$html .= "<script>" . LF;
					$html .= "document.getElementById('" . $this->name . "_div_input').style.display = 'none';" . LF;
					$html .= "document.getElementById('" . $this->name . "_div_list').style.display = '';" . LF;
					$html .= "</script>";
				} else {
					$html .= "<script>" . LF;
					$html .= "document.getElementById('" . $this->name . "_div_input').style.display = '';" . LF;
					$html .= "document.getElementById('" . $this->name . "_div_input').innerHTML = '" . str_replace("'", "\'", $this->getInput()) . "';" . LF;
					$html .= "document.getElementById('" . $this->name . "_div_list').style.display = 'none';" . LF;
					$html .= "</script>";
				}
				
				break;
			case "delete":
				if ($routine == "insert") {
					$file_name = $input->session($this->name . '_file');
					$file->deleteFile($file_name);
					$input->unsetSession($this->name . '_file');
				} else {
					$file_name = $this->_getFile();
					$this->_deleteFile($this->path . $file_name);
				}
				
				$html .= $this->path . $file_name . "<br>\r\n";
				
				$html .= "<script>uploadList('" . $this->name . "');</script>";
				
				break;
		}
		
		return $html;
	}
	
	function _getTempFile() {
		global $file;
	
		$file_name = substr("00000" . rand(1, 999999), -6);
		
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
	
	function _getFile() {
		global $form;
		
		global $rs_list;
		if (is_object($rs_list)) {
			$form = $rs_list;
		}
		
		$file_name = $this->file_name;
		
		foreach ($form->fields as $k => $v) {
			$file_name = str_replace("#" . strtoupper($k) . "#", $v, $file_name);
		}
		
		return $file_name;
	}
	
	function _deleteFile($tmp_path) {
		global $file;
		
		foreach ($this->extensions_accept as $v) {
			$path = $tmp_path . "." . $v;
			
			if (file_exists($path)) {
				$file->deleteFile($path);
			}
		}
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
}
?>