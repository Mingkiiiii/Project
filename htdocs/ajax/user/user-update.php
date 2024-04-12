<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

if (!isset($mb_r)) {
    die("회원만 접근할 수 있습니다.");
}

postValueChk([
    'user_name',
    'email',
], [
    '이름을 입력해주세요.',
    '이메일을 입력해주세요.',
], 'die', '/');

dbUpload("
  UPDATE member 
  SET user_name = ?, email = ?, user_image = ?
  WHERE idx = ?
", [
    $_POST['user_name'],
    $_POST['email'],
    $_POST['user_image'],
    $mb_r['idx'],
]);
