<?php
	include "../util/config.php";
	include "../db_con.php";

	$bno = $_POST['num']; // $bno(hidden)에 num값을 받아와 넣음	    
	$category = $_POST['category']; // 게시물 수정 시 카테고리 선택한 것 받아옴
	$sub_ctgr = $_POST['sub_ctgr'];
	$headpiece = $_POST['headpiece'];	
	
	
    /* wsecret 값이 1이면 잠금 0이면 공개 */
	if(isset($_POST['wsecret'])){
		$wsecret = '1';
	}else{
		$wsecret = '0';
	}

	// 첨부파일이 존재한다면 실행

	$filepath_array = array();
	// if(strpos($_FILES['files']['type'], 'image') != 0){ // 이미지를 제외한 파일 형식만 별도 첨부 가능
	if(isset($_FILES['upload'])){
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

				mq("INSERT filesave SET
				filename_real = '".$real_filename."',
				filename_tmp = '".$tmp_filename."',
				filepath = '".$baseDownFolder.$tmp_filename."'
				");

				$filepath_array[$i] = $baseDownFolder.$tmp_filename;
			}			
		}
	}
	// }

	if(isset($_POST['old_files'])) {
		$old_filepath_array = $_POST['old_files'];
		// print_r($old_filepath_array) ;

		$filepath_array_result = $old_filepath_array + $filepath_array;
		// print_r($filepath_array_result);
	} else {
		$filepath_array_result = $filepath_array;
		// print_r($filepath_array_result);
	}

	$filepath_array_str = serialize($filepath_array_result);
	// echo $filepath_array_str;

	/* 받아온 num값을 선택해서 게시글 수정 */
	mq("UPDATE 
			board 
        SET 
			category = '".$category."',
			sub_ctgr = '".$sub_ctgr."',
			headpiece = '".$headpiece."',
            title='".$_POST['title']."',
			content='".$_POST['content']."',            
            wsecret = '".$wsecret."',
			att_file = '".$filepath_array_str."'
        WHERE 
			num='".$bno."'
	");
?>
	<script>
		alert("수정되었습니다.");
		location.href = '/board/read.php?num=<?=$bno?>';
	</script>
	<!-- <meta http-equiv="refresh" content="0 url=./read.php?num=<?=$bno?>"> -->