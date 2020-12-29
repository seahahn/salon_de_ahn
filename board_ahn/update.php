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

$bno = $_GET['num']; // $bno에 num값을 받아와 넣음
	/* 받아온 num값을 선택해서 게시글 정보 가져오기 */
	$sql = mq("SELECT 
				 * 
                FROM 
                    board 
                WHERE 
                    num='$bno'
			");
    $board = $sql->fetch_array();	
    $category = $board['category'];
    $depth = $board['depth']; // 1 이상이면 답글임. 답글인 경우 카테고리 고정을 위해서 정보 가져옴
    $sub_ctgr = $board['sub_ctgr'];
    $headpiece = $board['headpiece'];
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

            $(".btnRemoveOld").on('click', function(){
                $(this).prev().prev().remove();    
                $(this).prev().remove();
                $(this).next().remove();
                $(this).remove();
            });  

        });        
        </script>
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
                                <!-- 글 수정 영역 -->
								

                                <div id="board_write">
                                    <form action="update_ok.php" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="num" value="<?=$bno?>" />
                                        <table class="table table-striped" style="border: 1px solid #ddddda">
                                            <thead>
                                                <!-- <tr>
                                                    <th colspan="2" style="background-color: #eeeeee; text-align: center;"><h3>글 수정하기</h3></th>
                                                </tr> -->
                                            </thead>	
                                            <tbody>                                                
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">                                                        
                                                            <?php include_once "./ctgr_fragment.php"; ?>                                                        
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" class="form-control" placeholder="글 제목" name="title" id="title" value="<?=$board['title']?>" required="required"></td>
                                                </tr>                                                
                                                <tr>
                                                    <td><textarea class="form-control" placeholder="글 내용" name="content" id="ucontent" style="height: 350px" required><?=$board['content']?></textarea></td>
                                                    <!-- <td><textarea id="summernote" name="content"><?=$board['content']?></textarea></td> -->
                                                </tr>
                                                <tr>
                                                    <td>                                                        
                                                        <button type="button" id="fileAdd" class="btn-sm">첨부파일 추가</button>
                                                        <ul id="fileList"></ul>
                                                        <?php
                                                        $sql = mq("SELECT att_file FROM board WHERE num='".$bno."'");                                                        
                                                        while($row = mysqli_fetch_assoc($sql)){
                                                            $filepath_array = unserialize($row['att_file']);
                                                        }                                                        
                                                        
                                                        for($i=0; $i<count($filepath_array);$i++){
                                                            $filename_result = mq("SELECT * FROM filesave WHERE filepath='".$filepath_array[$i]."'");                                                            
                                                            $fetch = mysqli_fetch_array($filename_result);
                                                            $filename_tmp = $fetch['filename_tmp'];
                                                            $filename_real = $fetch['filename_real'];                                                            
                                                            $filepath = $fetch['filepath'];
                                                            $filename = str_replace(" ","_", $filename_real);                                                            
                                                            // $filepath = "/file/";
                                                            echo "<input type='hidden' name='old_files[]' value=$filepath_array[$i]><span>$filename_real </span><button type='button' class='btn-sm btnRemoveOld'>첨부 취소</button><br/>";
                                                            // echo "<input type='file' class='col-8 btn-sm' id='fileUpload' name='upload[]'><button type='button' class='btn-sm btnRemove'>첨부 취소</button><br/>";
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row justify-content-between">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" value="1" id="wsecret" name="wsecret">
                                                <label class="custom-control-label" for="wsecret">비밀글</label>
                                            </div>
                                            <div class="row justify-content-end">
                                                <a href="board_list.php?ctgr=<?=$category?>"><button type="button" class="btn-lg ml-1 px-3">목록</button></a>
                                                <a class="a_nopadding"><button type="button" class="btn-lg ml-1 px-3" onclick="history.go(-1);">취소</button></a>
                                                <a class="a_nopadding"><button type="submit" class="btn-lg ml-1 px-3">수정하기</button></a>
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