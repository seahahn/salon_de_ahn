<?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";

// S3 객체를 생성하여 버킷과 파일 경로 저장 및 불러오기에 필요한 URL을 가져옴
$s3 = new aws_s3;
$bucket = $s3->bucket;
$url = $s3->url;

$folder = $_POST['folder']; // 사진첩 이름
$album_q = mq("SELECT * FROM photofolder WHERE title_key = '".$folder."'");
$album = mysqli_fetch_array($album_q); // 사진첩 이름과 함께 설명을 불러오기 위함
$q = mq("SELECT * FROM photosave WHERE folder = '".$folder."'");
if(mysqli_num_rows($q) != 0) {
	$total = mysqli_num_rows($q); // 해당 사진첩의 사진 총 갯수 불러오기
} else {
	$row = 0; // 없으면 올린 사진 없다는 문구가 화면 중앙에 나오도록 함
}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<link rel="stylesheet" href="gal_assets/style.css">
		<?php include_once "../fragments/head.php"; ?>

		<!-- 사진 업로드 기능 -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js" ></script>
        <script type="text/javascript">
        $(document).ready (function(){
            $("#fileAdd").click(function(){ // 사진 한 장씩 업로드
                $("#fileList").append(
					'<div>\
					<input type="file" accept="image/*" class="col-8 btn-sm" id="fileUpload" name="photos[]">\
					<button type="button" class="btn-sm btnRemove">첨부 취소</button>\
					<div class="d-flex">\
					<input type="text" class="form-control form-control-sm col-4" placeholder="제목" name="title[]">\
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

			$("#filesAdd").click(function(){ // 사진 여러 장 업로드
                $("#fileList").append(
					'<div>\
					<input type="file" accept="image/*" class="col-8 btn-sm" id="filesUpload" name="photos_multi[]" multiple>\
					<button type="button" class="btn-sm btnRemove">첨부 취소</button>\
					<div class="d-flex">\
					<input type="text" class="form-control form-control-sm col-4" placeholder="제목(여러 장 공통)" name="title_multi">\
					<input type="text" class="form-control form-control-sm col" placeholder="설명(여러 장 공통)" name="caption_multi">\
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


	</head>
	<body id="body" class="is-preload-0 is-preload-1 is-preload-2" style="overflow-x: hidden;">
	<div id="page-wrapper">

		<div id="header">
			<?php include_once "../fragments/header.php"; ?>
		</div>

		<div class="container">


			<header class="clearfix mt-3">
				<button onclick ="location.href='albums.php'" type="button" class="btn-lg">◀ 뒤로</button>
				<p class="m-0 mt-3"><?=$album['title']?></p>

				<span class="m-0"><?=$album['caption']?><br/><?=$album['rcday']?></span>

			</header>
			<?php
			if($role == "ADMIN") {
			?>
				<form action="photo_upload.php" method="post" enctype="multipart/form-data">
					<input type="hidden" id="folder" name="folder" value="<?=$album['title_key']?>">
					<button type="submit" class="btn-sm">사진 업로드하기</button>
					<button type="button" id="fileAdd" class="btn-sm">사진 추가</button>
					<button type="button" id="filesAdd" class="btn-sm">사진 여러 장 추가</button>
					<a href="photos_delmode.php?folder=<?=$folder?>"><button type="button" id="photoDelete" class="btn-sm">사진 삭제 모드</button></a>
					<ul id="fileList"></ul>
				</form>
			<?php
			}
			?>

			<div id="pt_section" class="masonry mb-5">
				<?php
				$q = mq("SELECT * FROM photosave WHERE folder='".$folder."' ORDER BY num ASC LIMIT 10");
				if(mysqli_num_rows($q) != 0) {
					$row = mysqli_num_rows($q); // 해당 사진첩의 사진 10개까지만 불러오기
				} else {
					$row = 0;
				}

				if($row != 0) {
					while($p = mysqli_fetch_array($q)){
				?>
				<div class="masonry-item">
					<img src="<?=$url.$p['filepath']?>" alt="<?=$p['title']?>" data-cap="<?=$p['caption']?>" class="masonry-content">
				</div>
				<?php
					}
				}
				?>
			</div>

		<!-- 올린 사진이 없는 경우-->
			<?php
			if($row == 0) {
			?>
				<div class="d-flex align-items-center justify-content-center" style="height: 40vh;">
				<p class="text-center" style="font-size: 2rem;">아직 올라온 사진이 없네요</p>
				</div>
			<?php
			}
			?>

			<div id="loadmore" class="loadmore" onclick="append_list()">사진 더보기</div>
		</div>
		<div class="lightbox">
			<div class="title"></div>
			<div class="filter"></div>
			<div class="arrowr"></div>
			<div class="arrowl"></div>
			<div class="close"></div>
		</div>

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
							<form method="post" id="modal_form1" action="./photo_delete.php">
								<input type="hidden" name="photo_no" id="photo_no" value=""/>
								<p>삭제하시겠습니까?<br/> <input type="submit" class="btn-sm float-right" value="확인"/></p>
							</form>
						</div>
					</div>
				</div>
			</div>
		<!-- 사진 삭제 모달창 구현 끝 -->

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

		<!-- 사진 더보기 버튼 동작 이벤트-->
			<script>
				if(11 < <?=$total?>) {
					$('#loadmore').css("display", "block"); // 다 불러왔으면 더보기 버튼 안 보이게 만듦
				}

				var items = [];
				<?php
				$q = mq("SELECT * FROM photosave WHERE folder='".$folder."' ORDER BY num ASC LIMIT 11, 99999");
				if(mysqli_num_rows($q) != 0) {
					$row = mysqli_num_rows($q); // 해당 사진첩의 사진 11번째부터 나머지 다 불러오기
				} else {
					$row = 0;
				}

				if($row != 0) {
					while($p = mysqli_fetch_array($q)){
				?>
					var photo = '<div class="masonry-item"><img src="<?=$url.$p['filepath']?>" alt="<?=$p['title']?>" class="masonry-content"></div>';
					items.push(photo);
				<?php
					}
				}
				?>
				var i = 0;
				var limit = 10;

				function append_list() {
						while(i < limit) {
							$('#pt_section').append( $(items[i]) );
							i++;
							if(i >= items.length) {
								$('#loadmore').hide();
								break;
							}
						}
						limit += 10; // 더 불러올 사진 개수

					waitForImages();
				}
			</script>

		<!-- 사진 불러오기 & 사진 확대 창 띄우는 스크립트-->
			<script>
				$( window ).resize( function () {
					// 창 사이즈 변경 시 위아래 이미지 사이 간격 다시 계산하여 재배치함
					resizeAllMasonryItems();
				});
			</script>
			<script src="gal_assets/unpkg.js"></script>
			<script src="gal_assets/masonry.js"></script>
			<script src="gal_assets/photo_lightbox.js?ver=2"></script>

	</body>
</html>