<?php
	include "../db_con.php";
	include_once "../s3.php";
	$s3 = new aws_s3;
	$s3path = "files/";
	$bucket = $s3->bucket;
	$url = $s3->url;
    
	$bno = $_GET['num'];
	$sql = mq("SELECT in_num, depth, category FROM board WHERE num = '".$bno."'");
	$fetch = ($sql->fetch_array());	
	$category = $fetch['category'];

	$sql = mq("SELECT att_file FROM board WHERE num='".$bno."'");
	while($row = mysqli_fetch_assoc($sql)){
		$filepath_array = unserialize($row['att_file']);
	}                                                        
	
	for($i=0; $i<count($filepath_array);$i++){
		$filename_result = mq("SELECT * FROM filesave WHERE filepath='".$filepath_array[$i]."'");                                                            
		$filename_fetch = mysqli_fetch_array($filename_result);
		$filepath = $filename_fetch['filepath'];

		$s3->delete($bucket, $filepath);
	}

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
