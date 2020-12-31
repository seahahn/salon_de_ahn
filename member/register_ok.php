<?php
include_once "../db_con.php";

$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$mq = mq("INSERT user set
                email = '".$email."',
                pw = '".$password."',
                nickname = '".$email."'
                ");

echo "
    <script>
    alert('회원가입이 완료되었습니다.');
    location.href = 'login.php';
    </script>";
?>
