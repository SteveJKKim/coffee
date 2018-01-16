<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class API extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

	public function UserChk($userid)	### 유저아이디가 없으면 process 중지
	{
		if (empty($userid))
		{
			$return = array(
				'result' => 'false',
				'error' => '1003',
				'errmsg' => '유저정보가 없습니다.'
			);
			echo json_encode($return, JSON_UNESCAPED_UNICODE);
			exit;
		}
	}

	public function Login()		### 회원가입 (이미 가입된 회원은 정보 출력만 합니다)  /  이미지랑 처리 프로세스 model 로 옮겨야 합니다
	{
		$this->output->set_content_type('application/json');

		$sns = $this->__ret(INPUT_POST, 'kakao_id');
		if(empty($sns))
		{
			$sns = $this->__ret(INPUT_GET, 'kakao_id');
		}

		if (empty($sns))
		{
			$return = array(
				'result' => 'false',
				'error' => '1004',
				'errmsg' => 'SNS 아이디가 없습니다.'
			);
			echo json_encode($return, JSON_UNESCAPED_UNICODE);
			exit;
		}

		$this->pdo = $this->load->database('pdo', true);
		$this->load->model('API_m');
		$data = array(
			'sns_id' => 'kakao_'.$sns,
			'mail' => $this->__ret(INPUT_POST, 'mail'),
			'sex' => $this->__ret(INPUT_POST, 'sex'),
			'age' => $this->__ret(INPUT_POST, 'age'),
			'area' => $this->__ret(INPUT_POST, 'area'),
			'name' => $this->__ret(INPUT_POST, 'name'),
			'phone' => $this->__ret(INPUT_POST, 'phone'),
			'img' => '',
			'birthday' => $this->__ret(INPUT_POST, 'birthday'),
			'recom_id' => $this->__ret(INPUT_POST, 'recom_id')
		);
		$result = $this->API_m->regist($data);
		if ($result != false)
		{
			$return = array(
				'result' => 'true',
				'error' => NULL,
				'errmsg' => NULL,
				'user_id' => $result
			);
		}
		else
		{
			$imgurl = $this->__ret(INPUT_POST, 'img_url');
			if (!empty($imgurl))
			{
				$data['img'] = $imgurl;
			}
			else
			{
				if ($_FILES['img']['error'] == '0')
				{
					$img_t = pathinfo($_FILES['img']['name']);
					$img_ext = strtolower($img_t['extension']);
					$img = $result.'_'.date("YmdHis").'.'.$img_ext;
					move_uploaded_file($_FILES['img']['tmpname'], '/var/www/rew.ad-fi.net/user_img/'.$img);
					$path_img = 'http://rew.ad-fi.net/user_img/'.$img;
					$data['img'] = $path_img;
				}
			}
			$result = $this->API_m->get_unique_id($data);
			if ($result != false) {
				$return = array(
					'result' => 'true',
					'error' => NULL,
					'errmsg' => NULL,
					'user_id' => $result
				);
			} else {
				$return = array(
					'result' => 'false',
					'error' => '1001',
					'errmsg' => '회원 가입 시 알수없는 오류 발생입니다'
				);
			}
		}
		echo json_encode($return, JSON_UNESCAPED_UNICODE);
	}

	public function Logout()	### 로그아웃 처리 (로그아웃 하면 모든 자동 로직에서 제외)
	{
		$this->output->set_content_type('application/json');
		$userid = $this->__ret(INPUT_POST, 'user_id');
		if (empty($userid))
		{
			$userid = $this->__ret(INPUT_GET, 'user_id');
		}
		$this->UserChk($userid);
		$this->pdo = $this->load->database('pdo', true);
		$this->load->model('API_m');
		$result = $this->API_m->logout($userid);
		if ($result != false) {
			$return = array(
				'result' => 'true',
				'error' => NULL,
			);
		} else {
			$return = array(
				'result' => 'false',
				'error' => '1004',
				'errmsg' => '로그아웃 시 알수없는 오류 발생입니다'
			);
		}
		echo json_encode($return, JSON_UNESCAPED_UNICODE);
	}

	public function deluser()	## 회원탈퇴
	{
	}

	public function Start()	### 앱 실행 시 처리되어야 할 내용
	{
		$this->output->set_content_type('application/json');
		$userid = $this->__ret(INPUT_POST, 'user_id');
		if (empty($userid))
		{
			$userid = $this->__ret(INPUT_GET, 'user_id');
		}
		$this->UserChk($userid);
		$push = $this->__ret(INPUT_POST, 'push_key');

		$this->pdo = $this->load->database('pdo', true);
		$this->load->model('API_m');
		$result = $this->API_m->login($userid, $push);
		if ($result != false)
		{
			$data['userid'] = $userid;
			$data['date'] = date("Y-m-d");

			$start = $this->API_m->start($data);
			foreach($start as $key => $val) {
				$winner[] = array(
					"title" => $val['fake_name'].' 님이 커피추첨에 당첨되었습니다.'
					);
			}

			$return = array(
				'result' => 'true',
				'error' => NULL,
				'errmsg' => NULL,
				'name' => $result[0]['m_name'],
				'point' => $result[0]['point'],
				'winner' => $winner
			);
		}
		else
		{
			$return = array(
				'result' => 'false',
				'error' => '1002',
				'errmsg' => '없는 회원정보 입니다.'
			);
		}
		echo json_encode($return, JSON_UNESCAPED_UNICODE);
	}

	public function Coupon()	### 해당 회원 금일 쿠폰 관련
	{
		$this->output->set_content_type('application/json');
		$userid = $this->__ret(INPUT_POST, 'user_id');
		if (empty($userid))
		{
			$userid = $this->__ret(INPUT_GET, 'user_id');
		}
		$this->UserChk($userid);
		$return = array(
			'coupon' => array(
				'1' => array('possible' => 'no', 'win' => 'no'),
				'2' => array('possible' => 'no', 'win' => 'yes'),
				'3' => array('possible' => 'yes', 'win' => null)
			)
		);
		echo json_encode($return, JSON_UNESCAPED_UNICODE);
	}

	public function StampCheck()	### 출석체크 (금일 이미 했으면 오늘 날자 출력함)
	{
		$this->output->set_content_type('application/json');
		$userid = $this->__ret(INPUT_POST, 'user_id');
		if (empty($userid))
		{
			$userid = $this->__ret(INPUT_GET, 'user_id');
		}
		$this->UserChk($userid);
		$this->pdo = $this->load->database('pdo', true);
		$this->load->model('API_m');
		$result = $this->API_m->stampcheck($userid);
		if ($result != false)
		{
			$return = array(
				'result' => 'false',
				'error' => '8001',
				'errmsg' => '이미 체크하였습니다',
				'date' => $result
			);
		}
		else
		{
			$return = array(
				'result' => 'true',
				'error' => NULL,
				'errmsg' => NULL
			);
		}
		echo json_encode($return, JSON_UNESCAPED_UNICODE);
	}

	public function Stamp()		### 스템프 체크 내역
	{
		$this->output->set_content_type('application/json');
		$userid = $this->__ret(INPUT_POST, 'user_id');
		if (empty($userid))
		{
			$userid = $this->__ret(INPUT_GET, 'user_id');
		}
		$this->UserChk($userid);
		$this->pdo = $this->load->database('pdo', true);
		$this->load->model('API_m');
		$result = $this->API_m->stamp($userid);
		$return = array(
			'result' => true,
			'possible' => $result['possible'],
			'stamp_count' => $result['cnt']
		);
/*		$ret_date = true;
		if ($result != false)
		{
			$date = date("Y-m-e");
			foreach($result as $key => $val)
			{
				if($val->date == date("Y-m-d"))
				{
					$ret_date = false;
				}
				$date[] = $val->date;
			}
			$return = array(
				'result' => 'true',
				'error' => null,
				'possible' => $ret_date,
				'date' => $date
			);
		}
		else
		{
			$return = array(
				'result' => 'true',
				'error' => null,
				'possible' => $ret_date
			);
/*			$return = array(
				'result' => 'false',
				'error' => '8002',
				'errmsg' => '데이터 로드 중 오류가 발생하였습니다'
			);*/
//		}
		echo json_encode($return, JSON_UNESCAPED_UNICODE);
	}

	public function Profile()
	{
		$this->output->set_content_type('application/json');
		$userid = $this->__ret(INPUT_POST, 'user_id');
		if (empty($userid))
		{
			$userid = $this->__ret(INPUT_GET, 'user_id');
		}
		$this->UserChk($userid);
		$this->pdo = $this->load->database('pdo', true);
		$this->load->model('API_m');
		$result = $this->API_m->profile($userid);
		if ($result != false)
		{
			foreach($result as $key => $val) $date[] = $val->date;
			$return = array(
				'result' => 'false',
				'error' => '8001',
				'date' => $date
			);
		}
		else
		{
			$return = array(
				'result' => 'false',
				'error' => '8002',
				'errmsg' => '데이터 로드 중 오류가 발생하였습니다'
			);
		}
		echo json_encode($return, JSON_UNESCAPED_UNICODE);
	}

	public function Coffee()
	{

	}

/*
	public function Coffee()
	{
		$this->output->set_content_type('application/json');
		$userid = $this->__ret(INPUT_POST, 'user_id');
		if (empty($userid))
		{
			$userid = $this->__ret(INPUT_GET, 'user_id');
		}
		$time = date("H");

		$this->UserChk($userid);
		$this->pdo = $this->load->database('pdo', true);
		$this->load->model('API_m');

		$data['userid'] = $userid;
		$data['date'] = date("Y-m-d");

		$result = $this->API_m->coffee($data);

		if (count($result) == 3)
		{
			foreach($result as $key => $val) {
				$win[] = array(
					'time' => $val['c_step'],
					'win' => $val['c_win']
					);
			}
			$return = array(
				'result' => 'true',
				'error' => 'NULL',
				'win' => $win
			);
		}
		else
		{
			$return = array(
				'result' => 'false',
				'error' => '8003',
				'errmsg' => '데이터 로드 중 오류가 발생하였습니다'
			);
		}
		echo json_encode($return, JSON_UNESCAPED_UNICODE);
	}
*/
}
