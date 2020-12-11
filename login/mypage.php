<?php
include_once "../util/config.php";
include_once "../db_con.php";
$email= $useremail;
$nickname;

foreach (mq("SELECT nickname FROM user WHERE email = '$email'") as $field){    
    $nickname = $field['nickname'];
}
?>

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
                    <nav class="mt-sm-4 navbar navbar-expand-lg navbar-light bg-light flex-fill p-0 d-flex justify-content-center">
                        <!-- <a class="col navbar-brand" href="#">카테고리 목록</a> -->
                        <button class="col-3 navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                            <ul class="col-auto navbar-nav mt-2 mt-lg-0">                                
                                <li class="nav-item">                                    
                                    <a class="nav-link px-4 mx-4" href="/board/board_list.php?ctgr=<?=$useremail?>&unum=<?=$usernum?>">내가 쓴 게시물</a>
                                </li>
                                <li class="nav-item">
                                    <input type="hidden" name="useremail" value="<?=$useremail?>"/>
                                    <input type="hidden" name="usernum" value="<?=$usernum?>"/>
                                    <a class="nav-link px-4 mx-4" href="/board/reply_list.php?ctgr=<?=$useremail?>&unum=<?=$usernum?>">내가 쓴 댓글</a>
                                </li>
                                <li class="nav-item">
                                    <form name="deleteSbmt" id="deleteSbmt" action="./delete_ok.php"><a class="nav-link px-4 mx-4" href="javascript:;" onclick="deleteUser();">회원 탈퇴</a></form>
                                </li>
                            </ul>                            
                            <form class="col d-flex justify-content-end" action="../board/search_result.php" method="get">
                                <select class="custom-select col-auto" name="search_category" style="display: inline-block; width: 18%;">
                                    <option value="title">제목</option>
                                    <option value="writer">글쓴이</option>
                                    <option value="content">내용</option>
                                </select>
                                <input class="form-control mr-sm-2 col-auto" placeholder="Search" type="search" name="search" size="50" required="required" style="display: inline-block; width: 30%;">
                                <button type="submit" class="btn-sm col-auto">검색</button>
                            </form>
                            
                            <!-- <form class="form-inline my-2 my-lg-0">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search">
                                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                            </form> -->
                        </div>
                    </nav>                    
                </div>
                <br/>

                <div class="row">
                    <div class="col-3"></div>
                    <fieldset class="col" style="width:250px;">
                        <!-- 회원 정보 수정 입력 양식 -->
                        <form name="infoSbmt" id="infoSbmt" method="POST" action="./edit_ok.php" edit-call="0">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <p><?=$email?></p>                                
                            </div>
                            <div class="form-group">
                                <label for="Nickname">Nickname</label>
                                <input type="text" class="form-control" name="nickname" id="nickname" value="<?=$nickname?>">
                                <span id="nickname_check_msg" data-check="0"></span>
                            </div>
                            <div class="form-group">
                                <label for="password" class="edit_call">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="비밀번호를 변경하시려면 입력해주세요.">
                                <small id="emailHelp" class="form-text text-muted"></small>
                            </div>
                            <div class="form-group">
                                <label for="pw_confirm" class="edit_call">Password Confirm</label>
                                <input type="password" class="form-control" name="pw_confirm" id="pw_confirm" placeholder="비밀번호를 변경하시려면 입력해주세요.">
                                <span id="pw_check_msg" data-check="0"></span>
                            </div>                            
                            <div>                                
                                <button class="col-auto" type="button" onclick="check_input()">정보 수정</button>                                
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

        
            <script>
            /* 필수 입력 채우지 않았을 경우 경고창 띄우기*/
            function check_input() {
                // if(!$("#password").val()){
                //     alert("비밀번호를 입력해주세요.");
                //     $("#password").focus();
                //     return;
                // }

                // if(!$("#pw_confirm").val()){
                //     alert("비밀번호 확인을 입력해주세요.");
                //     $("#pw_confirm").focus();
                //     return;
                // }

                if($("#password").val() != $("#pw_confirm").val()){
                    alert("비밀번호가 일치하지 않습니다.\n다시 입력해주세요.");
                    $("#password").focus();
                    $("#password").select();
                    return;
                }

                document.infoSbmt.submit();
            }

            /* 닉네임 입력 여부 검증 */
            $(function(){
                $("#nickname").blur(function(){                    
                    if($(this).val()==""){
                        $("#nickname_check_msg").html("닉네임을 입력해주세요.").css("color", "red").attr("data-check", "0");                                                
                    } else {
                        checkEmailAjax();
                    }
                });
            });

        /* 비밀번호 입력 및 일치 여부 검증 */
            // $(function(){
            //     $("#pw_confirm").blur(function(){
            //         if($("#password").val()==""){
            //             $("#pw_check_msg").html("비밀번호를 입력해주세요.").css("color", "red").attr("data-check", "0");
            //             $("#password").focus();
            //         } else if($(this).val()==""){            
            //             $("#pw_check_msg").html("비밀번호 확인을 입력해주세요.").css("color", "red").attr("data-check", "0");
            //             $(this).focus();            
            //         } else if($(this).val() != $("#password").val()){
            //             $("#pw_check_msg").html("비밀번호가 일치하지 않습니다.").css("color", "red").attr("data-check", "0");
            //         } else {    
            //             $("#pw_check_msg").html("비밀번호가 일치합니다.").css("color", "blue").attr("data-check", "1");
            //         }
            //     });
            // });

        /* 닉네임 중복 체크(비동기통신)*/
            function checkEmailAjax(){
                $.ajax({
                    url : "./check_nickname.php",
                    type : "POST",
                    dataType : "json",
                    data : {
                        "nickname" : $("#nickname").val()
                    },
                    success : function(data){
                        if(data.check){
                            $("#nickname_check_msg").html("사용 가능한 닉네임입니다.").css("color", "blue").attr("data-check", "1");            
                        } else {
                            $("#nickname_check_msg").html("중복된 닉네임입니다.").css("color", "red").attr("data-check", "0");
                            $("#nickname").focus();
                        }
                    }
                });
            }

        /* 회원 탈퇴 기능*/
            function deleteUser(){
                var dUser = confirm("회원 탈퇴를 진행합니다.\n계속하시겠어요?")
                if(dUser == true){                    
                    document.deleteSbmt.submit();
                } else if(dUser == false){                    

                }
            }
            </script>

    </body>
</html>