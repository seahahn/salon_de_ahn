<?php
    !empty($_POST['email']) ? $email = $_POST['email'] : $email = "";
    $ret['check'] = false;
    if($email != ""){
        // $con = new mysqli("127.0.0.1", "root", "0121", "salon_de_ahn");
        $result = mq("SELECT email FROM user WHERE email = '".$email."'");
        // $result = mysqli_query($con, $sql);
        $num = mysqli_num_rows($result);

        if($num==0){
            $ret['check'] = true;
        }
    }
    echo json_encode($ret);
?>