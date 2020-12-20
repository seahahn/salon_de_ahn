<?php
	include_once "../util/config.php";
	include_once "../db_con.php";	
	
	// $max_in_num_result = mq("SELECT MAX(in_num) FROM reply");
	// $max_in_num_fetch = mysqli_fetch_row($max_in_num_result);
	// if($max_in_num_fetch[0]%1000 != 0){
	// 	$max_in_num = ceil($max_in_num_fetch[0]/1000)*1000;
	// } else {
	// 	$max_in_num = ceil($max_in_num_fetch[0]/1000)*1000+1000;
	// }	
	
	// $unum = $_POST['unum'];
	$bno = $_POST['bno'];
	// $rno = $_POST['rno'];
	// $date = date('Y-m-d H:i:s');

	// $query = mq("SELECT * FROM reply");
	// $exists = (mysqli_num_rows($query));
	
	// if($exists == 0) {
	// 	mq("ALTER TABLE reply AUTO_INCREMENT = 1"); // 게시판에 게시물 없는 경우 auto_increment 값 초기화
	// }	

	// if(isset($_POST['in_num'])) {	
	// 	$in_num = $_POST['in_num'];
	// 	if($in_num % 1000 == 0){
	// 		$ceil_of_in_num = ceil(($in_num+1)/1000)*1000;			
	// 	} else {
	// 		$ceil_of_in_num = ceil($in_num/1000)*1000;			
	// 	}

	// 	$max_in_num_in_reply_result = mq("SELECT MAX(in_num) FROM reply WHERE con_num=$bno AND in_num < $ceil_of_in_num");
	// 	$max_in_num_in_reply_fetch = mysqli_fetch_row($max_in_num_in_reply_result);			
	// 	$max_in_num_in_reply = $max_in_num_in_reply_fetch[0];
		
	// 	$ans_in_num = $max_in_num_in_reply + 1;
		
	// 	// $ans_in_num = $in_num;
	// 	$depth = $_POST['depth'];
	// 	if($depth == 0) {
	// 		$ans_depth = $depth + 1;
	// 	} 
	// 	// else if($depth > 7) {
	// 	// 	$ans_depth = $depth;
	// 	// }
	// 	else {
	// 		$ans_depth = $depth;
	// 	}
		mq("INSERT test SET
		email = '".$bno."',
        a = '".$bno."',
        b = '".$bno."',
        c = '".$bno."'
		");
	// } else {
	// 	mq("INSERT reply SET
	// 	in_num = '".$max_in_num."',
	// 	unum = '".$unum."',
	// 	con_num = '".$bno."',
	// 	email = '".$_POST['dat_mail']."',								
	// 	writer = '".$_POST['dat_user']."',
	// 	wdate ='".$date."',
	// 	content = '".$_POST['rep_con']."'
	// 	");

	// 	echo '<script>console.log("'.$max_in_num.' '.$unum.' '.$bno.' '.$_POST['dat_mail'].' '.$_POST['dat_user'].' '.$date.' '.$_POST['rep_con'].'");</script>';
	// }
?>