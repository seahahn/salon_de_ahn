<?php
include "../util/config.php";
include_once "../db_con.php";
$email= $useremail;

mq("DELETE FROM user WHERE email = '$email'");

unset($_SESSION["useremail"]);
unset($_SESSION["usernickname"]);

echo "
    <script>
    alert('탈퇴가 완료되었습니다.');
    location.href = '../index.php';
    </script>";
?>