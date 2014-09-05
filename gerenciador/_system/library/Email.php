<?
class Email {
	var $to;
	var $from;
	var $reply_to;

	var $list_cc;
	var $list_bcc;

	var $subject;
	var $content;
	var $attach_images;
	var $debug;
	var $reset_content;

	var $_smtp_conn;
	var $_content_bkp;
	var $_content_formated;
	var $_lf;

	function Email() {
		$this->to = "";
		$this->from = "";
		$this->reply_to = "";

		$this->list_cc = array();
		$this->list_bcc = array();

		$this->subject = "";
		$this->content = "";
		$this->attach_images = false;
		$this->debug = false;

		$this->_stmp_conn = NULL;
		$this->_content_bkp = "";
		$this->_content_formated = "";
		$this->reset_content = true;

		$this->_lf = ((strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') ? "\r\n" : "\n");
	}

	function loadTemplate($tmp_path) {
		global $file;

		$this->content = $file->readFile($tmp_path);
	}

	function setTemplateValue($tmp_mask, $tmp_value) {
		$this->content = str_replace($tmp_mask, $tmp_value, $this->content);
	}

	function send() {
		$this->_formatContent();

		return mail($this->to, $this->subject, $this->content, $this->_getHeaders());
	}

	function sendTest() {
		$this->from = "ramon@webtrading.com.br";
		return $this->sendSmtp("smtp.webtrading.com.br", "ramon@webtrading.com.br", "r4m0nf");
	}

	function sendHostNet($tmp_host, $tmp_user, $tmp_pass) {
		//'smtp.jacquelinerabelo.com.br'
		//'contato=jacquelinerabelo.com.br'
		//'77cold'

		@include_once("Mail.php");
		@include_once("Mail/mime.php");

		$tmp_user = str_replace("@", "=", $tmp_user);

		$recipients = $this->to;

		$headers =
		array (
		  'From'    => $this->from,
		  'To'      => $this->to,
		  'Subject' => $this->subject
		);

		$html = $this->content;

		@$mime = new Mail_mime($this->_lf);

		$mime->setHTMLBody($html);

		$body = $mime->get();
		$headers = $mime->headers($headers);

		$params =
		array (
		  'auth' => true,
		  'host' => $tmp_host,
		  'username' => $tmp_user,
		  'password' => $tmp_pass
		);

		$mail_object =& Mail::factory('smtp', $params);
		$result = $mail_object->send($recipients, $headers, $body);
		if (PEAR::IsError($result))	{
			return true;
		} else {
			return false;
		}
	}

	function sendSmtp($tmp_smtp_server, $tmp_user = "", $tmp_pass = "") {
		$this->_formatContent();

		$this->_smtp_conn = fsockopen($tmp_smtp_server, 25, $errno, $errstr, 30);

		if (is_resource($this->_smtp_conn)) {
			if ($tmp_user != "") {
				$this->_smtpPut("EHLO " . $tmp_smtp_server);
			} else {
				$this->_smtpPut("HELO " . $tmp_smtp_server);
			}

			$this->_smtpGet();

			if ($tmp_user != "") {
				$this->_smtpPut("AUTH LOGIN");
				$this->_smtpGet();
				$this->_smtpGet();
				$this->_smtpGet();
				$this->_smtpGet();
				$this->_smtpGet();
				$this->_smtpPut(base64_encode($tmp_user));
				$this->_smtpGet();
				$this->_smtpPut(base64_encode($tmp_pass));
				$this->_smtpGet();
			}

			if (strpos($tmp_user, "@") > 0) {
				$from = $tmp_user;
			} else {
				$from = $this->from;
			}

			$this->_smtpPut("MAIL FROM: " . $from);
			$this->_smtpGet();

			$this->_smtpPut("RCPT TO: " . $this->to);
			$this->_smtpGet();

			$this->_smtpPut("DATA");
			$this->_smtpGet();

			$this->_smtpPut("To: <" . $this->to . ">");
			$this->_smtpGet();

			$this->_smtpPut($this->_getHeaders());
			$this->_smtpPut($this->_lf);

			$this->_smtpPut($this->content);

			$this->_smtpPut(".");
			$r = $this->_smtpGet();

			$this->_smtpPut("QUIT");
			$this->_smtpGet();

			if (is_resource($this->_smtp_conn)) {
				fclose($this->_smtp_conn);
			}

			if (substr($r, 0, 1) == "2") {
				$r = true;
			} else {
				$r = false;
			}
		} else {
			$r = false;
		}

		return $r;
	}

	//Private Functions
	function _formatContent() {
		global $file;

		$lf = $this->_lf;

		if ((($this->_content_bkp != $this->content) && ($this->_content_formated != $this->content)) || ($this->reset_content)) {
			$this->reset_content = false;

			$this->_boundary = "_=======" . date('YmdHms'). time() . "=======_";

			$this->_content_bkp = $this->content;
			$c = $this->content;
			$c_imgs = "";
			$content = "";

			//Get server from 'from' e-mail for imgs cids. eg: webtrading.com.br
			$arr = explode("@", $this->from);
			$server = $arr[1];

			if ($this->attach_images) {
				//Find: <img... src=""...> and <... url() ...>
				$c = $this->content;
				$i = 0;
				$imgs = array();

				while ((preg_match('#<img(.+?)'.preg_quote("src", '/').'(.+?)>|<(.+?)'.preg_quote("background=", '/').'(.+?)>#i', $c, $m)) && ($i < 150)) {

					if (strpos($m[0], "background=") > 0) {
						$imgs[] = array($m[0], str_replace(array("'", "\""), "", $m[4]));

						$pos = strpos($c, $m[0]) + strlen($m[0]);
					} else {
						$p2 = (int)strpos($m[2], '"', 2);
						$p1 = (int)strpos($m[2], "'", 2);
						if ($p1 == 0) { $p1 = $p2; }

						$imgs[] = array($m[0], substr($m[2], 2, ($p1 - 2)));
						$pos = strpos($c, $m[0]) + strlen($m[0]);
					}

					$c = substr($c, $pos);

					$i++;
				}

				//Replace imgs urls to imgs cids and generate contents.
				$c = $this->content;
				$img_tags = array();
				$img_files = array();
				foreach ($imgs as $v) {
					$tag = $v[0];
					$path = $v[1];

					$ext = $file->getExtension($path);

					if ((array_search($ext, array("jpg", "gif", "png")) !== false) && (array_search($tag, $img_tags) === false)) {
						$filename = $file->getFileName($path);
						$id = "IMG_" . str_replace(array("." . $ext, " "), "", $filename) . "@" . $server;

						$img = str_replace($path, "cid:" . $id, $tag);

						if (strpos($c, $tag) !== false) {
							$img_tags[] = $tag;

							if ((strpos($img, "moz-do-not-send=\"false\"") == false) && (strpos($img, "<img") !== false)) {
								$img = substr($img, 0, (strlen($img) - 1)) . " moz-do-not-send=\"false\">";
							} elseif ((strpos($img, "url(") !== false)) {

							}

							$c = str_replace($tag, $img, $c);

							if (array_search($path, $img_files) === false) {
								$img_files[] = $path;

								$c_imgs .= "--" . $this->_boundary . $lf;
								$c_imgs .= "Content-type: image/" . str_replace("jpg", "jpeg", $ext) . "; name=\"" . $filename . "\"" . $lf;
								$c_imgs .= "Content-Transfer-Encoding: base64" . $lf;
								$c_imgs .= "Content-ID: <" . $id . ">" . $lf . $lf;
								$c_imgs .= chunk_split(base64_encode($file->readFile($v[1]))) . $lf . $lf;
							}
						}
					}
				}
			}


			//Text plain content
			/*$content = "--" . $this->_boundary . "\n";
			$content .= "Content-Type: text/plan; charset=iso-8859-1\n\n";
			$content .= strip_tags(str_replace(array("\r\n", "\n\r", "\n", "<br>"), array("", "", "", "\n"), str_replace(array("<br/>", "<br />"), "<br>", substr($c, (int)strpos($c, "<body"))))) . "\n";*/

			//echo $c;

			//Html content
			$content .= "--" . $this->_boundary . $lf;
			$content .= "Content-Type: text/html; charset=iso-8859-1" . $lf . $lf;
			$content .= $c  . $lf . $lf;

			//Images contents
			$content .= $c_imgs;

			$content .= "--" . $this->_boundary . "--" . $lf;

			$this->_content_formated = $content;
			$this->content = $content;
		}

		if (!$this->attach_images) {
			$this->content = $this->_content_bkp;
		}
	}

	function _getHeaders() {
		$headers = "";
		$lf = $this->_lf;

		$headers .= "Message-Id: <" . date('YmdHis') . "." . md5(microtime()) . "." . strtoupper($this->from) . ">" . $lf;
		if ($this->attach_images) {
			$headers .= "Content-Type: multipart/related; boundary=\"" . $this->_boundary . "\"" . $lf;
		} else {
			$headers .= "Content-Type: text/html; charset=iso-8859-1" . $lf;
		}
		$headers .= "Subject: " . $this->subject . $lf;
		$headers .= "MIME-version: 1.0" . $lf;
		$headers .= "Date: ". date('D, d M Y H:i:s O') . $lf;

		//reply to

		$headers .= "Reply-To: " . $this->reply_to . $lf;

		//from
		if ($this->from) {
			$headers .= "FROM: " . $this->from . $lf;
		}

		//cc
		foreach ($this->list_cc as $v) {
			$headers .= "{CC}: " . $v . $lf;
		}

		//bcc
		foreach ($this->list_bcc as $v) {
			$headers .= "{BCC}: " . $v . $lf;
		}

		return $headers;
	}

	function _smtpPut($tmp_string) {
		if (substr($tmp_string, -1) != "\n") {
			$tmp_string .= $this->_lf;
		}

		if ($this->debug) {
			echo ">>> " . $tmp_string . "<br>";
		}

		$tmp_string = str_replace("\r\n", "#####*#####", $tmp_string);
		$tmp_string = str_replace("\n", "#####*#####", $tmp_string);
		$tmp_string = str_replace("#####*#####", $this->_lf, $tmp_string);

		return @fputs($this->_smtp_conn, $tmp_string);
	}

	function _smtpGet() {
		$v = @fgets($this->_smtp_conn, 512);
		if ($this->debug) {
			echo "<<< " . $v . "<br>";
		}

		return substr($v, 0, 3);
	}

	function _smtpGets() {
		$r = "";

		$i = 0;
		while ((!feof($this->_smtp_conn)) && ($i < 30)) {
			$tmp = fgets($this->_smtp_conn, 64);

			if ($tmp) {
				$r .= $tmp;
			} else {
				$i = 50;
			}

			$i++;
		}

		return $r;
	}
}
?>