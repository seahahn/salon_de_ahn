<?php
// 이전 로그인에서 '이메일 저장하기' 체크했다면 쿠키에 저장된 정보를 불러옴
if(isset($_COOKIE['cookieemail'])){
    $cookieemail = $_COOKIE['cookieemail']; // 이메일 입력란에 넣을 값
    $rememberInfo = $_COOKIE['rememberInfo'];
    if($rememberInfo == 'on') $checked = 'checked'; // '이메일 저장하기' 좌측 체크박스에 체크함

} else {
    $cookieemail = '';
    $rememberInfo = '';
    $checked = '';
}    
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <?php include_once "../fragments/head.php"; ?>
    </head>
    <body>
        <div id="page-wrapper">
            <!-- Header -->
            <div class="mb-4" id="header">
                <?php include_once "../fragments/header.php"; ?>
            </div>

            <!-- 메인 영역-->
            <div class="container mt-5 mb-5">
                <div class="d-flex justify-content-center">
                    <fieldset class="col-12 col-lg-6 col-md-8 col-sm-12">
                        <form name="loginSbmt" id="loginSbmt" method="POST" action="login_ok.php">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" value="<?=$cookieemail?>">                                                                
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                            <div class="form-check d-flex align-content-center">
                                <input class="form-check-input align-self-center mt-0" type="checkbox" name="rememberInfo" id="rememberInfo" <?=$checked?>>
                                <label class="form-check-label" for="rememberInfo">
                                    이메일 저장하기
                                </label>
                            </div>
                            <br/>
                            <button name="loginBtn" class="col mb-3" type="button" accesskey="Enter" onclick="check_input()">Login</button>
                            <br/>
                            <div class="row">
                                <div class="col-2">
                                    <a href="register.php">Register</a>
                                </div>
                                <div class=col-1>
                                    <span class="border"></span>
                                </div>
                                <div class="col">
                                    <a href="findPw.php">Find Password</a>
                                </div>
                            </div>                        
                        </form>
                    </fieldset>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-4" id="footer">
                <?php include_once "../fragments/footer.php"; ?>
            </div>
        </div>

        <!-- Main Scripts -->
			<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/jquery.dropotron.min.js"></script>
			<script src="/assets/js/jquery.scrolly.min.js"></script>
			<script src="/assets/js/jquery.scrollex.min.js"></script>
			<script src="/assets/js/browser.min.js"></script>
			<script src="/assets/js/breakpoints.min.js"></script>
			<script src="/assets/js/util.js"></script>
			<script src="/assets/js/main.js"></script>
            <script src="login.js"></script>

        <!-- Other Stripts-->
            <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>			
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
    </body>
</html>