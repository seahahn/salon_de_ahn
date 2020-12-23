<?php
	include_once "../util/config.php";
	include_once "../db_con.php";
  include_once "../s3.php";
    
    // hidden의 값 r_no(댓글 고유번호)를 받아와 그 값에 해당하는 num 에 대한 reply 테이블 정보 가져오기
	$album_no = $_POST['album_no'];
	$sql = mq("SELECT 
					* 
			    FROM
					photofolder 
			    WHERE 
					num='".$album_no."'
			");
	$album = $sql->fetch_array();
	
	if($role == "ADMIN") {
        // 테이블 photofolder에서 인덱스값이 $album_no인 값을 찾아 삭제
        
        // $s3path = "albumThumbnails/";
        $s3 = new aws_s3;
        $bucket = $s3->bucket;
        $filepath = $album['thumb'];
        $folderpath = $album['bucket_folder'];

        $s3->delete($bucket, $filepath);
        $s3->delete($bucket, $folderpath);
                
		$sql = mq("DELETE FROM
                        photofolder
                        WHERE
                        num='".$album_no."'
                ");
    }
?>
<script>
    alert("사진첩이 삭제 되었습니다.");
</script>
<meta http-equiv="refresh" content="0 url=./albums.php">