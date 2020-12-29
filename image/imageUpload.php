<?php
include_once "../s3.php";
$s3 = new aws_s3;
$s3path = "board_images/";
$bucket = $s3->bucket;
$url = $s3->url;

if($_FILES["upload"]["size"] > 0) {
	$date_filedir = date("YmdHis");
	$ext = substr(strrchr($_FILES["upload"]["name"], "."), 1);
	$ext = strtolower($ext);
	$savefilename = $date_filedir."_".str_replace(" ", "_", $_FILES["upload"]["name"]);

	$uploadpath = $_SERVER['DOCUMENT_ROOT']."/image";
	$uploadsrc = $_SERVER['HTTP_HOST']."/image/";
	$http = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? 's' : '') . '://';

	$baseDownFolder = "../image/";

	// php 파일 업로드하는 부분
	if($ext=="jpg" or $ext=="gif" or $ext == "png"){
		if(move_uploaded_file($_FILES['upload']['tmp_name'], $uploadpath."/".iconv("UTF-8", "EUC-KR", $savefilename))) {
			$uploadfile = $savefilename;
			$s3->put($bucket, $baseDownFolder.$uploadfile, $s3path.$uploadfile);

			// echo '{"filename" : "'.$uploadfile.'", "uploaded" : 1, "url" : "'.$http.$uploadsrc.$uploadfile.'"}';
			echo '{"filename" : "'.$uploadfile.'", "uploaded" : 1, "url" : "'.$url.$s3path.$uploadfile.'"}';
		}

		if(!unlink($baseDownFolder.$savefilename)) {
			echo "file delete failed.\n";
		}
	}
}
?>