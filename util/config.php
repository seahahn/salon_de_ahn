<!-- 세션 관리 -->
<?php
	session_start();
	if (isset($_SESSION["useremail"])) {
		$useremail = $_SESSION["useremail"];
	}else{
		$useremail = "";
	}if (isset($_SESSION["usernickname"])){
		$usernickname = $_SESSION["usernickname"];
	}else{
		$usernickname = "";
	}if (isset($_SESSION["role"])){ // 사용자, 관리자 구분 용도
		$role = $_SESSION["role"];
	}else{
		$role = "";
	}if (isset($_SESSION["num"])){ // 사용자, 관리자 구분 용도
		$usernum = $_SESSION["num"];
	}else{
		$usernum = "";
	}
?>