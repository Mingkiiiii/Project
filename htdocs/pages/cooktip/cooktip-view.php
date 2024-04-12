<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/head.php");

$idx = isset($_GET['idx']) ? $_GET['idx'] : 0;

// 레시피 데이터
$recipe_data = dbFetch("
  SELECT *, DATE_FORMAT(write_date, '%Y.%m.%d') w_date 
  FROM cooktip
  WHERE idx = ?
  ", [
    $idx,
]);

if (!$recipe_data) {
    msgMove('존재하지 않는 요리팁 게시글 입니다.', '/');
}
?>;

<body>
    <link rel="stylesheet" href="/css/recipe/recipe-view.css">
    <link rel="stylesheet" href="/css/comment/comment.css">
    <link rel="stylesheet" href="/css/etc/board.css">
    <link rel="stylesheet" href="/js_libs/smarteditor2-2.8.2.3/css/smart_editor2_out.css" />

    <div id=" wrap">
        <!-- 상단 영역 -->
        <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/header.php"); ?>

        <!-- 컨텐츠 중간 영역 -->
        <div id="contents">
            <!-- 컨텐츠 섹션 영역 -->
            <div id="section">
                <div class="section-list">
                    <div class="container">
                        <div class="recipe-view">
                            <div class="recipe-top">
                                <h4 class="recipe-name"><?= $recipe_data['title'] ?></h4>

                                <p class="write-date"><?= $recipe_data['w_date'] ?></p>
                            </div>

                            <div class="recipe-content">
                                <div class="recipe-text se2_outputarea">
                                    <?= $recipe_data['content'] ?>
                                </div>
                            </div>

                            <?php if (isset($mb_r) && $mb_r['user_id'] == $recipe_data['writer_id']) { ?>
                                <div class="board-control-btn">
                                    <button type="button" class="modify-btn" onClick="href('./cooktip-modify.php?idx=<?= $idx ?>');">수정</button>
                                    <button type="button" class="remove-btn" onClick="recipeRemove(<?= $idx ?>);">삭제</button>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 하단 영역 -->
        <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/footer.php"); ?>
    </div>

    <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/script.php"); ?>

    <script>
      function recipeRemove(idx) {
        $.ajax({
          type: "POST",
          url: "/ajax/cooktip/cooktip-remove.php",
          data: { idx: idx },
          success: function(result) {
            if (result) {
              alert(result);
            } else {
              alert('요리팁이 삭제되었습니다.');
              href('./cooktip.php')
            }
          }
        })
      }
    </script>
</body>

</html>