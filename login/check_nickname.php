<?php
    include_once "../db_con.php";

    !empty($_POST['nickname']) ? $nickname = $_POST['nickname'] : $nickname = "";
    $ret['check'] = false;

    if($nickname != ""){
        $result = mq("SELECT nickname FROM user WHERE nickname = '".$nickname."'");
        $num = mysqli_num_rows($result);
        if($num==0){
            $ret['check'] = true;
        }
    }
    echo json_encode($ret);
?>