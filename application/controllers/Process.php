<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends CI_Controller {

	public $MM, $SM;

    function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
		$this->coffee();
	}

	public function Coffee()
	{
		$this->pdo = $this->load->database('pdo', true);
		$this->load->model('Process_m');
		$data = $this->Process_m->Coffee();
	}
}
