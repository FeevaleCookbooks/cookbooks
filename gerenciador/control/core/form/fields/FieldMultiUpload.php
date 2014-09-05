<?php
class FieldMultiUpload extends Field {
	var $path;
	var $file_name;
	
	var $extensions_accept;
	
	var $path_tmp;

	function FieldMultiUpload($tmp_params) {
		parent::Field("multiupload", $tmp_params[0]);
		
		$this->flags_accept = "IU";
		
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
		$html .= "<a href='#' onclick=\"javascript: uploadSubmit('" . $this->name . "')\">upload</a>";
		
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
		$html .= "<div id='" . $this->name . "_div_loading' class='box_silver' style='display: none; height: 15px; margin-top: 5px;'>Loading...</div>";
		
		//.error box
		$html .= "<div id='" . $this->name . "_div_error' class='box_red' style='display: none; height: 20px; margin-top: 5px;'></div>";
		
		//.list
		if (IS_DEVELOP) {
			$html .= "<a href='#' onclick=\"javascript: uploadList('" . $this->name . "');\">refresh list</a><br>";
		}
		$html .= "<table width='100%' style='margin-top: 5px;'><tr><td class='box_yellow' id='" . $this->name . "_div_list' style='display: none;'></td></tr></table>";		
		
		//.list of tmp files
		if ($routine == "insert") {
			$html .= "<input type='hidden' id='" . $this->_getFormatedId() . "' value=''>";
			
			$_SESSION[$this->name . "_files"] = array();
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
			$list = $input->session($this->name . "_files");
			
			if (is_array($list)) {
				$i = 1;
				foreach ($list as $v) {
					if (file_exists($v)) {
						$ext = $file->getExtension($v);
						
						$file->copyFile($v, $this->_getPath() . $this->_getFile($i) . "." . $ext);
						
						$file->deleteFile($v);
						
						$i++;
					}
				}
			}
			
			$input->unsetSession($this->name . "_files");
		}
		
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
	
	function onDelete() {
		global $file;
		
		//delete files
		$list = $this->_getListFiles();
		
		foreach ($list as $v) {
			$file->deleteFile($v);
		}
		
		//delete path if is empty
		$path = $this->_getPath();
		$list = $file->listFolder($path);
		
		if (sizeof($list) == 0) {
			
			$file->deleteFolder($path);
		}
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
					$file_dest = $this->_getNewFile();
				}
				
				$ext = $file->getExtension($_FILES[$this->name]["name"]);

				if (array_search($ext, $this->extensions_accept) !== false) {
					if (move_uploaded_file($_FILES[$this->name]["tmp_name"], $file_dest . "." . $ext)) {
						$html .= "<script>";
						$html .= "window.parent.document.getElementById('" . $this->name . "_div_error').style.display = 'none';" . LF;
						
						if ($routine == "insert") {
							$html .= "var n = window.parent.document.getElementById('" . $this->_getFormatedId() . "').value;";
							$html .= "n++; n--;";
							$html .= "window.parent.document.getElementById('" . $this->_getFormatedId() . "').value = (n + 1);";
							
							$_SESSION[$this->name . "_files"][] = $file_dest . "." . $ext;
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
					$list = $_SESSION[$this->name . "_files"];
				} else {
					$list = $this->_getListFiles();
				}
				
				if (sizeof($list) > 0) {
					$i = 1;
					foreach ($list as $v) {
						$path_clean = str_replace("../../../", "", $v);
						
						$html .= "<div class='upload_item'>";
						$html .= "<div class='label'>" . $i . ". <a href='../../_system/scripts/download.php?file=" . $path_clean . "' target='ifr_aux'>" . $path_clean . "</a></div>";
						$html .= "<div class='size'>" . $file->fileSizeFormated($v) . "</div>";
						$html .= "<div class='buttons'><a href=\"javascript: { uploadDelete('" . $this->name . "', '" . $i . "'); }\">del</a></div>";
						$html .= "</div>" . LF;
						
						$i++;
					}
					
					$html .= "<script>" . LF;
					$html .= "document.getElementById('" . $this->name . "_div_list').style.display = '';" . LF;
					$html .= "</script>";
				} else {
					$html .= "<script>" . LF;
					$html .= "document.getElementById('" . $this->name . "_div_list').style.display = 'none';" . LF;
					$html .= "</script>";
				}
				
				$html .= "<script>";
				$html .= "document.getElementById('" . $this->name . "_div_input').style.display = '';" . LF;
				$html .= "document.getElementById('" . $this->name . "_div_input').innerHTML = '" . str_replace("'", "\'", $this->getInput()) . "';" . LF;
				$html .= "</script>";
				
				break;
			case "delete":
				if ($routine == "insert") {
					$list = $_SESSION[$this->name . "_files"];
				} else {
					$list = $this->_getListFiles();
				}
				
				$file->deleteFile($list[($input->get("n",false,'int') - 1)]);
				
				if ($routine == "insert") {
					//unset file in session list
					$new_list = array();
					
					if (sizeof($list) > 1) {
						unset($_SESSION[$this->name . "_files"][($input->get("n",false,'int') - 1)]);
						
						$i = 1;
						foreach ($_SESSION[$this->name . "_files"] as $v) {
							echo $v;
							$new_list[$i] = $v;
							
							$i++;
						}
					}						
					
					$_SESSION[$this->name . "_files"] = $new_list;
				} else {
					$this->_sortFiles();
				}
				
				$html .= "<script>uploadList('" . $this->name . "');</script>";
				
				break;
		}
		
		return $html;
	}
	
	function _getTempFile() {
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
	
	function _getPath() {
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
	
	function _getFile($tmp_n = 1) {
		global $form;
		
		$f = $form;
		
		global $rs_list;
		if (is_object($rs_list)) {
			$f = $rs_list;
		}
		
		$file_name = $this->file_name;
		
		$file_name = str_replace("#N#", $tmp_n, $file_name);
		
		foreach ($f->fields as $k => $v) {
			$file_name = str_replace("#" . strtoupper($k) . "#", $v, $file_name);
		}
		
		return $file_name;
	}
	
	function _getListFiles() {
		global $file;
		
		$path = $this->_getPath();
		
		$list = $file->listFolder($path);
		
		foreach ($list as $k => $v) {
			$list[$k] = $path . $v;
		}
		
		return $list;
	}
	
	function _getNewFile($tmp_n = 1) {
		$file = $this->_getPath() . $this->_getFile($tmp_n);
		
		$exists = false;
		
		foreach ($this->extensions_accept as $v) {
			if (file_exists($file . "." . $v)) {
				$exists = true;
			}
		}
		
		if ($exists) {
			$file = $this->_getNewFile($tmp_n + 1);
		}
		
		return $file;
	}
	
	function _sortFiles() {
		global $file;
		
		$path = $this->_getPath();
		
		$list = $file->listFolder($path);
		
		$i = 1;
		$i2 = 1;
		foreach ($list as $v) {
			$ext = $file->getExtension($v);
			
			$file_name = $this->_getFile($i);
			
			$file->rename($path . $v, $path . $file_name . "." . $ext);
			
			$i++;
		}
	}
}
?>