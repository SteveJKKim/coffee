<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

	public $MM, $SM ;

    function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$this->Member();
	}

	public function Member()
	{
		$this->MM = '3';
		$this->SM = '1';
		$this->load->library('session');
		$admin = $this->session->userdata();
		$this->load->library('Func');
		$this->func->chk_admin($admin);
		$this->pdo = $this->load->database('pdo', true);
		$this->load->model('Admin_m');
		$this->load->view('lib_header');
		$this->load->view('Member');
		$this->load->view('lib_footer');
		$this->load->view('lib_ender');
	}
}
