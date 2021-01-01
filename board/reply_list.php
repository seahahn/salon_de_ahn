<?php
include_once "../util/config.php";
include_once "../db_con.php";

// 페이징 구현
if(isset($_GET["page"])){
    $page = $_GET["page"];
} else {
    $page = 1;
}

// 마이페이지에서 '내가 쓴 댓글'을 클릭한 경우, 카테고리 값으로 사용자의 이메일 주소를 가져옴
$category = $_GET["ctgr"];
// 마이페이지로부터 사용자 고유번호를 전달받음. 카테고리로 전달된 이메일 주소와 사용자의 고유 번호 둘 다 일치하는 게시물만 가져오기 위함 (탈퇴 후 동일 메일로 재가입 시에(동일인이든 타인이든) 이전 계정의 게시물을 볼 수 없도록 하게 만듦)
if(isset($_GET["unum"])) $unum = $_GET["unum"];
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
	<body class="right-sidebar is-preload">
		<div id="page-wrapper">

			<!-- Header -->
				<div class="mb-4" id="header">
                    <?php include_once "../fragments/header.php"; ?>
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

			<!-- Main -->
                <div class="container">
                    <br/>

                    <div class="row">
                        <div class="col" id="content">
                            <!-- 댓글 목록 -->
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">번호</th>
                                        <th scope="col" class="text-center">댓글</th>
                                        <th scope="col" class="text-center">원문 보기</th>
                                        <th scope="col" class="text-center">작성일</th>
                                    </tr>
                                </thead>

                                <?php
                                // 페이징 구현
                                $sql = mq("SELECT * FROM reply WHERE email='".$category."' AND unum='".$unum."'");
                                $total_record = mysqli_num_rows($sql);

                                $list = 10; // 한 페이지에 보여줄 게시물 개수
                                $block_cnt = 5; // 하단에 표시할 블록 당 페이지 개수
                                $block_num = ceil($page / $block_cnt); // 현재 페이지 블록
                                $block_start = (($block_num - 1) * $block_cnt) + 1; // 블록의 시작 번호
                                $block_end = $block_start + $block_cnt - 1; // 블록의 마지막 번호

                                $total_page = ceil($total_record / $list); // 페이징한 페이지 수
                                if($block_end > $total_page){
                                    $block_end = $total_page; // 블록 마지막 번호가 총 페이지 수보다 크면 마지막 페이지 번호를 총 페이지 수로 지정함
                                }
                                $total_block = ceil($total_page / $block_cnt); // 블록의 총 개수
                                $page_start = ($page - 1) * $list; // 페이지의 시작 (SQL문에서 LIMIT 조건 걸 때 사용)

                                // 댓글 목록 가져오기
                                $sql2 = mq("SELECT * FROM reply WHERE email='".$category."' AND unum='".$unum."' ORDER BY in_num DESC, wdate ASC LIMIT $page_start, $list"); // $page_start를 시작으로 $list의 수만큼 보여주도록 가져옴

                                while($reply = $sql2->fetch_array()){
                                    $content=$reply["content"];
                                    /* 글자수가 30이 넘으면 ... 처리해주기 */
                                    if(strlen($content)>30){
                                        $content=str_replace($reply["content"],mb_substr($reply["content"],0,30,"utf-8")."...",$reply["content"]);
                                    }

                                    // 각 댓글이 달려있는 원문의 정보를 가져옴(댓글 DB에 저장된 원문의 고유 번호(con_num)를 이용함)
                                    $sql3 = mq("SELECT * FROM board WHERE num='".$reply['con_num']."'");
                                    $ori_post = mysqli_fetch_array($sql3);
                                ?>

                                <tbody>
                                    <tr>                                           
                                        <td width="70" class="text-center"><?=$reply['num'];?></td>
                                        <td width="300" class="text-center"><?=$reply["content"];?></td>
                                        <td width="70">
                                        <!-- 비밀 글 가져오기 -->
                                        <?php
                                            if($ori_post['wsecret']=="1"){ // lock_post 값이 1이면 잠금
                                        ?>                                                
                                            <span class="lock_check" style="cursor:pointer" data-action="./read.php?num=" data-check="<?=$role?>" data-num="<?=$ori_post['num']?>">원문 보기 ▶</span>
                                        <!-- 일반 글 가져오기 -->
                                        <?php                                                     
                                            }else{                                                 
                                        ?>
                                            <span class="read_check" style="cursor:pointer" data-action="./read.php?num=<?=$ori_post['num']?>">원문 보기 ▶</span></td>                                                
                                        <?php                       
                                            }
                                        ?>                                            
                                        <td width="90" class="text-center"><?=$reply["wdate"];?></td>                                                                            
                                    </tr>
                                </tbody>
                                <?php
                                }
                                ?>
                            </table>
                            <div class="row justify-content-end">                                    
                                <a href="write.php"><button type="button" class="btn-lg">글쓰기</button></a>
                            </div>
                            <br/>

                            <!-- 게시물 목록 중앙 하단 페이징 부분-->
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center">
                                    <?php
                                        if ($page <= 1){
                                            // 빈 값
                                        } else {
                                            if(isset($unum)){
                                                echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&unum=$unum&page=1' aria-label='Previous'>처음</a></li>";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&page=1' aria-label='Previous'>처음</a></li>";
                                            }
                                        }
                                        
                                        if ($page <= 1){
                                            // 빈 값
                                        } else {
                                            $pre = $page - 1;
                                            if(isset($unum)){
                                                echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&unum=$unum&page=$pre'>◀ 이전 </a></li>";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&page=$pre'>◀ 이전 </a></li>";
                                            }
                                        }
                                        
                                        for($i = $block_start; $i <= $block_end; $i++){
                                            if($page == $i){
                                                echo "<b> $i </b>";
                                            } else {
                                                if(isset($unum)){
                                                    echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&unum=$unum&page=$i'> $i </a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&page=$i'> $i </a></li>";
                                                }
                                            }
                                        }
                                        
                                        if($page >= $total_page){
                                            // 빈 값
                                        } else {
                                            $next = $page + 1;
                                            if(isset($unum)){
                                                echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&unum=$unum&page=$next'> 다음 ▶</a></li>";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&page=$next'> 다음 ▶</a></li>";
                                            }
                                        }
                                        
                                        if($page >= $total_page){
                                            // 빈 값
                                        } else {
                                            if(isset($unum)){
                                                echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&unum=$unum&page=$total_page'>마지막</a>";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&page=$total_page'>마지막</a>";
                                            }
                                        }
                                    ?>                                        
                                </ul>                                                                  
                            </nav>

                            <!-- 페이징 하단 게시물 검색 -->
                            <div class="d-flex justify-content-center">
                                <div id="search_box">
                                    <form class="d-flex justify-content-center align-items-center" action="search_result.php" method="get">
                                        <select class="custom-select d-inline-block col-2" name="search_category">
                                            <option value="title">제목</option>
                                            <option value="writer">글쓴이</option>
                                            <option value="content">내용</option>
                                        </select>
                                        <input class="d-inline-block col-7 px-2 py-2" type="text" name="search" size="70" required="required">
                                        <button class="d-inline-block col-1 px-2 py-0" type="button">검색</button>
                                    </form>
                                </div>
                            </div>

                        </div>											
                    </div>
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
            <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
            <script src="/bootstrap/bootstrap.bundle.js"></script>
            <script src="/bootstrap/bootstrap.bundle.min.js"></script>

        <!-- 비밀글 모달 창 관련 이벤트-->
            <script>
                // 비밀글 클릭시 모달창을 띄우는 이벤트
                $(function(){
                    $(".lock_check").click(function(){
                        var user = $(this).attr("data-user");
                        // 관리자 계정일 경우 바로 해당 글로 이동
                        if($(this).attr("data-check")=="ADMIN") {
                            var action_url = $(this).attr("data-action")+$(this).attr("data-num");
                            $(location).attr("href", action_url);                            
                        } else if(user == "<?=$useremail?>") {
                            // 일반 사용자일 경우 사용자 이메일과 게시물 작성한 사용자의 이메일 대조하여 일치하면 해당 글로 이동
                            var action_url = $(this).attr("data-action")+$(this).attr("data-num");
                            $(location).attr("href", action_url);
                        } else {
                            // 관리자도, 작성자도 아니면 읽을 수 없다는 모달창 띄우기
                            $("#modal_div").modal();
                        }
                    });
                });
            
                // 일반 글 클릭시 해당 num의 read 페이지로 이동하는 이벤트
                $(function(){
                    $(".read_check").click(function(){
                        var action_url = $(this).attr("data-action");
                        $(location).attr("href", action_url);
                    });
                });
            </script>


	</body>
</html>