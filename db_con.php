<?php
    $db_id=getenv('DB_USERID');
    $db_pw=getenv('DB_PW');
    $db_name=getenv('DB_NAME');
    $db_domain=getenv('DB_HOST');

    $db=mysqli_connect($db_domain,$db_id,$db_pw,$db_name);

    function mq($sql){
        global $db;
        return $db->query($sql);
    }
?>
