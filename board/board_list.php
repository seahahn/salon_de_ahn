<?php
include_once "../util/config.php";
include_once "../db_con.php";

// 페이징 구현
if(isset($_GET["page"])){
    $page = $_GET["page"];
} else {
    $page = 1;
}

// 사용자가 클릭한 항목에 맞는 카테고리 값을 GET으로 받아서 해당하는 게시물만 보여줌
// 마이페이지에서 '내가 쓴 게시물'을 클릭한 경우, 카테고리 값으로 사용자의 이메일 주소를 가져와서 해당 사용자가 작성한 글만 나오게 함
$category = $_GET["ctgr"];

// 마이페이지로부터 사용자 고유번호를 전달받음. 카테고리로 전달된 이메일 주소와 사용자의 고유 번호 둘 다 일치하는 게시물만 가져오기 위함 (탈퇴 후 동일 메일로 재가입 시에(동일인이든 타인이든) 이전 계정의 게시물을 볼 수 없도록 하게 만듦)
if(isset($_GET["unum"])) $unum = $_GET["unum"];

if(isset($_GET["hp"])) $hp = $_GET["hp"]; // 게시판 소분류 선택한 경우 그 값을 받아옴

if(isset($_GET["lang"])) $lang = $_GET["lang"]; // 언어 학습 카테고리에서 소분류로 언어 선택한 경우 그 값을 받아옴
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
                    <?php include_once "./ctgr_explain.php" ?>
                    <div class="d-flex justify-content-center"> <!-- 메인 글 영역-->
                        <div class="col-12" id="content">
                            <!-- 게시물 목록 -->
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center">번호</th>
                                        <th scope="col" class="text-center">분류</th>                                            
                                        <th scope="col" class="text-center">제목</th>
                                        <th scope="col" class="text-center">작성자</th>
                                        <th scope="col" class="text-center">작성일</th>
                                        <th scope="col" class="text-center">조회수</th>
                                    </tr>
                                </thead>

                                <?php
                                // 페이징 구현
                                if(isset($unum)){
                                    $sql = mq("SELECT * FROM board WHERE email='".$category."' AND unum='".$unum."'"); // 마이페이지에서 '내가 쓴 글' 클릭한 경우
                                } else if(isset($hp)) {
                                    $sql = mq("SELECT * FROM board WHERE category='".$category."' AND headpiece='".$hp."'"); // 게시판 소분류(토론, 정보 공유 등등) 선택한 경우
                                } else if(isset($lang)) {
                                    $sql = mq("SELECT * FROM board WHERE category='".$category."' AND sub_ctgr='".$lang."'"); // 언어 학습 주제 게시판에서 소분류(영어, 중국어 등등) 선택한 경우
                                } else {
                                    $sql = mq("SELECT * FROM board WHERE category='".$category."'");
                                }
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

                                // 게시물 목록 가져오기
                                // $page_start를 시작으로 $list의 수만큼 보여주도록 가져옴
                                if(isset($unum)){
                                    $sql2 = mq("SELECT * FROM board WHERE email='".$category."' AND unum='".$unum."' ORDER BY in_num DESC, wdate ASC LIMIT $page_start, $list");
                                } else if(isset($hp)) {
                                    $sql2 = mq("SELECT * FROM board WHERE category='".$category."' AND headpiece='".$hp."' ORDER BY in_num DESC, wdate ASC LIMIT $page_start, $list");
                                } else if(isset($lang)) {
                                    $sql2 = mq("SELECT * FROM board WHERE category='".$category."' AND sub_ctgr='".$lang."' ORDER BY in_num DESC, wdate ASC LIMIT $page_start, $list");
                                } else {
                                    $sql2 = mq("SELECT * FROM board WHERE category='".$category."' ORDER BY in_num DESC, wdate ASC LIMIT $page_start, $list");
                                }

                                $post_count = 0;
                                while($board = $sql2->fetch_array()){
                                    include "../fragments/headpiece.php";
                                    $title=$board["title"];
                                    /* 글자수가 40이 넘으면 ... 처리해주기 */
                                    if(strlen($title)>40){
                                        $title=str_replace($board["title"],mb_substr($board["title"],0,40,"utf-8")."...",$board["title"]);
                                    }
                                    
                                    /* 댓글 수 구하기 */
                                    $sql3 = mq("SELECT
                                                    *
                                                FROM
                                                    reply
                                                WHERE
                                                    con_num='".$board['num']."'
                                            ");
                                    $rep_count = mysqli_num_rows($sql3); // 레코드의 수(댓글의 수)
                                ?>

                                <tbody>                                        
                                    <tr>                                                                                  
                                        <td width="70" class="text-center"><?=$board['num']?></td>
                                        <td width="100" class="text-center" style="font-size: 1rem;"><?php if($board['sub_ctgr']) echo $sub_ctgr; ?></td>
                                        <td width="270">
                                        <!-- 비밀 글 가져오기 -->	 
                                        <?php 
                                            $lockimg="<img class='align-middle' src='../images/black_lock.png' alt='lock' title='lock' width='6%' height='auto'>";
                                            $attfile="<img class='align-middle' src='../images/attfile.png' alt='attfile' title='attfile' width='4%' height='auto'>";
                                            // $lockimg="※";
                                            if($board['wsecret']=="1"){ // wsecret 값이 1이면 잠금
                                                if($board['depth']>0) {                                                        
                                                    // if($board['depth']>1){
                                                        // // 답글의 깊이(원글의 답글=1, 답글의 답글=2, ...)에 따라서 글 제목 들여쓰기시킴
                                                        // echo "<img height=1 width=" . $board['depth']*10 . ">└";
                                                        // echo "<img height=1 width='10'>└";
                                                    // } else {
                                                        echo "└";
                                                    // }
                                                }
                                        ?>
                                            <div class="d-inline"><span class="lock_check align-middle" style="cursor:pointer" data-action="./read.php?num=" data-check=<?=$role?> data-num="<?=$board['num']?>" data-user="<?=$board['email']?>">[<?=$headpiece?>] <?=$title?></span><?=$lockimg?><?=$attfile?></div>
                                            <?php if($rep_count>0) { ?>
                                            <span class="align-middle" style="color:blue;">[<?=$board['rep_num']?>]</span></td>
                                            <?php } ?>
                                        <!-- 일반 글 가져오기 -->
                                        <?php                       
                                            } else {	// 아니면 공개 글
                                                if($board['depth']>0) {                                                        
                                                    // if($board['depth']>1){
                                                        // echo "<img height=1 width=" . $board['depth']*10 . ">└";
                                                        // echo "<img height=1 width=10>└";
                                                    // } else {
                                                        echo "└";
                                                    // }                                                    
                                                }
                                        ?>
                                            <span class="read_check" style="cursor:pointer" data-action="./read.php?num=<?=$board['num']?>">[<?=$headpiece?>] <?=$title?></span>
                                            <?php if($rep_count>0) {?>
                                            <span style="color:blue;">[<?=$board['rep_num']?>]</span></td>                                                    
                                            <?php } 
                                            } ?>
                                        <td width="70" class="text-center"><?=$board["writer"];?></td>
                                        <td width="100" class="text-center"><?=$board["wdate"];?></td>
                                        <td width="50" class="text-center"><?=$board["views"];?></td>
                                    </tr>
                                </tbody>
                                <?php
                                $post_count++;
                                }
                                ?>
                            </table>
                            <?php                                    
                                if($post_count == 0) {
                                ?>                                    
                                        <div class="d-flex align-items-center justify-content-center" style="height: 25vh;">
                                        <p class="text-center">작성된 게시물이 없습니다.</p>
                                        </div>                                                                                       
                                <?php
                                }
                                ?>
                            <div class="row justify-content-end">                                                                        
                                <form action="write.php" method="POST">
                                    <input type="hidden" name="category" value="<?=$category?>"/>
                                    <button type="submit" class="btn-lg">글쓰기</button>
                                </form>
                            </div>
                            <br/>

                            <!-- 게시물 목록 중앙 하단 페이징 부분-->
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <?php
                                        // 페이지 수 맨 왼쪽 '처음' 표시 여부 결정
                                        if ($page <= 1){
                                            // 빈 값
                                        } else {
                                            if(isset($unum)){
                                                echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&unum=$unum&page=1' aria-label='Previous'>처음</a></li>";
                                            } else {
                                                echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&page=1' aria-label='Previous'>처음</a></li>";
                                            }
                                        }

                                        // 페이지 수 왼쪽 두번째 '◀ 이전' 표시 여부 결정
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
                                        
                                        // 페이지 수 숫자(위에서 설정한 $block_start값 부터 $block_end값 까지) 표시
                                        for($i = $block_start; $i <= $block_end; $i++){
                                            if($page == $i){
                                                echo "<li class='page-item'><a class='page-link' disabled><b style='color: #df7366;'> $i </b></a></li>";
                                            } else {
                                                if(isset($unum)){
                                                    echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&unum=$unum&page=$i'> $i </a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='/board/board_list.php?ctgr=$category&page=$i'> $i </a></li>";
                                                }
                                            }
                                        }
                                        
                                        // 페이지 수 오른쪽 두번째 '다음 ▶' 표시 여부 결정
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
                                        
                                        // 페이지 수 맨 오른쪽 '마지막' 표시 여부 결정
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
                                        <input class="d-inline-block col-7 px-2 py-2" type="text" size="70" name="search" required="required">
                                        <button class="d-inline-block col-1 px-2 py-0" type="submit">검색</button>
                                    </form>
                                </div>
                            </div>

                        </div>											
                    </div>																	
                </div>

			<!-- Footer -->
				<div class="mt-4" id="footer">
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

        <!-- 비밀글 모달 창 관련 이벤트 + 게시물 읽기 페이지 이동 기능-->
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