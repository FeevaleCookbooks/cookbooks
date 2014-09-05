<?
class Image {
	var $width;
	var $height;

	var $_path;
	var $_p;
	
	var $ext;
	
	function Image($tmp_path = "", $tmp_w = 100, $tmp_h = 100) {
		if ($tmp_path != "") {
			if ($tmp_path == "blank") {
				$this->createBlankImage($tmp_w, $tmp_h);
			} else {
				$this->load($tmp_path);
			}
		}
	}
	
	function createBlankImage($tmp_w, $tmp_h) {
		$this->_p = imagecreatetruecolor($tmp_w, $tmp_h);
		
		if ($this->_p) {
			$this->width = imagesx($this->_p);
			$this->height = imagesy($this->_p);
		}
	}
	
	function load($tmp_path) {
		global $file;
		
		$this->_path = $tmp_path;
		
		$ext = $file->getExtension($tmp_path);
		$this->ext = $ext;
		switch ($this->ext) {
			default:
			case "jpeg":
			case "jpg":
				$this->_p = imagecreatefromjpeg($tmp_path);
				
				break;
			case "gif":
				$this->_p = imagecreatefromgif($tmp_path);
				
				break;
			case "png":
				$this->_p = imagecreatefrompng($tmp_path);
				
				break;
		}
		
		if ($this->_p) {
			$this->width = imagesx($this->_p);
			$this->height = imagesy($this->_p);
		}
	}
	
	function resize($tmp_w, $tmp_h = 0, $tmp_method = 1, $tmp_background = array(255, 255, 255)) {
		$n_x = 0;
		$n_y = 0;
		$n_w = 0;
		$n_h = 0;						
		
		$w = $this->width;
		$h = $this->height;
		
		$rel_w = $w / $tmp_w;
		$rel_h = $h / $tmp_h;
		
		$resize = true;
		
		switch ($tmp_method) {
			//Adequa a imagem dentro do quadrado passado no parametro
			case 1: 
				if ($rel_w > $rel_h) {
					$n_w = (int)$tmp_w; //Altura é o limite
					$n_h = (int)($h / $rel_w); //Largura se adapta
					
					if ($n_h < $tmp_h) { //Calcula espaçamento de altura
						$n_y = (int)(($tmp_h - $n_h) / 2);
					}
				} else {
					$n_w = (int)($w / $rel_h); //Altura se adapta
					$n_h = (int)$tmp_h; //Largura é o limite
					
					if ($n_w < $tmp_w) { //Calcula espaçamento de largura
						$n_x = (int)(($tmp_w - $n_w) / 2);
					}
				}
				
				break;
				
			//Da crop na sobra da imagem pra fica full
			case 2: 
				if ($rel_w > $rel_h) {
					$n_w = (int)($w / $rel_h); //Altura se adapta
					$n_h = (int)$tmp_h; //Largura é o limite
					
					//Calcula espaçamento de altura
					$n_y = (int)(($tmp_h - $n_h) / 2);
				} else {
					$n_w = (int)$tmp_w; //Altura é o limite
					$n_h = (int)($h / $rel_w); //Largura se adapta
					
					//Calcula espaçamento de largura
					$n_x = (int)(($tmp_w - $n_w) / 2);
				}
				
				break;
				
			//Redimensiona a imagem dentro do quadrado, sem margens
			case 3:
				if ($rel_w > $rel_h) {
					$n_w = (int)$tmp_w; //Altura é o limite
					$n_h = (int)($h / $rel_w); //Largura se adapta
				} else {
					$n_w = (int)($w / $rel_h); //Altura se adapta
					$n_h = (int)$tmp_h; //Largura é o limite
				}
				
				$p_new = imagecreatetruecolor($n_w, $n_h); //Cria uma nova
				
				break;
				
			//Redimensiona a imagem dentro do quadrado, sem margens (se as dimensões ultrapassarem)
			case 4: 
				if ($rel_w > $rel_h) {
					$n_w = (int)$tmp_w; //Altura é o limite
					$n_h = (int)($h / $rel_w); //Largura se adapta
				} else {
					$n_w = (int)($w / $rel_h); //Altura se adapta
					$n_h = (int)$tmp_h; //Largura é o limite
				}
				
				if (($w >= $n_w) || ($h >= $n_h)) {
					$p_new = imagecreatetruecolor($n_w, $n_h); //Cria uma nova
				} else {
					$resize = false;
				}
				
				break;
				
			//Adequa a imagem dentro do quadrado passado no parametro alinha à base
			case 5: 
				if ($rel_w > $rel_h) {
					$n_w = (int)$tmp_w; //Altura é o limite
					$n_h = (int)($h / $rel_w); //Largura se adapta
					
					//Calcula espaçamento de altura
					$n_y = (int)(($tmp_h - $n_h) / 1);
				} else {
					$n_w = (int)($w / $rel_h); //Altura se adapta
					$n_h = (int)$tmp_h; //Largura é o limite
					
					//Calcula espaçamento de largura
					$n_x = (int)(($tmp_w - $n_w) / 2);
				}
				break;
			
			//Da crop na sobra da imagem pra fica full, centralizando, seja horizontal ou vertical
			case 6: 
				if ($rel_w > $rel_h) {//imagem horizontal
					$n_w = (int)($w / $rel_h); //Altura se adapta
					$n_h = (int)$tmp_h; //Largura é o limite
					
					//Calcula espaçamento de altura
					$n_y = (int)(($tmp_h - $n_h) / 2);
					//centraliza largura
					$n_x = (int)(($rel_w/2)-($tmp_w/2));
				} else {//imagem vertical
					$n_w = (int)$tmp_w; //Altura é o limite
					$n_h = (int)($h / $rel_w); //Largura se adapta
					
					//Calcula espaçamento de largura
					$n_x = (int)(($tmp_w - $n_w) / 2);
					if($h >= $w) {
						//centraliza altura
						$n_y = (int)(($rel_h/2)-($tmp_h/2));
					}
				}
				
				break;
		}
		
		if(!isset($p_new)){
			$p_new = imagecreatetruecolor($tmp_w, $tmp_h); //Cria uma nova
		}
		
		switch($this->ext){
			default:
			case "jpg"://define cor de fundo
			case "jpeg":
				imagefill($p_new, 0, 0, imagecolorallocate($p_new, $tmp_background[0], $tmp_background[1], $tmp_background[2]));
				break;
			case "png":
				imagealphablending($p_new, false);
				$colorTransparent = imagecolorallocatealpha($p_new, 0, 0, 0, 127);
				imagefill($p_new, 0, 0, $colorTransparent);
				imagesavealpha($p_new, true);
				break;
			case "gif":
				$trnprt_indx = imagecolortransparent($this->_p);
				if ($trnprt_indx >= 0) { //its transparent
					$trnprt_color = imagecolorsforindex($this->_p, $trnprt_indx);
					$trnprt_indx = imagecolorallocate($p_new, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
					imagefill($p_new, 0, 0, $trnprt_indx);
					imagecolortransparent($p_new, $trnprt_indx);
				}
				break;
		}
		
		if ($resize) {
			//echo "$n_x, $n_y, 0, 0, " . ($n_w + 1) . ", " . ($n_h + 1) . ", $w, $h";
			imagecopyresampled($p_new, $this->_p, $n_x, $n_y, 0, 0, $n_w + 1, $n_h + 1, $w, $h);
			imagedestroy($this->_p);
			$this->_p = $p_new;
		} else {
			switch($this->ext){
				default:
				case "jpg"://define cor de fundo
				case "jpeg":
					imagefill($this->_p, 0, 0, imagecolorallocate($this->_p, $tmp_background[0], $tmp_background[1], $tmp_background[2]));
					break;
				case "png":
					imagealphablending($this->_p, false);
					$colorTransparent = imagecolorallocatealpha($this->_p, 0, 0, 0, 127);
					imagefill($this->_p, 0, 0, $colorTransparent);
					imagesavealpha($this->_p, true);
					break;
				case "gif":
					$trnprt_indx = imagecolortransparent($this->_p);
					if ($trnprt_indx >= 0) { //its transparent
						$trnprt_color = imagecolorsforindex($this->_p, $trnprt_indx);
						$trnprt_indx = imagecolorallocate($this->_p, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
						imagefill($this->_p, 0, 0, $trnprt_indx);
						imagecolortransparent($this->_p, $trnprt_indx);
					}
					break;
			}
		}
	}
	
	function header() {
		switch ($this->ext) {
			default:
			case "jpeg":
			case "jpg":
				header("Content-type: image/jpeg");				
				break;
			case "gif":
				header("Content-type: image/gif");				
				break;
			case "png":
				header("Content-type: image/png");				
				break;
		}
		
		$this->save("");
	}
	
	function save($tmp_path, $tmp_quality = 100, $tmp_extensao = "") {
		global $file;
		
		if($tmp_extensao == ""){
			$ext = $file->getExtension($tmp_path);
			if($ext == ""){
				if($this->ext != ""){
					$ext = $this->ext;
				}
			}			
		}else{
			$ext = $tmp_extensao;
		}
		
		switch($ext){
			default:
			case "jpeg":
			case "jpg":
				return imagejpeg($this->_p, $tmp_path, $tmp_quality);
			case "png":
				if($tmp_path == ""){
					return imagepng($this->_p);
				} else {
					return imagepng($this->_p, $tmp_path);
				}
			case "gif":
				if($tmp_path == ""){
					return imagegif($this->_p);
				} else {
					return imagegif($this->_p, $tmp_path);
				}
		}
	}
}
?>