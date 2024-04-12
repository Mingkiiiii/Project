<?php
function alert($msg)
{
	echo "<script>alert('{$msg}')</script>";
}

function move($url)
{
	echo "<script>";
	echo $url ? "document.location.replace('{$url}')" : "history.back()";
	echo "</script>";
	exit;
}

function msgMove($msg, $url)
{
	alert($msg);
	move($url);
}

// DB 데이터 처리 함수
function dbFetch($code, $data_arr)
{
	global $pdo, $mb_r;

	$db = $pdo->prepare($code);

	$db->execute($data_arr);

	return $db->fetch(2);
}

// DB 데이터 행 개수
function dbRow($code, $data_arr)
{
	global $pdo, $mb_r;

	$db = $pdo->prepare($code);

	$db->execute($data_arr);

	return $db->rowCount();
}

// DB 데이터 처리 함수
function dbFetchAll($code, $data_arr)
{
	global $pdo, $mb_r;

	$db = $pdo->prepare($code);

	$db->execute($data_arr);

	return $db->fetchAll(2);
}

// DB 데이터 처리 함수
function dbUpload($code, $data_arr)
{
	global $pdo, $mb_r;

	$db = $pdo->prepare($code);

	$db->execute($data_arr);

	return;
}

// 현재 페이지와 메뉴 페이지 URL 체크
function menu_active_chk($url)
{
	if ($_SERVER['REQUEST_URI'] === $url) return 'menu-active';
}

// 회원 체크 함수
function userChk($type, $msg = '접근할 수 없는 페이지입니다.', $url = '/')
{
	global $mb_r;

	if ($type ===  'move') {
		if (!isset($mb_r)) msgMove($msg, $url);
	} else if ($type === 'die') {
		if (!isset($mb_r)) die($msg);
	} else if ($type === 'exit') {
		if (!isset($mb_r)) exit;
	}
}

// 방문 기록
function historyInsert()
{
	global $pdo;

	$ht_chk_db = $pdo->prepare("
			SELECT user_ip from visit_history
			where user_ip = ?
			and DATE_FORMAT(history_date, '%Y-%m-%d') = curdate()
			");
	$ht_chk_db->execute(array(
		$_SERVER["REMOTE_ADDR"],
	));

	$ht_chk = $ht_chk_db->fetch(2);

	if (!$ht_chk) {
		$ht_db = $pdo->prepare("
				INSERT into visit_history
				set user_ip = ?,
				history_date = now();
				");
		$ht_db->execute(array(
			$_SERVER["REMOTE_ADDR"],
		));
	}
}

// POST 폼 데이터 체크
function postDataChk($dataArray, $errorMsg, $errorType, $errorUrl)
{
	foreach ($dataArray as $k => $data) {
		$post_data = isset($_POST[$data]) ? $_POST[$data] : "";


		if (!isset($_POST[$data])) {
			// if(!isset($_POST[$data]) || (is_array($post_data) && count($post_data) === 0) || (!is_array($post_data) && trim($post_data) === "") ) {
			$error_msg = is_array($errorMsg) ? $errorMsg[$k] : $errorMsg;


			switch ($errorType) {
				case 'exit':
					exit;
					break;
				case 'move':
					msgMove($error_msg, ($errorUrl === "" ? $_SERVER['REQUEST_URI'] : $errorUrl));
					break;
				case 'die':
					die($error_msg);
					break;
			}
		}
	}
}

// 폼 데이터 입력이 됐는지 체크
function postValueChk($dataArray, $errorMsg, $errorType, $errorUrl)
{
	foreach ($dataArray as $k => $data) {
		$post_data = isset($_POST[$data]) ? $_POST[$data] : "";


		if (!isset($_POST[$data]) || trim($_POST[$data]) === "") {
			$error_msg = is_array($errorMsg) ? $errorMsg[$k] : $errorMsg;

			switch ($errorType) {
				case 'exit':
					exit;
					break;
				case 'move':
					msgMove($error_msg, ($errorUrl === "" ? $_SERVER['REQUEST_URI'] : $errorUrl));
					break;
				case 'die':
					die($error_msg);
					break;
			}
		}
	}
}

// GET 데이터 체크
function getDataChk($dataArray, $errorMsg, $errorType, $errorUrl)
{
	foreach ($dataArray as $k => $data) {
		$get_data = isset($_GET[$data]) ? $_GET[$data] : "";


		if (!isset($_GET[$data]) || (is_array($get_data) && count($get_data) === 0) || (!is_array($get_data) && trim($get_data) === "")) {
			$error_msg = is_array($errorMsg) ? $errorMsg[$k] : $errorMsg;


			switch ($errorType) {
				case 'exit':
					exit;
					break;
				case 'move':
					msgMove($error_msg, ($errorUrl === "" ? $_SERVER['REQUEST_URI'] : $errorUrl));
					break;
				case 'die':
					die($error_msg);
					break;
			}
		}
	}
}

// 숫자 체크
function postNumberChk($dataArray, $errorMsg, $errorType, $errorUrl)
{
	foreach ($dataArray as $k => $data) {
		$post_data = isset($_POST[$data]) ? $_POST[$data] : "";

		if (!isset($_POST[$data]) || !is_numeric($post_data)) {
			$error_msg = is_array($errorMsg) ? $errorMsg[$k] : $errorMsg;

			switch ($errorType) {
				case 'exit':
					exit;
					break;
				case 'move':
					msgMove($error_msg, $_SERVER['REQUEST_URI']);
					break;
				case 'die':
					die($error_msg);
					break;
			}
		}
	}
}

function xss_filter($val)
{
	// remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
	// this prevents some character re-spacing such as <java\0script>
	// note that you have to handle splits with \n, \r, and \t later since they *are*
	// allowed in some inputs
	$val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);

	$search = 'abcdefghijklmnopqrstuvwxyz';
	$search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$search .= '1234567890!@#$%^&*()';
	$search .= '~`";:?+/={}[]-_|\'\\';
	for ($i = 0; $i < strlen($search); $i++) {
		// ;? matches the ;, which is optional
		// 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

		// &#x0040 @ search for the hex values
		$val = preg_replace('/(&#[x|X]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val);
		// with a ;

		// &#00064 @ 0{0,7} matches '0' zero to seven times
		$val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
	}

	// now the only remaining whitespace attacks are \t, \n, and \r
	$ra1 = array(
		'javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style',
		'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base'
	);
	$ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
	$ra = array_merge($ra1, $ra2);

	$found = true; // keep replacing as long as the previous round replaced something
	while ($found == true) {
		$val_before = $val;
		for ($i = 0; $i < sizeof($ra); $i++) {
			$pattern = '/';
			for ($j = 0; $j < strlen($ra[$i]); $j++) {
				if ($j > 0) {
					$pattern .= '(';
					$pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
					$pattern .= '|(&#0{0,8}([9][10][13]);?)?';
					$pattern .= ')?';
				}
				$pattern .= $ra[$i][$j];
			}
			$pattern .= '/i';
			$replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
			$val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
			if ($val_before == $val) {
				// no replacements were made, so exit the loop
				$found = false;
			}
		}
	}
	return $val;
}

// 이미지 파일 압축
function imageCompress($source, $destination, $quality)
{

	$info = getimagesize($source);

	if ($info['mime'] == 'image/jpeg')
		$image = imagecreatefromjpeg($source);

	elseif ($info['mime'] == 'image/gif')
		$image = imagecreatefromgif($source);

	elseif ($info['mime'] == 'image/png')
		$image = imagecreatefrompng($source);

	imagejpeg($image, $destination, $quality);

	return $destination;
}

// 태그를 삭제하여 텍스트만 출력
function tagRemove($text)
{
	$after = str_replace(["\r", "\n"], ' ', strip_tags($text));
	$removeSpaces = trim(preg_replace("/\s+/", ' ', $after));

	return $removeSpaces;
}

// 텍스트 썸네일 추출
function textThumbnail($contents)
{
	preg_match("/<img[^>]*src=[\"']?([^>\"']+)[\"']?[^>]*>/i", $contents, $matches);

	return $matches[1];
}

function pagingFunction($code, $data_arr, $page, $list, $block)
{
	// 총 데이터 수
	$num = dbRow($code, $data_arr);

	// 페이지 당 데이터 수
	// $list = 10;
	// 블록 당 페이지 수
	// $block = 3;

	$pageNum = ceil($num / $list); // 총 페이지
	$blockNum = ceil($pageNum / $block); // 총 블록
	$nowBlock = ceil($page / $block);

	$s_page = ($nowBlock * $block) - ($block - 1);

	if ($s_page <= 1) {
		$s_page = 1;
	}

	$e_page = $nowBlock * $block;

	if ($pageNum <= $e_page) {
		$e_page = $pageNum;
	}

	$list_end_page = ceil($num / $block);

	$return_arr = [
		'page_num' => $pageNum,
		's_point' => ($page - 1) * $list,
		'list' => $list,
		'block' => $block,
		's_page' => $s_page,
		'e_page' => $e_page,
		'list_num' => $num,
		'list_end_page' => $list_end_page
	];

	return $return_arr;
}

function noImageHtml()
{
	return '<div class="no-image d-flex align-items-center justify-content-center flex-wrap">
			<div class="no-image-parent d-flex flex-wrap flex-column">
				<span class="image-icon text-center"><i class="fa fa-camera-retro"></i></span>
				<span class="image-text">No Image</span>
			</div>
		</div>';
}

// 임의의 문자열 생성 ( 특수문자 포함 )
function passwordGenerator($length = 12)
{

	$counter = ceil($length / 4);
	// 0보다 작으면 안된다.
	$counter = $counter > 0 ? $counter : 1;

	$charList = array(
		array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0"),
		array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"),
		array("!", "@", "#", "%", "^", "&", "*")
	);
	$password = "";
	for ($i = 0; $i < $counter; $i++) {
		$strArr = array();
		for ($j = 0; $j < count($charList); $j++) {
			$list = $charList[$j];

			$char = $list[array_rand($list)];
			$pattern = '/^[a-z]$/';
			// a-z 일 경우에는 새로운 문자를 하나 선택 후 배열에 넣는다.
			if (preg_match($pattern, $char)) array_push($strArr, strtoupper($list[array_rand($list)]));
			array_push($strArr, $char);
		}
		// 배열의 순서를 바꿔준다.
		shuffle($strArr);

		// password에 붙인다.
		for ($j = 0; $j < count($strArr); $j++) $password .= $strArr[$j];
	}
	// 길이 조정
	return substr($password, 0, $length);
}

function Encrypt($str, $secret_key = 'hsytUhnmW', $secret_iv = 'miUSFCkaXGR')
{
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 32);

	return str_replace(
		"=",
		"",
		base64_encode(
			openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv)
		)
	);
}


function Decrypt($str, $secret_key = 'hsytUhnmW', $secret_iv = 'miUSFCkaXGR')
{
	$key = hash('sha256', $secret_key);
	$iv = substr(hash('sha256', $secret_iv), 0, 32);

	return openssl_decrypt(
		base64_decode($str),
		"AES-256-CBC",
		$key,
		0,
		$iv
	);
}

	//}
