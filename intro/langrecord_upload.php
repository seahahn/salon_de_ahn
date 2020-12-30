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
	$s3path = "audios/";
	$bucket = $s3->bucket;

	$query = mq("SELECT * FROM langrecord");
	$exists = (mysqli_num_rows($query));
	
	if($exists == 0)	{
		mq("ALTER TABLE langrecord AUTO_INCREMENT = 1"); // 게시판에 게시물 없는 경우 auto_increment 값 초기화
	}

	$filepath_array = array();		
	
	if($_FILES) {
		if(count($_FILES['record']['name']) > 0 ) { 
			$baseDownFolder = "../audios/";

			for($i = 0; $i < count($_FILES['record']['name']); $i++){
				// 실제 녹음 파일명 
				$real_filename = $_FILES['record']['name'][$i];

				// 녹음 파일 확장자 체크 
				$nameArr = explode(".", $real_filename);
				$extension = $nameArr[sizeof($nameArr) - 1];

				// 임시 녹음 파일명 (현재시간_랜덤수.파일 확장자) - 녹음 파일명 중복될 경우를 대비해 임시 녹음 파일명을 덧붙여 저장하려함 
				$tmp_filename = time() . '_' . mt_rand(0,99999) . '.' . strtolower($extension); 
				
				if(!move_uploaded_file($_FILES["record"]["tmp_name"][$i], $baseDownFolder.$tmp_filename) ) {
					echo 'upload error';
				}

				// 파일 권한 변경 (생략가능_추후 변경할 수 있게 권한 변경함) 
                chmod($baseDownFolder.$tmp_filename, 0755);	
                
				// 녹음 파일 언어 분류, 기록 분류, 기록명과 기록일
				$lang = $_POST['lang'][$i];
				switch ($lang) {
					case 'English' :
						$lang_key = 'en';
						break;
					case 'Chinese' :
						$lang_key = 'cn';
						break;
					case 'Russian' :
						$lang_key = 'ru';
						break;
					case 'German' :
						$lang_key = 'ge';
						break;
				}
				$ctgr = $_POST['ctgr'][$i];
				if($_POST['title'][$i] != '') {
					$title = $_POST['title'][$i];
				} else {
					$real_filename = pathinfo($real_filename, PATHINFO_FILENAME); // 확장자 제외한 파일명만 기록명으로 씀
					$title = $real_filename;
				}
				if($_POST['date'][$i] != '') {
					$date = $_POST['date'][$i];	
				} else {
					$date = substr($real_filename, 0, 9);
				}
				
				// $exist = $s3->exist($bucket, $s3path.$lang.'/'.$ctgr.'/');
				// if(!$exist) {
				// 	$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$lang.'/'.$ctgr.'/');
				// }
				$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$lang_key.'/'.$tmp_filename);

				// DB에 녹음 파일 제목, 날짜, 설명과 함께 S3 경로 업로드
				mq("INSERT langrecord SET
				lang = '".$lang."',
				lang_key = '".$lang_key."',
				ctgr = '".$ctgr."',
                title = '".$title."',
				wdate = '".$date."',
				filename_tmp = '".$tmp_filename."',
				filepath = '".$s3path.$lang_key.'/'.$tmp_filename."'
				");

				if(!unlink($baseDownFolder.$tmp_filename)) {
					echo "file delete failed.\n";
				}
			}			
		}

		if(count($_FILES['records']['name']) > 0 ) {
			$baseDownFolder = "../audios/";

			for($i = 0; $i < count($_FILES['records']['name']); $i++){
				// 실제 녹음 파일명 
				$real_filename = $_FILES['records']['name'][$i]; 

				// 녹음 파일 확장자 체크 
				$nameArr = explode(".", $real_filename);
				$extension = $nameArr[sizeof($nameArr) - 1]; 

				// 임시 녹음 파일명 (현재시간_랜덤수.파일 확장자) - 녹음 파일명 중복될 경우를 대비해 임시사진명을 덧붙여 저장하려함 
				$tmp_filename = time() . '_' . mt_rand(0,99999) . '.' . strtolower($extension);
				
				if(!move_uploaded_file($_FILES["records"]["tmp_name"][$i], $baseDownFolder.$tmp_filename) ) {
					echo 'upload error';
				}

				// 파일 권한 변경 (생략가능_추후 변경할 수 있게 권한 변경함) 
                chmod($baseDownFolder.$tmp_filename, 0755);	
                
                // 녹음 파일 언어 분류, 기록 분류, 기록명과 기록일
				$lang = $_POST['langs'];
				switch ($lang) {
					case 'English' :
						$lang_key = 'en';
						break;
					case 'Chinese' :
						$lang_key = 'cn';
						break;
					case 'Russian' :
						$lang_key = 'ru';
						break;
					case 'German' :
						$lang_key = 'ge';
						break;
				}
				$ctgr = $_POST['ctgrs'];
				if($_POST['titles'] != '') { 
					$title = $_POST['titles']; 
				} else {
					$real_filename = pathinfo($real_filename, PATHINFO_FILENAME); // 확장자 제외한 파일명만 기록명으로 씀
					$title = $real_filename;
				}
				if($_POST['dates'] != '') {
					$date = $_POST['dates'];
				} else {
					$date = substr($real_filename, 0, 9);
				}

				// $exist = $s3->exist($bucket, $s3path.$lang.'/'.$ctgr.'/');
				// if(!$exist) {
				// 	$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$lang.'/'.$ctgr.'/');
				// }
				$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$lang_key.'/'.$tmp_filename);

				// DB에 녹음 파일 제목, 날짜, 설명과 함께 S3 경로 업로드
				mq("INSERT langrecord SET
				lang = '".$lang."',
				lang_key = '".$lang_key."',
				ctgr = '".$ctgr."',
                title = '".$title."',                
				wdate = '".$date."',
				filename_tmp = '".$tmp_filename."',
				filepath = '".$s3path.$lang_key.'/'.$tmp_filename."'
				");

				if(!unlink($baseDownFolder.$tmp_filename)) {
					echo "file delete failed.\n";
				}
			}			
		}
	}	
?>
<script>
	alert("녹음 파일 업로드 완료");
	location.href = 'langstudyrecord.php';
</script>