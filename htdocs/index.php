<?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/head.php"); ?>

<body>

  <div id="wrap">
    <!-- 상단 영역 -->
    <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/header.php"); ?>

    <!-- 컨텐츠 중간 영역 -->
    <div id="contents">
      <!-- 메인 배너 -->
      <div id="main-banner">
        <div class="container">
          <div class="banner-image">
            <ul>
              <li>
                <img src="/images/banner/banner_1.jpg" alt="배너 1">
              </li>

              <li>
                <img src="/images/banner/banner_2.jpg" alt="배너 2">
              </li>

              <li>
                <img src="/images/banner/banner_3.jpg" alt="배너 3">
              </li>
            </ul>

            <div class="banner-arrow">
              <button class="prev-btn"><i class="fas fa-chevron-left"></i></button>
              <button class="next-btn"><i class="fas fa-chevron-right"></i></button>
            </div>
          </div>
        </div>
      </div>

      <!-- 컨텐츠 섹션 영역 -->
      <div id="section">
        <?php if (isset($mb_r)) { ?>
          <section id="my-recipe">
            <div class="section-title">
              <h2>나의 레시피</h2>
              <p>My Recipe</p>
            </div>

            <div class="section-list">
              <div class="container">
                <div class="row">
                  <?php
                  $recipe_data = dbFetchAll("
                  SELECT r.*, (SELECT COUNT(*) FROM recipe_scrap rs WHERE rs.recipe_idx = r.idx) s_count,
                  (SELECT ROUND(AVG(grade)) FROM recipe_grade WHERE recipe_idx = r.idx) grade_avg,
                  m.user_name
                  from recipe r LEFT OUTER JOIN (SELECT recipe_idx, user_id FROM recipe_scrap) rs
                  ON r.idx = rs.recipe_idx
                  LEFT OUTER JOIN member m
                  ON r.writer_id = m.user_id
                  WHERE rs.user_id = ?
                  ORDER BY r.idx DESC
                  LIMIT 4
                ", [
                  $mb_r['user_id'],
                  ]);

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
          </section>
        <?php } ?>

        <section id="best-recipe">
          <div class="section-title">
            <h2>베스트 레시피</h2>
            <p>Best Recipe</p>
          </div>

          <div class="section-list">
            <div class="container">
              <div class="row">
                <?php
                $recipe_data = dbFetchAll("
                  SELECT r.*, (SELECT COUNT(*) FROM recipe_scrap rs WHERE rs.recipe_idx = r.idx) s_count,
                  (SELECT ROUND(AVG(grade)) FROM recipe_grade WHERE recipe_idx = r.idx) grade_avg,
                  m.user_name
                  from recipe r LEFT OUTER JOIN member m
                  ON r.writer_id = m.user_id
                  ORDER BY grade_avg DESC
                  LIMIT 4
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

  <script>
    $('.banner-image > ul').slick({
      autoplay: true,
      arrows: false, 
    });

    $('.banner-arrow .prev-btn').on('click', function(e) {
      $('.banner-image > ul').slick('slickPrev');
    })

    $('.banner-arrow .next-btn').on('click', function(e) {
      $('.banner-image > ul').slick('slickNext');
    })
  </script>
</body>

</html>