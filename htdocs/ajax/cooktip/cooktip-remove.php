<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

if (!isset($mb_r)) {
    die("회원만 요리팁을 삭제할 수 있습니다.");
}

postValueChk([
    'idx',
], [
    '잘못 된 접근입니다.',
], 'die', '');

dbUpload("
    DELETE FROM cooktip WHERE idx = ? AND writer_id = ?
", [
    $_POST['idx'],
    $mb_r['user_id'],
]);
