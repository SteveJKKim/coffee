<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Func {

	public function alert($msg, $ret = false) {
		$return = '<script>alert("'.$msg.'");</script>';
		if($ret == false) { echo $return; } else { return $return; }
	}

	public function loca($url, $msg = false, $ret = false) {
		if(!empty($msg)) { $this->alert($msg); }
		$return = '<script language="javascript">document.location.href="'.$url.'";</script>';
		if($ret == false) { echo $return; } else { return $return; }
	}

	public function hist($msg = false, $step = false, $ret = false) {
		if(!empty($msg)) { $this->alert($msg); }
		$go = ($step != false) ? $step : '-1';
		$return = '<script>history.go("'.$go.'");</script>';
		if($ret == false) { echo $return; } else { return $return; }
	}

	public function closePOP($msg = false, $ret = false, $opener = false) {
		if(!empty($msg)) { $this->alert($msg); }
		if(!empty($opener)) { if($opener === 'reload') { echo '<script>opener.document.location.reload();</script>'; } else { echo '<script>'.$opener.'</script>'; } }
		$return = '<script>window.close();</script>';
		if($ret == false) { echo $return; } else { return $return; }
	}

	public function slash($input, $tf = false, $ret = false) {
		$return = $input;
		if($tf == false) {
			$return = htmlspecialchars($return);
			$return = addslashes($return);
		} else if ($ret == true) {
			$return = stripslashes($return);
			$return = htmlspecialchars_decode($return);
		}
		if($ret == false) { return $return; } else { echo $return; }
	}

	public function base($input, $tf = false, $ret = false) {
		$return = $input;
		$return = ($tf == false) ? base64_encode(urlencode(base64_encode($return))) : base64_decode(urldecode(base64_decode($return)));
		if($ret == false) { return $return; } else { echo $return; }
	}

	public function cutStr($str, $len, $suf = '...') {
		if(strlen($str) <= $len) {return $str;}
		$cpos = $len - 1;
		$count_2B = 0;
		$lastchar = $str[$cpos];
		while(ord($lastchar) > 127 && $cpos >= 0) {
			$count_2B++;
			$cpos--;
			$lastchar = $str[$cpos];
		}
		if($count_2B % 2) { $len--; }
		return substr($str,0,$len).$suf;
	}

	public function refer($ref, $val) {
		return ($ref != $val) ? false : true;
	}

	public function preg($org, $div) {
		return (preg_match('/'.$org.'/', $div) != false) ? true : false;
	}

	public function chk_admin($admin) {
		if(empty($admin['name']) || empty($admin['id']) || empty($admin['regtime'])) {
			exit( $this->loca("/", "로그인 정보가 없습니다.\\n\\n다시 로그인 해 주세요") );
		}
	}

	public function select($object, $option, $ret = false) {
		$return = ($object == $option) ? ' selected' : '';
		if($ret == false) { return $return; } else { echo $return; }
	}

	public function checked($object, $option, $ret = false) {
		$return = ($object == $option) ? ' checked' : '';
		if($ret == false) { return $return; } else { echo $return; }
	}

	public function server() {
		echo 'IP : '.filter_input(INPUT_SERVER, 'REMOTE_ADDR').'<br /><br />';
		echo '</pre>';
	}

	public function directory($img, $dir) {
		$t1 = substr($img, 0, 1);
		$t2 = substr($img, 1, 1);
		$t3 = substr($img, 2, 1);
		$t4 = substr($img, 3, 1);
		if(is_dir($dir.'/'.$t1)==false) {mkdir($dir.'/'.$t1, 0755);}
		if(is_dir($dir.'/'.$t1.'/'.$t2)==false) {mkdir($dir.'/'.$t1.'/'.$t2, 0755);}
		if(is_dir($dir.'/'.$t1.'/'.$t2.'/'.$t3)==false) {mkdir($dir.'/'.$t1.'/'.$t2.'/'.$t3, 0755);}
		if(is_dir($dir.'/'.$t1.'/'.$t2.'/'.$t3.'/'.$t4)==false) {mkdir($dir.'/'.$t1.'/'.$t2.'/'.$t3.'/'.$t4, 0755);}
		return '/'.$t1.'/'.$t2.'/'.$t3.'/'.$t4.'/';
	}

	public function menu_main($input, $div, $ret = false) {
		$return = ($input == $div) ? ' active open' : '';
		if($ret == false) { echo $return; } else { return $return; }
	}

}
