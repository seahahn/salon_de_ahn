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
		<link rel="stylesheet" href="/bootstrap/bootstrap_custom.css"/>	
		<link rel="stylesheet" href="/assets/css/main_custom.css" />		
		<!-- <style>
			section, article {
				margin-bottom: 0;
			}
			.row {
				margin-top: 0;
				margin-left: 0;
			}
			#header {
				padding: 3em 2.25em 1.75em 2.25em;
				margin: 0 0 0 0;
				color: #0c0a0a;
				background-image: none;
			}
			#header h1 {
				color: #151010;
			}
			#footer {
				padding: 1em 0 0 0;
			}
			#main {
				overflow : hidden;
				/* display : flex; */
				/* flex-direction: column; */
			}
			#main #header {
				height: 30%;
				overflow-y: auto;
			}
			#main #header::-webkit-scrollbar { 
				display: none !important;
			}
			#main #thumbnails {
				/* overflow-x : hidden; */
				height: 70%;
    			overflow-y: auto;
				/* flex: 1; */
				/* display: none !important; 윈도우 크롬 등 */
			}
			#main #thumbnails::-webkit-scrollbar { 
				display: none !important;
			}
		</style> -->

		<!-- 사진 업로드 기능 -->            
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js" ></script>
        <script type="text/javascript">
        $(document).ready (function(){            
            $("#fileAdd").click(function(){
                $("#fileList").append(					
					'<input type="file" class="col-8 btn-sm" id="fileUpload" name="photos[]">\
					<button type="button" class="btn-sm btnRemove">첨부 취소</button>\
					<input type="text" class="form-control form-control-sm" name="title[]">\
					<input type="text" class="form-control form-control-sm" name="caption[]">'
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
				$.post("./list_append.php", {start:start, list:list}, function(data) {
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

		<div id="header_top">
			<?php include_once "../fragments/header.php"; ?>
		</div>

		<div id="mid" class="row">
			<div class="" id="viewer">
				<div class="inner">
					<div class="nav-next"></div>
					<div class="nav-previous"></div>
					<div class="toggle"></div>
				</div>
			</div>
		<!-- Main -->
			<div id="main" class="main p-0">
				<!-- Header -->
					<header id="header" class="d-flex flex-column">
						<h1>Gallery</h1>
						<p class="mt-3 mb-1">멋진 갤러리</p>						
						<?php 
							if($role == "ADMIN") {
						?>							
							<form action="photo_upload.php" method="post" enctype="multipart/form-data">
								<button type="submit" class="btn-sm">사진 업로드하기</button>
								<button type="button" id="fileAdd" class="btn-sm">사진 추가</button>
								<ul id="fileList"></ul>
							</form>
						<?php
							}
						?>
					</header>

				<!-- Thumbnail -->
				<!-- <div id="thumbnail_area"> -->
					<section id="thumbnails" class="p-0 m-0">
						<article>
							<a class="thumbnail" href="../images/1607669888_91298.jpg"><img src="../images/1607669888_91298.jpg" alt="" /></a>
							<h2>1</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
						</article>						
						<article>
							<a class="thumbnail" href="../images/1607669888_91298.jpg"><img src="../images/1607669888_91298.jpg" alt="" /></a>
							<h2>2</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
						</article>											

						<?php 
						
						?>
					</section>
				<!-- </div>			 -->
			</div>					
		</div>

			<!-- Footer -->
			<footer id="footer" class="m-0">
				<?php include_once "../fragments/footer.php"; ?>
			</footer>			
	</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/main.js"></script>

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
			
	</body>
</html>