<?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../login/login_check.php";

if(isset($_GET['num'])){ // 글읽기에서 '답글' 버튼 누른 경우. 게시물 목록에서 답글이 원글 아래 붙게 정렬하기 위한 변수들 초기화
    $num = $_GET['num'];
    $sql = mq("SELECT in_num, depth, category, title FROM board WHERE num = $num"); // $ 게시물의 내부 번호(in_num)를 가져옴. 답글 작성 시 원글 바로 밑에 정렬할 수 있게 만들기 위한 번호임
    $fetch = ($sql->fetch_array());
    $in_num = $fetch['in_num'];
    $depth = $fetch['depth'];
    $category = $fetch['category'];
    $ori_title = $fetch['title'];
} else if(isset($_POST['category'])) {
    $category = $_POST['category'];
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
        <!-- <link rel="stylesheet" href="/bootstrap/bootstrap_custom.css"/> -->
        <!-- <link rel="stylesheet" href="../summernote/summernote-lite.css"> -->

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

        // $(function(){
        //     $("#fileUpload").change(function(){
        //     fileList = $("#fileUpload")[0].files;
        //     fileListTag = '';
        //     for(i = 0; i < fileList.length; i++){
        //         fileListTag += "<li>"+fileList[i].name+"</li>";
        //     }
        //     $('#fileList').html(fileListTag);
        // });
        // });
        </script>
        <!-- <script src="../ckeditor/ckeditor.js"></script> -->
	</head>
	<body class="right-sidebar is-preload">
		<div id="page-wrapper">

			<!-- Header -->
				<div class="mb-4" id="header">
                    <?php include_once "../fragments/header.php"; ?>
				</div>

			<!-- Main -->
				<!-- <div class="wrapper style1"> -->
					<div class="container">
                        <!-- <div class="row">
							<nav class="navbar navbar-expand-lg navbar-light bg-light flex-fill">
								<a class="col navbar-brand" href="#">카테고리 목록</a>
								<button class="col-3 navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
									aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
									<span class="navbar-toggler-icon"></span>
								</button>
							
								<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
									<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
										<li class="nav-item">
											<a class="nav-link" href="#">글 목록 <span class="sr-only">(current)</span></a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="#">의견/정보 공유</a>
										</li>										
									</ul>
									<form class="form-inline my-2 my-lg-0">
										<input class="form-control mr-sm-2" type="search" placeholder="Search">
										<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
									</form>
								</div>
							</nav>
						</div>									 -->
                        <br/>                       

						<div class="row"> <!-- 메인 글 영역-->
							<div class="col" id="content">
                                <!-- 글 작성 영역 -->
								

                                <div id="board_write">
                                    <form action="write_ok.php" method="post" enctype="multipart/form-data">
                                        <table class="table table-striped" style="border: 1px solid #ddddda">
                                            <thead>                                                
                                            </thead>	
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <?php include_once "./ctgr_fragment.php"; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" class="form-control" placeholder="글 제목" name="title" id="title" value="<?php if(isset($num)) { echo 'RE:#'.$num.' | '.$ori_title; } ?>" required></td>
                                                </tr>
                                                <tr>	
                                                    <td><textarea class="form-control" placeholder="글 내용" name="content" id="ucontent" style="height: 350px" required></textarea></td>                                                    
                                                    <!-- <td><textarea id="summernote" name="content"></textarea></td> -->
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <!-- <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="upload[]" id="upload" aria-describedby="uploadAddon" multiple>
                                                                <label class="custom-file-label" for="upload"></label>                                
                                                                <ul id="fileList"></ul>                                                                
                                                            </div>
                                                        </div>                          -->
                                                        <button type="button" id="fileAdd" class="btn-sm">첨부파일 추가</button>
                                                        <ul id="fileList"></ul>
                                                        <!-- <input type="file" id="fileUpload" name="upload[]"> -->
                                                                <!-- 여기에 파일 목록 태그 추가 -->
                                                                <!-- <input type="submit" value="send"> -->
                                                                
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>                                       
                                        <div class="row justify-content-end">
                                            <div class="custom-control custom-checkbox">                                                
                                                <input type="checkbox" class="custom-control-input" value="1" id="wsecret" name="wsecret">
                                                <label class="custom-control-label" for="wsecret">비밀글</label>
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
                                                <button type="submit" class="btn-lg">글쓰기</button>
                                                <a href="board_list.php?ctgr=<?=$category?>"><button type="button" class="btn-lg">목록</button></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>

							</div>											
						</div>																	
					</div>
				<!-- </div> -->

			<!-- Footer -->
				<div  class="mt-4"id="footer">
                    <?php include_once "../fragments/footer.php"; ?>
				</div>

		</div>

		<!-- Scripts -->
            <script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/jquery.dropotron.min.js"></script>
			<script src="/assets/js/jquery.scrolly.min.js"></script>
			<script src="/assets/js/jquery.scrollex.min.js"></script>
			<script src="/assets/js/browser.min.js"></script>
			<script src="/assets/js/breakpoints.min.js"></script>
			<script src="/assets/js/util.js"></script>
            <script src="/assets/js/main.js"></script>            
            <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

        <!-- Bootstrap Stripts-->
			<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
            <script src="/bootstrap/bootstrap.bundle.min.js"></script>

        <!-- HTML 텍스트 에디터(Summernote) 추가-->
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace( 'ucontent' );
            </script>
	</body>
</html>