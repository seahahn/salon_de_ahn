<?php 
include_once "../db_con.php";

// $folder = $_GET['folder'];
$folder = 'test1';
$album_q = mq("SELECT * FROM photofolder WHERE title = '".$folder."'");
$album = mysqli_fetch_array($album_q);
$q = mq("SELECT * FROM photosave WHERE folder = '".$folder."'");
// $q = mq("SELECT * FROM photosave WHERE folder = 'test2.php'");
if(mysqli_num_rows($q) != 0) {
	$row = mysqli_num_rows($q); // 해당 사진첩의 사진 총 갯수 불러오기
} else {
	$row = 0;
}

$start = 0;
$list = 10;
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
		<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <script src="js/modernizr.custom.70736.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>		
		<link rel="stylesheet" href="/bootstrap/bootstrap_custom.css"/>	
		<link rel="stylesheet" href="/assets/css/main_custom.css" />
        <noscript><link rel="stylesheet" type="text/css" href="css/noJS.css"/></noscript>		
        <style>
        .main_image{
            width:48%;
            display:inline-block;
            border:3px solid #eee;
        }
        .main_image img{
            width:100%;
        }
        .selection_image{
            width:48%;
            display:inline-block;
        }
        .thumb {
            position:relative; 
            width:25%; 
            height:15%; 
            display:inline-block; 
            margin:2px;
            border:4px solid #eee;
            outline:1px solid #ddd;
            }
        .thumb:hover .overlay {
            opacity:0!important;
            cursor:pointer;
        }
        .overlay {
            position:absolute;
            top:0;left:0;width:100%;height:100%;
            background:#000;opacity:0.4;
        }
        .selection_image img {
            width:100%;
            height:100%;    
        }
        </style>
        <script>
        $.(document).ready(function(){
            $.('.thumb').hover(function(){
                $('.main_image img').attr('src',$(this).children('img').attr('src'));
            });
        })
        </script>

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

		<!-- 사진 더보기 버튼 기능 -->
		<script>
			$(function (e) {
				// append_list();
				// 스크롤 이벤트
				$('#loadmore').click(function() {
					append_list();
				});
			});

			var start = <?=$start?>;
			var list = 10;				
			var url = window.location.href;
			function append_list() {
				console.log(start);
				$.post("./list_append.php", {start:start, list:list, folder:'<?=$folder?>'}, function(data) {
					if(data){
						$("#thumbnails").append(data);
						start += list;
						// $("#thumbnails").load(window.location.href + " #thumbnails");
					}
					if(start >= <?=$row?>) {
						$('#loadmore').css("display", "none"); // 다 불러왔으면 더보기 버튼 안 보이게 만듦				
					}
				});

				
			}
		</script>		
	</head>
	<body id="body" class="is-preload-0 is-preload-1 is-preload-2" style="overflow-x: hidden;">
	<div id="page-wrapper">

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
							<ul id="fileList"></ul>
						</form>
					<?php
						}
					?>

                <div class="gallery">
                    <div class="main_image">
                        <img src="images/aston.jpg" />
                    </div>

                    <div class="selection_image">
                        <div class="thumb">
                                <div class="overlay"></div>
                                <img src="images/aston.jpg" />
                        </div>
                    </div>
                </div>
				
				<div class="gamma-container gamma-loading thumbnails" id="gamma-container">

					<ul class="gamma-gallery" id="thumbnails">

					<?php 				
					// $start = 0;
					// $list = 10;
					if($row != 0) {
						$q = mq("SELECT * FROM photosave WHERE num>0 AND folder='".$folder."' ORDER BY num DESC LIMIT {$start}, {$list}");
						while($p = mysqli_fetch_array($q)){
					?>    
						<li>        
							<div data-alt="<?=$p['title']?>" data-description="<h3><?=$p['caption']?></h3>" data-max-width="1800" data-max-height="1350">								
								<div data-src="<?=$p['filepath']?>" data-min-width="200"></div>
							</div>
							<?php if($role == 'ADMIN') {
							echo '<button class="btn del_photo" style="z-index: 1;
							position: absolute;
							top: 0px;
							right: 0px;
							font-size: 2rem;">X</button>';
							} ?>
						</li>
					<?php
						}
					}
					$start += $list;
					?>
					</ul>
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

					<div id="loadmore" class="loadmore">사진 더보기</div>
				</div>
			</div><!--/main-->
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

				Gamma.init( GammaSettings, fncallback );


				// Example how to add more items (just a dummy):

				var page = 0,
					items = []

				function fncallback() {
					$( '#loadmore' ).show().on( 'click', function() {
						++page;
						var newitems = items[page-1]
						if( page <= 1 ) {							
							Gamma.add( $( newitems ) );
						}
						if( page === 1 ) {
							$( this ).remove();
						}
					});
				}
			});
		</script>
	</body>
</html>