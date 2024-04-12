<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

postValueChk([
    'userid',
    'password',
    'password_ok',
    'username',
    'email',
], [
    '아이디를 입력해주세요.',
    '비밀번호를 입력해주세요.',
    '비밀번호 확인을 입력해주세요.',
    '이름을 입력해주세요.',
    '이메일을 입력해주세요.',
], 'die', '');

$idChk = dbFetch("SELECT * FROM member where user_id = ?", [
    $_POST['userid'],
]);

if ($idChk) {
    die('아이디가 이미 존재합니다.');
}

if ($_POST['password'] != $_POST['password_ok']) {
    die('비밀번호가 일치하지 않습니다.');
}

dbUpload("INSERT INTO member (user_id, password, user_name, email, join_date) VALUES (?, password(?), ?, ?, now())", [
    $_POST['userid'],
    $_POST['password'],
    $_POST['username'],
    $_POST['email'],
]);
