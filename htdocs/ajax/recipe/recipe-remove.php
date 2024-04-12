<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

if (!isset($mb_r)) {
    die("회원만 레시피를 삭제할 수 있습니다.");
}

postValueChk([
    'idx',
], [
    '잘못 된 접근입니다.',
], 'die', '');

dbUpload("
    DELETE FROM recipe WHERE idx = ? AND writer_id = ?
", [
    $_POST['idx'],
    $mb_r['user_id'],
]);
