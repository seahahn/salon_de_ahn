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

            <!-- 메인 영역 -->
            <div class="container">                      
                <div class="d-flex justify-content-center">
                    <fieldset class="col-12 col-lg-6 col-md-8 col-sm-12">
                        <!-- 회원가입 입력 양식 -->
                        <form name="rgSbmt" id="rgSbmt" method="POST" action="./register_ok.php">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                                <span id="email_check_msg" data-check="0"></span>
                                <!-- 이메일 형식에 맞춰서 입력 완료하면 ajax 통해서 이메일 중복확인하여 email_check_msg의 텍스트를 변경함 -->
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password">                                
                            </div>
                            <div class="form-group">
                                <label for="pw_confirm">Password Confirm</label>
                                <input type="password" class="form-control" name="pw_confirm" id="pw_confirm">
                                <span id="pw_check_msg" data-check="0"></span>
                            </div>
                            <div class="form-check d-flex align-content-center">
                                <input class="form-check-input align-self-center mt-0" type="checkbox" name="infoAgree" id="infoAgree">
                                <label class="form-check-label" for="infoAgree">
                                    <a href="personalinfoagree.php" target="_blank">개인정보처리방침</a>에 동의합니다.
                                </label>
                            </div>
                            <div class="form-check d-flex align-content-center">
                                <input class="form-check-input align-self-center mt-0" type="checkbox" name="serviceAgree" id="serviceAgree">
                                <label class="form-check-label" for="serviceAgree">
                                    <a href="serviceagree.php" target="_blank">서비스 이용약관</a>에 동의합니다.
                                </label>
                            </div>
                            <br/>     
                            <div>
                            <button class="col mb-3" type="button" onclick="check_input()">Register</button>
                            </div>
                            <div>
                            <a href="./login.php"><button type="button">Go Back</button></a>                            
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
            <script src="register.js"></script> <!-- 회원가입 기능을 위한 스크립트-->

			<!-- Other Stripts-->
            <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>           
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
            <script src="/bootstrap/bootstrap.bundle.min.js"></script>
    </body>
</html>