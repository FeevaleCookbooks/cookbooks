<?php
class FieldImageUpload extends Field {
	var $path;
	var $thumbs;
	
	var $extensions_accept;
	
	var $path_tmp;
	
	function FieldImageUpload($tmp_params) {
		parent::Field("imageUpload", $tmp_params[0]);
		
		$this->flags_accept = "LIU";
		
		$this->label = $tmp_params[1];
		$this->validation = "TXT";
		$this->is_sql_affect = false;
		
		$this->extensions_accept = array("jpg", "gif");
		
		if (isset($tmp_params[2])) {
			$this->setPath($tmp_params[2]);
		}
		
		$this->setTmpPath("upload/tmp/");
		
		global $routine;
		if ($routine == "update") {
			$this->is_required = false;
		}
		
		$this->list_width = 70;
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
	
	
	//private functions	
	function getHtmlList($tmp_extra) {
		$this->formatValue();
		
		$path = $this->_findFile($this->path . $this->_getFile());
		$path_clean = str_replace("../../../", "", $path);
		
		if (file_exists($path)) {
			$v = "<center><img style='margin: 3 0 3 0px;' src='../../_system/scripts/image.php?file=" . $path_clean . "&w=60&h=60&rand=" . rand(1, 9999) . "'></center>";
		} else {
			$v = "<font color='silver'>(sem imagem)</font>";
		}
		
		$html = "<td " . $tmp_extra . ">" . $v . "</td>" . LF;
		
		return $html;
	}
	
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
			$list = $input->session($this->name . "_files");
			
			if (is_array($list)) {
				$i = 1;
				foreach ($list as $v) {
					if (file_exists($v)) {
						$ext = $file->getExtension($v);
						
						$file->copyFile($v, $this->path . $this->_getFile($i - 1) . "." . $ext);
						
						$file->deleteFile($v);
						
						$i++;
					}
				}
			}
			
			$input->unsetSession($this->name . "_files");
		}
	}
	
	function onDelete() {
		global $file;
		
		$list = array();
		foreach ($this->thumbs as $k => $v) {
			$file->deleteFile($this->_findFile($this->path . $this->_getFile($k)));
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
				if ($routine == "insert") {
					$file_dest = $this->_getTempFile();
				} else {
					$file_dest = $this->path . $this->_getFile();
				}
				
				foreach ($this->extensions_accept as $v) {
					$tmp_path = $path . "." . $v;
					
					if (file_exists($tmp_path)) {
						$file->deleteFile($tmp_path);
					}
				}
				
				$ext = $file->getExtension($_FILES[$this->name]["name"]);
				
				if (array_search($ext, $this->extensions_accept) !== false) {
					if (move_uploaded_file($_FILES[$this->name]["tmp_name"], $file_dest . "." . $ext)) {
						$html .= "<script>";
						$html .= "window.parent.document.getElementById('" . $this->name . "_div_error').style.display = 'none';" . LF;
						
						if ($routine == "insert") {
							$html .= "window.parent.document.getElementById('" . $this->_getFormatedId() . "').value = '" . $file_dest . "." . $ext . "';";
							
							$_SESSION[$this->name . "_files"] = array();
						}
						
						$load->setOverwrite(true);
						$load->system("library/Image.php");
						
						$img = new Image();
						$path = $file_dest . "." . $ext;
						$path_from = $path;
						foreach ($this->thumbs as $k => $v) {
							if ($k > 0) {
								if ($routine == "insert") {
									$path = $this->_getTempFile($k) . "." . $ext;
								} else {
									$path = $this->path . $this->_getFile($k) . "." . $ext;
								}
							}
							
							$img->load($path_from);
							
							if ($routine == "insert") {
								$_SESSION[$this->name . "_files"][] = $path;
							}
							
							$img->resize($v["w"], $v["h"], $v["method"]);
							
							$img->save($path);
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
					$path = $_SESSION[$this->name . "_files"][0];
				} else {
					$path = $this->_findFile($this->path . $this->_getFile());
				}
				
				if ($path != "") {
					$path_clean = str_replace("../../../", "", $path);
					
					$html .= "<div class='upload_item'>";
					$html .= "<div class='label'><img src='../../_system/scripts/image.php?file=" . $path_clean . "&w=60&h=60&rand=" . rand(1, 9999) . "'></div>";
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
					$list = $_SESSION[$this->name . "_files"];
				} else {					
					$list = array();
					foreach ($this->thumbs as $k => $v) {
						$list[] = $this->_findFile($this->path . $this->_getFile($k));
					}					
				}
				
				foreach ($list as $v) {
					echo $v;
					$file->deleteFile($v);
				}
				
				$input->unsetSession($this->name . "_files");
				
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
	
	function _getFile($tmp_thumb = 0) {
		global $form;
		
		$form2 = $form;
		
		global $rs_list;
		if (is_object($rs_list)) {
			$form2 = $rs_list;
		}
		
		$file_name = $this->thumbs[$tmp_thumb]["name"];
		
		foreach ($form2->fields as $k => $v) {
			$file_name = str_replace("#" . strtoupper($k) . "#", $v, $file_name);
		}
		
		return $file_name;
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