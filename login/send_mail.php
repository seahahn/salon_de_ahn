<!-- <?php
include_once "../db_con.php";

$email = $_POST['email'];

$rdnum = generateRandomString(12);
$password = password_hash($rdnum, PASSWORD_DEFAULT);

// 보내는사람 이름
$nameFrom  = "Salon de Ahn";    

// 여기의 이메일은 발송하는 서버에 기본 셋팅된 도메인이나 이메일주소가 들어가지 않으면 발송되지 않는 경우가 생길 수 있음
// 보내는 사람의 이메일
$mailFrom = "salon.de.ahn.noreply@gmail.com";

// 받는사람 닉네임
$nameTo  = mq("SELECT nickname FROM user WHERE email = '$email'");

// 받는사람 이메일
$mailTo = $email;

// 메일의 제목
$subject = "Salon de Ahn - 회원님의 임시 비밀번호입니다";

// 메일의 내용부분 입니다 html 형식으로 작성 하시면 됩니다.
$content = '<html><head><title></title></head><body><p>안녕하세요 <?=$nameTo?>님.<br/>요청하신 임시 비밀번호입니다.<br/><?=$rdnum?><br/><br/>임시 비밀번호로 로그인 후, 비밀번호를 꼭 변경해주세요.</p></body></html>';

// 인코딩셋, 한글이 포함된 컨텐츠는 웬만하면 UTF-8
$charset = "UTF-8";

// 위에서 설정한 값을 실제 셋팅하는 부분
// $nameFrom   = "=?$charset?B?".base64_encode($nameFrom)."?=";
// $nameTo   = "=?$charset?B?".base64_encode($nameTo)."?=";
// $subject = "=?$charset?B?".base64_encode($subject)."?=";
$header  = "Content-Type: text/html; charset=utf-8\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Return-Path: <". $mailFrom .">\r\n";
$header .= "From: ". $nameFrom ." <". $mailFrom .">\r\n";
$header .= "Reply-To: <". $mailFrom .">\r\n";

// php의 메일 발송 함수 mail()

mail($mailTo, $subject, $content, $header);

echo "
    <script>
    alert('임시 비밀번호가 발송되었습니다.');
    location.href = 'login.php';
    </script>";

function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
    $charactersLength = strlen($characters); 
    $randomString = ''; 
    for ($i = 0; $i < $length; $i++) { 
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)]; 
    } 
    return $randomString; 
}


    
?> -->


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
mq("UPDATE user SET pw = '$password' WHERE email = '$email'");

$getNickname  = mq("SELECT nickname FROM user WHERE email = '$email'"); // 받는사람 닉네임
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
    $mail -> Password = "Dltnstls7!";                // 메일 비밀번호
    $mail -> SMTPSecure = "ssl";                    // SSL을 사용함
    $mail -> Port = 465;                            // email 보낼때 사용할 포트를 지정
    $mail -> CharSet = "utf-8";                        // 문자셋 인코딩

    // 보내는 메일
    $mail -> setFrom("salon.de.ahn.noreply@gmail.com", "no-reply");

    // 받는 메일    
    $mail -> addAddress("$email", "receive01");
    
    // 첨부파일
    // $mail -> addAttachment("./test.zip");

    // 메일 내용
    $mail -> isHTML(true);                                               // HTML 태그 사용 여부
    //$mail -> Subject = "Salon de Ahn - <?=$nameTo 님의 임시 비밀번호입니다";              // 메일 제목
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
    echo "Message could not be sent. Mailer Error : ", $mail -> ErrorInfo;
}
?>