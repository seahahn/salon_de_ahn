<?php
	include_once "../util/config.php";
	include_once "../db_con.php";
  include_once "../s3.php";

  if($role != 'ADMIN') {
    echo '
        <script>
            alert("관리자만 작성 가능합니다.");
            history.go(-1);
        </script>';
  }
    
  // 사진첩 고유 번호로 해당 사진첩 DB 정보를 가져옴
	$album_no = $_POST['album_no_del'];
	$sql = mq("SELECT 
					* 
			    FROM
					photofolder 
			    WHERE 
					num='".$album_no."'
			");
  $album = $sql->fetch_array();
  
  // 사진첩 고유 번호로 해당 사진첩 안에 담긴 사진들의 DB 정보를 가져옴
  $sql2 = mq("SELECT 
					* 
			    FROM
					photosave 
			    WHERE 
					folder='".$album['title_key']."'
      ");
  $photos = $sql2->fetch_array();
	
	if($role == "ADMIN") {
    // AWS S3에 저장된 파일을 삭제하기 위해서 S3 객체 생성 및 버킷 정보 가져옴
    $s3 = new aws_s3;
    $bucket = $s3->bucket;

    $filepath = $album['thumb']; // 사진첩 썸네일 이미지 경로
    $folderpath = $album['bucket_folder']; // 사진첩 썸네일 이미지를 저장한 S3 경로
    $pt_folderpath = 'photos/';
    
    while($photos = $sql2->fetch_array()) {
      $s3->delete($bucket, $photos['filepath']); // 사진첩 내의 사진이 저장된 경로를 이용하여 S3에 저장된 사진들을 삭제함
    }
    $s3->delete($bucket, $pt_folderpath.$photos['folder'].'/'); // 사진 저장헀던 폴더도 삭제함

    $s3->delete($bucket, $filepath); // 사진첩 썸네일 이미지를 삭제한 후
    $s3->delete($bucket, $folderpath); // 사진첩 썸네일 이미지를 저장했던 폴더도 삭제함
            
    $sql2 = mq("DELETE FROM
            photosave
            WHERE
            folder='".$album['title_key']."'
            ");
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