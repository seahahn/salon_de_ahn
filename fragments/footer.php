<?php
if(basename($_SERVER['PHP_SELF']) == "index.php"){
    include_once "db_con.php";
} else {
    include_once "../db_con.php";
}

$lockimg="※";
?>

<div class="container">
    <div class="d-flex flex-wrap">
        <!-- 최근 게시물 5개 / 최고 조회수 TOP5 게시물 -->
        <table class="table col-12 col-lg-6 col-md-12 col-sm-12 col-12-mobile mb-4">
            <thead>
                <tr>                        
                    <th scope="col" class="text-center text-white">댓글수 TOP5 게시물</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = mq("SELECT * FROM board WHERE rep_num>=1 AND wsecret=0 UNION SELECT * FROM board_ahn WHERE rep_num>=1 AND wsecret=0 ORDER BY rep_num DESC LIMIT 5");
            while($board = $sql->fetch_array()) {
                include "headpiece.php";
                $title=$board["title"];
                /* 글자수가 60이 넘으면 ... 처리해주기 */
                if(strlen($title)>50){
                    $title=str_replace($board["title"],mb_substr($board["title"],0,50,"utf-8")."...",$board["title"]);
                }
            ?>
                <tr><td>
                    <a class="text-white" href="../board/read.php?num=<?=$board['num']?>">[<?=$sub_ctgr.' - '.$headpiece?>] <?=$title?></a>
                </td></tr>
            <?php } ?>
            </tbody>
        </table>        
        <table class="table col-12 col-lg-6 col-md-12 col-sm-12 col-12-mobile mb-4">
            <thead>
                <tr>                       
                    <th scope="col" class="text-center text-white">조회수 TOP5 게시물</th>
                </tr>
            </thead>
            <tbody>
            
            <?php
            $sql2 = mq("SELECT * FROM board WHERE wsecret=0 UNION SELECT * FROM board_ahn WHERE wsecret=0 ORDER BY views DESC LIMIT 5");
            
            while($board = $sql2->fetch_array()) {
                include "headpiece.php";
                $title=$board["title"];
                /* 글자수가 60이 넘으면 ... 처리해주기 */
                if(strlen($title)>50){
                    $title=str_replace($board["title"],mb_substr($board["title"],0,50,"utf-8")."...",$board["title"]);
                }            
            ?>
                <tr><td>                
                    <a class="text-white" href="../board/read.php?num=<?=$board['num']?>">[<?=$sub_ctgr.' - '.$headpiece?>] <?=$title?></a>                    
                </td></tr>
            <?php } ?>
                            
            </tbody>
        </table>

        <div class="col-12">            

            <!-- Contact -->
                <section class="contact">
                    <header>
                        <h3>Contact</h3>
                    </header>                                        
                    <p>seah.ahn.nt@gmail.com</p>
                </section>

            <!-- Copyright -->
                <div class="copyright">
                    <ul class="menu">
                        <!-- <li><a href="#">Sitemap</a></li> -->
                        <li>&copy; Salon de Ahn. All rights reserved.</li>
                        <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                    </ul>
                </div>

        </div>

    </div>
    <?php include_once "../fragments/tbbtn.php" ?>
</div>

<!-- 비밀 글 모달창 양식 구현-->
<div class="modal fade modal-center" id="modal_div">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- header -->
            <div class="modal-header">                                
                <!-- header title -->
                <h4 class="modal-title"><b>비밀글입니다.</b></h4>
                <!-- 닫기(x) 버튼 -->
                <button type="button" class="close" data-dismiss="modal">X</button>
            </div>
            <!-- body -->
            <div class="modal-body">
                <p>작성자 또는 관리자만 조회 가능합니다.<br/><br/><input type="submit" class="btn-sm float-right" data-dismiss="modal" value="확인"></p>
            </div>
        </div>
    </div>
</div>
<!-- 비밀 글 모달창 구현 끝-->
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script>
    // 비밀글 클릭시 모달창을 띄우는 이벤트
    $(function(){
        $(".lock_check").click(function(){
            var user = $(this).attr("data-user");
            console.log(user);
            // 관리자 계정일 경우 바로 해당 글로 이동
            if($(this).attr("data-check")=="ADMIN") {
                var action_url = $(this).attr("data-action")+$(this).attr("data-num");
                $(location).attr("href", action_url);                            
            } else if(user == "<?=$useremail?>") {
                // 일반 사용자일 경우 사용자 이메일과 게시물 작성한 사용자의 이메일 대조하여 일치하면 해당 글로 이동
                var action_url = $(this).attr("data-action")+$(this).attr("data-num");
                $(location).attr("href", action_url);
            } else {
                $("#modal_div").modal();
            }
        });
    });
</script>
