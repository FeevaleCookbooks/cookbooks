<?
class Input {

	function Input() {
		log_message("[input] é instanciado.");

		$this->_encode_array = array('4', '5', 'J', 'A', 'Q', 'c', 'n', 'x', 'P', 'Y', 'd', 'b', 'g', 'i', 'j', 'y', 'a', '9');

		//TODO: Esquematizar segurança nas variáveis de entrada
	}

	function keyExists($tmp_input_name, $tmp_key) {
		switch ($tmp_input_name) {
			case "request":
				$var = $_REQUEST;

				break;
			case "post":
				$var = $_POST;

				break;
			case "get":
				$var = $_GET;

				break;
		}

		return array_key_exists($tmp_key, $var);
	}

	function get($tmp_key, $tmp_decode = false, $tmp_type = 'str') {
		$key = $this->_cleanKey($tmp_key);

		$r = "";
		if (isset($_GET[$key])) {
			$r = $this->_cleanStr($_GET[$key]);
			
			if ($tmp_decode) {
				$r = $this->_decode($r);
			}
			
			if ($tmp_type == 'int') {
				$r = $this->clearInt($r);
			}
		}		

		return $r;
	}

	function post($tmp_key, $tmp_decode = false, $tmp_type = 'str') {
		$key = $this->_cleanKey($tmp_key);

		$r = "";
		if (isset($_POST[$key])) {	
			$r = $this->_cleanStr($_POST[$key]);

			if ($tmp_decode) {
				$r = $this->_decode($r);
			}
			if ($tmp_type == 'int') {
				$r = $this->clearInt($r);
			}	
		}

		return $r;
	}

	function request($tmp_key, $tmp_decode = false, $tmp_type = 'str') {
		$get = $this->get($tmp_key,$tmp_decode,$tmp_type);
		$post = $this->post($tmp_key,$tmp_decode,$tmp_type);

		if ($get != "") {
			return $get;
		} elseif ($post != "") {
			return $post;
		} else {
			return "";
		}
	}

	function server($tmp_key) {
		global $HTTP_SERVER_VARS;
		global $HTTP_ENV_VARS;

		if (!isset($_SERVER)) {
			$_SERVER = $HTTP_SERVER_VARS;
			if(!isset($_SERVER["REMOTE_ADDR"])) {
				// must be Apache
				$_SERVER = $HTTP_ENV_VARS;
			}
		}

		if (isset($_SERVER[$tmp_key])) {
			return $_SERVER[$tmp_key];
		} else {
			return "";
		}
	}

	function session($tmp_key) {
		$r = "";

		if (isset($_SESSION[$tmp_key])) {
			$r = $_SESSION[$tmp_key];
		}

		return $r;
	}

	function setSession($tmp_key, $tmp_value) {
		$_SESSION[$tmp_key] = $tmp_value;
	}

	function unsetSession($tmp_key) {
		unset($_SESSION[$tmp_key]);
	}

	function encode($tmp_string) {
		$tmp_string = $tmp_string."";
		return $this->_encode($tmp_string);
	}

	function decode($tmp_string) {
		$tmp_string = $tmp_string."";
		return $this->_decode($tmp_string);
	}

	//private functions
	function _cleanStr($tmp_string) {
		//Remove null chars
		$tmp_string = preg_replace('/\0+/', '', $tmp_string);
		$tmp_string = preg_replace('/(\\\\0)+/', '', $tmp_string);

		//Decode raw urls
		$tmp_string = rawurldecode($tmp_string);

		//Remove bad words
		$bad = array(
						'document.cookie'	=> '[removed]',
						'document.write'	=> '[removed]',
						'.parentNode'		=> '[removed]',
						'.innerHTML'		=> '[removed]',
						'window.location'	=> '[removed]',
						'-moz-binding'		=> '[removed]',
						'<!--'				=> '&lt;!--',
						'-->'				=> '--&gt;',
						'<!CDATA['			=> '&lt;![CDATA['
					);

		foreach ($bad as $k => $v) {
			$tmp_string = str_ireplace($k, $v, $tmp_string);
		}

		//Escape '
		$tmp_string = str_replace("'", "`", $tmp_string);

		return $tmp_string;
	}

	function clearInt($tmp_string) {
		return ereg_replace('[^0-9]','',$tmp_string);
	}

	function _cleanKey($tmp_string) {
		if (!preg_match("/^[a-z0-9:_\/-]+$/i", $tmp_string)) {
			error(2, "Chave não permitida", "Input", "_cleanKey");
		}

		return $tmp_string;
	}

	function _encode($tmp_string) {
		$arr = $this->_encode_array;
		$t = sizeof($arr) - 1;
		$r = "";
		$l = strlen($tmp_string);

		for ($i = 0; $i < $l; $i++) {
			$c1 = 0;
			$c2 = ord($tmp_string{$i});

			while ($c2 > $t) {
				$c2 -= $t;

				$c1++;
			}

			if (($i % 2) == 0) { $r .= $arr[$c1] . $arr[$c2]; }
			else { $r .= $arr[$t - $c1] . $arr[$t - $c2]; }
		}

		return $r;
	}

	function _decode($tmp_string) {
		$arr = $this->_encode_array;
		$t = sizeof($arr) - 1;
		$k = array_flip($arr);
		$n = 0;
		$r = "";
		$l = strlen($tmp_string);

		for ($i = 0; $i < $l; $i++) {
			$c1 = $tmp_string{$i}; $i++;
			if ($i < $l) {
				$c2 = $tmp_string{$i};
			}
			
			if ((isset($k[$c1])) && (isset($k[$c2]))) {
				if (($n % 2) == 0) { $r .= chr(($k[$c1] * $t) + $k[$c2]); }
				else { $r .= chr((($t - $k[$c1]) * $t) + ($t - $k[$c2])); }
			}
			
			$n++;
		}

		return $r;
	}
}
?>