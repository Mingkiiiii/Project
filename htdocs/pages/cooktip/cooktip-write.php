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
            <h2>요리팁 작성</h2>
            <p>Cooktip Write</p>
          </div>

          <div class="recipe-write-form">
            <div class="container">
              <form method="post" enctype="multipart/form-data" onSubmit="return frmSubmit(this, '/ajax/cooktip/cooktip-write.php', '요리팁을 작성했습니다.', './cooktip.php');">
                <div class="form-group">
                  <label for="title">제목</label>
                  <input type="text" name="title" id="title" class="form-control" placeholder="제목을 입력해주세요." required>
                </div>

                <div class="form-group">
                  <label for="content">레시피 내용</label>
                  <textarea type="text" name="content" id="content" class="form-control" style="height:500px; width:100%;" placeholder=''></textarea>
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
      oEditors.getById["content"].exec("UPDATE_CONTENTS_FIELD", []);

      $('form').submit()
    }

    var oEditors = [];

    var sLang = "ko_KR"; // 언어 (ko_KR/ en_US/ ja_JP/ zh_CN/ zh_TW), default = ko_KR
    // 추가 글꼴 목록
    //var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];


    nhn.husky.EZCreator.createInIFrame({
      oAppRef: oEditors,
      elPlaceHolder: "content",
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
  </script>
</body>

</html>