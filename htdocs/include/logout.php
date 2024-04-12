<?php 
	include_once("./lib.php");

	session_destroy();

	msgMove('로그아웃이 완료되었습니다.', '/');