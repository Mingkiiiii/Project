<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

if (!isset($mb_r)) {
    die("회원만 요리팁을 등록할 수 있습니다.");
}

postValueChk([
    'title',
    'content',
], [
    '제목을 입력해주세요.',
    '내용을 입력해주세요.',
], 'die', '/');

dbUpload("INSERT INTO cooktip (title, content, writer_id, write_date) VALUES (?, ?, ?, now())", [
    $_POST['title'],
    $_POST['content'],
    $mb_r['user_id'],
]);
