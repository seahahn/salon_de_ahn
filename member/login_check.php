<!-- 로그인 여부 체크 -->
<?php 
	if(!$useremail && !$username) { // PHP 오류 표시 설정해두면 여기서 에러 표시됨. 오류 끄면 이상 없음
		echo("
			<script>
			alert('로그인 후 이용해 주세요!');
			location.href='/member/login.php';			
			</script>
			");
	}
?>