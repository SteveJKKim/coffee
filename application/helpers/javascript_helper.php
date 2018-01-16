<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// 경고창
function alert($msg='', $url='') {
	$CI =& get_instance();
	if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'>alert('".$msg."');";
	if ($url) echo "location.replace('".$url."');";
	else echo "history.go(-1);";
	echo "</script>";
	exit;
}
 
// 경고메세지 출력후 창을 닫음
function alert_close($msg) {
	$CI =& get_instance();
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> alert('".$msg."'); window.close(); </script>";
	exit;
}
 
// 경고메세지만 출력
function alert_only($msg) {
	$CI =& get_instance();
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> alert('".$msg."'); </script>";
	exit;
}

// 경고 후 진행
function alert_continue($msg) {
	$CI =& get_instance();
	echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
	echo "<script type='text/javascript'> alert('".$msg."'); </script>";
	exit;
}

function value_chk(O) {
	var Obj = $("#"+O);
	if(Obj.val()==="") {
		Obj.css("background-color", "#ffcc99");
		Obj.focus();
		return false;
	} else {
		Obj.css("background-color","transparent");
		return true;
	}
}
