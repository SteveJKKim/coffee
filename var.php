<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

header("Content-Type: text/html; charset=UTF-8");
session_start();

function ret($key, $val, $ret = false) {
	$return = filter_input($key, $val);
	$return = preg_replace('/select|union|insert|update|delete|drop|\"|\'|#|\/\*|\*\/|\\\/', '', $return);
	if($ret == false) { return $return; } else { echo $return; }
}

function ret_arr($key, $val, $ret = false) {
	$args = array($val => array('flags' => FILTER_REQUIRE_ARRAY));
	$tmp = filter_input_array($key, $args);
	$return = array();
	foreach($tmp as $key => $vv) {
		$return = preg_replace('/select|union|insert|update|delete|drop|\"|\'|#|\/\*|\*\/|\\\/', '', $vv);
	}
	if($ret == false) { return $return; } else { echo $return; }
}

define('__root__', ret(INPUT_SERVER, 'DOCUMENT_ROOT'));
define('__pdo__', __root__.'/Class/Class.PDO.php');
define('__func__', __root__.'/Class/Class.Func.php');
define('__date__', date("Y-m-d"));
define('__time__', date("H:i:s"));
define('__stamp__', time());
define('__self__', ret(INPUT_SERVER, 'PHP_SELF'));
define('__dom__', 'rew.ad-fi.net');
define('__page__', __root__.'/Class/Class.Page.php');
define('__ver_js__', '?v=20170711001');
define('__ver_css__', '?v=20170711001');

define('__header__', __root__.'/lib/header.php');
define('__footer__', __root__.'/lib/footer.php');
define('__ender__', __root__.'/lib/ender.php');

$__title__ = 'ADMIN';

if(!empty($_SESSION)) { extract($_SESSION); }
