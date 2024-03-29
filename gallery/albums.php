<?php
include_once "../db_con.php";

$q = mq("SELECT * FROM photofolder");
$row = mysqli_num_rows($q); // 사진첩 총 갯수 불러오기
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Salon de Ahn</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="gal_assets/blur.css"/>
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
				display: none;
			}

			.loadmore:hover {
				background: #333;
			}
		</style>

		<!-- 사진첩 업로드 기능 -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js" ></script>
        <script type="text/javascript">
        $(document).ready (function(){
            $("#folderAdd").click(function(){
                $("#folderList").append(
					'<div>\
					<input type="file" accept="image/*" class="col-8 btn-sm" id="folderUpload" name="folders[]" required>\
					<button type="button" class="btn-sm btnRemove">첨부 취소</button>\
					<div class="d-flex">\
					<input type="text" class="form-control form-control-sm col" placeholder="제목" name="title[]" required>\
					<input type="text" class="form-control form-control-sm col" placeholder="사진첩 키" name="title_key[]" required>\
					<input type="text" class="form-control form-control-sm col rcday" placeholder="날짜" name="rcday[]" required>\
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
				$( ".rcday" ).datepicker({
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
		});
		</script>

	<!-- 사진첩 더보기 버튼 기능 -->
		<script>
			$(function (e) {
				append_list();
				// 버튼 누르면 사진첩 목록 더 불러옴
				$('#loadmore').click(function() {
					append_list();
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
					if(start < <?=$row?>) {
						$('#loadmore').css("display", "block"); // 다 불러왔으면 더보기 버튼 안 보이게 만듦
					}

					if(start >= <?=$row?>) {
						$('#loadmore').css("display", "none"); // 다 불러왔으면 더보기 버튼 안 보이게 만듦
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
						<button type="button" id="folderAdd" class="btn-sm">사진첩 만들기</button>
						<ul id="folderList"></ul>
					</form>
				<?php
					}
				?>
			</div>

			<div class="grid-container m-4" id="thumbnails">
				<!-- 사진첩 목록 출력하는 부분-->
			</div>

		<!-- 올린 사진첩이 없는 경우-->
			<?php
			if($row == 0) {
			?>
				<div class="d-flex align-items-center justify-content-center" style="height: 40vh;">
				<p class="text-center" style="font-size: 2rem;">아직 올라온 사진첩이 없네요</p>
				</div>
			<?php
			}
			?>
			<!-- end grid container -->
			<div id="loadmore" class="loadmore">사진첩 더보기</div>

			<!-- 사진첩 삭제 모달창 구현 -->
			<div class="modal fade" id="album_modal_del">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<!-- header -->
						<div class="modal-header">
							<!-- header title -->
							<h4 class="modal-title"><b>사진첩 삭제</b></h4>
							<!-- 닫기(x) 버튼 -->
							<button type="button" class="close" data-dismiss="modal">X</button>
						</div>
						<!-- body -->
						<div class="modal-body">
							<form method="post" id="modal_form1" action="./folder_delete.php">
								<input type="hidden" name="album_no_del" id="album_no_del" value=""/>
								<p>삭제하시겠습니까?<br/> <input type="submit" class="btn-sm float-right" value="확인"/></p>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- 사진첩 삭제 모달창 구현 끝 -->
			<!-- 사진첩 수정 모달창 구현 -->
			<div class="modal fade" id="album_modal_edit">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<!-- header -->
						<div class="modal-header">
							<!-- header title -->
							<h4 class="modal-title"><b>사진첩 수정</b></h4>
							<!-- 닫기(x) 버튼 -->
							<button type="button" class="close" data-dismiss="modal">X</button>
						</div>
						<!-- body -->
						<div class="modal-body">
							<form method="post" id="modal_form1" action="./folder_edit.php" enctype="multipart/form-data">
								<div>
									<input type="hidden" name="album_no_edit" id="album_no_edit" value="">
									<input type="file" accept="image/*" class="col-8 btn-sm" id="folderEdit" name="folderEdit[]">
									<input type="hidden" name="thumb_edit" id="thumb_edit">
									<div class="d-flex flex-wrap">
									<input type="text" class="form-control form-control-sm col-12" placeholder="제목" id="title_edit" name="title" required>
									<input type="text" class="form-control form-control-sm col-6" placeholder="날짜" id="rcday_edit" name="rcday" required>
									<input type="text" class="form-control form-control-sm col-6" placeholder="설명" id="caption_edit" name="caption">
									</div>
								</div>
								<p>수정하시겠습니까?<br/> <input type="submit" class="btn-sm float-right" value="확인"/></p>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- 사진첩 수정 모달창 구현 끝 -->

		</div>

		<!-- Footer -->
		<footer id="footer" class="m-0">
			<?php include_once "../fragments/footer.php"; ?>
		</footer>
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
			<script src="/assets/js/jquery-ui.js"></script>

			<script>
                $(function() {
                    $( "#rcday_edit" ).datepicker({
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