<?php
	include_once "../util/config.php";
	include_once "../db_con.php";
	include_once "../s3.php";
	$s3 = new aws_s3;
	$s3path = "videos/";
	$bucket = $s3->bucket;
	$url = $s3->url;

	if($role != 'ADMIN') {
		echo '
			<script>
				alert("관리자만 작성 가능합니다.");
				history.go(-1);
			</script>';
	}

	$title = $_POST['title'];
	$pjcode = $_POST['pjcode'];
	$caption = $_POST['caption'];
	$content = $_POST['content'];
		
	$query = mq("SELECT * FROM pj");
	$exists = (mysqli_num_rows($query));
	
	if($exists == 0)	{
		mq("ALTER TABLE pj AUTO_INCREMENT = 1"); // 게시판에 게시물 없는 경우 auto_increment 값 초기화
	}	

	// 첨부파일이 존재한다면 실행
	$filepath_array = array();	
	if($_FILES) {
		if(count($_FILES['video']['name']) > 0 ) { 
			$baseDownFolder = "../video/";

			for($i = 0; $i < count($_FILES['video']['name']); $i++){
				// 실제 파일명 
				$real_filename = $_FILES['video']['name'][$i]; 

				// 파일 확장자 체크 
				$nameArr = explode(".", $real_filename);
				$extension = $nameArr[sizeof($nameArr) - 1];

				// 임시 파일명 (현재시간_랜덤수.파일 확장자) - 파일명 중복될 경우를 대비해 임시파일명을 덧붙여 저장하려함 
				$tmp_filename = time() . '_' . mt_rand(0,99999) . '.' . strtolower($extension); 

				// 저장 파일명 (실제파일명@@@임시파일명) 
				// $thumbnail_file = $real_filename . '@@@' . $tmp_filename;

				if(!move_uploaded_file($_FILES["video"]["tmp_name"][$i], $baseDownFolder.$tmp_filename) ) {
					echo 'upload error';
				}

				// 파일 권한 변경 (생략가능_추후 변경할 수 있게 권한 변경함) 
				chmod($baseDownFolder.$tmp_filename, 0755);	

				$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$tmp_filename);

				// mq("INSERT filesave SET
				// filename_real = '".$real_filename."',
				// filename_tmp = '".$tmp_filename."',
				// filepath = '".$s3path.$tmp_filename."'
				// ");

				$filepath_array[$i] = $s3path.$tmp_filename;

				if(!unlink($baseDownFolder.$tmp_filename)) {
					echo "file delete failed.\n";
				}
			}			
		}
	}

	$videopath = $s3path.$tmp_filename;

	// 첨부파일 경로를 담은 배열을 직렬화하여 문자열 형태로 바꿈. 그리고 해당 게시물 첨부파일 경로 테이블에 넣음
	$filepath_array_str = serialize($filepath_array);
	
	// DB 저장
	$mq = mq("INSERT pj SET	
	pjcode = '".$pjcode."',
	title = '".$title."',
	caption = '".$caption."', 
	content = '".$content."',
	videopath = '".$videopath."'	
	");				
	
	
?>
	<script>
		alert("글이 작성되었습니다.");
		location.href = 'it_dev_portfolio.php';
	</script>