<?php
include_once "../db_con.php";

$rec_num = $_POST['num'];

$sql = mq("SELECT 
    * 
    FROM
    langrecord
    WHERE 
    num='".$rec_num."'
");
$rec = $sql->fetch_array();

$ret['lang'] = $rec['lang'];
$ret['ctgr'] = $rec['ctgr'];
$ret['title'] = $rec['title'];
$ret['date'] = $rec['wdate'];

echo json_encode($ret);
?>