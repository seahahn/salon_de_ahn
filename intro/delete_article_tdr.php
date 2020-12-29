<?php
	include "../db_con.php";
	
	if($role != 'ADMIN') {
		echo '
			<script>
				alert("관리자만 작성 가능합니다.");
				history.go(-1);
			</script>';
	}
    
	$bno = $_GET['num'];	

	/* 받아온 num값을 선택해서 게시글 삭제 */
	mq("DELETE 
        FROM 
        tdrecord 
        WHERE 
        num='".$bno."'
		");
?>
	<script>
		alert("삭제되었습니다.");
	</script>
	<meta http-equiv="refresh" content="0 url=./tradingrecord.php">
