<?php
include_once "../util/config.php";
include_once "../db_con.php";

// 페이징 구현
if(isset($_GET["page"])){
    $page = $_GET["page"];
} else {
    $page = 1;
}
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
				<!-- <div class="wrapper style1"> -->
					<div class="container">			
                        <div class="row">
							<nav class="navbar navbar-expand-lg navbar-light bg-light flex-fill">
								<a class="col navbar-brand" href="#">카테고리 목록</a>
								<button class="col-3 navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
									aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
									<span class="navbar-toggler-icon"></span>
								</button>
							
								<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
									<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
										<li class="nav-item">
											<a class="nav-link" href="#">글 목록 <span class="sr-only">(current)</span></a>
										</li>
										<li class="nav-item">
											<a class="nav-link" href="#">의견/정보 공유</a>
										</li>										
									</ul>
									<form class="form-inline my-2 my-lg-0">
										<input class="form-control mr-sm-2" type="search" placeholder="Search">
										<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
									</form>
								</div>
							</nav>
						</div>									
                        <br/>                       

						<div class="row"> <!-- 메인 글 영역-->
							<div class="col" id="content">
                                <!-- 게시물 목록 -->
								<table class="table table-sm">
									<thead>
										<tr>
											<th scope="col" class="text-center">번호</th>
											<th scope="col" class="text-center">제목</th>
											<th scope="col" class="text-center">작성자</th>
                                            <th scope="col" class="text-center">작성일</th>
                                            <th scope="col" class="text-center">조회수</th>
										</tr>
                                    </thead>

                                    <?php
                                    // 페이징 구현
                                    $sql = mq("SELECT * FROM finance_board");
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
                                    $sql2 = mq("SELECT * FROM finance_board ORDER BY in_num DESC, wdate ASC LIMIT $page_start, $list"); // $page_start를 시작으로 $list의 수만큼 보여주도록 가져옴                                   

                                    while($board = $sql2->fetch_array()){
                                        $title=$board["title"];
                                        /* 글자수가 30이 넘으면 ... 처리해주기 */
                                        if(strlen($title)>30){
                                            $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
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
                                            <td width="70" class="text-center"><?=$board['num'];?></td>
                                            <td width="300">
                                            <!-- 비밀 글 가져오기 -->	 
                                            <?php 
                                                // $lockimg="<img src='./img/lock.png' alt='lock' title='lock' width='18' height='18'>";
                                                $lockimg="※";
                                                if($board['wsecret']=="1"){ // lock_post 값이 1이면 잠금
                                                    if($board['depth']>0) {                                                        
                                                        if($board['depth']>1){
                                                            echo "<img height=1 width=" . $board['depth']*10 . ">└";
                                                        } else {
                                                            echo "└";
                                                        }                                                    
                                                    }
                                            ?>                                                
                                                <span class="lock_check" style="cursor:pointer" data-action="./read.php?num=" data-check="<?=$role?>" data-num="<?=$board['num']?>"><?=$title?> <?=$lockimg?></span>
                                            <!-- 일반 글 가져오기 -->
                                            <?php                                                     
                                                }else{	// 아니면 공개 글
                                                    if($board['depth']>0) {                                                        
                                                        if($board['depth']>1){
                                                            echo "<img height=1 width=" . $board['depth']*10 . ">└";
                                                        } else {
                                                            echo "└";
                                                        }                                                    
                                                    }
                                            ?>
                                                <span class="read_check" style="cursor:pointer" data-action="./read.php?num=<?=$board['num']?>"><?=$title?></span>
                                                <?php if($rep_count>0) {?>
                                                <span style="color:blue;">[<?=$rep_count?>]</span></td>                                                    
                                            <?php                       
                                                    }                             
                                                }
                                            ?>
                                            <td width="70" class="text-center"><?=$board["writer"];?></td>
                                            <td width="90" class="text-center"><?=$board["wdate"];?></td>
                                            <td width="50" class="text-center"><?=$board["views"];?></td>
                                            
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
                                                echo "<li class='page-item'><a class='page-link' href='/finance/board_list.php?page=1' aria-label='Previous'>처음</a></li>";
                                            }
                                            
                                            if ($page <= 1){
                                                // 빈 값
                                            } else {
                                                $pre = $page - 1;
                                                echo "<li class='page-item'><a class='page-link' href='/finance/board_list.php?page=$pre'>◀ 이전 </a></li>";
                                                
                                            }
                                            
                                            for($i = $block_start; $i <= $block_end; $i++){
                                                if($page == $i){
                                                    echo "<b> $i </b>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='/finance/board_list.php?page=$i'> $i </a></li>";
                                                }
                                            }
                                            
                                            if($page >= $total_page){
                                                // 빈 값
                                            } else {
                                                $next = $page + 1;
                                                echo "<li class='page-item'><a class='page-link' href='list.php?page=$next'> 다음 ▶</a></li>";
                                            }
                                            
                                            if($page >= $total_page){
                                                // 빈 값
                                            } else {
                                                echo "<li class='page-item'><a class='page-link' href='list.php?page=$total_page'>마지막</a>";
                                            }
                                        ?>                                        
                                    </ul>                                                                  
                                </nav>

                                <!-- 페이징 하단 게시물 검색 -->
                                <div class="row justify-content-center">
                                    <div id="search_box">
                                        <form action="search_result.php" method="get">
                                            <select name="category" style="display: inline-block; width: 12%;">
                                                <option value="title">제목</option>
                                                <option value="name">글쓴이</option>
                                                <option value="content">내용</option>
                                            </select>
                                            <input type="text" name="search" size="70" required="required" style="display: inline-block; width: 70%;">
                                            <button type="button" style="padding: 0.65em 2em 0.65em 2em;">검색</button>
                                        </form>
                                    </div>
                                </div>

							</div>											
						</div>																	
					</div>
										
				<!-- </div> -->

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

        <!-- 게시물 읽기 페이지 이동 기능-->
            <script>
                $(function(){
                    $(".read_check").click(function(){
                        var action_url = $(this).attr("data-action");
                        $(location).attr("href", action_url);
                    });
                });
            </script>

        <!-- 비밀글 모달 창 관련 이벤트-->
            <script>
                // 비밀글 클릭시 모달창을 띄우는 이벤트
                $(function(){
                    $(".lock_check").click(function(){
                        // 관리자 계정일 경우 바로 해당 글로 이동
                        if($(this).attr("data-check")=="ADMIN") {
                            var action_url = $(this).attr("data-action")+$(this).attr("data-num");
                            $(location).attr("href", action_url);
                        }
                        $("#modal_div").modal();
                        //주소에 data-num(num)값을 더하기
                        var action_url = $("#modal_form").attr("data-action")+$(this).attr("data-num");
                        console.log($(this).attr("data-check"));
                        console.log(action_url);
                        $("#modal_form").attr("action",action_url);                        
                    });
                });
            
                // 일반 글 클릭시 해당 num의 read 페이지로 이동하는 이벤트
                $(function(){
                    $(".read_check").click(function(){
                        var action_url = $(this).attr("data-action");
                        console.log(action_url);
                        $(location).attr("href", action_url);
                    });
                });
            </script>


	</body>
</html>