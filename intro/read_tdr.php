<?php
include_once "../util/config.php";
include_once "../db_con.php";
// include_once "../login/login_check.php";
// echo $useremail;

$bno = $_GET['num']; // $bno에 num값을 받아와 넣음
	/* 받아온 num값을 선택해서 게시글 정보 가져오기 */
	$sql = mq("SELECT
				 *
                FROM
                    tdrecord
                WHERE
                    num='".$bno."'
			");
	$board = $sql->fetch_array();
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
        <!-- <link rel="stylesheet" href="/bootstrap/bootstrap_custom.css"/> -->
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
                                    <h3 class=my-3>종목명 : <?=$board['item']?></h3>
                                    <table class="table table-striped" style="text-align: start; border: 1px solid #ddddda; min-height: 200px;">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class=p-0>
                                                    <div class="d-flex">
                                                        <span class="pos_input col-6">분류 : <?=$board['category']?></span>
                                                        <span class="pos_input col-6">포지션 : <?=$board['position']?></span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=p-0>
                                                    <div class="d-flex">
                                                        <span class="pos_input col-6">진입 포인트 : <?=$board['in_pos']?></span>
                                                        <span class="pos_input col-6">진입 일자 : <?=$board['in_date']?></span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=p-0>
                                                    <div class="d-flex">
                                                        <span class="pos_input col-6">청산 포인트 : <?=$board['out_pos']?></span>
                                                        <span class="pos_input col-6">청산 일자 : <?=$board['out_date']?></span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class=p-0>
                                                    <div class="d-flex">
                                                        <span class="pos_input col-6">손익 : <?=$board['pl']?></span>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="min-height: 200px; text-align: left;"><?=$board['content']?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="row justify-content-start">
                                                    <p class="col-12" style="margin-bottom: 0px;"><b>첨부파일 목록</b></p>
                                                    <?php
                                                        $sql = mq("SELECT att_file FROM tdrecord WHERE num='".$bno."'");
                                                        while($row = mysqli_fetch_assoc($sql)){
                                                            $filepath_array = unserialize($row['att_file']);
                                                        }

                                                        for($i=0; $i<count($filepath_array);$i++){
                                                            $filename_result = mq("SELECT filename_real, filename_tmp FROM filesave WHERE filepath='".$filepath_array[$i]."'");
                                                            $filename_fetch = mysqli_fetch_array($filename_result);
                                                            $filename_tmp = $filename_fetch[1];
                                                            $filename_real = $filename_fetch[0];
                                                            $filename = str_replace(" ","_", $filename_real);
                                                            $filepath = "/file/";
                                                            echo "<a class='col-12 float-left' style='text-align: initial;' href=./download.php?dir=$filepath&file=$filename_tmp&name=$filename>$filename_real</a><br/>";
                                                        }
                                                    ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
							</div>
                        </div>

                        <!-- 목록, 수정, 삭제 -->
                        <div class="row justify-content-end">
                            <div class="row col-auto">
                                <?php
                                    if($role == "ADMIN") {
                                ?>
                                <form action="write_tdr.php" method="POST" class="pl-0">
                                    <a class="a_padding"><button type="submit" class="col-auto mr-auto btn-lg">글쓰기</button></a>
                                </form>
                                <a href="update_tdr.php?num=<?=$board['num']?>" class="a_nopadding"><button type="button" value="<?=$bno?>" class="col-auto mr-auto btn-lg">수정</button></a>
                                <a href="delete_article_tdr.php?num=<?=$board['num']?>" class="a_nopadding"><button type="button" value="<?=$bno?>" class="col-auto mr-auto btn-lg">삭제</button></a>
                                <?php } ?>
                            </div>
                            <!-- <div class="col-auto d-flex justify-content-end"> -->
                                <a href="tradingrecord.php" class="a_nopadding"><button type="button" class="btn-lg">목록</button></a>
                            <!-- </div>                                                                                                       -->
                        </div>

                    </div>
                    <!-- 댓글 불러오기 끝 -->

			<!-- Footer -->
				<div  class="mt-4"id="footer">
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
	</body>
</html>