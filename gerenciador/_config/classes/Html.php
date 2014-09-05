<?php
class Html{
	function getSelect($arr,$label,$sufixo,$name,$extra = "",$secondItem = "------",$selected = "",$item = "") {
		$obj = '';
		$total = sizeof($arr);

		if ($total > 0) {
			$obj = 	'<select id="'.$label.'_'.$sufixo.'" name="'.$name.'" class="input" '.$extra.' '.$this->alt($label).' >'.
						'<option value="" '.$this->alt($label).'>'.$label.'</option>'.
						'<option value="" '.$this->alt($label).'>'.$secondItem.'</option>';
			$inlineSelected = "";
			foreach($arr as $k => $v){
				if(($selected == $k) && ($selected != "")){
					$inlineSelected = " selected ";
				} else {
					$inlineSelected = "";
				}
				$obj .= '	<option value="'.$k.'" '.$inlineSelected.' '.$this->alt($v).'>'.$v.'</option>';
			}
			$obj .= 	'</select>';
		}

		echo  $obj;
	}
	
	function getSelectByRows($rows,$label,$sufixo,$name,$extra = "",$secondItem = "------",$selected = "") {
		$arr = Array();
		while(!$rows->EOF){
			$arr[$rows->fields("id")] = $rows->fields("nome");
			$rows->moveNext();
		}

		echo $this->getSelect($arr,$label,$sufixo,$name,$extra,$secondItem,$selected);
	}
	function alt($alt){
		return ' alt="'.$alt.'" title="'.$alt.'" ';
	}
	function getInput($label,$sufixo,$name,$extra = "",$testDV = true,$type = "text",$colsrows="") {
		$obj = '';
		switch($type){
			case "text":
					$func = ' onfocus="javascript: swapI(this,true);" onblur="javascript: swapI(this,false);" testDV="true" ';
					$value = $label;
					
					if(!$testDV){
						$func = '';
						$value = '';
					}
					
					$obj ='<input type="text" class="input" label="'.$label.'" id="'.$label.'_'.$sufixo.'" name="'.$name.'" value="'.$value.'" '.$extra.$func.' />';
								
				break;
			case "password":
					$id = $label.'_'.$sufixo;
					$func = ' onfocus="javascript: swapP(document.getElementById(\'div'.$id.'\'),true);" onblur="javascript: swapP(this,false);" ';
					
					$obj = '<div id="div'.$id.'" parent="'.$id.'" class="divPass" style="padding-top: 8px; position:absolute; padding-left:6px;" onclick="javascript: swapP(this,true);">'.$label.'</div>';
					if(!$testDV){
						$func = '';
						$obj = '';
					}
					$obj .= '<input type="password" class="input" label="'.$label.'" id="'.$id.'" name="'.$name.'" '.$extra.$func.' />';
				break;
			case "textarea":
					$id = $label.'_'.$sufixo;
					$func = ' onfocus="javascript: swapI(this,true);" onblur="javascript: swapI(this,false);" testDV="true" ';
					$value = $label;
					
					if(!$testDV){
						$func = '';
						$value = '';
					}
					$obj = '<textarea type="textarea" class="input" label="'.$label.'" id="'.$label.'_'.$sufixo.'" name="'.$name.'" '.$extra.$func.' '.$colsrows.' >'.$value.'</textarea>';
				break;
		}
		echo $obj;
	}
	function getInput2($label,$sufixo,$name,$extra = "",$testDV = true,$type = "text", $colsrows="") {
		$obj = '';
		switch($type){
			case "text":
					$func = ' onfocus="javascript: swapI(this,true);" onblur="javascript: swapI(this,false);" testDV="true" ';
					$value = $label;
					
					if(!$testDV){
						$func = '';
						$value = '';
					}
					
					$obj = 	'<input type="text" class="input2" label="'.$label.'" id="'.$label.'_'.$sufixo.'" name="'.$name.'" value="'.$value.'" '.$extra.$func.' />';
					
				break;
			case "password":
					$id = $label.'_'.$sufixo;
					$func = ' onfocus="javascript: swapP(document.getElementById(\'div'.$id.'\'),true);" onblur="javascript: swapP(this,false);" ';
					
					$obj = '<div id="div'.$id.'" parent="'.$id.'" class="divPass" style="margin:7px;" onclick="javascript: swapP(this,true);">'.$label.'</div>';
					if(!$testDV){
						$func = '';
						$obj = '';
					}
					$obj .= '<input type="password" class="input" label="'.$label.'" id="'.$id.'" name="'.$name.'" '.$extra.$func.' />';
				break;
			case "textarea":
					$id = $label.'_'.$sufixo;
					$func = ' onfocus="javascript: swapI(this,true);" onblur="javascript: swapI(this,false);" testDV="true" ';
					$value = $label;
					
					if(!$testDV){
						$func = '';
						$value = '';
					}
					
					$obj .= '<textarea class="input2" label="'.$label.'" id="'.$id.'" name="'.$name.'" '.$extra.$func.' '. $colsrows .' >'.$value.'</textarea>';
				break;
		}
		echo $obj;
	}
	function getSelectByPagecount($pagecount,$label,$sufixo,$name,$extra = "",$zeroBased = true){
		$arr = array();
		for($x=1;$x<=$pagecount;$x++){
			if($zeroBased){
				$arr[] = $x;
			} else {
				$arr[$x] = $x;
			}
		}
		
		$obj = '';
		$total = sizeof($arr);
		
		if($total > 0){
			$obj = 	'<select id="'.$label.'_'.$sufixo.'" name="'.$name.'" class="input" '.$extra.' >';
			foreach($arr as $k => $v){
				$obj .= '	<option value="'.$k.'">'.$v.'</option>';
			}
			$obj .= '</select>';
		}
		
		return $obj;
	}
	function getRadio($valor,$label,$sufixo,$name,$checked='') {
		$obj = '<input type="radio" name="'.$name.'" value="'.$valor.'" '.$checked.' /> '.$label;
		
		echo $obj;
	}
	function getTitle($arr_caminho = array()){
		global $cfg;
		
		if (sizeof($arr_caminho)>0) {
			$titulo = '';
			
			for($x=sizeof($arr_caminho)-1;$x>=0;$x--){
				$titulo .= $arr_caminho[$x][0] . ' - ';
			}
			$titulo .= 'FLY BY NIGHT';
		} else {
			$titulo = $cfg["site_title"];	
		}
		
		echo('<title>'. $titulo .'</title>');
	}
	function titulo_internas($tmp_string,$tmp_reverse = false){
		$obj = '<table cellspacing="0" cellpadding="0" width="740" height="25"><tr><td>#TITULO#</td></tr></table>';
		$arr_string = explode('#',$tmp_string);
		$total = sizeof($arr_string);
		$titulo = '';
		$class1 = 'tit_inter_azl';
		$class2 = 'tit_inter_cnz';
		if($tmp_reverse){
			$class2 = 'tit_inter_azl';
			$class1 = 'tit_inter_cnz';
		}
		for($x=0;$x<$total;$x++){
			if($x == $total-1){
				$titulo .= '<div class="'.$class1.'">'.$arr_string[$x].'</div>';
			} else {
				$titulo .= '<div class="'.$class2.'">'.$arr_string[$x].'</div>';
			}
			if(($x+1) < $total){
				$titulo .= '<div class="tit_inter_seta"><img src="site/img/common/misc/setatit.gif" width="16" height="19"/></div>';
			}
		}
		
		return str_replace('#TITULO#',$titulo,$obj);
	}
	function local_balada($tmp_string,$tmp_reverse = true){
		$obj = '<table cellspacing="0" cellpadding="0" width="385" height="25"><tr><td>#TITULO#</td></tr></table>';
		$arr_string = explode('#',$tmp_string);
		$total = sizeof($arr_string);
		$titulo = '';
		$class1 = 'tit_inter_azl';
		$class2 = 'tit_inter_cnz';
		if($tmp_reverse){
			$class2 = 'tit_inter_azl';
			$class1 = 'tit_inter_cnz';
		}
		for($x=0;$x<$total;$x++){
			if($x == $total-1){
				$titulo .= '<div class="'.$class1.'">'.$arr_string[$x].'</div>';
			} else {
				$titulo .= '<div class="'.$class2.'">'.$arr_string[$x].'</div>';
			}
			if(($x+1) < $total){
				$titulo .= '<div class="tit_inter_seta"><img src="site/img/common/misc/setatit.gif" width="16" height="19"/></div>';
			}
		}
		
		return str_replace('#TITULO#',$titulo,$obj);
	}
	function titulo_djs($tmp_string,$tmp_reverse = false){
		$obj = '<table cellspacing="0" cellpadding="0" width="385" height="25"><tr><td>#TITULO#</td></tr></table>';
		$arr_string = explode('#',$tmp_string);
		$total = sizeof($arr_string);
		$titulo = '';
		$class1 = 'tit_inter_azl';
		$class2 = 'tit_inter_cnz';
		if($tmp_reverse){
			$class2 = 'tit_inter_azl';
			$class1 = 'tit_inter_cnz';
		}
		for($x=0;$x<$total;$x++){
			if($x == 0){
				$titulo .= '<div class="'.$class1.'">'.$arr_string[$x].'</div>';
			} else {
				$titulo .= '<div class="'.$class2.'">'.$arr_string[$x].'</div>';
			}
			if(($x+1) < $total){
				$titulo .= '<div class="tit_inter_seta"><img src="site/img/common/misc/setatit.gif" width="16" height="19"/></div>';
			}
		}
		
		return str_replace('#TITULO#',$titulo,$obj);
	}
	function titblue($tmp_string,$tmp_width,$tmp_height){
		$obj = '<table cellspacing="0" cellpadding="0" width="'.$tmp_width.'" height="'.$tmp_height.'"><tr><td><div class="tit_inter_azl">#TITULO#</div></td></tr></table>';
		return str_replace('#TITULO#',$tmp_string,$obj);
	}
	function titgrey($tmp_string,$tmp_width,$tmp_height){
		$obj = '<table cellspacing="0" cellpadding="0" width="'.$tmp_width.'" height="'.$tmp_height.'"><tr><td><div class="tit_inter_cnz" style="font-size:17px;">#TITULO#</div></td></tr></table>';
		return str_replace('#TITULO#',$tmp_string,$obj);
	}
	function data_foto($tmp_string){
		return $this->titblue($tmp_string,190,27);
	}
	function descricao_foto_resultados($tmp_string){
		return $this->titblue($tmp_string,190,60);
	}
	function nome_dj($tmp_string){
		return $this->titblue($tmp_string,193,28);
	}
	function dj_local($tmp_string){
		return $this->titgrey($tmp_string,193,23);
	}
	function data_balada($tmp_string,$tmp_reverse = false){
		$obj = '<table cellspacing="0" cellpadding="0" width="400" height="25"><tr><td>#TITULO#</td></tr></table>';
		$arr_string = explode('#',$tmp_string);
		$total = sizeof($arr_string);
		$titulo = '';
		$class1 = 'tit_inter_azl';
		$class2 = 'tit_inter_cnz';
		if($tmp_reverse){
			$class2 = 'tit_inter_azl';
			$class1 = 'tit_inter_cnz';
		}
		for($x=0;$x<$total;$x++){
			if($x == $total-1){
				$titulo .= '<div class="'.$class1.'">'.$arr_string[$x].'</div>';
			} else {
				$titulo .= '<div class="'.$class2.'">'.$arr_string[$x].'</div>';
			}
			if(($x+1) < $total){
				$titulo .= '<div class="tit_inter_seta"><img src="site/img/common/misc/setatit.gif" width="16" height="19"/></div>';
			}
		}
		
		return str_replace('#TITULO#',$titulo,$obj);
	}
}
?>