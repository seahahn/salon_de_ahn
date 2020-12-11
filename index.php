<!DOCTYPE HTML>
<!--
	Helios by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<?php include_once "./fragments/head.php"; ?>
	</head>
	<body class="homepage is-preload">
		<div id="page-wrapper">

				<!-- Header -->
				<div id="header">
					<?php include_once "./fragments/header.php"; ?>
				</div>

			<!-- Banner -->
			<!-- 메인 페이지에서 Start 버튼 누르면 보이는 화면 중 위쪽의 문장 두 개-->
				<section id="banner">
					<header>
						<h2>Greetings and Welcome to <strong>Salon de Ahn</strong>.</h2>
						<p class="mb-5">IT 개발자 안경호의 포트폴리오 웹사이트에 오신 것을 환영합니다 !
						</p>
					</header>
					<article id="main" class="container special">
						<div class="row">
						
						<p class="col mr-3">
							Commodo id natoque malesuada sollicitudin elit suscipit. Curae suspendisse mauris posuere accumsan massa
							posuere lacus convallis tellus interdum. Amet nullam fringilla nibh nulla convallis ut venenatis purus
							sit arcu sociis. Nunc fermentum adipiscing tempor cursus nascetur adipiscing adipiscing. Primis aliquam
							mus lacinia lobortis phasellus suscipit. Fermentum lobortis non tristique ante proin sociis accumsan
							lobortis. Auctor etiam porttitor phasellus tempus cubilia ultrices tempor sagittis. Nisl fermentum
							consequat integer interdum integer purus sapien. Nibh eleifend nulla nascetur pharetra commodo mi augue
							interdum tellus. Ornare cursus augue feugiat sodales velit lorem. Semper elementum ullamcorper lacinia
							natoque aenean scelerisque.
						</p>
						<p class="col mr-3">
							Commodo id natoque malesuada sollicitudin elit suscipit. Curae suspendisse mauris posuere accumsan massa
							posuere lacus convallis tellus interdum. Amet nullam fringilla nibh nulla convallis ut venenatis purus
							sit arcu sociis. Nunc fermentum adipiscing tempor cursus nascetur adipiscing adipiscing. Primis aliquam
							mus lacinia lobortis phasellus suscipit. Fermentum lobortis non tristique ante proin sociis accumsan
							lobortis. Auctor etiam porttitor phasellus tempus cubilia ultrices tempor sagittis. Nisl fermentum
							consequat integer interdum integer purus sapien. Nibh eleifend nulla nascetur pharetra commodo mi augue
							interdum tellus. Ornare cursus augue feugiat sodales velit lorem. Semper elementum ullamcorper lacinia
							natoque aenean scelerisque.
						</p>
						<img class="col" src="images/IMG_4078.jpg" alt="메인 사진" style=" display: inline; width: 50%; height: 50%;"/></a>
						</div>						
					</article>
				</section>				

			<!-- Features -->
			<!-- Main 아래로 내려가면 보이는 제목, 제목 아래 문장 그리고 이미지와 글 제목, 내용 세트 3개-->
				<div class="wrapper style1">

					<section id="features" class="container special">
						<header>
							<h2>IT개발, 금융, 언어 그리고 일상</h2>
							<p>제가 관심있는 주제들에 대한 정보, 그리고 저의 일상을 남겼습니다.</p>
						</header>
						<div class="row">
							<article class="col-3 col-12-mobile special">
								<a href="/intro/it_dev.php" class="image featured"><img src="images/pic07.jpg" alt="" /></a>
								<header>
									<h3><a href="/intro/it_dev.php">IT개발</a></h3>
								</header>
								<p>
									IT개발에 대한 내 소개
								</p>
							</article>
							<article class="col-3 col-12-mobile special">
								<a href="/intro/finance.php" class="image featured"><img src="images/pic07.jpg" alt="" /></a>
								<header>
									<h3><a href="/intro/finance.php">금융</a></h3>
								</header>
								<p>
									금융에 대한 내 소개
								</p>
							</article>
							<article class="col-3 col-12-mobile special">
								<a href="/intro/languages.php" class="image featured"><img src="images/pic07.jpg" alt="" /></a>
								<header>
									<h3><a href="/intro/languages.php">언어 학습</a></h3>
								</header>
								<p>
									언어 학습에 대한 내 소개
								</p>
							</article>
							<article class="col-3 col-12-mobile special">
								<a href="/board/board_list.php?ctgr=<?=$daily_life?>" class="image featured"><img src="images/pic07.jpg" alt="" /></a>
								<header>
									<h3><a href="/board/board_list.php?ctgr=<?=$daily_life?>">일상</a></h3>
								</header>
								<p>
									일상에 대한 내 소개
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