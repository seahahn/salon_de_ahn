<?php
    $db_id=$_ENV['DB_USERID'];
    $db_pw=$_ENV['DB_PW'];
    $db_name=$_ENV['DB_NAME'];
    $db_domain=$_ENV['DB_HOST'];

    $db=mysqli_connect($db_domain,$db_id,$db_pw,$db_name);

    function mq($sql){
        global $db;
        return $db->query($sql);
    }
?>
