<?php
    include "../db_con.php";
    
	$bno = $_GET['num'];
	$sql = mq("SELECT in_num, depth, category FROM board WHERE num = $bno");
	$fetch = ($sql->fetch_array());	
	$category = $fetch['category'];

	/* 받아온 num값을 선택해서 게시글 삭제 */
	mq("DELETE 
        FROM 
        board 
        WHERE 
        num='".$bno."'
		");
?>
	<script>
		alert("삭제되었습니다.");
	</script>
	<meta http-equiv="refresh" content="0 url=./board_list.php?ctgr=<?=$category?>">
