<?php
    include_once "../db_con.php";

    $email = $_POST['email'];
    $password = $_POST['password'];
        
    if(isset($_POST['rememberInfo']) && $_POST['rememberInfo'] == ('checked' || 'on')) {
        // '이메일 저장하기' 체크한 경우 쿠키 생성
        $rememberInfo = $_POST['rememberInfo'];
        setcookie("cookieemail", $email, time() + 86400 * 30); // 쿠키에 이메일 입력값 저장
        setcookie("rememberInfo", $rememberInfo, time() + 86400 * 30); // 쿠키에 체크박스 체크 여부 저장
        
    } else if(!isset($_POST['rememberInfo']) || $_POST['rememberInfo'] == ''){
        setcookie("cookieemail", "", time()-3600);
        setcookie("rememberInfo", "", time()-3600);
    }    

    $sql = "SELECT * FROM user WHERE email='".$email."'";
    $result = mq($sql);

    $num_match = mysqli_num_rows($result);

    if(!$num_match){
        echo("
            <script>
            window.alert('등록되지 않은 이메일입니다.');
            history.go(-1);
            </script>
            ");
    } else {
        $row = mysqli_fetch_array($result);
        $db_password = $row['pw'];

        if(!password_verify($password, $db_password)){
            echo("
                <script>
                window.alert('비밀번호가 틀립니다.');
                history.go(-1);
                </script>
                ");
        } else {
            session_start();
            $_SESSION["useremail"] = $row["email"];
            $_SESSION["usernickname"] = $row["nickname"];
            $_SESSION["role"] = $row["role"]; // 관리자 / 일반 사용자 역할 구분
            $_SESSION["num"] = $row["num"]; // DB상에 저장된 사용자의 고유 번호
            echo("
                <script>
                location.href = '/index.php';
                </script>
                ");
        }
    }
?>