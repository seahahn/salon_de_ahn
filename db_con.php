<?php
    $db_id="ahn";
    $db_pw="SalonDeAhn930121!";
    $db_name="salon_de_ahn";
    $db_domain="salondeahn.me";
    
    $db=mysqli_connect($db_domain,$db_id,$db_pw,$db_name);

    function mq($sql){
        global $db;
        return $db->query($sql);
    }
?>
