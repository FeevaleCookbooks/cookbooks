<?php
class Upload{
	var $file; // Arquivo
	var $extension; // Extensão do arquivo
	var $namefile; // Novo nome do arquivo
	var $nameinput; // Nome do campo para fazer upload
	var $folderfile; // Pasta onde o arquivo será salvo
	
	var $arr_extension; // Array com as permissões permitidas
	var $maxsizefile; // Tamanho maximo do arquivo para download
	
	var $error; // Variável de retorno de erro
	
	function Upload($nameinput,$folderfile,$arr_extensipermition) {
		$this->error = '';
		$this->namefile = '';
		
		$this->nameinput = $nameinput;
		
		$this->setExtensionPermision($arr_extensipermition);
		
		$this->maxsizefile = 0;
		
		$this->setFolder($folderfile);
	}
	
	// Seta a pasta, e se ela não existir, tenta cria-la. Caso não consiga criar, retorna false.
	function setFolder($folderfile) {
		global $file;
		
		if (!is_dir($folderfile)) {
			if (!$file->makeFolder($folderfile)) {
				$this->error = "Não foi possivel criar a pasta.";
				return false;
			}
		}
		
		if ($folderfile != '') {
			if (substr($folderfile, -1) != '/') {
				$folderfile . '/';
			}
		}
			
		$this->folderfile = $folderfile;
				
		return true;
	}
	
	function checkExtension() {
		return in_array($this->extension, $this->arr_extension);
	}
	
	// Seta as extensões permitidas
	function setExtensionPermision($arr_extensipermition) {
		$this->arr_extension = $arr_extensipermition;
	}

	function setExtension($namefile) {
		global $file;
		
		$this->extension = $file->getExtension($namefile);
	}
	
	function setNameFile($namefile,$index = 1) {
		$namefile = $this->cleanName($namefile);
		
		if ($namefile != '') {
			if (!file_exists($this->folderfile . $namefile.'.'.$this->extension)) {
				$this->namefile = $namefile . '.' . $this->extension;
			} else {
				$this->setNameFile($namefile . '_'.$index,$index+1);
			}
		} else {
			$this->setNameFile(substr(md5(time()),-15));
		}
	}
	
	function setNameFileByFileUpload($namefile) {
		if ($namefile != '') {
			$arr_arquivo = explode(".",$namefile);
			unset($arr_arquivo[sizeof($arr_arquivo)-1]);
			
			$namefile = implode(".",$arr_arquivo);
			
			$this->setNameFile($namefile);
		} else {
			$this->error = "Não foi possivel fazer o upload do arquivo pois o nome do arquivo está vazio.";
			return false;
		}
	}
		
	function cleanName($namefile) {
		global $load;
		$load->system("functions/text.php");
		
		return formatNameFile($namefile);
	}
	
	
	function uploadFile($newname = '') {
		if ($this->error != '') {
			return false;
		}
		
		$arr_file = $_FILES[$this->nameinput];
		
		if (($arr_file['tmp_name'] != '') && ($arr_file['tmp_name'] != 'none') && ($arr_file['name'] != '')) {
			if ($this->maxsizefile > 0) {
				if ($arr_file['size'] > $this->maxsizefile) {
					$this->error = "Arquivo maior que tamanho máximo.";
					return false;
				}
			}
			
			$this->setExtension($arr_file['name']);			
			
			if ($this->checkExtension()) {
				if ($this->namefile == '') {
					if ($newname != '') {
						$this->setNameFile($newname);
					} else {
						$this->setNameFileByFileUpload($arr_file['name']);
					}
				}				
				
				if (!move_uploaded_file($arr_file['tmp_name'],$this->folderfile.$this->namefile)) {
					$this->error = "Erro para fazer o upload.";
					return false;
				}
			} else {
				$this->error = "Extensão não permitida.";
				return false;
			}
		} else {
			$this->error = "Não foi possivel fazer o upload do arquivo pois o campo está vazio.";
			return false;
		}
		
		return true;
	}
	
	
}
?>