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

	// S3 객체 생성 후 경로 설정 및 버킷 정보 가져오기
	$s3 = new aws_s3;
	$s3path = "photos/";
	$bucket = $s3->bucket;

	$filepath_array = array();
	$folder = $_POST['folder']; // 사진이 들어가 있는 사진첩 제목
	if($_FILES) {
		if(count($_FILES['photoEdit']['name']) > 0 ) { 
			$baseDownFolder = "../image/";

			for($i = 0; $i < count($_FILES['photoEdit']['name']); $i++){
				// 실제 사진명 
				$real_filename = $_FILES['photoEdit']['name'][$i]; 

				// 사진 확장자 체크 
				$nameArr = explode(".", $real_filename);
				$extension = $nameArr[sizeof($nameArr) - 1]; 

				// 임시 사진명 (현재시간_랜덤수.파일 확장자) - 사진명 중복될 경우를 대비해 임시사진명을 덧붙여 저장하려함 
				$tmp_filename = time() . '_' . mt_rand(0,99999) . '.' . strtolower($extension); 
				
				if(!move_uploaded_file($_FILES["photoEdit"]["tmp_name"][$i], $baseDownFolder.$tmp_filename) ) {
					echo 'upload error';
				}

				// 파일 권한 변경 (생략가능_추후 변경할 수 있게 권한 변경함) 
                chmod($baseDownFolder.$tmp_filename, 0755);	
                
				// 사진 제목과 설명
				$num = $_POST['photo_no_edit'];
                $title = $_POST['title'][$i];
				$caption = $_POST['caption'][$i];
				
				// $exist = $s3->exist($bucket, $s3path.$folder.'/');
				// if(!$exist) {
				// 	$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$folder.'/');
				// }
				$sql = mq("SELECT 
						* 
						FROM
						photosave
						WHERE 
						num='".$num."'
					");
				$photo = $sql->fetch_array();
				$filepath = $photo['filepath'];
				$s3->delete($bucket, $filepath);
				$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$folder.'/'.$tmp_filename);

				// DB에 사진 제목, 날짜, 설명과 함께 S3 경로 업로드
				mq("UPDATE photosave SET
				filename_real = '".$real_filename."',
				filename_tmp = '".$tmp_filename."',
				filepath = '".$s3path.$folder.'/'.$tmp_filename."',
                title = '".$title."',
                caption = '".$caption."',
				folder = '".$folder."'
				WHERE num = '".$num."'
				");

				if(!unlink($baseDownFolder.$tmp_filename)) {
					echo "file delete failed.\n";
				}
			}			
		}

		if(count($_FILES['photos_multi']['name']) > 0 ) {
			$baseDownFolder = "../image/";

			for($i = 0; $i < count($_FILES['photos_multi']['name']); $i++){
				// 실제 사진명 
				$real_filename = $_FILES['photos_multi']['name'][$i]; 

				// 사진 확장자 체크 
				$nameArr = explode(".", $real_filename);
				$extension = $nameArr[sizeof($nameArr) - 1]; 

				// 임시 사진명 (현재시간_랜덤수.파일 확장자) - 사진명 중복될 경우를 대비해 임시사진명을 덧붙여 저장하려함 
				$tmp_filename = time() . '_' . mt_rand(0,99999) . '.' . strtolower($extension);
				
				if(!move_uploaded_file($_FILES["photos_multi"]["tmp_name"][$i], $baseDownFolder.$tmp_filename) ) {
					echo 'upload error';
				}

				// 파일 권한 변경 (생략가능_추후 변경할 수 있게 권한 변경함) 
                chmod($baseDownFolder.$tmp_filename, 0755);	
                
                // 사진 제목과 설명(여러 장 동시에 올린 것은 동일한 제목, 설명으로 들어가게 함)
                $title = $_POST['title_multi'];
				$caption = $_POST['caption_multi'];

				$exist = $s3->exist($bucket, $s3path.$folder.'/');
				if(!$exist) {
					$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$folder.'/');
				}
				$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$folder.'/'.$tmp_filename);

				// DB에 사진 제목, 날짜, 설명과 함께 S3 경로 업로드
				mq("INSERT photosave SET
				filename_real = '".$real_filename."',
				filename_tmp = '".$tmp_filename."',
				filepath = '".$s3path.$folder.'/'.$tmp_filename."',
                title = '".$title."',
                caption = '".$caption."',
				folder = '".$folder."'
				");

				if(!unlink($baseDownFolder.$tmp_filename)) {
					echo "file delete failed.\n";
				}
			}			
		}
	}	
?>
<form action="photos.php" method="post" name="move">
	<input type="hidden" name="folder" value="<?=$folder?>">
</form>
	<script>
		alert("사진 수정 완료");
		document.move.submit();
	</script>