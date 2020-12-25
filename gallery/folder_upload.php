<?php
	include_once "../util/config.php";
	include_once "../db_con.php";
	include_once "../s3.php";

	$s3 = new aws_s3;
	
	$filepath_array = array();
	if($_FILES) {
		if(count($_FILES['folders']['name']) > 0 ) { 
			$baseDownFolder = "../images/";

			for($i = 0; $i < count($_FILES['folders']['name']); $i++){
				// 실제 파일명 
				$real_filename = $_FILES['folders']['name'][$i]; 

				// 파일 확장자 체크 
				$nameArr = explode(".", $real_filename);
				$extension = $nameArr[sizeof($nameArr) - 1]; 

				// 임시 파일명 (현재시간_랜덤수.파일 확장자) - 파일명 중복될 경우를 대비해 임시파일명을 덧붙여 저장하려함 
				$tmp_filename = time() . '_' . mt_rand(0,99999) . '.' . strtolower($extension); 

				// 저장 파일명 (실제파일명@@@임시파일명) 
				// $thumbnail_file = $real_filename . '@@@' . $tmp_filename;
				
				if(!move_uploaded_file($_FILES["folders"]["tmp_name"][$i], $baseDownFolder.$tmp_filename) ) {
					echo 'upload error';
				}

				// 파일 권한 변경 (생략가능_추후 변경할 수 있게 권한 변경함) 
                chmod($baseDownFolder.$tmp_filename, 0755);
                
                // 사진첩 제목과 날짜, 설명
				$title = $_POST['title'][$i];
				$rcday = $_POST['rcday'][$i];
				$caption = $_POST['caption'][$i];
				
				// S3에 파일 업로드
				$s3path = "albumThumbnails/";				
				$bucket = $s3->bucket;

				$exist = $s3->exist($bucket, $s3path.$title.'/');
				if(!$exist) {
					$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$title.'/');
				}
				$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$title.'/'.$tmp_filename);

				// DB에 사진첩 제목, 날짜, 설명과 함께 S3 경로 업로드
				mq("INSERT photofolder SET				
                title = '".$title."',
				rcday = '".$rcday."',
                caption = '".$caption."',
				thumb = '".$s3path.$title.'/'.$tmp_filename."',
				bucket_folder = '".$s3path.$title.'/'."'
				");
			}			
		}
	}	
?>
	<script>
		alert("사진첩 등록 완료");
		location.href = 'albums.php';
	</script>