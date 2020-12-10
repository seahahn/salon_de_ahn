<?php
$db_con = mysqli_connect("salondeahn.me", "root", "SalonDeAhn930121!", "salon_de_ahn");
if ($db_con){
  echo "DB 연결 성공<p>";
} else {
  echo "DB 연결 실패<p>";
}
?>
