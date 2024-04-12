<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

if (!isset($mb_r)) {
    die("회원만 요리팁을 수정할 수 있습니다.");
}

postValueChk([
  'cooktip_idx',
    'title',
    'content',
], [
    '잘못 된 경로입니다.',
    '제목을 입력해주세요.',
    '내용을 입력해주세요.',
], 'die', '/');

dbUpload("UPDATE cooktip SET title = ?, content = ? WHERE idx = ? AND writer_id = ?", [
    $_POST['title'],
    $_POST['content'],
    $_POST['cooktip_idx'],
    $mb_r['user_id'],
]);
