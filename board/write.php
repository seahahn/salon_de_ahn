<?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../member/login_check.php";

if(isset($_GET['num'])){ // 글읽기에서 '답글' 버튼 누른 경우. 게시물 목록에서 답글이 원글 아래 붙게 정렬하기 위한 변수들 초기화
    $num = $_GET['num'];
    $sql = mq("SELECT * FROM board WHERE num = $num"); // $ 게시물의 내부 번호(in_num)를 가져옴. 답글 작성 시 원글 바로 밑에 정렬할 수 있게 만들기 위한 번호임
    $fetch = ($sql->fetch_array());
    $in_num = $fetch['in_num'];
    $depth = $fetch['depth'];
    $category = $fetch['category'];
    $ori_title = $fetch['title'];
    $sub_ctgr = $fetch['sub_ctgr'];
    $headpiece = $fetch['headpiece'];
} else if(isset($_POST['category'])) {
    $category = $_POST['category'];
    $sub_ctgr = '';
    $headpiece = '';
}
?>

<!DOCTYPE HTML>
<!--
	Helios by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
        <?php include_once "../fragments/head.php"; ?>

        <!-- 파일 업로드 기능 -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js" ></script>
        <script type="text/javascript">
        $(document).ready (function(){
            $("#fileAdd").click(function(){
                $("#fileList").append(
                    '<input type="file" class="col-8 btn-sm" id="fileUpload" name="upload[]">\
                    <button type="button" class="btn-sm btnRemove">첨부 취소</button><br/>'
                );
                $(".btnRemove").on('click', function(){
                    $(this).prev().remove();
                    $(this).next().remove();
                    $(this).remove();
                });
            });
        });
        </script>
	</head>
	<body>
		<div id="page-wrapper">

        <!-- Header -->
            <div class="mb-4" id="header">
                <?php include_once "../fragments/header.php"; ?>
            </div>

        <!-- Main -->
            <div class="container">
                <br/>

                <div class="row"> <!-- 메인 글 영역-->
                    <div class="col" id="content">
                        <!-- 글 작성 영역 -->
                        <div id="board_write">
                            <form name="write" id="write" action="write_ok.php" method="post" enctype="multipart/form-data">
                                <table class="table table-striped" style="border: 1px solid #ddddda">
                                    <thead>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex">
                                                    <!-- 게시판 대분류, 소분류, 말머리 선택하는 곳 -->
                                                    <?php include_once "./ctgr_fragment.php"; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="form-control" placeholder="글 제목" name="title" id="title" value="<?php if(isset($num)) { echo 'RE:#'.$num.' | '.$ori_title; } ?>" required></td>
                                        </tr>
                                        <tr>
                                            <td><textarea class="form-control" placeholder="글 내용" name="content" id="ucontent" style="height: 350px" required></textarea></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <button type="button" id="fileAdd" class="btn-sm">첨부파일 추가</button>
                                                <ul id="fileList"></ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="d-flex justify-content-end">
                                    <div class="form-check d-flex align-content-center">
                                        <input class="form-check-input align-self-center mt-0" type="checkbox" value="1" name="wsecret" id="wsecret">
                                        <label class="form-check-label" for="wsecret">
                                            <span class="align-middle">비밀글 여부</span>
                                        </label>
                                    </div>
                                    <div class="col d-flex justify-content-end">
                                        <?php if(isset($in_num)){ ?> <!-- 답글 누르고 들어온 경우-->
                                        <input type="hidden" name="in_num" value="<?=$in_num?>"/> <!-- 게시물 내부 번호. 답글 작성 시 따라가서 원글 밑에 붙게 만듦-->
                                        <input type="hidden" name="depth" value="<?=$depth?>"/> <!-- 게시물 계층 구조 깊이. 깊이 숫자만큼 원글 밑에 들여쓰기된 제목으로 목록에 표시됨-->
                                        <?php } ?>
                                        <input type="hidden" name="unum" value="<?=$usernum?>"/> <!-- 게시물을 작성한 사용자의 고유 번호-->
                                        <?php if(isset($_GET['num'])) {;?>
                                        <input type="hidden" name="category" value="<?=$category?>"/> <!-- 게시물의 카테고리. 사용자가 답글로 눌러서 들어올 경우 상단의 select가 비활성화되어 값이 안 넘어가기에 별도로 만들어서 넘겨줌 -->
                                        <?php } ?>
                                        <button type="button" class="btn-lg" onclick="check_ctgr()">글쓰기</button>
                                        <a class="pl-1" href="board_list.php?ctgr=<?=$category?>"><button type="button" class="btn-lg">목록</button></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Footer -->
            <div  class="mt-4"id="footer">
                <?php include_once "../fragments/footer.php"; ?>
            </div>
		</div>

        <?php include_once "../fragments/scripts.php"; ?>
		<!-- Main Scripts -->
            <!--<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/jquery.dropotron.min.js"></script>
			<script src="/assets/js/jquery.scrolly.min.js"></script>
			<script src="/assets/js/jquery.scrollex.min.js"></script>
			<script src="/assets/js/browser.min.js"></script>
			<script src="/assets/js/breakpoints.min.js"></script>
			<script src="/assets/js/util.js"></script>
            <script src="/assets/js/main.js"></script>-->

        <!-- Other Stripts-->
            <!--<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
            <script src="/bootstrap/bootstrap.bundle.min.js"></script>-->

        <!-- HTML 텍스트 에디터(CKEDITOR) 추가-->
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace( 'ucontent' );
            </script>

        <!-- 게시판 분류 선택 여부 검증 후 선택 안했으면 alert 띄우기 -->
            <script>
                function check_ctgr(){
                    if($("#category option:selected").val() == "none_category"){
                        alert("게시판 분류를 선택해주세요.");
                        return;
                    }
                    if($("#sub_ctgr option:selected").val() == "none_subctgr"){
                        alert("게시판 소분류를 선택해주세요.");
                        return;
                    }
                    if($("#headpiece option:selected").val() == "none_headpiece"){
                        alert("말머리를 선택해주세요.");
                        return;
                    }
                    document.write.submit();
                }
            </script>
	</body>
</html>