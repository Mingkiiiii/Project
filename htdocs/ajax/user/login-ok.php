<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

postValueChk([
    'userid',
    'password',
], [
    '아이디를 입력해주세요.',
    '비밀번호를 입력해주세요.',
], 'die', '');

$result = dbFetch("SELECT * FROM member WHERE user_id = ? AND password = password(?)", [
    $_POST['userid'],
    $_POST['password'],
]);

if (!$result) {
    die('아이디 또는 비밀번호가 일치하지 않습니다.');
} else {
    $_SESSION['idx'] = $result['idx'];
}
