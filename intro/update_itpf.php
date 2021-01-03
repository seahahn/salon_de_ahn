<?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../login/login_check.php";

if($role != 'ADMIN') {
    echo '
        <script>
            alert("관리자만 작성 가능합니다.");
            history.go(-1);
        </script>';
}

$num = $_GET['num'];
$sql = mq("SELECT 
				 * 
                FROM 
                    pj 
                WHERE 
                    num='$num'
			");
    $pj = $sql->fetch_array();
    $pjcode = $pj['pjcode'];
    $title = $pj['title']; // 1 이상이면 답글임. 답글인 경우 카테고리 고정을 위해서 정보 가져옴
    $caption = $pj['caption'];
    $content = $pj['content'];
    $videopath = $pj['videopath'];
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
                        <br/>                       

						<div class="row"> <!-- 메인 글 영역-->
							<div class="col" id="content">
                                <!-- 글 작성 영역 -->
								
                                <div id="board_write">
                                    <form name="update" id="update" action="update_ok_itpf.php" method="post" enctype="multipart/form-data">
                                        <table class="table table-striped" style="border: 1px solid #ddddda">
                                            <thead>                                                
                                            </thead>	
                                            <tbody>                                                
                                                <tr>
                                                    <td><input type="text" class="form-control" placeholder="글 제목" value="<?=$title?>" name="title" id="title" required></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" class="form-control" placeholder="작품 정보 코드" value="<?=$pjcode?>" name="pjcode" id="pjcode" required></td>                                                    
                                                </tr>
                                                <tr>
                                                    <td><input type="text" class="form-control" placeholder="한 줄 설명" value="<?=$caption?>" name="caption" id="caption" required></td>
                                                </tr>
                                                <tr>	
                                                    <td><textarea class="form-control" placeholder="글 내용" name="content" id="ucontent" style="height: 350px" required><?=$content?></textarea></td>
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
                                                        <div>
                                                            <span>비디오 넣기</span>
                                                            <input type="file" accept="video/*" class="col-12 btn-sm" id="videoUpload" name="video[]">
                                                            <input type="hidden" name="videopath" value=<?=$videopath?>><span>기존 비디오 경로 : <?=$videopath?> </span>
                                                            <input type="hidden" name="num" value=<?=$num?>>
                                                            <!-- <button type="button" class="btn-sm btnRemove">첨부 취소</button> -->
                                                        </div>
                                                        
                                                        <!-- <button type="button" id="fileAdd" class="btn-sm">첨부파일 추가</button>
                                                        <ul id="fileList"></ul> -->
                                                        <!-- <input type="file" id="fileUpload" name="upload[]"> -->
                                                                <!-- 여기에 파일 목록 태그 추가 -->
                                                                <!-- <input type="submit" value="send"> -->
                                                                
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>                                       
                                        <div class="row justify-content-end">                                            
                                            <div class="col d-flex justify-content-end">                                                
                                                <button type="button" class="btn-lg" onclick="document.update.submit()">수정하기</button>
                                                <a class="pl-1" href="it_dev_portfolio.php"><button type="button" class="btn-lg">목록</button></a>
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
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
            <script src="/bootstrap/bootstrap.bundle.min.js"></script>

        <!-- HTML 텍스트 에디터(CKEDITOR) 추가-->
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace( 'ucontent' );
            </script>

        <!-- 게시판 분류 선택 여부 검증 후 선택 안했으면 alert 띄우기 -->
            <script>
                // function check_ctgr(){
                //     document.write.submit();
                // }
            </script>
	</body>
</html>