<?php
	include_once "../util/config.php";
	include_once "../db_con.php";
	include_once "../s3.php";
	$s3 = new aws_s3;
	$s3path = "files/";
	$bucket = $s3->bucket;
	$url = $s3->url;
	
	$max_in_num_result = mq("SELECT MAX(in_num) FROM board");
	$max_in_num_fetch = mysqli_fetch_row($max_in_num_result);
	$max_in_num = ceil($max_in_num_fetch[0]/1000)*1000+1000;

	$category = $_POST['category'];
	$sub_ctgr = $_POST['sub_ctgr'];
	$headpiece = $_POST['headpiece'];
	// $board_class = $_POST['board_class'];

	$unum = $_POST['unum'];
	$email = $useremail;
	$nickname = $usernickname;
	$date = date('Y-m-d H:i:s');	
	$title = $_POST['title'];
	$content = $_POST['content'];
	/* wsecret 값이 1이면 잠금 0이면 공개 */
	if(isset($_POST['wsecret'])){
		$wsecret = '1';
	}else{
		$wsecret = '0';
	}	
	
	$query = mq("SELECT * FROM board");
	$exists = (mysqli_num_rows($query));
	
	if($exists == 0)	{
		mq("ALTER TABLE board AUTO_INCREMENT = 1"); // 게시판에 게시물 없는 경우 auto_increment 값 초기화
	}	

	// 첨부파일이 존재한다면 실행
	$filepath_array = array();
	// print_r($_FILES['files']['type']);
	// print_r(strpos($_FILES['files']['type'], "image"));
	// if(strpos($_FILES['file']['type'], 'image') != 0){ // 이미지를 제외한 파일 형식만 별도 첨부 가능
	if($_FILES) {
		if(count($_FILES['upload']['name']) > 0 ) { 
			$baseDownFolder = "../file/";

			for($i = 0; $i < count($_FILES['upload']['name']); $i++){
				// 실제 파일명 
				$real_filename = $_FILES['upload']['name'][$i]; 

				// 파일 확장자 체크 
				$nameArr = explode(".", $real_filename);
				$extension = $nameArr[sizeof($nameArr) - 1]; 

				// 임시 파일명 (현재시간_랜덤수.파일 확장자) - 파일명 중복될 경우를 대비해 임시파일명을 덧붙여 저장하려함 
				$tmp_filename = time() . '_' . mt_rand(0,99999) . '.' . strtolower($extension); 

				// 저장 파일명 (실제파일명@@@임시파일명) 
				// $thumbnail_file = $real_filename . '@@@' . $tmp_filename;

				if(!move_uploaded_file($_FILES["upload"]["tmp_name"][$i], $baseDownFolder.$tmp_filename) ) {
					echo 'upload error';
				}

				// 파일 권한 변경 (생략가능_추후 변경할 수 있게 권한 변경함) 
				chmod($baseDownFolder.$tmp_filename, 0755);	

				$s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$tmp_filename);

				mq("INSERT filesave SET
				filename_real = '".$real_filename."',
				filename_tmp = '".$tmp_filename."',
				filepath = '".$s3path.$tmp_filename."'
				");

				$filepath_array[$i] = $s3path.$tmp_filename;

				if(!unlink($baseDownFolder.$tmp_filename)) {
					echo "file delete failed.\n";
				}
			}			
		}
	}

	// 첨부파일 경로를 담은 배열을 직렬화하여 문자열 형태로 바꿈. 그리고 해당 게시물 첨부파일 경로 테이블에 넣음
	$filepath_array_str = serialize($filepath_array);	
	
	// DB 저장
	if(isset($_POST['in_num'])) { //답글인 경우
		$in_num = $_POST['in_num'];
		// $ans_in_num = $in_num - 1;
		$ans_in_num = $in_num - 1;
		$depth = $_POST['depth'];
		$ans_depth = $depth + 1;
		mq("INSERT board SET
		in_num = '".$ans_in_num."',
		unum = '".$unum."',
		depth = '".$ans_depth."',
		category = '".$category."',
		sub_ctgr = '".$sub_ctgr."',
		headpiece = '".$headpiece."',
		email = '".$email."',						
		title = '".$title."', 
		writer = '".$nickname."', 
		wdate ='".$date."',
		content = '".$content."',  		
		wsecret = '".$wsecret."',
		att_file = '".$filepath_array_str."'		
		");
	} else { // 일반적인 글 작성인 경우
		$mq = mq("INSERT board SET
		in_num = '".$max_in_num."',
		unum = '".$unum."',
		category = '".$category."',
		sub_ctgr = '".$sub_ctgr."',
		headpiece = '".$headpiece."',
		email = '".$email."',						
		title = '".$title."', 
		writer = '".$nickname."', 
		wdate ='".$date."',
		content = '".$content."',  		
		wsecret = '".$wsecret."',
		att_file = '".$filepath_array_str."'		
		");				
	}
	
?>
	<script>
		alert("글이 작성되었습니다.");
		location.href = 'board_list.php?ctgr=<?=$category?>';
	</script>