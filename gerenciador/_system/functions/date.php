<?
function dateToMysql($tmp_date) {
	$arr = explode("/", $tmp_date);

	return $arr[2] . "-" . $arr[1] . "-" . $arr[0];
}

function addTimeToMysqlDate($tmp_date, $add_seconds) {
	$v2 = strtotime($tmp_date);
	$v2 += ($add_seconds);
	return date("Y-m-d", $v2);
}

function dateFromMysql($tmp_date, $tmp_short_year = false, $tmp_separator = "/") {
	$arr = explode("-", $tmp_date);

	if ($tmp_short_year) {
		$arr[0] = substr($arr[0], 2, 2);
	}

	return $arr[2] . $tmp_separator . $arr[1] . $tmp_separator . $arr[0];
}

function datetimeToMysql($tmp_date) {
	$arr = explode(" ", $tmp_date);

	if (sizeof($arr) > 1) {
		$v = $arr[1];
	} else {
		$v = "";
	}

	return dateToMysql($arr[0]) . " " . $v;
}

function datetimeFromMysql($tmp_date, $tmp_short_year = false) {
	$arr = explode(" ", $tmp_date);

	if (sizeof($arr) > 1) {
		$v = $arr[1];
	} else {
		$v = "";
	}

	return dateFromMysql($arr[0], $tmp_short_year) . " " . $arr[1];
}

function monthToBrName($tmp_month) {
	return monthToBrEnEsName($tmp_month, 1);
}

function monthToBrEnEsName($tmp_month,$i = 1) {
	$month = findMonth($i);
	return $month[((int)$tmp_month) - 1];
}

function findMonth($language = 1) {
	$month = array();
	
	switch ($language) {
		case 'pt':
		case 1:
				$month[] = "Janeiro";
				$month[] = "Fevereiro";
				$month[] = "Março";
				$month[] = "Abril";
				$month[] = "Maio";
				$month[] = "Junho";
				$month[] = "Julho";
				$month[] = "Agosto";
				$month[] = "Setembro";
				$month[] = "Outubro";
				$month[] = "Novembro";
				$month[] = "Dezembro";
			break;
			
		case 'en':
		case 2:
				$month[] = "January";
				$month[] = "February";
				$month[] = "March";
				$month[] = "April";
				$month[] = "May";
				$month[] = "June";
				$month[] = "July";
				$month[] = "August";
				$month[] = "September";
				$month[] = "October";
				$month[] = "November";
				$month[] = "December";
			break;
			
		case 'es':
		case 3:
				$month[] = "Enero";
				$month[] = "Febrero";
				$month[] = "Marzo";
				$month[] = "Abril";
				$month[] = "Mayo";
				$month[] = "Junio";
				$month[] = "Julio";
				$month[] = "Agosto";
				$month[] = "Septiembre";
				$month[] = "Octubre";
				$month[] = "Noviembre";
				$month[] = "Diciembre";
			break;
	}
	
	return $month;
}

function returnArrayYear($yearfirst, $yearlast = '') {
	$yearlast = (($yearlast == '')?date('Y'):$yearlast);
	
	$arr_year = array();
	
	if ($yearfirst <= $yearlast) {
		for(;$yearfirst<=$yearlast;$yearfirst++) {
			$arr_year[$yearfirst] = $yearfirst;	
		}
	} else {
		for(;$yearfirst>=yearlast;$yearfirst--) {
			$arr_year[$yearfirst] = $yearfirst;	
		}
	}
	return $arr_year;
}

/**
 * @param $tmp_short  nomes cortos o longos
 * @return array
 */
function weekDaysBrName($tmp_short = false) {
	$day = array();
	if($tmp_short){
		$day[] = "Domingo";
		$day[] = "Segunda-feira";
		$day[] = "Terça-feira";
		$day[] = "Quarta-feira";
		$day[] = "Quinta-feira";
		$day[] = "Sexta-feira";
		$day[] = "Sábado";
	} else {
		$day[] = "Domingo";
		$day[] = "Segunda";
		$day[] = "Terça";
		$day[] = "Quarta";
		$day[] = "Quinta";
		$day[] = "Sexta";
		$day[] = "Sábado";
	}
	return $day;
}

/**
 * @param $tmp_week index o dia
 * @param $tmp_short  nomes cortos o longos
 * @return string
 */
function weekDayBrName($tmp_week,$tmp_short = false) {
	$days = weekDaysBrName($tmp_short);
	return $days[$tmp_week];
}

function dateFromMysqlToMask($tmp_date, $tmp_mask) {
	$t = strtotime($tmp_date);

	return date($tmp_mask, $t);
}

function dateInformal($tmp_date,$tmp_apenasinformal = false){
	$date = dateFromMysqlToMask($tmp_date,"d/m/Y");

	if($date == date("d/m/Y")){
		return "Hoje";
	} elseif ($date == date("d/m/Y",time()+86400)){//amanha
		return "Amanhã";
	} elseif ($date == date("d/m/Y",time()-86400)){//ontem
		return "Ontem";
	} else {
		if (!$tmp_apenasinformal) {
			if ($date == date("d/m/Y",time()+172800)){//depois de amanha
				return weekDayBrName(date("w",time()+172800),true)." ".date("d/m",time()+172800); // Ex. Segunda-feira 10/10
			} else {
				return substr($date,0,5); // 10/10
			}
		} else {
			return weekDayBrName(date("w",strtotime($tmp_date))); // Ex. Segunda
		}
	}
}

/**
 * Coloca o numero dos secundos e cria o string com informacões quanto é o tempo.
 * @param number $seconds  secundos
 * @return string  tempo passado
 */
function dateFromSeconds($seconds, $showSeconds = false) {
	// $ret = $seconds . ' seconds: ';
	$ret = '';

	$secondsInMinute = 60;
	$secondsInHour = 60 * $secondsInMinute;
	$secondsInDay = 24 * $secondsInHour;

	$days = floor($seconds / $secondsInDay);
	$seconds -= $days * $secondsInDay;

	$hours = floor($seconds / $secondsInHour);
	$seconds -= $hours * $secondsInHour;

	$minutes = floor($seconds / $secondsInMinute);
	$seconds -= $minutes * $secondsInMinute;

	$ret .= ($days == 1?$days . ' dia ':'');
	$ret .= ($days > 1?$days . ' dias ':'');
	$ret .= ($hours == 1?$hours . ' hora ':'');
	$ret .= ($hours > 1?$hours . ' horas ':'');
	$ret .= ($minutes == 1?$minutes . ' minuto ':'');
	$ret .= ($minutes > 1?$minutes . ' minutos ':'');
	if($showSeconds) {
		$seconds = floor($seconds);
		$ret .= ($seconds == 1? $seconds . ' segundo ':'');
		$ret .= (($seconds > 1 || $seconds == 0)? $seconds . ' segundos ':'');
	}

	return $ret;
}
?>