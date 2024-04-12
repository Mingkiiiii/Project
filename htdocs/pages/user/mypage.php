<?php
  include_once("{$_SERVER['DOCUMENT_ROOT']}/include/head.php");

  if (!isset($mb_r)) msgMove('회원만 접근할 수 있습니다.', '/');
?>

<body>
  <link rel="stylesheet" href="/css/user/mypage.css">

  <div id="wrap">
    <!-- 상단 영역 -->
    <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/header.php"); ?>

    <!-- 컨텐츠 중간 영역 -->
    <div id="contents">
      <div id="my-page">
        <div class="section-title">
          <h2>마이페이지</h2>
          <p>My Page</p>
        </div>
        
        <div class="mypage-form">
          <form onSubmit="return frmSubmit(this, '/ajax/user/user-update.php', '회원 정보를 수정했습니다.', './mypage.php');">
            <div class="user-image">
              <div class="user-icon image" onClick="$('#user_image_file')[0].click();">
                <img src="/uploads/user/<?= $mb_r['user_image'] ?>" alt="회원 이미지" id="user-preview-image" <?= $mb_r['user_image'] == '' ? 'style="display:none;"' : '' ?>>
                <i id="user-non-image" class="fas fa-user" style="<?= $mb_r['user_image'] != '' ? 'style="display:none;"' : '' ?>"></i>
              </div>
              <input type="hidden" name="user_image" id="user_image" value="">
              <input type="file" name="user_image_file" id="user_image_file" onChange="userImageUpload();" style="display:none;">
            </div>

            <div class="user-info">
              <div class="form-group">
                <label for="user_id">아이디</label>
                <input type="text" name="user_id" id="user_id" class="form-control" value="<?= $mb_r['user_id'] ?>" disabled >
              </div>

              <div class="form-group">
                <label for="user_name">이름</label>
                <input type="text" name="user_name" id="user_name" class="form-control" value="<?= $mb_r['user_name'] ?>" >
              </div>

              <div class="form-group">
                <label for="email">이메일</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= $mb_r['email'] ?>" >
              </div>
            </div>

            <div class="form-btn">
              <button type="submit">수정</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- 하단 영역 -->
    <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/footer.php"); ?>
  </div>

  <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/script.php"); ?>

  <script>
    function userImageChange(ts) {
      const file = ts.files[0];
      let image = new Image();

      let reader = new FileReader();

      reader.readAsDataURL(file);
      reader.onload = function(e) {
        image.src = e.target.result;

        image.onload = function(img) {
          console.log(image);
          $('#user-preview-image').attr('src', image.src);
          $('#user-preview-image').show();
          $('#user-non-image').hide();
        }
      }
    }

    //파일 업로드
    function userImageUpload() {
      var form = new FormData();
      form.append("image", $("#user_image_file")[0].files[0]);

      jQuery.ajax({
        url: "/ajax/user/user-image-upload.php",
        type: "POST",
        processData: false,
        contentType: false,
        data: form,
        success: function(response) {
          if (response == "에러") {
            alert('이미지만 업로드 가능합니다.');
          } else {
            $('#user_image').val(response);
            userImageChange($("#user_image_file")[0]);
          }
        },
        error: function(jqXHR) {
          alert(jqXHR.responseText);
        }
      });
    }
  </script>
</body>

</html>