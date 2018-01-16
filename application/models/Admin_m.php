<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_m extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }

	public function login($value) {	## 관리자 로그인 처리
		$query = $this->pdo->query("select * from admin where a_id=? and a_pw=?", array($value['name'], md5($value['pwd'])));
		$result = $query->result();
		return (count($result) > 0) ? $result : false;
//		return $result;
	}

}
