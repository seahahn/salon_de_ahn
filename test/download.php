<?php
// $target_Dir = $_SERVER['DOCUMENT_ROOT'].$_POST['filepath'];
// $file = $_POST['filename_tmp'];
// $name = $_POST['filename_real'];

$target_Dir = $_SERVER['DOCUMENT_ROOT'].$_GET['dir'];
$file = $_GET['file'];
$name = $_GET['name'];
$name = str_replace("_"," ", $name);

$down = $target_Dir.$file;
$filesize = filesize($down);
  
  if(file_exists($down)){
    header("Content-Type:application/octet-stream");
    header("Content-Type: application/x-zip-compressed; charset=utf-8" );        
    header("Content-Disposition:attachment;filename=$name");
    header("Content-Transfer-Encoding:binary");
    header("Content-Length:".filesize($target_Dir.$file));    
    header("Cache-Control:cache,must-revalidate");
    header("Pragma:no-cache");
    header("Expires:0");
    if(is_file($down)){
        $fp = fopen($down,"r");
        while(!feof($fp)){
          $buf = fread($fp,8096);
          $read = strlen($buf);
          print($buf);
          ob_clean();
          flush();
        }
        fclose($fp);
    }
  } else{
      ?>      
        <script>alert("존재하지 않는 파일입니다.")</script>
    
    <?php
  }?>