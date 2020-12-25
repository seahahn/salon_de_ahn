<?php 
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";

$folder = $_GET['folder']; // 사진첩 이름
$album_q = mq("SELECT * FROM photofolder WHERE title = '".$folder."'");
$album = mysqli_fetch_array($album_q); // 사진첩 이름과 함께 설명을 불러오기 위함

$s3 = new aws_s3;
$bucket = $s3->bucket;
$url = $s3->url;
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Salon de Ahn</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="css/blur.css"/>	
		<link rel="stylesheet" href="/bootstrap/bootstrap_custom.css"/>	
		<link rel="stylesheet" href="/assets/css/main_custom.css" />				
		<link rel="stylesheet" href="/assets/css/jquery-ui.css" />			
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
					<form action="photo_delete.php" method="post" enctype="multipart/form-data">
						<!-- <button type="submit" class="btn-sm">사진첩 등록하기</button>
						<button type="button" id="folderAdd" class="btn-sm">사진첩 만들기</button> -->
						<button type="button" class="btn-sm" id="del_modal" onclick="javascript:document.photos.submit();">사진 삭제하기</button>
						<!-- <ul id="folderList"></ul> -->
					</form>
				<?php
					}
				?>
			</div>
			
			<form class="grid-container m-4" id="photos" name="photos" action="photo_delete.php" method="post" enctype="multipart/form-data">
				<!-- <button type="button" class="btn btn-sm" id="del_modal">사진 삭제하기</button> -->
				<input type="hidden" name="folder" value="<?=$folder?>">

			<?php
					$q = mq("SELECT * FROM photosave WHERE folder = '".$folder."'");
					while($f = mysqli_fetch_array($q)){
				?>			
				<article class="location-listing">
				
				
					<a class="location-title" href="javascript:document.gotophotos.submit();"><?=$f['title']?></a>
					<div class="location-image" data-num="<?=$f['num']?>">
						<a href="javascript:document.gotophotos.submit();">
							<img width="300" height="169" src="<?=$url.$f['filepath']?>" alt="<?=$f['title']?>">
						</a>
						<input type="checkbox" class="del_photo" name="del_photo[]" value="<?=$f['num']?>" style="z-index: 1;
						position: absolute;
						top: 0px;
						right: 0px;
						width: 26px;
						height: 26px;">
						
					</div>        
				</article>
			<?php
			}
			?>
			</form>
			<!-- end grid container -->			

			<!-- 사진첩 삭제 모달창 구현 -->
			<div class="modal fade" id="photo_modal_del">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<!-- header -->
						<div class="modal-header">
							<!-- header title -->
							<h4 class="modal-title"><b>사진 삭제</b></h4>
							<!-- 닫기(x) 버튼 -->
							<button type="button" class="close" data-dismiss="modal">X</button>                                                
						</div>
						<!-- body -->
						<div class="modal-body">
							<form method="post" id="modal_form1" action="./photo_delete.php">
								<input type="hidden" name="photo_no" id="photo_no" value=""/>
								<p>삭제하시겠습니까?<br/> <input type="submit" class="btn-sm float-right" value="확인"/></p>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- 사진첩 삭제 모달창 구현 끝 -->

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
				/* 사진첩 삭제 이벤트 */
				// $("#del_modal").click(function(){					
					// num[] = $('.del_photo').val();
					// $("#photo_no").attr("value", num);
					// $("#photo_modal_del").modal();
					// console.log($('.del_photo').val());
				// });
			</script>
			
			<!-- <script>
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
                });
			</script> -->
			
	</body>
</html>