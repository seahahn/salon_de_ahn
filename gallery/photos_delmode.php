<?php 
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";

if($role != 'ADMIN') {
    echo '
        <script>
            alert("관리자만 작성 가능합니다.");
            history.go(-1);
        </script>';
}

$folder = $_GET['folder']; // 사진첩 이름
$album_q = mq("SELECT * FROM photofolder WHERE title_key = '".$folder."'");
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
		<link rel="stylesheet" href="gal_assets/blur.css"/>	
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
				<form name="goback" action="photos.php" method="POST" class="invisible">
					<input type="hidden" name="folder" value="<?=$folder?>">
				</form>
				<button type="button" class="btn-lg" onclick="javascript:document.goback.submit();">◀ 뒤로</button>
				<h2>My memories</h2>
				<?php 
					if($role == "ADMIN") {
				?>							
					<form action="photo_delete.php" method="post" enctype="multipart/form-data">
						<button type="button" class="btn-sm" id="del_photo" name="del_photo">사진 삭제하기</button>
					</form>
				<?php
					}
				?>
			</div>
			
			<form class="grid-container m-4" style="grid-template-rows: none;" id="photos" name="photos" action="photo_delete.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="folder" value="<?=$folder?>">

			<?php
					$q = mq("SELECT * FROM photosave WHERE folder = '".$folder."'");
					while($f = mysqli_fetch_array($q)){
				?>			
				<article class="location-listing">
					<div class="location-image" data-num="<?=$f['num']?>" data-title="<?=$f['title']?>" data-cap="<?=$f['caption']?>">
						<img src="<?=$url.$f['filepath']?>" alt="<?=$f['title']?>">
						<input type="checkbox" class="photo" name="photo[]" value="<?=$f['num']?>" style="z-index: 1;
						position: absolute;
						top: 0px;
						right: 0px;
						width: 26px;
						height: 26px;">
						<button type="button" class="btn edit_photo" style="z-index: 2;
						position: absolute;
						top: 0px;
						left: 0px;
						font-size: 2rem;">수정</button>
					</div>        
				</article>
			<?php
			}
			?>
			</form>
			<!-- end grid container -->			

			<!-- 사진 삭제 모달창 구현 -->
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
							<p>삭제하시겠습니까?<br/> <button type="button" class="btn-sm float-right" onclick="document.photos.submit()">확인</button></p>							
						</div>
					</div>
				</div>
			</div>
			<!-- 사진 삭제 모달창 구현 끝 -->
			<!-- 사진 수정 모달창 구현 -->
			<div class="modal fade" id="photo_modal_edit">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<!-- header -->
						<div class="modal-header">
							<!-- header title -->
							<h4 class="modal-title"><b>사진 수정</b></h4>
							<!-- 닫기(x) 버튼 -->
							<button type="button" class="close" data-dismiss="modal">X</button>
						</div>
						<!-- body -->
						<div class="modal-body">
							<form method="post" id="modal_form1" action="./photo_edit.php" enctype="multipart/form-data">
								<div>
									<input type="hidden" name="photo_no_edit" id="photo_no_edit" value="">
									<input type="file" accept="image/*" class="col-8 btn-sm" id="photoEdit" name="photoEdit[]">
									<div class="d-flex flex-wrap">
									<input type="text" class="form-control form-control-sm col-12 mb-1" placeholder="제목" id="title_edit" name="title">
									<input type="text" class="form-control form-control-sm col-12 mb-1" placeholder="설명" id="caption_edit" name="caption">
									<!-- <input type="text" class="form-control form-control-sm col-12 mb-1" placeholder="사진첩" name="folder[]"> -->
									<span class="col-4">사진첩 선택 :</span><select class="custom-select col-8" name="folder" id="folder">
										<?php
											$q = mq("SELECT * FROM photofolder");
											while($f = mysqli_fetch_array($q)){
												?>
												<option value="<?=$f['title_key']?>" <?php if($f['title_key'] == $album['title_key']) echo 'selected' ?>><?=$f['title']?></option>
												<?php
											}
										?>
									</select>
									</div>
								</div>
								<p>수정하시겠습니까?<br/> <input type="submit" class="btn-sm float-right" value="확인"/></p>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- 사진 수정 모달창 구현 끝 -->

		</div>

		<!-- Footer -->
		<footer id="footer" class="m-0">
			<?php include_once "../fragments/footer.php"; ?>
		</footer>			
	</div>

		<!-- Main Scripts -->
			<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/jquery.dropotron.min.js"></script>
			<script src="/assets/js/jquery.scrolly.min.js"></script>
			<script src="/assets/js/jquery.scrollex.min.js"></script>
			<script src="/assets/js/browser.min.js"></script>
			<script src="/assets/js/breakpoints.min.js"></script>
			<script src="/assets/js/util.js"></script>
			<script src="/assets/js/main.js"></script>
			
		<!-- Other Stripts-->			
			<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
			<script src="/assets/js/jquery-ui.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
			<script src="/bootstrap/bootstrap.bundle.min.js"></script>		

			<script>
				/* 사진 삭제 이벤트 */
				$("#del_photo").click(function(){
					num = $(this).parent().data("num");
					$("#photo_no_del").attr("value", num);
					$("#photo_modal_del").modal();
				});

				/* 사진첩 수정 이벤트 */
				$(".edit_photo").click(function(){
					num = $(this).parent().data("num");
					title = $(this).parent().data("title");
					cap = $(this).parent().data("cap");
					console.log(cap);
					console.log('cap');
					$("#photo_no_edit").attr("value", num);
					$("#title_edit").attr("value", title);
					$("#caption_edit").attr("value", cap);
					$("#photo_modal_edit").modal();
				});
			</script>
	</body>
</html>