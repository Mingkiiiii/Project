<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

if (!isset($mb_r)) {
    die("회원만 레시피를 등록할 수 있습니다.");
}

postValueChk([
    'recipe_name',
    'recipe_text',
], [
    '레시피 이름을 입력해주세요.',
    '레시피 내용을 입력해주세요.',
], 'die', '/');

dbUpload("INSERT INTO recipe (recipe_name, recipe_youtube, recipe_text, recipe_image, writer_id, write_date) VALUES (?, ?, ?, ?, ?, now())", [
    $_POST['recipe_name'],
    $_POST['youtube_video'],
    $_POST['recipe_text'],
    $_POST['recipe_image_name'],
    $mb_r['user_id'],
]);
