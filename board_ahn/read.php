<?php
include_once "../util/config.php";
include_once "../db_con.php";
// include_once "../login/login_check.php";
// echo $useremail;

$bno = $_GET['num']; // $bno에 num값을 받아와 넣음 
    /* 조회수 올리기  */
    if(empty($_COOKIE["read_".$bno])){
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
    }
	/* 조회수 올리기 끝 */
	
	/* 받아온 num값을 선택해서 게시글 정보 가져오기 */
	$sql = mq("SELECT 
				 * 
                FROM 
                    board 
                WHERE 
                    num='".$bno."'
			"); 
	$board = $sql->fetch_array();
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
        <!-- <link rel="stylesheet" href="/bootstrap/bootstrap_custom.css"/> -->        
	</head>
	<body class="right-sidebar is-preload">
		<div id="page-wrapper">

			<!-- Header -->
				<div class="mb-4" id="header">
                    <?php include_once "../fragments/header.php"; ?>
				</div>

			<!-- Main -->
				<!-- <div class="wrapper style1"> -->
					<div class="container">
                        
                        <br/>                       

						<div class="row"> <!-- 메인 글 영역-->
							<div class="col" id="content">
                                <!-- 글 내용 영역 -->								
                                <!-- 글 불러오기 -->
                                <div id="board_read">
                                    <h3><?=$board['title']?></h3>
                                    <div><?=$board['writer']?></div>
                                    <div class="row justify-content-start">                                        
                                        <div class="col-2"><?=$board['wdate']?></div>
                                        <div class="co1-1">조회 <?=$board['views']?></div>
                                    </div>

                                    <table class="table table-striped" style="text-align: center; border: 1px solid #ddddda; min-height: 200px;">
                                        <thead>                                                                                                                                    
                                        </thead>	
                                        <tbody>                                                                                      
                                            <tr>                                                
                                                <td colspan="2" style="min-height: 200px; text-align: left;"><?=$board['content']?></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="row justify-content-start">
                                                    <p class="col-12" style="margin-bottom: 0px;"><b>첨부파일 목록</b></p>
                                                    <?php
                                                        $sql = mq("SELECT att_file FROM board WHERE num='".$bno."'");                                                        
                                                        while($row = mysqli_fetch_assoc($sql)){
                                                            $filepath_array = unserialize($row['att_file']);
                                                        }                                                        
                                                        
                                                        for($i=0; $i<count($filepath_array);$i++){
                                                            $filename_result = mq("SELECT filename_real, filename_tmp FROM filesave WHERE filepath='".$filepath_array[$i]."'");                                                            
                                                            $filename_fetch = mysqli_fetch_array($filename_result);
                                                            $filename_tmp = $filename_fetch[1];
                                                            $filename_real = $filename_fetch[0];                                                            
                                                            $filename = str_replace(" ","_", $filename_real);                                                            
                                                            $filepath = "/file/";                                                            
                                                            // echo "<form class='col-12 float-left' style='text-align: initial;' method='get' action='./download.php'>
                                                            // <input type='hidden' name='filename_tmp' value=$filename_tmp/>
                                                            // <input type='hidden' name='filename_real' value=$filename_real/>
                                                            // <input type='hidden' name='filepath' value=$filepath/>
                                                            // <button type='submit' class='btn'>$filename_real</button></form><br/>";

                                                            echo "<a class='col-12 float-left' style='text-align: initial;' href=./download.php?dir=$filepath&file=$filename_tmp&name=$filename>$filename_real</a><br/>";
                                                        }
                                                    ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- 목록, 수정, 삭제 -->
                                    <!-- <form class="row justify-content-between" method="GET" action="update.php">
                                        <div class="col">                                            
                                            <a href="write.php"><button type="button" class="btn-lg">글쓰기</button></a>
                                            <a href="write.php?num=<?=$board['num']?>"><button type="button" class="btn-lg">답글</button></a>                                             -->
                                            <!-- 자신의 글만 수정, 삭제 할 수 있도록 설정-->
                                            <!-- <?php                                             
                                                //if($useremail==$board['email'] || $role=="ADMIN"){ // 본인 아이디거나, 관리자 계정이거나
                                            ?>
                                            <a href="update.php?num=<?=$board['num']?>"><button type="button" value="<?=$bno?>" class="btn-lg">수정</button></a>
                                            <a href="delete_article.php?num=<?=$board['num']?>"><button type="button" value="<?=$bno?>" class="btn-lg">삭제</button></a>                                    
                                            <?php //} ?>
                                        </div>
                                        <div class="col d-flex justify-content-end">
                                            <a href="board_list.php"><button type="button" class="btn-lg">목록</button></a>
                                        </div>                                                                                                      
                                    </form>                                     -->
                                </div>
							</div>											
                        </div>

                    <!-- </div> 컨테이너 끝-->
                <!-- </div> -->
                
                <!-- 댓글 불러오기 -->
                    <!-- <div class="container"> -->
                        <h3 style="padding:10px 0 15px 0; border-bottom: solid 1px gray; margin-left: inherit;">댓글목록</h3>
                        <div class="row justify-content-start">
                            <div class="col-12 reply_view">
                                
                                <!-- 댓글 목록 불러오기-->
                                <?php 
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
                                            if($ori_writer != '') {
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
                                            <textarea class="col rep_con" name="content" id="rep_con_ans_<?=$reply['num']?>" placeholder="<?=$reply['writer']?> 님에게"></textarea>
                                            <button class="rep_btn" id="rep_ans_cancel_<?=$reply['num']?>" data-num="<?=$reply['num']?>">취소</button>
                                            <button class="rep_btn" id="rep_ans_<?=$reply['num']?>">등록</button>
                                        </div>  
                                        <!-- 수정 버튼 누르면 나오는 영역-->
                                        <div id="edit_reply_<?=$reply['num']?>" data-num="<?=$reply['num']?>" class="row edit_reply" style="margin-top:10px; display:none">
                                            <input type="hidden" name="rno" value="<?=$reply['num']?>"/>
                                            <textarea class="col rep_con" name="content" id="rep_con_edit_<?=$reply['num']?>"><?=$reply['content']?></textarea>
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
                                    <input type="hidden" name="dat_mail" id="dat_mail" class="dat_mail" value="<?=$useremail?>"">
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
                                <div class="row justify-content-between" method="POST" action="update.php">
                                    <div class="row col-auto">
                                        <?php
                                            if($role == "ADMIN") {
                                        ?>
                                        <form action="write.php" method="POST" class="pl-0">
                                            <input type="hidden" name="category" value="<?=$board['category']?>"/>
                                            <a class="a_padding"><button type="submit" class="col-auto mr-auto btn-lg">글쓰기</button></a>
                                        </form>
                                        <a href="write.php?num=<?=$board['num']?>" class="a_nopadding"><button type="button" class="col-auto mr-auto btn-lg">답글</button></a>                                        
                                        <?php } ?>
                                        <!-- 자신의 글만 수정, 삭제 할 수 있도록 설정-->
                                        <?php                                             
                                            if($useremail==$board['email'] || $role=="ADMIN"){ // 본인 아이디거나, 관리자 계정이거나
                                        ?>
                                        <a href="update.php?num=<?=$board['num']?>" class="a_nopadding"><button type="button" value="<?=$bno?>" class="col-auto mr-auto btn-lg">수정</button></a>
                                        <a href="delete_article.php?num=<?=$board['num']?>" class="a_nopadding"><button type="button" value="<?=$bno?>" class="col-auto mr-auto btn-lg">삭제</button></a>                                    
                                        <?php } ?>
                                    </div>
                                    <div class="col-auto d-flex justify-content-end">
                                        <a href="board_list.php?ctgr=<?=$board['category']?>"><button type="button" class="btn-lg">목록</button></a>
                                    </div>                                                                                                      
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- 댓글 불러오기 끝 -->

			<!-- Footer -->
				<div  class="mt-4"id="footer">
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

        <!-- 댓글 작성 기능-->
            <script>
            /* 댓글 작성 이벤트(ajax) */
                var session = "<?php echo $useremail; ?>"
                $(function(){
                    $("#rep_btn").click(function(){
                        if(session == "") {
                            alert('로그인 후 이용해주세요!');
                            location.href='/login/login.php';
                            return;
                        }
                        $('#rep_con_new').val().replace(/\n/g, "<br>");

                        $.ajax({				//비동기통신방법, 객체로 보낼때{}사용
                            url : "../reply_ahn/reply_ok.php",
                            type : "post",                            
                            data : {
                                "bno" : $(".bno").val(),
                                "unum" : <?=$usernum?>,
                                "dat_mail" : $(".dat_mail").val(),
                                "dat_user" : $(".dat_user").val(),				
                                "rep_con" : $("#rep_con_new").val()
                            },
                            success : function(data){                
                                console.log($("#rep_con_new").val());
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
                        console.log(num);
                        console.log($("#r_no").attr("value"));
                        $("#rep_modal_del").modal();
                        
                    });
                    
                        
                });

                /* 답글 작성 이벤트*/
                $(document).ready(function(){                    
                    $(".dat_ans_btn").click(function(){ // 사용자가 선택한 댓글의 답글 쓰기 버튼                        
                        if(session == "") {
                            alert('로그인 후 이용해주세요!');
                            location.href='/login/login.php';
                            return;
                        }

                        num = $(this).parent().parent().parent().data("num"); // 선택한 답글 쓰기 버튼이 있는 댓글의 번호
                        in_num = $(this).parent().parent().parent().data("innum"); // 선택한 답글 쓰기 버튼이 있는 댓글의 내부 번호
                        depth = $(this).parent().parent().parent().data("depth"); // 선택한 답글 쓰기 버튼이 있는 댓글의 계층 구조 깊이(몇 번 깊게 들어간 답글인지. 댓글의 답글=1 or 댓글의 답글의 답글=2, ...)
                        ori_writer = $(this).parent().parent().parent().data("writer"); // 선택한 답글 쓰기 버튼이 있는 댓글의 작성자 닉네임
                        $("#rno").attr("value", num); // DB로 댓글 번호 전달하기 위해서 input value 값 변경
                        // $("#edit_reply_"+num).attr("data-num", num); // 선택한 댓글에만 내용 수정 영역 보이게 함
                        console.log($("#ans_reply_"+num).attr("data-num"));

                        ans_reply = $("#ans_reply_"+num); // 선택한 댓글의 내용 수정 영역 변수로 초기화
                        console.log(ans_reply.attr("data-num"));

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
                                url : "../reply_ahn/reply_ok.php",
                                type : "post",                            
                                data : {
                                    "in_num" : in_num,
                                    "unum" : <?=$usernum?>,
                                    "depth" : depth,
                                    "ori_writer" : ori_writer,
                                    "rno" : num,
                                    "bno" : $(".bno").val(),
                                    "rep_con" : $("#rep_con_ans_"+num).val(),
                                    "dat_mail" : $(".dat_mail").val(),
                                    "dat_user" : $(".dat_user").val()
                                },
                                success : function(data){                
                                    console.log($(".rep_con").val());
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
                        // $("#edit_reply_"+num).attr("data-num", num); // 선택한 댓글에만 내용 수정 영역 보이게 함
                        console.log($("#edit_reply_"+num).attr("data-num"));

                        edit_reply = $("#edit_reply_"+num); // 선택한 댓글의 내용 수정 영역 변수로 초기화
                        console.log(edit_reply.attr("data-num"));

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
                                url : "../reply_ahn/reply_update.php",
                                type : "post",                            
                                data : {                                
                                    "rno" : num,
                                    "rep_con" : $("#rep_con_edit_"+num).val()
                                },
                                success : function(data){                
                                    console.log($(".rep_con").val());
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