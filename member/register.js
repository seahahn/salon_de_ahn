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

    if(!$("#password").val() != $("#pw_confirm").val()){
        alert("비밀번호가 일치하지 않습니다.\n다시 입력해주세요.");
        $("#password").focus();
        $("#password").select();
        return;
    }

    document.rgSbmt.submit();
}

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
            checkEmailAjax();
        }
    });
});

/* 이메일 중복 체크(비동기통신)*/
function checkEmailAjax(){
    $.ajax({
        url : "check_email.php",
        type : "POST",
        dataType : "json",
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