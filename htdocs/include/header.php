<div id="header">
  <div class="container">
    <div class="hd-wrap">
      <div class="util-menu">
        <ul>
          <?php if (isset($mb_r)) { ?>
            <li><a href="/pages/user/logout.php">로그아웃</a></li>
          <?php } else { ?>
            <li><a href="/pages/user/join.php">회원가입</a></li>
            <li><a href="/pages/user/login.php">로그인</a></li>
          <?php } ?>
        </ul>
      </div>

      <div id="logo">
        <h1><a href="/">MYRECIPE</a></h1>
      </div>

      <div id="main-menu">
        <ul>
          <li><a href="/pages/recipe/recipe.php">레시피</a></li>
          <li><a href="/pages/cooktip/cooktip.php">나의 요리팁</a></li>
          <li><a href="/pages/recipe/my-recipe.php">나의 레시피</a></li>
          <li><a href="/pages/user/mypage.php">마이페이지</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>