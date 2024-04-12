<?php
include_once("{$_SERVER['DOCUMENT_ROOT']}/include/head.php");

$idx = isset($_GET['idx']) ? $_GET['idx'] : 0;

// 레시피 데이터
$recipe_data = dbFetch("SELECT r.*, m.user_name, rg.grade
FROM recipe r left outer join member m
on r.writer_id = m.user_id
LEFT OUTER JOIN recipe_grade rg
ON r.idx = rg.recipe_idx
where r.idx = ?", [
    $idx,
]);

// 레시피 댓글 리스트
$recipe_comment = dbFetchAll("
    SELECT c.*, m.user_name, m.user_image, DATE_FORMAT(c.write_date, '%Y.%m.%d') w_date
    FROM comment c LEFT OUTER JOIN member m
    ON c.writer_id = m.user_id
    WHERE parent_idx = ?
    AND comment_type = 'recipe'
    ORDER BY c.idx DESC
", [
    $idx
]);

if (isset($mb_r)) {
    $scrap_check = dbFetch("
      SELECT * FROM recipe_scrap
      WHERE recipe_idx = ?
      AND user_id = ?
    ", [
        $idx,
        $mb_r['user_id'],
    ]);
}

if (!$recipe_data) {
    msgMove('존재하지 않는 레시피입니다.', '/');
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
                                <h4 class="recipe-name"><?= $recipe_data['recipe_name'] ?></h4>

                                <p class="write-date"><?= $recipe_data['write_date'] ?></p>
                            </div>

                            <div class="recipe-content">
                                <div class="recipe-youtube">
                                    <div id="player"></div>
                                </div>

                                <div class="recipe-text se2_outputarea">
                                    <?= $recipe_data['recipe_text'] ?>
                                </div>
                            </div>

                            <div class="recipe-grade">
                                <h4>레시피 평점 매기기</h4>

                                <ul>
                                    <?php
                                    for ($i = 0; $i < $recipe_data['grade']; $i++) {
                                    ?>
                                        <li onClick="recipeGradeClick(this);" class="fill-star"><i class="fas fa-star"></i></li>
                                    <?php } ?>
                                    <?php
                                    for ($i = $recipe_data['grade']; $i < 5; $i++) {
                                    ?>
                                        <li onClick="recipeGradeClick(this);" class="empty-star"><i class="far fa-star"></i></li>
                                    <?php } ?>

                                </ul>
                            </div>

                            <?php if (isset($mb_r)) { ?>
                                <div class="board-control-btn">
                                    <?php if ($mb_r['user_id'] == $recipe_data['writer_id']) { ?>
                                        <button type="button" class="modify-btn" onClick="href('./recipe-modify.php?idx=<?= $idx ?>');">수정</button>
                                        <button type="button" class="remove-btn" onClick="recipeRemove(<?= $idx ?>);">삭제</button>
                                    <?php } ?>
                                    <button type="button" class="scrap-btn" onClick="scrapRequest(<?= $idx ?>);"><?= $scrap_check ? '스크랩 취소' : '스크랩' ?></button>
                                </div>
                            <?php } ?>

                            <div class="recipe-comment">
                                <h5 class="comment-title">댓글</h5>

                                <?php if (isset($mb_r)) { ?>
                                    <div class="comment-write-form">
                                        <form action="" onSubmit="return frmSubmit(this, '/ajax/comment/comment-write.php', '댓글이 작성되었습니다.', './recipe-view.php?idx=<?= $idx ?>')">
                                            <input type="hidden" name="comment_type" value="recipe">
                                            <input type="hidden" name="parent_idx" value="<?= $idx ?>">

                                            <textarea name="comment_text" id="comment_text" class="form-control" rows="3" placeholder="댓글을 작성해주세요."></textarea>

                                            <div class="comment-write-btn">
                                                <button type="submit">작성</button>
                                            </div>
                                        </form>
                                    </div>
                                <?php } ?>

                                <div class="comment-list">
                                    <?php
                                    foreach ($recipe_comment as $k => $comment) {
                                    ?>
                                        <div class="comment-item">
                                            <div class="comment-top">
                                                <div class="comment-writer-name">
                                                    <div class="writer-image image">
                                                        <img src="/uploads/user/<?= $comment['user_image'] ?>" alt="<?= $comment['user_name'] ?>">
                                                    </div>
                                                    <h4><?= $comment['user_name'] ?></h4>
                                                </div>

                                                <div class="comment-write-date">
                                                    <?php if (isset($mb_r) && $comment['writer_id'] == $mb_r['user_id']) { ?>
                                                        <span class="comment-remove" onClick="commentRemove(<?= $comment['idx'] ?>);">&times;</span>
                                                    <?php } ?>

                                                    <p><?= $comment['w_date'] ?></p>
                                                </div>
                                            </div>

                                            <div class=" comment-text">
                                                <p><?= $comment['comment_text'] ?></p>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
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
        //youtube API 불러오는 부분
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        //플레이어 변수 설정
        var player;

        function onYouTubeIframeAPIReady() {
            player = new YT.Player('player', {
                //width&height를 설정할 수 있으나, 따로 css영역으로 뺐다.
                videoId: '<?= $recipe_data['recipe_youtube'] ?>',
                events: {
                    'onReady': onPlayerReady, //로딩중에 이벤트 실행한다
                    'onStateChange': onPlayerStateChange //플레이어 상태 변화 시 이벤트를 실행한다.
                }
            });
        }

        function onPlayerReady(event) {
            //로딩된 후에 실행될 동작을 작성한다(소리 크기,동영상 속도를 미리 지정하는 것등등...)
            event.target.playVideo(); //자동재생

        }

        var done = false;

        function onPlayerStateChange(event) {
            if (event.data == YT.PlayerState.PLAYING && !done) {
                done = true;
                //플레이어가 재생중일 때 작성한 동작이 실행된다.
            }
        }

        function recipeRemove(idx) {
            $.ajax({
                type: "POST",
                url: "/ajax/recipe/recipe-remove.php",
                data: {
                    idx
                },
                success: function(result) {
                    if (result) {
                        alert(result);
                    } else {
                        alert('레시피가 삭제되었습니다.');
                        href('/');
                    }
                }
            })
        }

        function recipeGradeClick(ts) {
            const grade_list = $(ts).prevAll();
            const recipe_grade = $(ts).index() + 1;

            $.ajax({
                type: "POST",
                url: "/ajax/recipe/recipe-grade.php",
                data: {
                    recipe_grade,
                    recipe_idx: <?= $idx ?>
                },
                success: function(result) {
                    if (result) {

                    } else {
                        $('.recipe-grade ul li i')
                            .removeClass('fas fa-star')
                            .addClass('far fa-star')

                        $(grade_list).each(function() {
                            $(this).find('i')
                                .removeClass('far fa-star')
                                .addClass('fas fa-star')
                        })

                        $(ts).find('i')
                            .removeClass('far fa-star')
                            .addClass('fas fa-star')
                    }
                }
            })
        }

        function scrapRequest(recipe_idx) {
            $.ajax({
                type: "POST",
                url: "/ajax/recipe/scrap-request.php",
                data: {
                    recipe_idx
                },
                success: function(result) {
                    if (result == '스크랩 추가') {
                        $('.board-control-btn .scrap-btn').text('스크랩 취소');
                    } else {
                        $('.board-control-btn .scrap-btn').text('스크랩');
                    }
                }
            })
        }

        function commentRemove(idx) {
            $.ajax({
                type: "POST",
                url: "/ajax/comment/comment-remove.php",
                data: {
                    comment_idx: idx
                },
                success: function(result) {
                    alert('댓글이 삭제되었습니다.');
                    location.reload();
                }
            })
        }
    </script>
</body>

</html>