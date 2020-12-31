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

            <!-- 메인 영역-->
            <div class="container py-5 my-5">
                <div class="row">
                    <div class="col-3"></div>
                    <fieldset class="col" style="width:250px;">                        
                        <form name="findPw" id="findPw" method="POST" action="./send_mail.php">
                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp">
                                <small id="emailHelp" class="form-text text-muted">입력하신 이메일로 임시 비밀번호를 전송합니다.</small>
                                <span id="email_check_msg" data-check="0"></span>
                            </div>                            
                            <br/>
                            <button class="col mb-3" type="button" onclick="check_input()">임시 비밀번호 전송</button>
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

            <!-- 이메일 입력 여부 검증 스크립트 -->
            <script>
                /* 필수 입력 채우지 않았을 경우 경고창 띄우기*/
                function check_input() {
                    if(!$("#email").val()){
                        alert("이메일 주소를 입력해주세요.");
                        $("#email").focus();
                        return;
                    } else if($("#email_check_msg").attr("data-check") == 0){
                        alert("가입하신 이메일 주소를 입력해주세요.");
                        $("#email").focus();
                        return;
                    }
                    document.findPw.submit();
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

                /* 이메일 가입 여부 체크(비동기통신)*/
                function checkEmailAjax(){
                    $.ajax({
                        url : "./check_email.php",
                        type : "POST",
                        dataType : "JSON",
                        data : {
                            "email" : $("#email").val()
                        },
                        success : function(data){
                            if(data.check){
                                $("#email_check_msg").html("가입되지 않은 이메일입니다.").css("color", "red").attr("data-check", "0");
                            } else {
                                $("#email_check_msg").html("가입된 이메일입니다.").css("color", "blue").attr("data-check", "1");                                
                            }
                        }
                    });
                }                
            </script>
            

    </body>
</html>