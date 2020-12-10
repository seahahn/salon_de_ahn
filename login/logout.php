<?php
    session_start();
    unset($_SESSION["useremail"]);
    unset($_SESSION["usernickname"]);
    echo("
        <script>
            // alert('로그아웃 되었습니다.');
            location.href = '/index.php'
        </script>")
?>