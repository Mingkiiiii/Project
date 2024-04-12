<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

if (!isset($mb_r)) {
    die("회원만 댓글을 작성할 수 있습니다.");
}

postValueChk([
    'comment_text',
    'comment_type',
    'parent_idx',
], [
    '댓글을 입력해주세요.',
    '잘못 된 접근입니다.',
    '잘못 된 접근입니다.',
], 'die', '');

dbUpload(
    "INSERT INTO comment set comment_type = ?, parent_idx = ?, comment_text = ?, write_date = now(), writer_id = ?",
    [
        $_POST['comment_type'],
        $_POST['parent_idx'],
        $_POST['comment_text'],
        $mb_r['user_id'],
    ]
);
