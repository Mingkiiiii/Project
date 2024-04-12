<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/lib.php");

if (!isset($mb_r)) {
    die("접근할 수 없는 경로입니다.");
}

postValueChk([
    'recipe_idx',
], [
    '접근할 수 없는 경로입니다.',
], 'die', '/');

$scrap_check = dbFetch("
  SELECT * FROM recipe_scrap
  WHERE recipe_idx = ?
  AND user_id = ?
", [
  $_POST['recipe_idx'],
  $mb_r['user_id'],
]);

if ($scrap_check) {
  dbUpload("
  DELETE FROM recipe_scrap 
  WHERE recipe_idx = ?
  AND user_id = ?
  ", [
    $_POST['recipe_idx'],
    $mb_r['user_id'],
  ]);

  die('스크랩 취소');
} else {
  dbUpload("
    INSERT INTO recipe_scrap
    (recipe_idx, user_id, scrap_date) 
    VALUES 
    (?, ?, now())
    ", [
      $_POST['recipe_idx'],
      $mb_r['user_id'],
  ]);

  die('스크랩 추가');
}

