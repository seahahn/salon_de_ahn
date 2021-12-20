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
                    tdrecord 
                WHERE 
                    num='$bno'
			");
    $board = $sql->fetch_array();	
    $category = $board['category'];
    $position = $board['position'];
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
                        <br/>                       

						<div class="row"> <!-- 메인 글 영역-->
							<div class="col" id="content">
                                <!-- 글 수정 영역 -->
								

                                <div id="board_write">
                                    <form action="update_ok_tdr.php" method="post" enctype="multipart/form-data">
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
                                                            <select class="custom-select col-8 mr-2" name="category" id="category">
                                                                <option selected disabled>분류</option>
                                                                <option value="주식" <?php if($category == '주식') echo 'selected'?>>주식</option>
                                                                <option value="선물" <?php if($category == '선물') echo 'selected'?>>선물</option>
                                                                <option value="외환" <?php if($category == '외환') echo 'selected'?>>외환</option>
                                                                <option value="옵션" <?php if($category == '옵션') echo 'selected'?>>옵션</option>
                                                            </select>
                                                            <select class="custom-select col" name="position">
                                                                <option selected disabled>포지션</option>
                                                                <option value="매수" <?php if($position == '매수') echo 'selected'?>>매수</option>
                                                                <option value="매도" <?php if($position == '매도') echo 'selected'?>>매도</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" class="form-control" placeholder="종목명" name="item" id="item" value="<?=$board['item']?>" required="required"></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <span class="pos_input">진입 포인트 : </span><input type="text" class="form-control col mx-2" placeholder="진입 당시의 가격" value="<?=$board['in_pos']?>" name="in_pos" id="in_pos" required>
                                                            <span class="pos_input">진입 일자 : </span><input type="text" class="form-control col mx-2" placeholder="진입일" value="<?=$board['in_date']?>" name="in_date" id="in_date" required>                                                    
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <span class="pos_input">청산 포인트 : </span><input type="text" class="form-control col mx-2" placeholder="청산 당시의 가격" value="<?=$board['out_pos']?>" name="out_pos" id="out_pos" required>
                                                            <span class="pos_input">청산 일자 : </span><input type="text" class="form-control col mx-2" placeholder="청산일" value="<?=$board['out_date']?>" name="out_date" id="out_date" required>                                                    
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>                                                        
                                                        <div class="d-flex">
                                                            <span class="pos_input">손익 : </span><input type="text" class="form-control col mx-2" placeholder="% 또는 pips" value="<?=$board['pl']?>" name="pl" id="pl" required>
                                                        </div>
                                                    </td>
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
                                                        $sql = mq("SELECT att_file FROM tdrecord WHERE num='".$bno."'");                                                        
                                                        while($row = mysqli_fetch_assoc($sql)){
                                                            $filepath_array = unserialize($row['att_file']);
                                                        }                                                        
                                                        
                                                        for($i=0; $i<count($filepath_array);$i++){
                                                            $filename_result = mq("SELECT filename_real, filename_tmp FROM filesave WHERE filepath='".$filepath_array[$i]."'");                                                            
                                                            $filename_fetch = mysqli_fetch_array($filename_result);
                                                            $filename_tmp = $filename_fetch[1];
                                                            $filename_real = $filename_fetch[0];                                                            
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
                                        <div class="row justify-content-end">                                            
                                            <div class="row justify-content-end">
                                                <a href="board_list.php?ctgr=<?=$category?>"><button type="button" class="btn-lg ml-1 px-3">목록</button></a>
                                                <button type="button" class="btn-lg ml-1 px-3" onclick="history.go(-1);">취소</button></a>
                                                <button type="submit" class="btn-lg ml-1 px-3">수정하기</button>
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

        <?php include_once "../fragments/scripts.php"; ?>
		<!-- Scripts -->
            <!--<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/jquery.dropotron.min.js"></script>
			<script src="/assets/js/jquery.scrolly.min.js"></script>
			<script src="/assets/js/jquery.scrollex.min.js"></script>
			<script src="/assets/js/browser.min.js"></script>
			<script src="/assets/js/breakpoints.min.js"></script>
			<script src="/assets/js/util.js"></script>
			<script src="/assets/js/main.js"></script>
            <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>-->

        <!-- Bootstrap Stripts-->
			<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
			<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
            <script src="/bootstrap/bootstrap.bundle.min.js"></script>-->

        <!-- HTML 텍스트 에디터(ckeditor) 추가-->
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace( 'ucontent' );
            </script>
        <!-- 손익 자동 계산 기능 -->
            <script>
                $("#in_pos").on("propertychange change keyup paste input", function() {
                    var pl = ($("#out_pos").val() - $("#in_pos").val()) / $("#in_pos").val() * 100;
                    $("#pl").val(pl.toFixed(2));
                });
                $("#out_pos").on("propertychange change keyup paste input", function() {
                    var pl = ($("#out_pos").val() - $("#in_pos").val()) / $("#in_pos").val() * 100;
                    $("#pl").val(pl.toFixed(2));
                });
            </script>

	</body>
</html>