<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$this->load->view('Login');
	}

	public function confirm()
	{
		$value['name'] = $this->__ret(INPUT_POST, 'name');
		$value['pwd'] = $this->__ret(INPUT_POST, 'pwd');
		$this->pdo = $this->load->database('pdo', true);
		$this->load->model('Admin_m');
		$res = $this->Admin_m->Login($value);
		$this->load->library('Func');
		if($res == false) {
			$this->func->alert('접속 정보를 확인해 주세요');
			$this->func->hist();
		} else {
			$this->func->alert('안녕하세요 관리자님');
			$this->load->library('session');
			$admin = array( 'name' => '관리자', 'id' => 'Admin', 'regtime' => date("Y-m-d H:i:s") );
			$this->session->set_userdata($admin);
			$this->func->loca('/summary');
		}
		exit;
	}

	public function logout()
	{
		$admin = array( 'name' => null, 'id' => null, 'regtime' => null );
		$this->load->library('Func');
		$this->load->library('session');
		$this->session->set_userdata($admin);
		$this->func->alert("로그아웃 합니다");
		$this->func->loca("/");
	}

}
