<?php
include_once "./util/config.php";
include_once "./db_con.php";
?>
<!DOCTYPE HTML>
<!--
	Helios by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<?php include_once "./fragments/head.php"; ?>
		<style media="screen and (min-width: 1680px)">			
			#intro_img {
				padding: 0 0 0 40px;
			}
		</style>
	</head>
	<body class="homepage is-preload">
		<div id="page-wrapper">

				<!-- Header -->
				<div id="header">
					<?php include_once "./fragments/header.php"; ?>
				</div>

			<!-- Banner -->
			<!-- 메인 페이지에서 Start 버튼 누르면 보이는 화면 중 위쪽의 문장 두 개-->
			<!-- <div class="wrapper style1 m-0"> -->
				<section id="banner">
					<header>
						<h2>Greetings and Welcome to <strong>Salon de Ahn</strong>.</h2>
						<p class="mb-5">IT 개발자 안경호의 포트폴리오 웹사이트에 오신 것을 환영합니다 !
						</p>
					</header>
					<article id="main" class="container special" style="height: auto;">
						<div class="row">						
						<p class="col-12 col-lg-6 col-md-12 col-sm-12 col-12-mobile">
							반갑습니다! 저는 대한민국 서울에 거주중인 IT 개발자 안경호입니다.
							<br/><br/>
							초등학교에 들어가기 전부터 사랑스러운 가족들 덕분에 '피코'라는 교육용 게임기 및 플레이스테이션 1 등의 전자기기를 접할 기회가 있었습니다.
							그 후 초등학생이 되어서는 컴퓨터 게임을 시작으로 자연스레 컴퓨터를 다루게 되었고, 곧이어 혼자서 컴퓨터 부품 조립을 할 정도로 손에 익었습니다.
							이때가 9살 즈음이었는데, 이때부터 장래희망에 '컴퓨터 프로그래머'라고 썼던 기억이 납니다. 정작 프로그래밍이 뭔지도 잘 모르면서요 :))
							제가 컴퓨터에 관심이 있어하니 부모님이 컴퓨터 학원을 보내주셨는데, 그때는 제 나이가 어려서였는지 몰라도 주로 워드프로세서 같은 것을 배웠습니다.
							<br/><br/>
							이후에는 집안 사정으로 인해 학원도 그만두게 되고, 컴퓨터도 멀리하게 되어 자연스레 '프로그래머'라는 장래희망과도 다소 멀어졌습니다.
							성장 과정에서 다른 관심사를 갖게 되면서 더더욱 멀어지는 듯했으나, 마음 속에서는 제 스스로가 생각한 무언가를 실제로 만들어내고 싶다는 욕구가 계속해서 남아있었습니다.
							그리고 무엇을 통해서 이 욕구를 채울 수 있을까, 어떤 능력이 필요할까 라는 고민을 한 결과 다시금 프로그래밍으로 눈을 향하게 되었습니다.
							그리고, 지금에 이르게 되었습니다. :)
							<br/><br/>
							공부를 시작하면서 어떤 개발자가 되고 싶은지를 생각할 기회가 있었습니다. 실력 좋은 개발자, 돈 많이 버는 개발자가 되는 것도 좋겠다는 생각도 했습니다만,
							그 이전에 저는 사람들과 소통할 줄 아는 개발자, 나의 틀림과 타인의 다름을 받아들일 줄 아는 개발자가 되고 싶다는 생각을 했습니다.
							제가 가진 능력으로 세상을 돌아다니면서 많은 사람들을 만나며 그들과 소통하고, 그들이 가진 문제를 해결하는 데에 도움을 주면서 나 자신의 시야를 넓혀가는 그런 개발자가 되고 싶습니다.						
						</p>
						<img id="intro_img" class="col-12 col-lg-6 col-md-12 col-sm-12 col-12-mobile" src="images/IMG_4078.jpg" alt="메인 사진" style="width:50%; height:50%;"/></a>						
						<p class="col-12 col-12-mobile">
							이 웹사이트는 저의 IT 개발 기록뿐만 아니라 제가 관심을 갖고 있는 분야들, 그리고 저의 일상에 대한 기록을 모아두기 위해서 만들었습니다.
							크게 IT 개발, 금융, 언어 학습의 3가지 분야 및 일상 기록까지 합하여 총 4개의 카테고리로 나누어서 게시글을 작성하였습니다.
							각각의 카테고리에는 제가 각 분야를 접하면서 배우거나 알게된 내용을 기록한 게시판과 함께 이 웹사이트를 방문하신 분들과 함께 토론, 정보 및 경험 공유, 질의응답 등의 이야기를 나눌 수 있는 게시판을 만들었습니다.
							<br/><br/>
							많은 분들께 저의 기록이 도움이 되기를, 그리고 많은 분들이 저와 함께 이야기를 나눌 수 있기를 바랍니다.
						</p>
						</div>						
					</article>
				</section>				
			<!-- </div> -->

			<!-- Features -->
			<!-- Main 아래로 내려가면 보이는 제목, 제목 아래 문장 그리고 이미지와 글 제목, 내용 세트 3개-->
				<div class="wrapper style1 m-0">

					<section id="features" class="container special" style="height: auto;">
						<header>
							<h2>IT개발, 금융, 언어 그리고 일상</h2>
							<p>제가 관심있는 주제들에 대한 정보, 그리고 저의 일상을 남겼습니다.</p>
						</header>
						<div class="row">
							<article class="col-12 col-lg-3 col-md-6 col-sm-12 special">
								<a href="/intro/it_dev.php" class="image featured">
									<img src="https://salon-de-ahn.s3.ap-northeast-2.amazonaws.com/images/laptop-336373_640.jpg" alt="" />
								</a>								
								<header>
									<h3><a href="/intro/it_dev.php">IT개발</a></h3>
								</header>
								<p class=p-3>
									IT개발을 공부하며 배운 내용, 유용한 정보 등을 모아두었습니다.
								</p>
							</article>
							<article class="col-12 col-lg-3 col-md-6 col-sm-12 special">
								<a href="/intro/finance.php" class="image featured">								
									<img src="https://salon-de-ahn.s3.ap-northeast-2.amazonaws.com/images/money-2724241_640.jpg" alt="" style=""/>
								</a>								
								<header>
									<h3><a href="/intro/finance.php">금융</a></h3>
								</header>
								<p class=p-3>
									주식, 선물, FX등의 금융 거래를 경험하면서 알게된 경험 및 내용을 담았습니다.
								</p>
							</article>
							<article class="col-12 col-lg-3 col-md-6 col-sm-12 special">
								<a href="/intro/languages.php" class="image featured">
									<img src="https://salon-de-ahn.s3.ap-northeast-2.amazonaws.com/images/education-4382169_640.jpg" alt="" />
								</a>								
								<header>
									<h3><a href="/intro/languages.php">언어 학습</a></h3>
								</header>
								<p class=p-3>
									다국어 학습에 관심을 가지고 공부하면서 쌓아둔 학습 기록 및 자료들을 올려두었습니다.
								</p>
							</article>
							<article class="col-12 col-lg-3 col-md-6 col-sm-12 special">
								<a href="/board/board_list.php?ctgr=<?=$daily_life?>" class="image featured">
									<img src="https://salon-de-ahn.s3.ap-northeast-2.amazonaws.com/images/the-work-2166128_640.jpg" alt="" />
								</a>
								<header>
									<h3><a href="/board/board_list.php?ctgr=<?=$daily_life?>">일상</a></h3>
								</header>
								<p class=p-3>
									저의 개인적인 일상 기록 및 사진들을 공유하였습니다.
								</p>
							</article>
						</div>
					</section>
				</div>

			<!-- Footer -->
			<!-- 맨 아래 어두운 바탕 영역에 있는 것들-->
				<div id="footer">
					<?php include_once "./fragments/footer.php"; ?>
				</div>
		</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.dropotron.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
	</body>
</html>