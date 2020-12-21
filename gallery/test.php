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
		<script src="js/modernizr.custom.70736.js"></script>
		<link rel="stylesheet" type="text/css" href="css/style.css"/>
		<link rel="stylesheet" href="/bootstrap/bootstrap_custom.css"/>	
		<link rel="stylesheet" href="/assets/css/main_custom.css" />				
		<noscript><link rel="stylesheet" type="text/css" href="css/noJS.css"/></noscript>		

		<!-- 사진 업로드 기능 -->            
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js" ></script>
        <script type="text/javascript">
        $(document).ready (function(){            
            $("#fileAdd").click(function(){
                $("#fileList").append(					
					'<div>\
					<input type="file" class="col-8 btn-sm" id="fileUpload" name="photos[]">\
					<button type="button" class="btn-sm btnRemove">첨부 취소</button>\
					<div class="row">\
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
		});
		</script>

		<!-- 사진 불러오기 무한 스크롤 기능 -->
		<!-- <script>
			$(function (e) {
				append_list();
				// 스크롤 이벤트
				$('#loadmore').click(function() {
					append_list();					
				});
			});

			var start = 0;
			var list = 8;
			function append_list() {
				$.post("./list_append.php", {start:start, list:list}, function(data) {
					if(data){
						$("#thumbnails").append(data);
						start += list;
					}
				});
			}
		</script> -->
	</head>
	<body class="is-preload-0 is-preload-1 is-preload-2" style="overflow-x: hidden;">
	<div id="page-wrapper">

		<div id="header">
			<?php include_once "../fragments/header.php"; ?>
		</div>

		<a href="test2.php"><button type="button" class="btn" style="position: absolute; top: 300px; left: 110px; z-index: 1">◀ 뒤로</button></a>
		<div class="container">			
			
			<div class="main">
				<header class="clearfix">
				
					<h1>갤러리 제목<span>갤러리 설명</span></h1>					
					
				</header>
				<?php 
					if($role == "ADMIN") {
					?>							
						<form action="photo_upload.php" method="post" enctype="multipart/form-data">
							<input type="hidden" id="folder" name="folder" value="test2.php">
							<button type="submit" class="btn-sm">사진 업로드하기</button>
							<button type="button" id="fileAdd" class="btn-sm">사진 추가</button>
							<ul id="fileList"></ul>
						</form>
					<?php
						}
					?>
				
				<div class="gamma-container gamma-loading" id="gamma-container">

					<ul class="gamma-gallery" id="thumbnails">

					<?php 				
					$start = 0;
					$list = 8;

					$q = mq("SELECT * FROM photosave WHERE num>0 ORDER BY num DESC LIMIT {$start}, {$list}");
					while($p = mysqli_fetch_array($q)){
					?>    
						<li>        
							<div data-alt="<?=$p['title']?>" data-description="<h3><?=$p['caption']?></h3>" data-max-width="1800" data-max-height="1350">								
								<div data-src="<?=$p['filepath']?>" data-min-width="200"></div>
							</div>
						</li>
					<?php
					}
					?>

						<!-- <li>
							<div data-alt="대신할_글" data-description="<h3>마우스_올리면_나오는_글씨</h3>" data-max-width="1800" data-max-height="1350">
								<div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div>																
							</div>
						</li> -->
						<li>
							<div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350">								
								<div data-src="images/medium/3.jpg" data-min-width="200"></div>
							</div>
						</li>
						
					</ul>

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
					items = ['<li><div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li><li><div data-alt="img03" data-description="<h3>Sky high</h3>" data-max-width="1800" data-max-height="1350"><div data-src="images/xxxlarge/3.jpg" data-min-width="1300"></div><div data-src="images/xxlarge/3.jpg" data-min-width="1000"></div><div data-src="images/xlarge/3.jpg" data-min-width="700"></div><div data-src="images/large/3.jpg" data-min-width="300"></div><div data-src="images/medium/3.jpg" data-min-width="200"></div><div data-src="images/small/3.jpg" data-min-width="140"></div><div data-src="images/xsmall/3.jpg"></div><noscript><img src="images/xsmall/3.jpg" alt="img03"/></noscript></div></li>']

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

					} );

				}

			});

		</script>
			
	</body>
</html>