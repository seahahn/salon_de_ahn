<?php 
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";

$folder = $_POST['folder']; // 사진첩 이름
$album_q = mq("SELECT * FROM photofolder WHERE title = '".$folder."'");
$album = mysqli_fetch_array($album_q); // 사진첩 이름과 함께 설명을 불러오기 위함
$q = mq("SELECT * FROM photosave WHERE folder = '".$folder."'");
if(mysqli_num_rows($q) != 0) {
	$row = mysqli_num_rows($q); // 해당 사진첩의 사진 총 갯수 불러오기
} else {
	$row = 0; // 없으면 올린 사진 없다는 문구가 화면 중앙에 나오도록 함
}

// $s3 = new aws_s3;
// $bucket = $s3->bucket;
// $url = $s3->url;
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Salon de Ahn</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
		<script src="js/modernizr.custom.70736.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" href="/bootstrap/bootstrap_custom.css"/>	
		<link rel="stylesheet" href="/assets/css/main_custom.css" />				
		<style>
		#sample {
			display: none;
		}
		</style>
		<noscript><link rel="stylesheet" type="text/css" href="css/noJS.css"/></noscript>		

		<!-- 사진 업로드 기능 -->            
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js" ></script>
        <script type="text/javascript">
        $(document).ready (function(){            
            $("#fileAdd").click(function(){ // 사진 한 장씩 업로드
                $("#fileList").append(					
					'<div>\
					<input type="file" class="col-8 btn-sm" id="fileUpload" name="photos[]">\
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
					<input type="file" class="col-8 btn-sm" id="filesUpload" name="photos_multi[]" multiple>\
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
	<div id="page-wrapper" style="height: inherit;">

		<div id="header">
			<?php include_once "../fragments/header.php"; ?>
		</div>
		
		<div class="container">			
			<a href="albums.php"><button type="button" class="btn" style="position: absolute; top: 30px; left: -50px;">◀ 뒤로</button></a>
			<div class="main">
				<header class="clearfix m-0 p-0">
				
					<h1><?=$album['title']?><span><?=$album['caption']?></span><span><?=$album['rcday']?></span></h1>
					
				</header>
				<?php 
					if($role == "ADMIN") {
					?>							
						<form action="photo_upload.php" method="post" enctype="multipart/form-data">
							<input type="hidden" id="folder" name="folder" value="<?=$album['title']?>">
							<button type="submit" class="btn-sm">사진 업로드하기</button>
							<button type="button" id="fileAdd" class="btn-sm">사진 추가</button>
							<button type="button" id="filesAdd" class="btn-sm">사진 여러 장 추가</button>
							<a href="photos_delmode.php?folder=<?=$folder?>"><button type="button" id="photoDelete" class="btn-sm">사진 삭제 모드</button></a>
							<ul id="fileList"></ul>
						</form>
					<?php
						}
					?>
				
				<div class="gamma-container gamma-loading thumbnails" id="gamma-container">

					<ul class="gamma-gallery" id="thumbnails">
						<li id="sample" class="p-0">							
							<div data-alt="" data-description="<h3></h3>" data-max-width="1800" data-max-height="1350">								
								<div data-src="" data-min-width="200"></div>								
							</div>																					
						</li>						
					</ul>
					<div class="form-check" id="del_check" class="del_check" style="display: none;">
						<input class="form-check-input" type="checkbox" name="del_photo[]" id="del_photo" style="width: 26px; height: 26px;">
					</div>

				<!-- 올린 사진이 없는 경우-->
					<?php
					if($row == 0) {
					?>
						<div class="d-flex align-items-center justify-content-center" style="height: 25vh;">
						<p class="text-center" style="font-size: 2rem;">아직 올라온 사진이 없네요</p>
						</div>						
					<?php
					}
					?>
					<div class="gamma-overlay"></div>

					<!-- <div id="loadmore" class="loadmore">사진 더보기</div> -->
				</div>
			</div><!--/main-->
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
			
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
			<script src="js/jquery.masonry.min.js"></script>
			<script src="js/jquery.history.js"></script>
			<script src="js/js-url.min.js"></script>
			<script src="js/jquerypp.custom.js"></script>
			<script src="js/gamma.js"></script>				
			<script type="text/javascript">			
			$(function() {				

				var GammaSettings = {
						// order is important!
						viewport : [ {
							width : 1200,
							columns : 5
						}, {
							width : 900,
							columns : 4
						}, {
							width : 500,
							columns : 3
						}, { 
							width : 320,
							columns : 2
						}, { 
							width : 0,
							columns : 2
						} ]
				};

				Gamma.init( GammaSettings, append_list );	
			});
		

	// <!-- 사진 더보기 버튼 기능 -->
		
			$(function (e) {
				// append_list();
				// 더보기 이벤트
				$('#loadmore').show().on( 'click', function() {
					append_list();
				});
			});

			var items = []

			<?php
			// S3 객체를 생성하여 버킷과 파일 경로 저장 및 불러오기에 필요한 URL을 가져옴
			$s3 = new aws_s3;
			$bucket = $s3->bucket;
			$url = $s3->url;

			// $q = mq("SELECT * FROM photosave WHERE num>0 AND folder='".$folder."' ORDER BY num DESC LIMIT {$start}, {$list}");
			$q = mq("SELECT * FROM photosave WHERE num>0 AND folder='".$folder."' ORDER BY num DESC");
			if(mysqli_num_rows($q) != 0) {
				$row = mysqli_num_rows($q); // 해당 사진첩의 사진 총 갯수 불러오기
			} else {
				$row = 0;
			}

			if($row != 0) {
				while($p = mysqli_fetch_array($q)){
			?>    
				var del_btn = $('#fileAdd').clone();
				del_btn.attr('id', '<?=$p['num']?>._del');
				del_btn.attr('class', 'btn del_photo');
				del_btn.text('X')
				del_btn.css({'z-index': '1',
						'position': 'absolute',
						'top': '1px',
						'right': '1px',
						'font-size': '2rem'});

				// var photo = $('#sample').clone();
				var photo = '<li id="<?=$p['num']?>"><div data-alt="<?=$p['title']?>" data-description="<h3><?=$p['caption']?></h3>" data-max-width="1800" data-max-height="1350"><div data-src="<?=$url.$p['filepath']?>" data-min-width="200"></div></div></li>'
				// photo.attr('id', '<?=$p['num']?>');
				// photo.attr('class', 'masonry-brick');
				// photo.css('display', 'list-item');
				// photo.children('img').attr('alt', '<?=$p['title']?>');
				// photo.children('img').attr('src', '<?=$url.$p['filepath']?>');
				// photo.children('div').children('h3').text('<?=$p['caption']?>');
				<?php if($role == 'ADMIN') { ?> 
					// photo.append(del_btn);
				<?php } ?>
				// $('#thumbnails').append(photo);
				items.push(photo);
				// console.log(items);
			<?php
				}
			}				
			?>
			var i = 0;
			var limit = 10;
			
			function append_list() {
				while(i < items.length) {
					// $('#thumbnails').append(items[i]);
					// items[i].attr('class', 'masonry-brick');
					Gamma.add( $(items[i]) );
					// console.log(items[i]);
					i++;
					if(i >= items.length) {
						$('#loadmore').hide();
						break;
					}
				}
				// limit += 10;				
				// if(self.name != 'reload') {
				// 	self.name = 'reload';
				// 	self.location.reload(true);
				// } else {
				// 	self.name = '';
				// }
			}
			
		</script>			
	</body>
</html>