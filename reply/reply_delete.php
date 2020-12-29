<?php
	include_once "../util/config.php";
    include_once "../db_con.php";
	
	// hidden의 값 r_no(댓글 고유번호)를 받아와 그 값에 해당하는 num 에 대한 reply 테이블 정보 가져오기
	$rno = $_POST['r_no'];
	// $role = $_SESSION['role'];
	$sql = mq("SELECT 
					* 
			   FROM 
					reply 
			   WHERE 
					num='".$rno."'
			");
	$reply = $sql->fetch_array();
	
	// hidden의 값 b_no를 받아와 그 값에 해당하는 num 에 대한 board 정보 가져오기
	$bno = $_POST['b_no'];
	$sql2 = mq("SELECT 
					* 
                    FROM 
					board 
                    WHERE 
					num='".$bno."'
			");
	$board = $sql2->fetch_array();
	
	
	/* 세션값과 db의 email을 비교  */
	if((($useremail == $reply['email']) || ($role=="ADMIN")) && ($reply['email'] != 'deleted')) {
		// 테이블 reply에서 인덱스값이 $rno인 값을 찾아 삭제
		$content_backup = $reply['content'];
		$content = '삭제된 댓글입니다.';
		$sql3 = mq("UPDATE
						reply
					SET
						writer = '',
						email = 'deleted',
						content = '".$content."',
						content_backup = '".$reply['email'].$reply['writer'].$content_backup."'						
					WHERE
						num='".$rno."'
				");

		$rep_count = $board['rep_num']-1; // 기존에 게시물에 달린 댓글 수에 1을 뺀 값을 넣어줌
		mq("UPDATE board SET rep_num='".$rep_count."' WHERE num='".$board["num"]."'");
?>
				<script>
					alert("댓글이 삭제 되었습니다.");					
				</script>
				<meta http-equiv="refresh" content="0 url=../board/read.php?num=<?=$bno?>">
	
			<?php 
		}else if(($reply['email'] == 'deleted') && ($role=="ADMIN")){
			$sql3 = mq("DELETE FROM
						reply
						WHERE
						num = '".$rno."'
				");
			?>
				<script>						
					alert("댓글이 삭제 되었습니다.");					
				</script>					
				<meta http-equiv='refresh' content='0 url=../board/read.php?num=<?=$bno?>'>						
			<?php
		} else {
			?>
				<script>
					alert('본인의 댓글이 아닙니다');
					history.back();
				</script>
	<?php } ?>	