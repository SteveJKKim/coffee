<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Summary extends CI_Controller {

	public $MM, $SM;

    function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$this->Summary();
	}

	public function Summary()
	{
		$this->MM = '1';
		$this->load->library('session');
		$admin = $this->session->userdata();
		$this->load->library('Func');
		$this->func->chk_admin($admin);
		$this->load->view('lib_header');
		$this->load->view('Summary');
		$this->load->view('lib_footer');
		$this->load->view('lib_chart');
		$this->load->view('lib_ender');
	}
}
