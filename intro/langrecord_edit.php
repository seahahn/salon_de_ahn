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

$rec_num = $_POST['edit_num'];

$lang = $_POST['lang_input'];
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
$ctgr = $_POST['ctgr_input'];
$title = $_POST['title_input'];
$date = $_POST['date_input'];

$s3 = new aws_s3;
$s3path = "audios/";
$bucket = $s3->bucket;
  
$sql = mq("SELECT 
    * 
    FROM
    langrecord
    WHERE 
    num='".$rec_num."'
");
$rec = $sql->fetch_array();
$tmp_filename = $rec['filename_tmp'];
$filepath = $rec['filepath'];
// S3 버킷 내의 파일 이동 기능이 없으므로, 기존 위치 파일 삭제 후 새로운 위치에 복사함
$s3->copy($bucket, $s3path.$lang_key.'/'.$tmp_filename, $filepath);
$s3->delete($bucket, $filepath);
// $s3->put($bucket, $baseDownFolder.$tmp_filename, $s3path.$lang.'/'.$ctgr.'/'.$tmp_filename);

$sql2 = mq("UPDATE 
                langrecord
                SET
                lang = '".$lang."',
                lang_key = '".$lang_key."',
                ctgr = '".$ctgr."',
                title = '".$title."',
                wdate = '".$date."'
                WHERE
                num='".$rec_num."'
        ");
?>
<script>
    alert("녹음 파일이 수정되었습니다.");
    location.href = 'langstudyrecord.php';
</script>