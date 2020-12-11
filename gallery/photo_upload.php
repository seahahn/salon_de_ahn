<?php
	include "../util/config.php";
	include "../db_con.php";
	
	// $query = mq("SELECT * FROM photosave");
    // $exists = (mysqli_num_rows($query));
    // print_r($query);
	
	// if($exists == 0)	{
	// 	mq("ALTER TABLE photosave AUTO_INCREMENT = 1"); // 게시판에 게시물 없는 경우 auto_increment 값 초기화
	// }	

	// 첨부파일이 존재한다면 실행
	$filepath_array = array();
	// print_r($_FILES['files']['type']);
	// print_r(strpos($_FILES['files']['type'], "image"));
	// if(strpos($_FILES['file']['type'], 'image') != 0){ // 이미지를 제외한 파일 형식만 별도 첨부 가능
	if($_FILES) {
		if(count($_FILES['photos']['name']) > 0 ) { 
			$baseDownFolder = "../images/";

			for($i = 0; $i < count($_FILES['photos']['name']); $i++){
				// 실제 파일명 
				$real_filename = $_FILES['photos']['name'][$i]; 

				// 파일 확장자 체크 
				$nameArr = explode(".", $real_filename);
				$extension = $nameArr[sizeof($nameArr) - 1]; 

				// 임시 파일명 (현재시간_랜덤수.파일 확장자) - 파일명 중복될 경우를 대비해 임시파일명을 덧붙여 저장하려함 
				$tmp_filename = time() . '_' . mt_rand(0,99999) . '.' . strtolower($extension); 

				// 저장 파일명 (실제파일명@@@임시파일명) 
				// $thumbnail_file = $real_filename . '@@@' . $tmp_filename;

				if(!move_uploaded_file($_FILES["photos"]["tmp_name"][$i], $baseDownFolder.$tmp_filename) ) {
					echo 'upload error';
				}

				// 파일 권한 변경 (생략가능_추후 변경할 수 있게 권한 변경함) 
                chmod($baseDownFolder.$tmp_filename, 0755);	
                
                // 파일 제목과 설명
                $title = $_POST['title'][$i];
                $caption = $_POST['caption'][$i];

				mq("INSERT photosave SET
				filename_real = '".$real_filename."',
				filename_tmp = '".$tmp_filename."',
				filepath = '".$baseDownFolder.$tmp_filename."',
                title = '".$title."',
                caption = '".$caption."'
				");

                // $filepath_array[$i] = $baseDownFolder.$tmp_filename;                
			}			
		}
	}	
?>
	<script>
		alert("사진 업로드 완료");
		location.href = 'gallery.php';
	</script>