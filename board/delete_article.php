<?php
	include_once "../util/config.php";
	include_once "../db_con.php";
	include_once "../s3.php";
	$s3 = new aws_s3;
	$s3path = "board_files/";
	$bucket = $s3->bucket;
	$url = $s3->url;
    
	$bno = $_GET['num'];
	$sql = mq("SELECT * FROM board WHERE num = '".$bno."'");
	$fetch = ($sql->fetch_array());	
	$category = $fetch['category'];
	$board_class = $fetch['board_class'];

	if($board_class == "private" && $role != "ADMIN"){
        echo '
        <script>
            alert("관리자만 작성 가능합니다.");
            history.go(-1);
		</script>';
		return;
    }

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
<?php
	if($board_class == "private"){
?>
	<meta http-equiv="refresh" content="0 url=../board_ahn/board_list.php?ctgr=<?=$category?>">
<?php
	} else {
?>
	<meta http-equiv="refresh" content="0 url=./board_list.php?ctgr=<?=$category?>">
<?php
	}
?>