<?php
    !empty($_POST['nickname']) ? $nickname = $_POST['nickname'] : $nickname = "";
    $ret['check'] = false;
    if($nickname != ""){
        $con = new mysqli("127.0.0.1", "root", "0121", "salon_de_ahn");
        $sql = "select nickname from user where nickname = '{$nickname}'";
        $result = mysqli_query($con, $sql);
        $num = mysqli_num_rows($result);

        if($num==0){
            $ret['check'] = true;
        }
    }
    echo json_encode($ret);
?>