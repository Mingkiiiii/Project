<?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/head.php"); ?>

<body>
  <link rel="stylesheet" href="/css/recipe.css">

  <div id="wrap">
    <!-- 상단 영역 -->
    <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/header.php"); ?>

    <!-- 컨텐츠 중간 영역 -->
    <div id="contents">
      <!-- 컨텐츠 섹션 영역 -->
      <div id="section">
        <section id="my-recipe">
          <div class="section-title">
            <h2>레시피</h2>
            <p>Recipe</p>
          </div>


          <div class="section-list">
            <div class="container">
              <?php if (isset($mb_r)) { ?>
                <div class="writer-btn">
                  <button type="button" onClick="href('/pages/recipe/recipe-write.php');">레시피 작성</button>
                </div>
              <?php } ?>

              <div class="row">
                <?php
                $recipe_data = dbFetchAll("
                  SELECT r.*, (SELECT COUNT(*) FROM recipe_scrap rs WHERE rs.recipe_idx = r.idx) s_count,
                  (SELECT ROUND(AVG(grade)) FROM recipe_grade WHERE recipe_idx = r.idx) grade_avg,
                  m.user_name
                  from recipe r LEFT OUTER JOIN member m
                  ON r.writer_id = m.user_id
                  ORDER BY idx DESC
                ", []);

                foreach ($recipe_data as $k => $data) {
                ?>
                  <div class="col-md-6">
                    <div class="box" onClick="href('/pages/recipe/recipe-view.php?idx=<?= $data['idx'] ?>');">
                      <div class="info-box">
                        <h4><?= $data['recipe_name'] ?></h4>

                        <div class="recipe-grade">
                          <ul>
                            <?php
                            for ($i = 0; $i < $data['grade_avg']; $i++) {
                            ?>
                              <li class="fill-star"><i class="fas fa-star"></i></li>
                            <?php } ?>
                            <?php
                            for ($i = $data['grade_avg']; $i < 5; $i++) {
                            ?>
                              <li class="empty-star"><i class="far fa-star"></i></li>
                            <?php } ?>
                          </ul>
                        </div>

                        <div class="box-bottom">
                          <div class="scrap-count">
                            <p>스크랩 : <?= $data['s_count'] ?></p>
                          </div>

                          <div class="writer-name">
                            <p>작성자 : <?= $data['user_name'] ?></p>
                          </div>
                        </div>
                      </div>

                      <div class="info-image image">
                        <img src="/uploads/recipe/<?= $data['recipe_image'] ?>" alt="레시피 1">
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
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