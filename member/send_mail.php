<?php
include_once "../db_con.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../PHPMailer/src/PHPMailer.php";
require "../PHPMailer/src/SMTP.php";
require "../PHPMailer/src/Exception.php";

$email = $_POST['email']; // 사용자가 입력한 본인의 이메일
$rdnum = generateRandomString(12); // 무작위 12자리 임시 비밀번호 생성
$password = password_hash($rdnum, PASSWORD_DEFAULT); // 임시 비밀번호 암호화
mq("UPDATE user SET pw = '$password' WHERE email = '".$email."'");

$getNickname  = mq("SELECT nickname FROM user WHERE email = '".$email."'"); // 받는사람 닉네임
$row = $getNickname->fetch_row();
$nickname = (string)$row[0];

$mail = new PHPMailer(true);

try {

    // 서버세팅
    $mail -> SMTPDebug = 2;    // 디버깅 설정
    $mail -> isSMTP();        // SMTP 사용 설정

    $mail -> Host = "smtp.gmail.com";                // email 보낼때 사용할 서버를 지정
    $mail -> SMTPAuth = true;                        // SMTP 인증을 사용함
    $mail -> Username = "salon.de.ahn.noreply@gmail.com";    // 메일 계정
    $mail -> Password = "qylxiytlblwogflu";                // 메일 비밀번호
    $mail -> SMTPSecure = "ssl";                    // SSL을 사용함
    $mail -> Port = 465;                            // email 보낼때 사용할 포트를 지정
    $mail -> CharSet = "utf-8";                        // 문자셋 인코딩

    // 보내는 메일
    $mail -> setFrom("salon.de.ahn.noreply@gmail.com", "no-reply");

    // 받는 메일    
    $mail -> addAddress("$email", "$nickname");
    
    // 첨부파일
    // $mail -> addAttachment("./test.zip");

    // 메일 내용
    $mail -> isHTML(true);                                               // HTML 태그 사용 여부
    $mail -> Subject = "Salon de Ahn - $nickname 님의 임시 비밀번호입니다";              // 메일 제목
    $mail -> Body = "안녕하세요 $nickname 님.<br/>요청하신 임시 비밀번호입니다.<br/>$rdnum<br/><br/>임시 비밀번호로 로그인 후, 비밀번호를 꼭 변경해주세요.";    // 메일 내용

    // Gmail로 메일을 발송하기 위해서는 CA인증이 필요하다.
    // CA 인증을 받지 못한 경우에는 아래 설정하여 인증체크를 해지하여야 한다.
    $mail -> SMTPOptions = array(
        "ssl" => array(
              "verify_peer" => false
            , "verify_peer_name" => false
            , "allow_self_signed" => true
        )
    );
    
    // 메일 전송
    $mail -> send();
    
    echo "
    <script>
    alert('임시 비밀번호가 발송되었습니다.');
    location.href = 'login.php';
    </script>";

} catch (Exception $e) {
    // echo "Message could not be sent. Mailer Error : ", $mail -> ErrorInfo;
}

function generateRandomString($length) {
    // 임시 비밀번호 생성하는 함수
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $charactersLength = strlen($characters); 
    $randomString = ''; 
    for ($i = 0; $i < $length; $i++) { 
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)]; 
    } 
    return $randomString; 
}



?>