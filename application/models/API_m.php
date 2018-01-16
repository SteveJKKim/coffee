<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API_m extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	public function get_unique_id($data)
	{
		$rr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','1','2','3','4','5','6','7','8','9');
		$ran = array_rand($rr, 7);
		$xx = '';
		foreach($ran as $key => $val) $xx .= $rr[$val];
//		$xx = 'XX113FG';
		$query = $this->pdo->query("select m_code from member where m_code=?", array($xx));
		$result = $query->result_array();
		if (count($result) > 0)
		{
			$this->get_unique_id($data);
		}
		else
		{
			$sql = "
insert into member (
	m_code, m_name, phone, sns_id, mail, sex,
	area, img, birthday, recom_id, regdate,
	regtime
) values (
	?, ?, ?, ?, ?, ?,
	?, ?, ?, ?, now(),
	now()
)
			";
			$query = $this->pdo->query($sql, array(
				$xx, $data['name'], $data['phone'], $data['sns_id'], $data['mail'], $data['sex'],
				$data['area'], $data['img'], $data['birthday'], $data['recom_id']));
			return ($query != true) ? false : $xx ;
			return $xx;
		}
	}

	public function regist($data)
	{
		$query = $this->pdo->query("select m_idx, m_code from member where sns_id=? order by m_idx desc limit 1", array($data['sns_id']));
		$result = $query->result_array();
		if (!empty($result[0]['m_code']))
		{
			return $result[0]['m_code'];
		}
		else
		{
			return false;
		}
	}

	public function login($userid, $push = false)
	{
		$query = $this->pdo->query("select * from member where m_code=?", array($userid));
		$result = $query->result_array();
		if (count($result) > 0)
		{
			if (!empty($push))
			{
				$this->pdo->query("update member set push=? where m_code=?", array($push, $userid));
			}
			return $result;
		}
		else
		{
			return false;
		}
	}

	public function logout($userid)
	{
		return ($this->pdo->query("update member set login='n' where m_code=?", array($userid)) != false) ? true : false;
	}

	public function stampcheck($userid)
	{
		$date = date("Y-m-d");
		$query = $this->pdo->query("select date from stampcheck where m_idx=(select m_idx from member where m_code=?) and date=?", array($userid, $date));
		$result = $query->result_array();
		if (count($result) > 0)
		{
			return $result[0]['date'];
		}
		else
		{
			$this->pdo->query("insert into stampcheck (m_idx, date, time) values ((select m_idx from member where m_code=?), now(), now())", array($userid));
			return false;
		}
	}

	public function stamp($userid)
	{
		$date = date("Y-m");
		$query = $this->pdo->query("select count(date) as cnt from stampcheck where m_idx=(select m_idx from member where m_code=?) and date between ? and ? order by date asc", array($userid, $date.'-01', $date.'-31'));
		$result = $query->result_array();
		$return['cnt'] = $result[0]['cnt'];
		$query = $this->pdo->query("select date from stampcheck where m_idx=(select m_idx from member where m_code=?) and date=?", array($userid, date("Y-m-d")));
		$result = $query->result_array();
		$return['possible'] = (empty($result)) ? true : false;
		return $return;
	}

	public function start($value)
	{
		$sql = "select fake_name from coffee where c_date=? order by c_step";
		$query = $this->pdo->query($sql, array($value['date']));
		$result = $query->result('array');
/*		for($i = 1 ; $i < 4 ; $i++) {
			$sql = "select * from coffee where m_idx=(select m_idx from member where m_code=?) and c_date=? and c_step=?";
			$query = $this->pdo->query($sql, array($value['userid'], $value['date'], $i));
			$res = $query->result('array');
			if($res!=false) {
				$result[] = array(
					'c_step' => $res[0]['c_step'],
					'c_win' => 'yes'
					);
			} else {
				$result[] = array(
					'c_step' => $i,
					'c_win' => 'NULL'
					);
			}
		}
*/
		return $result;
	}

}
