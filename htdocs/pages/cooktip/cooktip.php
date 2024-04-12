<?php
  include_once("{$_SERVER['DOCUMENT_ROOT']}/include/head.php");

  if (!isset($mb_r)) {
    msgMove('회원만 접근 가능합니다.', '/');
  }

  $cooktip_data = dbFetchAll("
    SELECT *, DATE_FORMAT(write_date, '%Y.%m.%d') w_date FROM cooktip
    WHERE writer_id = ?
  ", [
    $mb_r['user_id'],
  ]);
?>

<body>
  <link rel="stylesheet" href="/css/cooktip/cooktip.css">

  <div id="wrap">
    <!-- 상단 영역 -->
    <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/header.php"); ?>

    <!-- 컨텐츠 중간 영역 -->
    <div id="contents">
      <!-- 컨텐츠 섹션 영역 -->
      <div id="section">
        <section id="my-recipe">
          <div class="section-title">
            <h2>나의 요리팁</h2>
            <p>My Cooktip</p>
          </div>


          <div class="section-list">
            <div class="container">
              <div class="cooktip-write-btn">
                <button type="button" onClick="href('/pages/cooktip/cooktip-write.php');">작성</button>
              </div>

              <table class="table table-striped table-hover cooktip-table">
                <colgroup>
                  <col style="width:80%;" />
                  <col style="width:20%;" />
                </colgroup>

                <thead>
                  <tr>
                    <th>제목</th>
                    <th>작성 일자</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if (count($cooktip_data) == 0) { ?>
                    <tr>
                      <td colspan="2">게시글이 존재하지 않습니다.</td>
                    </tr>
                  <?php } ?>
                  <?php
                    foreach($cooktip_data as $k => $cooktip) {
                  ?>
                  <tr onClick="href('/pages/cooktip/cooktip-view.php?idx=<?= $cooktip['idx'] ?>');">
                    <td><?= $cooktip['title'] ?></td>
                    <td><?= $cooktip['w_date'] ?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </section>
      </div>
    </div>

    <!-- 하단 영역 -->
    <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/footer.php"); ?>
  </div>

  <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/script.php"); ?>
</body>

</html>