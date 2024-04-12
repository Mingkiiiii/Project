<?php
// 상수 선언
define("root", $_SERVER["HTTP_HOST"]);

ini_set( 'display_errors', '0' );

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

$pdo = new PDO("mysql:host=localhost; charset=utf8; dbname=recipe;", "root", "");

header("content-type:text/html; charset=utf-8");

session_start();

date_default_timezone_set("Asia/Seoul");


define("_ROOT", $_SERVER['DOCUMENT_ROOT']);

extract($_POST, EXTR_SKIP);

// 회원 로그인이 되어있을경우 변수에 데이터 저장
if (isset($_SESSION['idx']) && $_SESSION['idx'] !== '') {
	$mb_db = $pdo->prepare("
			SELECT * from  member where idx = ?
			");

	$mb_db->execute(array(
		$_SESSION['idx']
	));

	$mb_r = $mb_db->fetch(2);
}

// url 배열
$url_slash_arr = explode("/", $_SERVER['REQUEST_URI']);

include_once("function.php");

// 방문기록 함수 호출
// historyInsert();
