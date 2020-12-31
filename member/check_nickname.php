<?php
    include_once "../db_con.php";

    !empty($_POST['nickname']) ? $nickname = $_POST['nickname'] : $nickname = "";
    $ret['check'] = false;

    if($nickname != ""){
        $result = mq("SELECT * FROM user WHERE nickname = '".$nickname."'");
        $num = mysqli_num_rows($result);
        $user = mysqli_fetch_array($result);
        if($num==0){
            $ret['check'] = true;
        } else if($user['email'] == $_POST['email']) {
            $ret['etc'] = true;
        }
    }
    echo json_encode($ret);
?>