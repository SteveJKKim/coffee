<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process_m extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	public function Coffee()
	{
		$date = date("Y-m-d");
		$hour = date("H");
		Switch($hour) {
			Case '08' : $step = '1'; break;
			Case '12' : $step = '2'; break;
			Case '16' : $step = '3'; break;
		}
		try {
			$sql = "select c_idx from coffee where c_date=? and c_step=?";
			$query = $this->pdo->query($sql, array($date, $step));
			$res = $query->result('array');
			if(count($res) > 0) { exit; }
			unset($query);
			unset($res);
			$sql = "select count(m_idx) as cnt from member where 1";
			$mm = $this->pdo->query($sql);
			$rr = $mm->result('array');
			if($rr[0]['cnt'] > 10000) {	## 1만 이상
				$sql = "select m_idx, left(m_code, 3) as cd from member where 1 order by rand() limit 3";
				$mem = $this->pdo->query($sql);
				$res = $mem->result('array');
				foreach($mem[0] as $key => $val) {
					$sql = "insert into coffee (m_idx, c_fake, fake_name, c_date, c_step, c_win) values (?, ?, ?, ?, ?, 'y')";
					$this->pdo->query($sql, array(
						$val['m_idx'], 'n', $val['cd'].'****', $date, $step
						));
				}
			} else {	## 1만 미만
				$rr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9');
				$ran = $this->Coffee_rand();
				for($i = 0 ; $i < count($ran) ; $i++) {
					$sql = "select m_idx, left(m_code,3) as cd from member where m_idx=?";
					$mem = $this->pdo->query($sql, array($ran[$i]));
					$res = $mem->result('array');
					$cd = '';
					if(!empty($res[0]['m_idx'])) {
						$fake = 'n';
						$cd = $res[0]['cd'].'****';
						$idx = $res[0]['m_idx'];
					} else {
						$fake = 'y';
						$rd = array_rand($rr, 3);
						foreach($rd as $key => $val) $cd .= $rr[$val];
						$cd .= '****';
						$idx = $ran[$i];
					}
					$sql = "insert into coffee (m_idx, c_fake, fake_name, c_date, c_step, c_win) values (?, ?, ?, ?, ?, 'y')";
					$this->pdo->query($sql, array(
						$idx, $fake, $cd, $date, $step
						));
				}
			}
		} catch (Exception $e) {
			exit ($e->getMessage(). '<br />'.__CLASS__. ' :: '. __FUNCTION__.' :: '.__LINE__);
		}
	}

	public function Coffee_rand()
	{
		for($i = 1 ; $i < 10000 ; $i++) $ran[$i] = $i;
		$rr = array_rand($ran, 3);
		return $rr;
	}
}