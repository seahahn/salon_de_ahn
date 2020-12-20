<!DOCTYPE html>
<html lang="ko">
    <head>
        <?php include_once "../fragments/head.php"; ?>             
    </head>
    <body class="right-sidebar is-preload">
        <div id="page-wrapper">
            <!-- Header -->
            <div class="mb-4" id="header">
                <?php include_once "../fragments/header.php"; ?>
            </div>

            <div class="container">                      
                <div class="row">
                    <div class="col-3"></div>
                    <fieldset class="col" style="width:250px;">
                        <!-- 회원가입 입력 양식 -->
                        <form name="rgSbmt" id="rgSbmt" method="POST" action="./register_ok.php">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                                <!-- <button type="button" class="btn-sm" onclick="checkEmailAjax()">중복 확인</button> -->
                                <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                <span id="email_check_msg" data-check="0"></span>
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
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="infoAgree">
                                <label class="form-check-label" for="infoAgree">
                                    <a href="#">개인정보처리방침</a>에 동의합니다.
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="serviceAgree">
                                <label class="form-check-label" for="serviceAgree">
                                    <a href="#">서비스 이용약관</a>에 동의합니다.
                                </label>
                            </div>
                            <br/>     
                            <div>
                            <button class=col type="button" onclick="check_input()">Register</button>
                            </div>
                            <p></p>
                            <div>
                            <a href="./login.php"><button type="button">Go Back</button></a>                            
                            </div>                                                   
                        </form>
                    </fieldset>
                    <div class="col-3"></div>
                </div>
            </div>
            
            <!-- Footer -->
				<div class="mt-4" id="footer">
                    <?php include_once "../fragments/footer.php"; ?>
				</div>
        </div>

        <!-- Scripts -->
			<script src="/assets/js/jquery.min.js"></script>
			<script src="/assets/js/jquery.dropotron.min.js"></script>
			<script src="/assets/js/jquery.scrolly.min.js"></script>
			<script src="/assets/js/jquery.scrollex.min.js"></script>
			<script src="/assets/js/browser.min.js"></script>
			<script src="/assets/js/breakpoints.min.js"></script>
			<script src="/assets/js/util.js"></script>
			<script src="/assets/js/main.js"></script>
            <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>           
            

			<!-- Bootstrap Stripts-->
			<!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
            <script src="/bootstrap/bootstrap.bundle.min.js"></script>

            <!-- 회원가입 기능을 위한 스크립트-->
            <script>
            /* 필수 입력 채우지 않았을 경우 경고창 띄우기*/
            function check_input() {
                if(!$("#email").val()){
                    alert("이메일 주소를 입력해주세요.");
                    $("#email").focus();
                    return;
                }

                if(!$("#password").val()){
                    alert("비밀번호를 입력해주세요.");
                    $("#password").focus();
                    return;
                }

                if(!$("#pw_confirm").val()){
                    alert("비밀번호 확인을 입력해주세요.");
                    $("#pw_confirm").focus();
                    return;
                }

                if($("#password").val() != $("#pw_confirm").val()){
                    alert("비밀번호가 일치하지 않습니다.\n다시 입력해주세요.");
                    $("#password").focus();
                    $("#password").select();
                    return;
                }

                document.rgSbmt.submit();
            }

            /* 이메일 입력 여부 및 형식 검증 */
            $(function(){
                $("#email").blur(function(){
                    var regEmail = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i; // 이메일 형식 검증식
                    if($(this).val()==""){
                        $("#email_check_msg").html("이메일을 입력해주세요.").css("color", "red").attr("data-check", "0");
                        $(this).focus();
                    } else if(!regEmail.test(($(this)).val())){
                        $("#email_check_msg").html("올바른 이메일 주소가 아닙니다.").css("color", "red").attr("data-check", "0");
                    } else {
                        checkEmailAjax();
                    }
                });
            });

            /* 비밀번호 입력 및 일치 여부 검증 */
            $(function(){
                $("#pw_confirm").blur(function(){        
                    if($("#password").val()==""){
                        $("#pw_check_msg").html("비밀번호를 입력해주세요.").css("color", "red").attr("data-check", "0");
                        $("#password").focus();
                    } else if($(this).val()==""){            
                        $("#pw_check_msg").html("비밀번호 확인을 입력해주세요.").css("color", "red").attr("data-check", "0");
                        $(this).focus();            
                    } else if($(this).val() != $("#password").val()){
                        $("#pw_check_msg").html("비밀번호가 일치하지 않습니다.").css("color", "red").attr("data-check", "0");
                    } else {    
                        $("#pw_check_msg").html("비밀번호가 일치합니다.").css("color", "blue").attr("data-check", "1");
                    }
                });
            });

            /* 이메일 중복 체크(비동기통신)*/
            function checkEmailAjax(){
                $.ajax({
                    url : "./check_email.php",
                    type : "POST",                    
                    data : {
                        "email" : $("#email").val()
                    },
                    success : function(data){
                        if(data.check){
                            $("#email_check_msg").html("사용 가능한 이메일입니다.").css("color", "blue").attr("data-check", "1");            
                        } else {
                            $("#email_check_msg").html("중복된 이메일입니다.").css("color", "red").attr("data-check", "0");
                            $("#email").focus();
                        }
                    }
                });
            }
            </script>

    </body>
</html>