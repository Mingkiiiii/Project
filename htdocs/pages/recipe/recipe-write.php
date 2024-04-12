<?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/head.php"); ?>

<link rel="stylesheet" href="/css/recipe/recipe-write.css">

<body>

  <div id="wrap">
    <!-- 상단 영역 -->
    <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/header.php"); ?>

    <!-- 컨텐츠 중간 영역 -->
    <div id="contents">
      <!-- 컨텐츠 섹션 영역 -->
      <div id="section">
        <section id="my-recipe">
          <div class="section-title">
            <h2>레시피 작성</h2>
            <p>Recipe Write</p>
          </div>

          <div class="recipe-write-form">
            <div class="container">
              <form method="post" enctype="multipart/form-data" onSubmit="return frmSubmit(this, '/ajax/recipe/recipe-write.php', '레시피를 등록했습니다.', '/');">
                <div class="form-group">
                  <label for="recipe_name">레시피 이름</label>
                  <input type="text" name="recipe_name" id="recipe_name" class="form-control" placeholder="레시피 이름을 입력해주세요." required>
                </div>

                <div class="form-group">
                  <label for="recipe_youtube">유튜브 영상</label>
                  <textarea type="text" name="youtube_video" id="youtube_video" class="form-control" placeholder='YOUTUBE 동영상 ID(ex: lKyOIDYn5Xo)'></textarea>
                </div>

                <div class="form-group">
                  <label for="recipe_thumbnail">레시피 썸네일</label>
                  <div class="thumbnail-image" style="display:none;">
                    <img src="" alt="" id="thumbnail-image" style="width:200px;">
                  </div>

                  <div class="thumbnail-file">
                    <button type="button" class="thumbnail-btn" onClick="$('#recipe_thumbnail')[0].click()">파일 선택</button>
                    <input type="file" name="recipe_thumbnail" id="recipe_thumbnail" class="form-control" style="display:none;" onChange="recipeImageUpload();" required>
                    <input type="hidden" name="recipe_image_name" id="recipe_image_name" value="" />
                  </div>
                </div>

                <div class="form-group">
                  <label for="recipe_text">레시피 내용</label>
                  <textarea type="text" name="recipe_text" id="recipe_text" class="form-control" style="height:500px; width:100%;" placeholder=''></textarea>
                </div>

                <div class="form-btn">
                  <button type="button" onClick="formSubmit();">작성</button>
                </div>
              </form>
            </div>
          </div>
        </section>
      </div>
    </div>

    <!-- 하단 영역 -->
    <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/footer.php"); ?>
  </div>

  <?php include_once("{$_SERVER['DOCUMENT_ROOT']}/include/script.php"); ?>

  <script type="text/javascript" src="/js_lib/smarteditor2-2.8.2.3/js/HuskyEZCreator.js"></script>

  <script>
    function formSubmit() {
      oEditors.getById["recipe_text"].exec("UPDATE_CONTENTS_FIELD", []);

      $('form').submit()
    }

    var oEditors = [];

    var sLang = "ko_KR"; // 언어 (ko_KR/ en_US/ ja_JP/ zh_CN/ zh_TW), default = ko_KR
    // 추가 글꼴 목록
    //var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];


    nhn.husky.EZCreator.createInIFrame({
      oAppRef: oEditors,
      elPlaceHolder: "recipe_text",
      sSkinURI: "/js_lib/smarteditor2-2.8.2.3/SmartEditor2Skin.html",
      htParams: {
        bUseToolbar: true, // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
        bUseVerticalResizer: true, // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
        bUseModeChanger: true, // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
        //bSkipXssFilter : true,  // client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
        //aAdditionalFontList : aAdditionalFontSet,  // 추가 글꼴 목록
        fOnBeforeUnload: function() {
          //alert("완료!");
        },
        I18N_LOCALE: sLang
      }, //boolean
      fOnAppLoad: function() {
        //예제 코드
        //oEditors.getById["content"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
      },
      fCreator: "createSEditor2"
    });



    function pasteHTML(filepath) {

      // var sHTML = "<span style='color:#FF0000;'>이미지도 같은 방식으로 삽입합니다.<\/span>";
      var sHTML = '<span style="color:#FF0000;"><img src="' + filepath + '" style="max-width:100%;"></span>';
      console.log(filepath)
      oEditors.getById["content"].exec("PASTE_HTML", [sHTML]);



    }



    function showHTML() {
      var sHTML = oEditors.getById["content"].getIR();
      alert(sHTML);
    }

    function submitContents(elClickedObj) {
      oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용됩니다.


      // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("content").value를 이용해서 처리하면 됩니다.

      try {

        var form2 = document.f;
        if (!form2.name.value) {
          alert("작성자 이름을 입력해 주십시오");
          form2.name.focus();
          return;
        }



        if (!form2.subject.value) {
          alert("글제목을 입력해 주십시오.");
          form2.subject.focus();
          return;
        }



        if (document.getElementById("content").value == "<p><br></p>") {
          alert("내용을 입력해 주세요.");
          oEditors.getById["content"].exec("FOCUS", []);
          return;
        }



        form2.action = "notice_write_ok.php";
        //elClickedObj.form.submit();
        form2.submit();
      } catch (e) {
        alert(e);
      }
    }



    function setDefaultFont() {
      var sDefaultFont = '궁서';
      var nFontSize = 24;
      oEditors.getById["content"].setDefaultFont(sDefaultFont, nFontSize);
    }


    function writeReset() {
      document.f.reset();
      oEditors.getById["content"].exec("SET_IR", [""]);

    }

    function thumbnailChange(ts) {
      const file = ts.files[0];
      console.log(file);
      let image = new Image();

      let reader = new FileReader();

      reader.readAsDataURL(file);
      reader.onload = function(e) {
        image.src = e.target.result;

        image.onload = function(img) {
          $('#thumbnail-image').attr('src', image.src);
          $('.thumbnail-image').show();
        }
      }

      console.log(file);
    }

    //파일 업로드
    function recipeImageUpload() {
      var form = new FormData();
      form.append("image", $("#recipe_thumbnail")[0].files[0]);

      jQuery.ajax({
        url: "/ajax/recipe/recipe-image-upload.php",
        type: "POST",
        processData: false,
        contentType: false,
        data: form,
        success: function(response) {
          if (response == "에러") {
            alert('이미지만 업로드 가능합니다.');
          } else {
            $('#recipe_image_name').val(response);
            console.log("썸네일 이미지 업로드");
            thumbnailChange($("#recipe_thumbnail")[0]);
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