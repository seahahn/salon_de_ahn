<?php
	include_once "../util/config.php";
	include_once "../db_con.php";
	
	foreach($_POST['reply'] as $reply_num) {
		$sql = mq("SELECT 
			* 
			FROM
			reply
			WHERE 
			num='".$reply_num."'
		");

		$reply = $sql->fetch_array();

		$sql2 = mq("SELECT 
				* 
				FROM 
				board
				WHERE 
				num='".$reply['con_num']."'
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
							num='".$reply_num."'
					");

			$rep_count = $board['rep_num']-1; // 기존에 게시물에 달린 댓글 수에 1을 뺀 값을 넣어줌
			mq("UPDATE board SET rep_num='".$rep_count."' WHERE num='".$board['num']."'");

		}else if(($reply['email'] == 'deleted') && ($role=="ADMIN")){
			$sql3 = mq("DELETE FROM
						reply
						WHERE
						num = '".$reply_num."'
				");

			$sql4 = mq("DELETE FROM
						reply
						WHERE
						num='".$reply_num."'
						");
		}
	}
?>
<script>
	alert("선택하신 댓글이 삭제 되었습니다.");					
</script>
<meta http-equiv="refresh" content="0 url=../board/reply_list.php?ctgr=<?=$useremail?>&unum=<?=$usernum?>">