function check_input() {
    // 로그인 창에서 Login 버튼 클릭 시 작동시킬 기능
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

    document.loginSbmt.submit();
}