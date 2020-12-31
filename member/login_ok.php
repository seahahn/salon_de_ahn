<?php
    include_once "../db_con.php";

    $email = $_POST['email'];
    $password = $_POST['password'];        
        
    if(isset($_POST['rememberInfo']) && $_POST['rememberInfo'] == ('checked' || 'on')) {        
        $rememberInfo = $_POST['rememberInfo'];
        // echo '들어옴';

        setcookie("cookieemail", $email, time() + 86400 * 30);
        // setcookie("cookiepw", $password, time() + 86400 * 30);
        setcookie("rememberInfo", $rememberInfo, time() + 86400 * 30);
        
    } else if(!isset($_POST['rememberInfo']) || $_POST['rememberInfo'] == ''){  
        setcookie("cookieemail", "", time()-3600);
        // setcookie("cookiepw", "", time()-3600);
        setcookie("rememberInfo", "", time()-3600);

        // echo '설정 안됨';
    }    

    // $con = new mysqli("127.0.0.1", "root", "0121", "salon_de_ahn");
    $sql = "select * from user where email='$email'";

    // $result = mysqli_query($con, $sql);
    $result = mq($sql);

    $num_match = mysqli_num_rows($result);

    if(!$num_match){
        echo("
            <script>
            window.alert('등록되지 않은 이메일입니다.')
            history.go(-1)
            </script>
            ");
    } else {
        $row = mysqli_fetch_array($result);
        $db_password = $row['pw'];

        mysqli_close($con);

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
            $_SESSION["role"] = $row["role"];
            $_SESSION["num"] = $row["num"];
            echo("
                <script>
                location.href = '/index.php';
                </script>
                ");
        }
    }
?>