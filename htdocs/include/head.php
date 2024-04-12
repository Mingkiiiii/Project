<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

$page_title = isset($page_title) ? $page_title : "MYRECIPE";
?>
<!DOCTYPE html>
<html lang="ko">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width">
	<title><?= $page_title ?></title>

	<link rel="preconnect" href="https://fonts.gstatic.com" />
	<linkq href="https://fonts.googleapis.com/css2?family=Karla:wght@200;300;400;500;600;700;800&family=Noto+Sans+KR:wght@100;300;400;500;700;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet" />

	<link rel="shortcut icon" href="/images/favicon.png">

	<!-- <link rel="shortcut icon" href="/images/logo/logo.png"> -->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0/css/all.min.css">

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css" />

	<link rel=" stylesheet" href="/css/default.css">

	<link rel="stylesheet" href="/css/modal.css">

	<link rel="stylesheet" href="/css/all.css">

	<link rel="stylesheet" href="/css/main.css">

	<?php
	if (count($url_slash_arr) === 2) {
		echo '<link rel="stylesheet" href="/css/main.css">';
	}
	?>

	<!-- 

	<?php
	if (count($url_slash_arr) >= 3 && $url_slash_arr[2] === "member") {
		echo '<link rel="stylesheet" href="/css/member.css">';
	}
	?> -->
</head>