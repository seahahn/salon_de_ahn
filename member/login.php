<?php
if(isset($_COOKIE['cookieemail'])){
    $cookieemail = $_COOKIE['cookieemail'];    
    $rememberInfo = $_COOKIE['rememberInfo'];
    if($rememberInfo == 'on') $checked = 'checked';

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
    <body class="right-sidebar is-preload">
        <div id="page-wrapper">
            <!-- Header -->
            <div class="mb-4" id="header">
                <?php include_once "../fragments/header.php"; ?>
            </div>

            <!-- 메인 영역-->
            <div class="container mt-5 mb-5">
                <div class="row">
                    <div class="col-3"></div>
                    <fieldset class="col" style="width:250px;">
                        <!-- <legend>login</legend> -->
                        <form name="loginSbmt" id="loginSbmt" method="POST" action="login_ok.php">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <?php echo '<span><?=$useremail?></span>'; ?>
                                <input type="email" name="email" class="form-control" id="InputEmail" value="<?=$cookieemail?>">                                                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1">
                            </div>

                            <!-- <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="rememberInfo" id="rememberInfo" <?=$checked?>>
                                <label class="custom-control-label" for="rememberInfo">Remember me !</label>
                            </div> -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="rememberInfo" id="rememberInfo" <?=$checked?>>
                                <label class="form-check-label" for="rememberInfo">
                                    아이디 저장하기
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
            <script src="login.js"></script>            

			<!-- Bootstrap Stripts-->
			<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
            <script src="/bootstrap/bootstrap.bundle.min.js"></script>          
            

    </body>
</html>