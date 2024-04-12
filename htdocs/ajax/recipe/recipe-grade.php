<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

if (!isset($mb_r)) {
    die("접근할 수 없는 경로입니다.");
}

postValueChk([
    'recipe_grade',
    'recipe_idx',
], [
    '잘못 된 접근입니다.',
    '잘못 된 접근입니다.',
], 'die', '/');

dbUpload("
    INSERT INTO recipe_grade
    (grade, recipe_idx, user_id)
    VALUES
    (?, ?, ?)
    ON DUPLICATE KEY UPDATE
    grade = ?, recipe_idx = ?, user_id = ?
", [
    $_POST['recipe_grade'],
    $_POST['recipe_idx'],
    $mb_r['user_id'],
    $_POST['recipe_grade'],
    $_POST['recipe_idx'],
    $mb_r['user_id'],
]);
