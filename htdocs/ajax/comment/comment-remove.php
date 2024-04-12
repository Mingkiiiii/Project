<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

if (!isset($mb_r)) {
    die("회원만 댓글을 작성할 수 있습니다.");
}

postValueChk([
    'comment_idx',
], [
    '잘못 된 접근입니다.',
], 'die', '');

dbUpload(
    "DELETE FROM comment WHERE writer_id = ? AND idx = ?",
    [
        $mb_r['user_id'],
        $_POST['comment_idx'],
    ]
);
