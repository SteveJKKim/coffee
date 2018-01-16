<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {

	public $MM, $SM;

    function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$this->Report();
	}

	public function Report()
	{
		$this->MM = '2';
		$this->load->library('session');
		$admin = $this->session->userdata();
		$this->load->library('Func');
		$this->func->chk_admin($admin);
		$this->load->view('lib_header');
		$this->load->view('Report');
		$this->load->view('lib_footer');
		$this->load->view('lib_ender');
	}
}
