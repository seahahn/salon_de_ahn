<?php
	include_once "../util/config.php";
	include_once "../db_con.php";
	include_once "../s3.php";
	$s3 = new aws_s3;	
	$bucket = $s3->bucket;
	$url = $s3->url;
	
	if($role != "ADMIN") {
		echo '
			<script>
				alert("관리자만 작성 가능합니다.");
				history.go(-1);
			</script>';
	}
    
	$bno = $_GET['num'];
	$sql = mq("SELECT * FROM pj WHERE num = $bno");
	$fetch = $sql->fetch_array();
	$videopath = $fetch['videopath'];

	if($videopath != ''){
		$s3->delete($bucket, $videopath);
	}

	/* 받아온 num값을 선택해서 게시글 삭제 */
	mq("DELETE 
        FROM 
        pj 
        WHERE 
        num='".$bno."'
		");
?>
	<script>
		alert("삭제되었습니다.");
	</script>
	<meta http-equiv="refresh" content="0 url=./it_dev_portfolio.php">
