<?php
	include "../util/config.php";
	include "../db_con.php";
	
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
                
                // 파일 제목과 설명
				$title = $_POST['title'][$i];
				$rcday = $_POST['rcday'][$i];
                $caption = $_POST['caption'][$i];

				mq("INSERT photofolder SET				
                title = '".$title."',
				rcday = '".$rcday."',
                caption = '".$caption."',
				thumb = '".$baseDownFolder.$tmp_filename."'
				");

                // $filepath_array[$i] = $baseDownFolder.$tmp_filename;                
			}			
		}
	}	
?>
	<script>
		alert("사진첩 등록 완료");
		location.href = 'test2.php';
	</script>