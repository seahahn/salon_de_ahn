<?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";
$s3 = new aws_s3;
$url = $s3->url;

$bno = $_GET['num']; // $bno에 num값을 받아와 넣음
	
	/* 받아온 num값을 선택해서 게시글 정보 가져오기 */
	$sql = mq("SELECT 
				 * 
                FROM 
                    board 
                WHERE 
                    num='".$bno."'
			"); 
    $board = $sql->fetch_array();
    $board_class = $board['board_class'];
    $category = $board['category'];
    
    /* 조회수 올리기  */
    $views = $board['views'];
    if(empty($_COOKIE["read_".$bno.$board_class])){
        $views = mysqli_fetch_array(mq("SELECT 
                                        * 
                                    FROM 
                                        board 
                                    WHERE 
                                        num ='".$bno."'
                                    "));
        $views = $views['views'] + 1;
        mq("UPDATE 
                board 
            SET 
                views = '".$views."' 
            WHERE 
                num = '".$bno."'
        ");

        // 읽은 게시물 정보를 쿠키에 저장하여 24시간동안 해당 게시물 다시 봐도 조회수 올라가지 않게 함
        setcookie("read_".$bno.$board_class, $bno.$board_class, time() + 60 * 60 * 24);
    }    
    /* 조회수 올리기 끝 */    

    include_once "../fragments/headpiece.php";
?>

<!DOCTYPE HTML>
<!--
	Helios by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
        <?php include_once "../fragments/head.php"; ?>
	</head>
	<body>
		<div id="page-wrapper">

        <!-- Header -->
            <div class="mb-4" id="header">
                <?php include_once "../fragments/header.php"; ?>
            </div>

        <!-- Main -->
            <div class="container">
                
                <br/>                    
                <!-- ctgr_explain.php : 현재 보여지고 있는 게시물이 포함된 게시판의 제목과 간단한 설명을 넣은 것 -->
                <?php include_once "./ctgr_explain.php" ?>
                <div class="row"> <!-- 메인 글 영역-->
                    <div class="col" id="content">
                        <!-- 글 내용 영역 -->								
                        <!-- 글 불러오기 -->
                        <div id="board_read">
                            <h3>[<?=$sub_ctgr.' - '.$headpiece?>] <?=$board['title']?></h3> <!-- 게시물 제목 앞에 게시물 분류와 말머리를 붙임 -->
                            <div><?=$board['writer']?></div> <!-- 작성자 -->
                            <div class="row justify-content-start">                                        
                                <div class="col-2"><?=$board['wdate']?></div> <!-- 작성일 -->
                                <div class="co1-1">조회 <?=$views?></div>
                            </div>

                            <table class="table table-striped" style="text-align: center; border: 1px solid #ddddda; min-height: 200px;">
                                <thead>                                                                                                                                    
                                </thead>	
                                <tbody>                                                                                      
                                    <tr>                                                
                                        <td colspan="2" style="min-height: 200px; text-align: left;"><?=$board['content']?></td> <!-- 글 내용-->
                                    </tr>
                                    <tr>
                                        <td>
                                            <!-- 게시물에 포함된 첨부파일들을 보여주는 영역 -->
                                            <div class="row justify-content-start">
                                                <p class="col-12" style="margin-bottom: 0px;"><b>첨부파일 목록</b></p>
                                                <?php
                                                $sql = mq("SELECT att_file FROM board WHERE num='".$bno."'");
                                                while($row = mysqli_fetch_assoc($sql)){
                                                    $filepath_array = unserialize($row['att_file']);
                                                }                                                        
                                                
                                                for($i=0; $i<count($filepath_array);$i++){
                                                    $filename_result = mq("SELECT * FROM filesave WHERE filepath='".$filepath_array[$i]."'");
                                                    $fetch = mysqli_fetch_array($filename_result);
                                                    $filename_real = $fetch['filename_real'];
                                                    $filename_tmp = $fetch['filename_tmp'];
                                                    $filepath = $fetch['filepath'];
                                                    $filename = str_replace(" ","_", $filename_real);                                                            

                                                    echo "<a class='col-12 float-left py-1 border-0' style='text-align: initial;' href=../file/download.php?dir=$filepath&file=$filename_tmp&name=$filename>$filename_real</a>";
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>											
                </div>                    

            <!-- 댓글 불러오기 -->
                <h3 style="padding:10px 0 15px 0; border-bottom: solid 1px gray; margin-left: inherit;">댓글목록</h3>
                <div class="row justify-content-start">
                    <div class="col-12 reply_view">
                        
                        <!-- 댓글 목록 불러오기-->
                        <?php
                            // DB에 저장된 댓글들 중에서 현재 게시물의 고유 번호에 해당되는 댓글들만 불러옴
                            $sql2=mq("SELECT
                                *
                            FROM
                                reply
                            WHERE
                                con_num='".$bno."'
                            ORDER BY
                                in_num ASC, wdate ASC
                            ");
                            while($reply=$sql2->fetch_array()){
                        ?>
                        
                        <!-- 개별 댓글 쭉 보여주는 영역 (댓글 내용, 작성일, (작성자 본인일 경우) 수정, 삭제 버튼)-->
                        <div class="row dat_view">
                            <?php
                                if($reply['depth']>0) { // 댓글의 답글(대댓글)일 경우 왼쪽에 여백을 두어 윗 댓글의 답글임을 구분하게 만듦
                                    echo "
                                        <img height=1 width=" . $reply['depth']*30 . ">
                                        ";
                                }
                            ?>                                                                        
                            <div name="reply_area_<?=$reply['num']?>" id="reply_area_<?=$reply['num']?>" class="reply_area col" data-num="<?=$reply['num']?>" data-innum="<?=$reply['in_num']?>" data-depth="<?=$reply['depth']?>" data-writer="<?=$reply['writer']?>">
                                <div><b><?=$reply['writer']?></b></div>
                                <div class="dap_to comt_edit">
                                    <?php 
                                    $ori_writer = $reply['ori_writer'];
                                    if($ori_writer != '' && $reply['email'] != 'deleted') {
                                    echo "<a href='#reply_area_$reply[ori_reply]'>".$reply['ori_writer']." 님에게</a>";
                                    }
                                    ?>
                                    <p style="white-space: pre-line;"><?=$reply['content']?></p>
                                </div>
                                <div class="row justify-content-between">
                                    <div class="rep_me dap_to">
                                        <span class="align-middle"><?=$reply['wdate']?></span>
                                        <?php if(($reply['email'] != 'deleted')){ ?>
                                        <button class="btn dat_ans_btn">답글 쓰기</button>
                                        <?php } ?>
                                    </div>                                        
                                    <!-- 자신의 글만 수정, 삭제 할 수 있도록 설정-->
                                    <?php                                             
                                        if($useremail==$reply['email'] || $role=="ADMIN"){ // 본인 아이디거나, 관리자 계정이거나
                                    ?>
                                    <div id="dat_edit" class="rep_me rep_menu">
                                        <button class="btn dat_edit_btn" id="edit_btn" data-num="<?=$reply['num']?>">수정</button>
                                        <button class="btn dat_del_btn">삭제</button>
                                    </div>
                                    <?php
                                        }
                                    ?>
                                </div>

                                <!-- 답글 쓰기 버튼 누르면 나오는 영역-->
                                <div id="ans_reply_<?=$reply['num']?>" data-num="<?=$reply['num']?>" class="row ans_reply" style="margin-top:10px; display:none">
                                    <input type="hidden" name="rno" value="<?=$reply['num']?>"/>
                                    <textarea class="col rep_con p-1" name="content" id="rep_con_ans_<?=$reply['num']?>" placeholder="<?=$reply['writer']?> 님에게"></textarea>
                                    <button class="rep_btn" id="rep_ans_cancel_<?=$reply['num']?>" data-num="<?=$reply['num']?>">취소</button>
                                    <button class="rep_btn" id="rep_ans_<?=$reply['num']?>">등록</button>
                                </div>  
                                <!-- 수정 버튼 누르면 나오는 영역-->
                                <div id="edit_reply_<?=$reply['num']?>" data-num="<?=$reply['num']?>" class="row edit_reply" style="margin-top:10px; display:none">
                                    <input type="hidden" name="rno" value="<?=$reply['num']?>"/>
                                    <textarea class="col rep_con p-1" name="content" id="rep_con_edit_<?=$reply['num']?>"><?=$reply['content']?></textarea>
                                    <button class="rep_btn" id="rep_edit_cancel_<?=$reply['num']?>" data-num="<?=$reply['num']?>">취소</button>
                                    <button class="rep_btn" id="rep_edit_<?=$reply['num']?>">수정</button>
                                </div>
                            </div>         
                        </div>

                        <!-- 댓글 삭제 모달창 구현(회원) -->
                        <div class="modal fade" id="rep_modal_del">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <!-- header -->
                                    <div class="modal-header">
                                        <!-- header title -->
                                        <h4 class="modal-title"><b>댓글 삭제</b></h4>
                                        <!-- 닫기(x) 버튼 -->
                                        <button type="button" class="close" data-dismiss="modal">X</button>                                                
                                    </div>
                                    <!-- body -->
                                    <div class="modal-body">
                                        <form method="post" id="modal_form1" action="/reply/reply_delete.php">
                                            <input type="hidden" name="r_no" id="r_no" value="<?=$reply['num']?>"/>
                                            <input type="hidden" name="b_no" value="<?=$bno;?>">
                                            <script>console.log((<?=$reply['num'];?>));</script>
                                            <p>삭제하시겠습니까?<br/> <input type="submit" class="btn-sm float-right" value="확인" /></p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 댓글 삭제 모달창 구현 끝 -->                            
                        <?php } ?>                                
                        
                        <!-- 댓글 달기 -->
                        <div class="row dat_ins dat_view rep_area">
                            <input type="hidden" name="bno" class="bno" value="<?=$bno?>">
                            <input type="hidden" name="dat_mail" id="dat_mail" class="dat_mail" value="<?=$useremail?>">
                            <input type="hidden" name="dat_user" id="dat_user" class="dat_user" value="<?=$usernickname?>">                                    
                            <!-- <div class="row justify-content-start"> -->
                            <?php 
                                if($useremail != "") {                                            
                            ?>                                    
                            
                            <div class="col-12 dat_ins dat_name"><b><?=$usernickname?></b></div>
                            <textarea class="col rep_con rep_textarea" name="content" id="rep_con_new" placeholder="댓글을 남겨보세요."></textarea>
                            <button class="rep_btn" id="rep_btn">댓글 달기</button>
                            
                            <?php 
                                } else {
                            ?>
                            <textarea class="col rep_con rep_textarea" name="content" id="rep_con_new" placeholder="로그인 후 이용가능합니다." disabled></textarea>
                            <button class="rep_btn" id="rep_btn" disabled>댓글 달기</button>
                            <?php 
                                }
                            ?>                                                                       
                            <!-- </div> -->
                        </div>

                        <!-- 목록, 수정, 삭제 -->
                        <div class="d-flex justify-content-between" method="POST" action="update.php">
                            <div class="d-flex align-content-start col-auto px-0">
                                <form action="write.php" method="POST" class="pl-0">
                                    <input type="hidden" name="category" value="<?=$board['category']?>"/>
                                    <button type="submit" class="col-auto mr-auto btn-lg">글쓰기</button>
                                </form>
                                    <a class="mx-1" href="write.php?num=<?=$board['num']?>" class=""><button type="button" class="col-auto mr-auto btn-lg">답글</button></a>
                                <!-- 자신의 글만 수정, 삭제 할 수 있도록 설정-->
                                <?php                                             
                                    if($useremail==$board['email'] || $role=="ADMIN"){ // 본인 아이디거나, 관리자 계정이거나
                                ?>
                                <a href="update.php?num=<?=$board['num']?>"><button type="button" value="<?=$bno?>" class="col-auto mr-auto btn-lg">수정</button></a>
                                <a class="mx-1" href="delete_article.php?num=<?=$board['num']?>"><button type="button" value="<?=$bno?>" class="col-auto mr-auto btn-lg">삭제</button></a>                                    
                                <?php } ?>
                            </div>
                            <div class="col-auto d-flex justify-content-end p-0">
                                <a href="board_list.php?ctgr=<?=$board['category']?>"><button type="button" class="btn-lg">목록</button></a>
                            </div>                                                                                                      
                        </div>

                    </div>
                </div>
            <!-- 댓글 불러오기 끝 -->
            </div>

        <!-- Footer -->
            <div  class="mt-4"id="footer">
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
            
        <!-- Other Stripts-->
            <script src="/assets/js/jquery-3.5.1.js"></script>            
            <!-- <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script> -->
            <script src="/assets/js/ajax.js"></script>            
			<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->
            <script src="/bootstrap/bootstrap.bundle.js"></script>
            <script src="/bootstrap/bootstrap.bundle.min.js"></script>                    

        <!-- 댓글 작성 기능-->
            <script type="text/javascript" src="/assets/js/jquery.ajax-cross-origin.min.js"></script>
            <script>
            /* 댓글 작성 이벤트(ajax) */
                var session = "<?php echo $useremail; ?>"
                $(function(){
                    $("#rep_btn").click(function(){
                        if(session == "") {
                            alert('로그인 후 이용해주세요!');
                            location.href='/member/login.php';
                            return;
                        }
                        $('#rep_con_new').val().replace(/\n/g, "<br>");

                        $.ajax({				//비동기통신방법, 객체로 보낼때{}사용
                            url : "../reply/reply_ok.php",
                            type : "POST",
                            data : {
                                "bno" : $(".bno").val(),
                                "unum" : <?=$usernum?>,
                                "dat_mail" : $(".dat_mail").val(),
                                "dat_user" : $(".dat_user").val(),				
                                "rep_con" : $("#rep_con_new").val()
                            },                            
                            success : function(data){                                                
                                // alert("댓글이 작성되었습니다");
                                location.reload();
                            }
                        });
                    });                    

                /* 댓글 삭제 이벤트 */
                    $(".dat_del_btn").click(function(){
                        num = $(this).parent().parent().parent().data("num");
                        console.log("댓글 삭제?");
                        $("#r_no").attr("value", num);
                        $("#rep_modal_del").modal();
                    });
                });

                /* 답글 작성 이벤트*/
                $(document).ready(function(){                    
                    $(".dat_ans_btn").click(function(){ // 사용자가 선택한 댓글의 답글 쓰기 버튼
                        if(session == "") {
                            alert('로그인 후 이용해주세요!');
                            location.href='/member/login.php';
                            return;
                        }

                        num = $(this).parent().parent().parent().data("num"); // 선택한 답글 쓰기 버튼이 있는 댓글의 번호
                        in_num = $(this).parent().parent().parent().data("innum"); // 선택한 답글 쓰기 버튼이 있는 댓글의 내부 번호
                        depth = $(this).parent().parent().parent().data("depth"); // 선택한 답글 쓰기 버튼이 있는 댓글의 계층 구조 깊이(몇 번 깊게 들어간 답글인지. 댓글의 답글=1 or 댓글의 답글의 답글=2, ...)
                        ori_writer = $(this).parent().parent().parent().data("writer"); // 선택한 답글 쓰기 버튼이 있는 댓글의 작성자 닉네임
                        $("#rno").attr("value", num); // DB로 댓글 번호 전달하기 위해서 input value 값 변경

                        ans_reply = $("#ans_reply_"+num); // 선택한 댓글의 내용 수정 영역 변수로 초기화

                        rep_ans = $("#rep_ans_"+num); // 내용 수정 영역 우측 '수정' 버튼
                        rep_ans_cancel = $("#rep_ans_cancel_"+num); // 내용 수정 영역 우측 '취소' 버튼

                        ans_reply.toggle(
                            function(){ans_reply.addClass('show')},
                            function(){ans_reply.addClass('hide')}
                        );

                        $(rep_ans_cancel).click(function(){
                            ans_reply.toggle(
                            function(){ans_reply.addClass('hide')},
                            function(){ans_reply.addClass('show')}
                            );
                        });

                        $(rep_ans).click(function(){
                            $.ajax({				//비동기통신방법, 객체로 보낼때{}사용
                                url : "../reply/reply_ok.php",
                                type : "post",                            
                                data : {
                                    "in_num" : in_num,
                                    "unum" : <?=$usernum;?>,
                                    "depth" : depth,
                                    "ori_writer" : ori_writer,
                                    "rno" : num,
                                    "bno" : $(".bno").val(),
                                    "rep_con" : $("#rep_con_ans_"+num).val(),
                                    "dat_mail" : $(".dat_mail").val(),
                                    "dat_user" : $(".dat_user").val()
                                },
                                success : function(data){
                                    // alert("댓글이 수정되었습니다");
                                    location.reload();
                                }
                            });
                        });
                    });       
                });
                
                /* 댓글 수정 이벤트 */
                $(document).ready(function(){                    
                    $(".dat_edit_btn").click(function(){ // 사용자가 선택한 댓글 수정 버튼
                        num = $(this).parent().parent().parent().data("num"); // 선택한 수정 버튼이 있는 댓글의 번호
                        $("#rno").attr("value", num); // DB로 댓글 번호 전달하기 위해서 input value 값 변경

                        edit_reply = $("#edit_reply_"+num); // 선택한 댓글의 내용 수정 영역 변수로 초기화

                        rep_edit = $("#rep_edit_"+num); // 내용 수정 영역 우측 '수정' 버튼
                        rep_edit_cancel = $("#rep_edit_cancel_"+num); // 내용 수정 영역 우측 '취소' 버튼

                        edit_reply.toggle(
                            function(){edit_reply.addClass('show')},
                            function(){edit_reply.addClass('hide')}
                        );

                        $(rep_edit_cancel).click(function(){
                            edit_reply.toggle(
                            function(){edit_reply.addClass('hide')},
                            function(){edit_reply.addClass('show')}
                            );
                        });
                        
                        $(rep_edit).click(function(){
                            $.ajax({				//비동기통신방법, 객체로 보낼때{}사용
                                url : "../reply/reply_update.php",
                                type : "post",                            
                                data : {                                
                                    "rno" : num,
                                    "rep_con" : $("#rep_con_edit_"+num).val()
                                },
                                success : function(data){
                                    // alert("댓글이 수정되었습니다");
                                    location.reload();
                                }
                            });
                        });
                    });       
                });                       
            </script>
            <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
            <script>autosize($('.rep_con'));</script>
	</body>
</html>