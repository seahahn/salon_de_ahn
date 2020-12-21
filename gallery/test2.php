<?php 
include_once "../db_con.php";
?>
<!DOCTYPE HTML>
<!--
	Lens by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>Salon de Ahn</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="css/blur.css"/>	
		<link rel="stylesheet" href="/bootstrap/bootstrap_custom.css"/>	
		<link rel="stylesheet" href="/assets/css/main_custom.css" />				
		<link rel="stylesheet" href="/assets/css/jquery-ui.css" />
		<style>
			.loadmore {
				padding: 10px;
				background: #ddd;
				color: #fff;
				text-transform: uppercase;
				letter-spacing: 3px;
				font-weight: 700;
				text-align: center;
				cursor: pointer;
				margin: 10px 4px;
				margin-bottom: 30px;
				display: block;
			}

			.loadmore:hover {
				background: #333;
			}
		</style>

		<!-- 사진 업로드 기능 -->            
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js" ></script>
        <script type="text/javascript">
        $(document).ready (function(){            
            $("#folderAdd").click(function(){
                $("#folderList").append(
					'<div>\
					<input type="file" class="col-8 btn-sm" id="folderUpload" name="folders[]">\
					<button type="button" class="btn-sm btnRemove">첨부 취소</button>\
					<div class="row">\
					<input type="text" class="form-control form-control-sm col" placeholder="제목" name="title[]">\
					<input type="text" class="form-control form-control-sm col" placeholder="날짜" id="rcday" name="rcday[]">\
					<input type="text" class="form-control form-control-sm col" placeholder="설명" name="caption[]">\
					</div>\
					</div>'
                );
                $(".btnRemove").on('click', function(){
                    // $(this).prev().remove();
					// $(this).next().remove();					
					$(this).siblings().remove();
					$(this).remove();
					
                });                            
            });
		});
		</script>

		<!-- 사진 불러오기 무한 스크롤 기능 -->
		<script>
			$(function (e) {
				append_list();
				// 스크롤 이벤트
				$(window).scroll(function() {
					var dh = $(document).height();
					var wh = $(window).height();
					var wt = $(window).scrollTop();
					if(dh == (wh + wt)){
						append_list();
					}
				});
			});

			var start = 0;
			var list = 8;
			function append_list() {
				$.post("./folder_append.php", {start:start, list:list}, function(data) {
					if(data){
						$("#thumbnails").append(data);
						start += list;
					}
				});
			}
		</script>
	</head>
	<body class="is-preload-0 is-preload-1 is-preload-2" style="overflow-x: hidden;">
	<div id="page-wrapper">

		<div id="header">
			<?php include_once "../fragments/header.php"; ?>
		</div>

		<div class="child-page-listing container">

			<div class="mt-4 mx-4">
				<h2>My memories</h2>
				<?php 
					if($role == "ADMIN") {
				?>							
					<form action="folder_upload.php" method="post" enctype="multipart/form-data">
						<button type="submit" class="btn-sm">사진첩 등록하기</button>
						<button type="button" id="folderAdd" class="btn-sm">사진첩 작성하기</button>
						<ul id="folderList"></ul>
					</form>
				<?php
					}
				?>
			</div>
			
			<div class="grid-container m-4" id="thumbnails">

				<article class="location-listing">
				<a class="location-title" href="test.php">San Francisco</a>
				<div class="location-image">
					<a href="test.php">
						<img width="300" height="169" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/san-fransisco-768x432.jpg" alt="san francisco">    </a>
				</div>
				</article>
				
			</div>
			<!-- end grid container -->
			<div id="loadmore" class="loadmore">사진첩 더보기</div>

		</div>

			<!-- Footer -->
			<footer id="footer" class="m-0">
				<?php include_once "../fragments/footer.php"; ?>
			</footer>			
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
			<script src="/assets/js/jquery-ui.js"></script>
			
		<!-- Bootstrap Stripts-->
			<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
			<script src="/bootstrap/bootstrap.bundle.min.js"></script>
			
			<script>
				$(function() {
                    $( "#rcday" ).datepicker({  
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
			
	</body>
</html>