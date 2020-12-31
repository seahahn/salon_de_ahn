function check_input() {
    if (!document.loginSbmt.email.value){
        alert("이메일을 입력해주세요.");
        document.loginSbmt.email.focus();
        return;
    }

    if (!document.loginSbmt.password.value){
        alert("비밀번호를 입력해주세요.");
        document.loginSbmt.password.focus();
        return;
    }

    // var rememberInfo = document.getElementById('rememberInfo');
    // $(rememberInfo).prop("checked");

    document.loginSbmt.submit();
}

