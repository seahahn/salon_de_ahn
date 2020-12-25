<?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";

  $s3 = new aws_s3;
  $bucket = $s3->bucket;

  foreach($_POST['del_rec'] as $rec_num) {
    $sql = mq("SELECT 
        * 
        FROM
        langrecord
        WHERE 
        num='".$rec_num."'
    ");
  $rec = $sql->fetch_array();
  $filepath = $rec['filepath'];
  $s3->delete($bucket, $filepath);

  $sql2 = mq("DELETE FROM
                    langrecord
                    WHERE
                    num='".$rec_num."'
            ");
  }
?>
<script>
    alert("녹음 파일이 삭제 되었습니다.");
    location.href = 'langstudyrecord.php';
</script>