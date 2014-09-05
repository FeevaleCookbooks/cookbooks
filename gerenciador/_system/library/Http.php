<?
class Http {
	var $_redirs;
	var $response_headers;
	var $response_data;
	
	var $method;
	
	function Http() {
		$this->_redirs = 0;
	}

	function request($tmp_url, $tmp_method = "get", $tmp_content = "", $tmp_headers = array()) {
		$r = "";
		$out = "";
		
		$this->method = strtoupper($tmp_method);
		
		$uri = parse_url($tmp_url);
		$server = $uri['host'];
		$port = isset($uri["port"])?$uri["port"]:80;
		$path = $uri["path"];
		$gets = $uri["query"];
		
		$p = fsockopen($server, $port, $errno, $errstr, 30);
		
		if (!$p) {
			return false;
		} else {
			if ($this->method == "GET") {
				$out .= "GET ";
				$out .= isset($path) ? $path : "/";
				$out .= isset($gets) ? "?" . $gets : "";
				$out .= " HTTP/1.1\r\n";
				$out .= "Host: ".$server."\r\n";
				$out .= "Connection: Close\r\n\r\n";
			} else {
				$out .= "POST ";
				$out .= isset($path) ? $path : "/";
				$out .= isset($gets) ? "?" . $gets : "";
				$out .= " HTTP/1.1\r\n";
				$out .= "Host: ".$server."\r\n";
				$out .= "Content-length: " . strlen($tmp_content) . "\r\n";
				$out .= "User-agent: Ramon-HttpPHPClass\r\n";
				
				foreach ($tmp_headers as $k => $v) {
					$out .= $k . ":" . $v . "\r\n";
				}
				
				$out .= "Connection: Close\r\n\r\n";
				
				$out .= $tmp_content;
			}
			
			fwrite($p, $out, strlen($out));
			//echo ">>" . $out;
			
			//recebe os headers
			//.Response
			$data = "";
			$lb = "";
			
			//.headers
			$i = 0;
			while ($i++ < 200) {
				if (feof($p)) { break; }
				
				$tmp = fgets($p, 256);
				$tmplen = strlen($tmp);
				if ($tmplen == 0) { break; }
				
				$data .= $tmp;
				
				if (strpos($data,"\r\n\r\n") > 1) {
					$lb = "\r\n";
				} else {
					if (strpos($data,"\n\n") > 1) { 
						$lb = "\n"; 
					}
				}
				
				if (($lb != "") && ereg('^HTTP/1.1 100', $data)) {
					$lb = "";
					$data = "";
				}
				
				if ($lb != "") { break; }
			}
			
			$rh = array();
			$header_arr = explode($lb, $data);
			$k = "";
			foreach ($header_arr as $v) {
				$tmp = explode(":", $v, 2);
				if (sizeof($tmp) > 1) {
					$k = strtolower(trim($tmp[0]));
					
					if ($k != "") { $rh[$k] = trim($tmp[1]); }
				} elseif ($k != "") {
					$rh[$k] .= $lb . " " . trim($v);
				}
			}
			
			//.content-length
			if (isset($rh['transfer-encoding']) && strtolower($rh['transfer-encoding']) == 'chunked') {
				$content_length = 2147483647;
				$chunked = true;
			} elseif (isset($rh['content-length'])) {
				$content_length = $rh['content-length'];
				$chunked = false;
			} else {
				$content_length = 2147483647;
				$chunked = false;
			}
			$rh_str = $data;
			
			//.data		
			$data = "";
			do {
				if ($chunked) {
					$tmp = fgets($p, 256);
					$tmplen = strlen($tmp);
					
					if ($tmplen == 0) {
						echo "chunk error";
						return false;
					}
					
					$content_length = hexdec(trim($tmp));
				}
				
				$strlen = 0;
				while (($strlen < $content_length) && (!feof($p))) {
					$rlen = min(8192, $content_length - $strlen);
					
					$tmp = fread($p, $rlen);
					$tmplen = strlen($tmp);
					
					if (($tmplen == 0) && (!feof($p))) {
						echo "Body timeout";
						return false;
					}
					
					$strlen += $tmplen;
					$data .= $tmp;
				}
				
				if ($chunked && ($content_length > 0)) {
					$tmp = fgets($p, 256);
					$tmplen = strlen($tmp);
					
					if ($tmplen == 0) {
						echo "Chunk timeout";
						return false;
					}
				}
			} while ((!feof($p)) && ($chunked) && ($content_length > 0));
			
			//Se tiver redirecionamento
			/*if ((isset($rh["location"])) && ($this->redirs < 20)) {
				$link = $uri["scheme"] . "://" . $uri["host"] . trim($rh["location"]);

				if ($link != $path) {
					$r = $this->request($link,  false);
				}

				$this->redirs++;
			}*/
			
			$this->response_headers = $rh;
			$this->response_data = $data;
			
			return $data;
		}
	}
}
?>