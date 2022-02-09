<?php
    // $db_id="ahn";
    // $db_pw="SalonDeAhn930121!";
    // $db_name="salon_de_ahn";
    // $db_domain="salondeahn.me"; $_SERVER['DB_USERID']

    $db_id=$_SERVER['DB_USERID'];
    $db_pw=$_SERVER['DB_PW'];
    $db_name=$_SERVER['DB_NAME'];
    $db_domain=$_SERVER['DB_HOST'];
    
    $db=mysqli_connect($db_domain,$db_id,$db_pw,$db_name);

    function mq($sql){
        global $db;
        return $db->query($sql);
    }
?>
