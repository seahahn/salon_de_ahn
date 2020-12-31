<?php
include "../util/config.php";
include_once "../db_con.php";
$email= $useremail;
$nickname = $_POST['nickname'];
if(!empty($_POST['password'])){
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
}


if(isset($password)){
    mq("UPDATE user set                
    pw = '$password',
    nickname = '$nickname'
    WHERE email = '$email'
    ");
} else {
    mq("UPDATE user set                    
    nickname = '$nickname'
    WHERE email = '$email'
    ");
}

$_SESSION["useremail"] = $email;
$_SESSION["usernickname"] = $nickname;

echo "
    <script>
    alert('정보 수정이 완료되었습니다.');
    location.href = '../index.php';
    </script>";
    
?>