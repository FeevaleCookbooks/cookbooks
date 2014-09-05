<?
class File {
	//TODO: Funções para tratar arquivos e pastas

	function getExtension($tmp_file) {
		$arr = explode(".", $tmp_file);
		
		return strtolower($arr[sizeof($arr) - 1]);
	}
	
	function getFileName($tmp_file) {
		return basename($tmp_file);
	}
	
	function rename($tmp_name, $tmp_new_name) {
		return @rename($tmp_name, $tmp_new_name);
	}
	
	function deleteFile($tmp_file) {
		return @unlink($tmp_file);
	}
	
	function makeFolder($tmp_folder) {
		$r = @mkdir($tmp_folder, 0777);
		
		$this->permission($tmp_folder);
		
		return $r;
	}
	
	function copyFile($tmp_path, $tmp_path_dest) {
		return copy($tmp_path, $tmp_path_dest);	
	}
	
	function listFolder($tmp_folder, $tmp_mask = "") {
		$r = array();
		
		$witout_mask = true;
		if ($tmp_mask != "") {
			$witout_mask = false;
		}
		
		if ($d = @dir($tmp_folder)) {
			while (false !== ($name = $d->read())) {
				if (($name != "Thumbs.db") && ($name != ".") && ($name != "..") && ((is_link($tmp_folder . $name)) || (is_file($tmp_folder . $name)) || (is_dir($tmp_folder . $name)))) {
					if (($witout_mask) || (strpos($name, $tmp_mask) !== false)) {
						$r[] = $name;
					}
				}
			}
		} else {
			$r = array();
		}
		
		return $r;
	}
	
	function fileSizeFormated($tmp_path) {
		$size = @filesize($tmp_path);
		
		$unitys = array("B", "KB", "MB", "GB");
		$unity = 0;
		
		while ($size > 1024) {
			$size = ($size / 1024);
			
			$unity++;
		}
		
		if ($size != round($size)) {
			$size = number_format($size, 1, ",", ".");
		}
		
		return $size . " " . $unitys[$unity];
	}
	
	function deleteFolder($tmp_folder) {
		$this->permission($tmp_folder);
	
		if (is_dir($tmp_folder)) {
			$list = $this->listFolder($tmp_folder);

			foreach ($list as $v) {
				if (is_dir($v)) {
					echo "recursive: " . $tmp_folder . $v . "/<br>";
					$this->deleteFolder($tmp_folder . $v . "/");
				} else {
					echo "delete file: " . $tmp_folder . $v . "<br>";
					$this->deleteFile($tmp_folder . $v);
				}
			}
			
			$this->permission($tmp_folder);
			$r = @rmdir($tmp_folder);
			
			return $r;
		} else {
			return false;
		}
	}
	
	function permission($tmp_path) {
		@chmod($tmp_path, 0777);
		@chown($tmp_path, 0);
	}
	
	function readFile($tmp_file) {
		$p = fopen($tmp_file, "r");
		$fs = filesize($tmp_file);
		
		if ($fs > 0) {
			$r = fread($p, filesize($tmp_file));
		} else {
			$r = "";
		}
		
		fclose($p);
		
		return $r;
	}
	
	function writeFile($tmp_file, $tmp_string, $tmp_overwrite = true) {
		if ($tmp_overwrite) {
			$this->deleteFile($tmp_file);
		} else {
			$tmp_string = $this->readFile($tmp_file) . $tmp_string;
		}
		
		$p = fopen($tmp_file, "w");
		
		fwrite($p, $tmp_string);
		fclose($p);
	}
	
	function folder2Array($tmp_directory, $tmp_recursive = false, $tmp_onlyFolder = false) {
		$array_items = array();
		if ($handle = opendir($tmp_directory)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != "..") {
					if (is_dir($tmp_directory. "/" . $file)) {
						if($tmp_recursive) {
							$array_items = array_merge($array_items, $this->folder2Array($tmp_directory. "/" . $file, $tmp_recursive, $tmp_onlyFolder));
						}
						$file = $tmp_directory . "/" . $file;
						$array_items[] = preg_replace("/\/\//si", "/", $file);
					} else {
						if(!$tmp_onlyFolder){
							$file = $tmp_directory . "/" . $file;
							$array_items[] = preg_replace("/\/\//si", "/", $file);
						}
					}
				}
			}
			closedir($handle);
		}
		return $array_items;
	}
}
?>