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
        <link rel="stylesheet" href="/assets/css/jquery-ui.css" />
        <!-- <link rel="stylesheet" href="/bootstrap/bootstrap_custom.css"/> -->
        <!-- <link rel="stylesheet" href="../summernote/summernote-lite.css"> -->
        <style>
        .pos_input {
            font-size: 80%;
        }
        </style>

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
                        <br/>                       

						<div class="row"> <!-- 메인 글 영역-->
							<div class="col" id="content">
                                <!-- 글 작성 영역 -->
								

                                <div id="board_write">
                                    <form name="write" id="write" action="write_ok_tdr.php" method="post" enctype="multipart/form-data">
                                        <table class="table table-striped" style="border: 1px solid #ddddda">
                                            <thead>                                                
                                            </thead>	
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <select class="custom-select col-8 mr-2" name="category" id="category">
                                                                <option selected disabled>분류</option>
                                                                <option value="주식">주식</option>
                                                                <option value="선물">선물</option>
                                                                <option value="외환">외환</option>
                                                                <option value="옵션">옵션</option>
                                                            </select>
                                                            <select class="custom-select col" name="position">
                                                                <option selected disabled>포지션</option>
                                                                <option value="매수">매수</option>
                                                                <option value="매도">매도</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" class="form-control" placeholder="종목명" name="item" id="item" required></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <span class="pos_input">진입 포인트 : </span><input type="text" class="form-control col mx-2" placeholder="진입 당시의 가격" name="in_pos" id="in_pos" required>
                                                            <span class="pos_input">진입 일자 : </span><input type="text" class="form-control col mx-2" placeholder="진입일" name="in_date" id="in_date" required>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <div class="d-flex">
                                                            <span class="pos_input">청산 포인트 : </span><input type="text" class="form-control col mx-2" placeholder="청산 당시의 가격" name="out_pos" id="out_pos" required>
                                                            <span class="pos_input">청산 일자 : </span><input type="text" class="form-control col mx-2" placeholder="청산일" name="out_date" id="out_date" required>                                                    
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>                                                        
                                                        <div class="d-flex">
                                                            <span class="pos_input">손익 : </span><input type="text" class="form-control col mx-2" placeholder="% 또는 pips" name="pl" id="pl" required>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>	
                                                    <td><textarea class="form-control" placeholder="글 내용" name="content" id="ucontent" style="height: 350px" required></textarea></td>
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
                                            <div class="col d-flex justify-content-end">                                                
                                                <button type="submit" class="btn-lg">글쓰기</button>
                                                <a class="pl-1" href="tradingrecord.php"><button type="button" class="btn-lg">목록</button></a>
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
            <script src="/assets/js/jquery-ui.js"></script>
            
        <!-- HTML 텍스트 에디터(ckeditor) 추가-->
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace( 'ucontent' );
            </script>

        <!-- 진입/청산일 날짜 선택 기능 -->
            <script>
                $(function() {
                    $( "#in_date" ).datepicker({  
                        nextText: '다음 달', // next 아이콘의 툴팁.
                        prevText: '이전 달', // prev 아이콘의 툴팁.
                        changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
                        changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
                        yearRange: 'c-100:c+10', // 년도 선택 셀렉트박스를 현재 년도에서 이전, 이후로 얼마의 범위를 표시할것인가.
                        showButtonPanel: true, // 캘린더 하단에 버튼 패널을 표시한다. 
                        currentText: '오늘 날짜' , // 오늘 날짜로 이동하는 버튼 패널
                        closeText: '닫기',  // 닫기 버튼 패널
                        dateFormat: "yy-mm-dd", // 텍스트 필드에 입력되는 날짜 형식.
                    });
                    $( "#out_date" ).datepicker({
                        nextText: '다음 달', // next 아이콘의 툴팁.
                        prevText: '이전 달', // prev 아이콘의 툴팁.
                        changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
                        changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
                        yearRange: 'c-100:c+10', // 년도 선택 셀렉트박스를 현재 년도에서 이전, 이후로 얼마의 범위를 표시할것인가.
                        showButtonPanel: true, // 캘린더 하단에 버튼 패널을 표시한다. 
                        currentText: '오늘 날짜' , // 오늘 날짜로 이동하는 버튼 패널
                        closeText: '닫기',  // 닫기 버튼 패널
                        dateFormat: "yy-mm-dd", // 텍스트 필드에 입력되는 날짜 형식.
                    });
                });
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