<?php
    include_once "../db_con.php";

    !empty($_POST['email']) ? $email = $_POST['email'] : $email = "";
    $ret['check'] = false;
    
    if($email != ""){        
        $result = mq("SELECT email FROM user WHERE email = '".$email."'");        
        $num = mysqli_num_rows($result);
        if($num==0){
            $ret['check'] = true;
        }
    }
    echo json_encode($ret);
?>