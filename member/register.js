/* 필수 입력 채우지 않았을 경우 경고창 띄우기*/
function check_input() {
    // 회원가입(register.php)에서 사용되는 함수
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

    if(!$("#infoAgree").prop("checked")){
        alert("개인정보처리방침에 동의해주세요.");                    
        return;
    }

    if(!$("#serviceAgree").prop("checked")){
        alert("서비스 이용약관에 동의해주세요.");
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
        dataType : "JSON",
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