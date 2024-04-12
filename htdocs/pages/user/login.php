<?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/head.php"); ?>

<body>
  <link rel="stylesheet" href="/css/user/login.css">

  <div id="wrap">
    <!-- 상단 영역 -->
    <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/header.php"); ?>

    <!-- 컨텐츠 중간 영역 -->
    <div id="contents">
      <div id="login-page">
        <div class="sub-title">
          <h3>로그인</h3>
        </div>

        <div class="login-form">
          <form onSubmit="return frmSubmit(this, '/ajax/user/login-ok.php', '로그인이 완료되었습니다.', '/');">
            <div class="form-row">
              <div class="col-md-4">
                <label for="userid">아이디 <span class="required-star">*</span></label>
              </div>
              <div class="col-md">
                <input type="text" name="userid" id="userid" class="form-control" placeholder="아이디를 입력해주세요" />
              </div>
            </div>

            <div class="form-row">
              <div class="col-md-4">
                <label for="userid">비밀번호 <span class="required-star">*</span></label>
              </div>
              <div class="col-md">
                <input type="password" name="password" id="password" class="form-control" placeholder="비밀번호를 입력해주세요" />
              </div>
            </div>

            <div class="form-btn">
              <div class="login-btn">
                <button type="submit">로그인</button>
              </div>

              <div class="join-btn">
                <button type="button" onClick="href('/pages/user/join.php');">회원가입</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- 하단 영역 -->
    <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/footer.php"); ?>
  </div>

  <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/script.php"); ?>
</body>

</html>