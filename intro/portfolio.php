<?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";
$s3 = new aws_s3;
$url = $s3->url;

$num = $_GET['num'];
$sql = mq("SELECT * FROM pj WHERE num='".$num."'");
$pj = $sql->fetch_array();
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
                        <div class="row"> <!-- 메인 글 영역-->
							<div class="col" id="content">
                                <!-- 글 내용 영역 -->
                                <!-- 글 불러오기 -->
                                <div id="board_read">
                                    <h2><?=$pj['title']?></h2>
                                    <a class="pl-1 float-right" href="it_dev_portfolio.php"><button type="button" class="btn-lg">목록</button></a>
                                    <p><?=$pj['caption']?></p>
                                    <table class="table table-striped" style="text-align: center; border: 1px solid #ddddda; min-height: 200px;">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <video class="my-2 col-12" src="<?=$url.$pj['videopath']?>" controls></video>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="min-height: 200px; text-align: left;"><?=$pj['content']?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <a class="pl-1 float-right" href="it_dev_portfolio.php"><button type="button" class="btn-lg">목록</button></a>
							</div>
                        </div>
					</div>

				<!-- </div> -->

			<!-- Footer -->
				<div class="mt-4" id="footer">
                    <?php include_once "../fragments/footer.php"; ?>
				</div>

		</div>

        <?php include_once "../fragments/scripts.php"; ?>
		<!-- Scripts -->
            <!--<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/jquery.dropotron.min.js"></script>
			<script src="/assets/js/jquery.scrolly.min.js"></script>
			<script src="/assets/js/jquery.scrollex.min.js"></script>
			<script src="/assets/js/browser.min.js"></script>
			<script src="/assets/js/breakpoints.min.js"></script>
			<script src="/assets/js/util.js"></script>
			<script src="/assets/js/main.js"></script>
            <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>-->

        <!-- Bootstrap Stripts-->
			<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
			<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
            <script src="/bootstrap/bootstrap.bundle.min.js"></script>-->

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