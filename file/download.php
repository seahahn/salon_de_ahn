<?php
include_once "../s3.php";
$s3 = new aws_s3;
$bucket = $s3->bucket;
$url = $s3->url;

$filepath = $_GET['dir'];
$file = $_GET['file'];
$name = $_GET['name'];
$name = str_replace("_"," ", $name);

$s3->download($bucket, $filepath, $file); // S3로부터 파일 받아서 임시로 file 폴더에 저장함

$down = '../file/'.$file;
$filesize = filesize($down);
  
  if(file_exists($down)){
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/x-zip-compressed; charset=utf-8" );
    header("Content-Disposition:attachment;filename=$name");
    header("Content-Transfer-Encoding:binary");
    header("Content-Length:".filesize($down));
    header("Cache-Control:cache,must-revalidate");
    header("Pragma:no-cache");
    header("Expires:0");
    if(is_file($down)){
        $fp = fopen($down,"r");
        while(!feof($fp)){
          $buf = fread($fp,8096);
          $read = strlen($buf);
          print($buf);
          flush();
        }
        fclose($fp);
    }

    if(!unlink($down)) {
      echo "file delete failed.\n";
    }
  } else{
      ?>      
        <script>alert("존재하지 않는 파일입니다.")</script>
    <?php
  }?>