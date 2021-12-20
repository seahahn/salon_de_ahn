<?php
    // $db_id="ahn";
    // $db_pw="SalonDeAhn930121!";
    // $db_name="salon_de_ahn";
    // $db_domain="salondeahn.me";

    $db_id="h48k3s6czvuv4kkw";
    $db_pw="rpx7h5svuakegvy3";
    $db_name="tc8q2rjfpkbo9wlc";
    $db_domain="dcrhg4kh56j13bnu.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
    
    $db=mysqli_connect($db_domain,$db_id,$db_pw,$db_name);

    function mq($sql){
        global $db;
        return $db->query($sql);
    }
?>
