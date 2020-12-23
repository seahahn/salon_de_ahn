<?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";

  $s3 = new aws_s3;
  $bucket = $s3->bucket;

  $folder = $_POST['folder'];
  foreach($_POST['del_photo'] as $photo_num) {
    $sql = mq("SELECT 
        * 
        FROM
        photosave
        WHERE 
        num='".$photo_num."'
    ");
  $photo = $sql->fetch_array();
  $filepath = $photo['filepath'];
  $s3->delete($bucket, $filepath);

  $sql2 = mq("DELETE FROM
                    photosave
                    WHERE
                    num='".$photo_num."'
            ");
  }
?>
<form action="photos.php" method="post" name="move">
	<input type="hidden" name="folder" value="<?=$folder?>">
</form>
<script>
    alert("사진이 삭제 되었습니다.");
    document.move.submit();
</script>