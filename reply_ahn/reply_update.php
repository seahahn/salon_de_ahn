<?php
	include_once "../util/config.php";
    include_once "../db_con.php";
    
    $num = $_POST['rno']; // 댓글 고유 번호 통해서 내용 수정
	// $date = date('Y-m-d H:i:s');	
	$sql = mq("UPDATE
					reply_ahn
                SET
					content = '".$_POST['rep_con']."'					
                WHERE
                    num='".$num."'
			");
?>