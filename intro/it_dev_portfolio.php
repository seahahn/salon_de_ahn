<?php
include_once "../util/config.php";
include_once "../db_con.php";

$category = "it_dev_portfolio";
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

                        <div class="row my-5"> <!-- 메인 글 영역-->
                            <div class="col">
                                <video class="my-2" src="../video/stocking.mp4" width="640px" height="360px" controls></video>
                                <img src="">
                                <h3 class="my-2 read_check" style="cursor:pointer" data-action="./portfolio.php?pj=stocking"></a>기초 자바 작품 - Stocking</h3>
                                <p>기초 자바 작품 - Stocking</p>
                            </div>
                            <div class="col">
                                <video class="my-2"src="" width="640px" height="360px" controls>비디오 준비중...</video>
                                <img src="">                                
                                <h3 class="my-2 read_check" style="cursor:pointer" data-action="./portfolio.php?pj=cvr">(비디오 준비중) 기초 안드로이드 작품 - Cyclic Voca Review</h3>
                                <p>기초 안드로이드 작품 - Cyclic Voca Review</p>
                            </div>																		
						</div>																	
					</div>
										
				<!-- </div> -->

			<!-- Footer -->
				<div class="mt-4" id="footer">
                    <?php include_once "../fragments/footer.php"; ?>
				</div>

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

        <!-- 게시물 읽기 페이지 이동 기능-->
            <script>
                $(function(){
                    $(".read_check").click(function(){
                        var action_url = $(this).attr("data-action");
                        $(location).attr("href", action_url);
                    });
                });
            </script>

        <!-- 글 읽기 이벤트-->
            <script>               
            
                // 일반 글 클릭시 해당 num의 read 페이지로 이동하는 이벤트
                $(function(){
                    $(".read_check").click(function(){
                        var action_url = $(this).attr("data-action");
                        console.log(action_url);
                        $(location).attr("href", action_url);
                    });
                });
            </script>


	</body>
</html>