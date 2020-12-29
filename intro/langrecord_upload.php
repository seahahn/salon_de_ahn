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

	$filepath_array = array();		
	
	if($_FILES) {
		echo '<script>console.log("작동확인");</script>';
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
					case '영어' :
						$lang_key = 'en';
						break;
					case '중국어' :
						$lang_key = 'cn';
						break;
					case '러시아어' :
						$lang_key = 'ru';
						break;
					case '독일어' :
						$lang_key = 'ge';
						break;
				}
				$ctgr = $_POST['ctgr'][$i];
                $title = $_POST['title'][$i];
				$date = $_POST['date'][$i];				
				
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
				$ctgr = $_POST['ctgrs'];
                $title = $_POST['titles'];
				$date = $_POST['dates'];

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
			}			
		}
	}	
?>
<script>
	alert("녹음 파일 업로드 완료");
	location.href = 'langstudyrecord.php';
</script>