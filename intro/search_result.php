<?php 
	include_once "../util/config.php";
    include_once "../db_con.php";
	
	// 현재 페이지 번호를 확인
	if (isset($_GET["page"]))
		$page = $_GET["page"]; //1,2,3,4,5
	else
		$page = 1;
	
	$search_category = $_GET['search_category'];
	$search = $_GET['search'];
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
                <div class="modal fade" id="modal_div">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- header -->
                            <div class="modal-header">
                                <!-- header title -->
                                <h4 class="modal-title"><b>비밀글 입니다.</b></h4>
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
                        <!-- <div class="row">
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
						</div>									 -->
                        <br/>                       

						<div class="row"> <!-- 메인 글 영역-->
                            <div class="col" id="board_area">



                            <!-- 출력을 위해서 form의 title, name, content 값을 제목, 글쓴이, 내용으로 변경하기 위한 조건문 -->
                                <?php 
                                    if($search_category == 'title'){
                                        $keyword = '제목';
                                    } else if($search_category == 'writer'){
                                        $keyword = '글쓴이';
                                    } else{
                                        $keyword = '내용';
                                    }
                                ?>
                                <h1>'<?=$keyword?>' 에서 '<b><?=$search?></b>' 검색결과는 다음과 같습니다.</h1><br>
                                <!-- <h4></h4><br> -->
                                <!-- 검색된 게시물 목록 -->
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

                                    <!-- 검색한 결과 페이징 구현 -->
                                    <?php                                                                  
                                        $sql = mq("SELECT 
                                                        * 
                                                    FROM 
                                                        board 
                                                    WHERE
                                                        $search_category LIKE '%{$search}%'
                                                    UNION
                                                    SELECT 
                                                        * 
                                                    FROM 
                                                        board_ahn 
                                                    WHERE
                                                        $search_category LIKE '%{$search}%'
                                                    ORDER BY 
                                                        in_num DESC
                                                ");
                                        $total_record = mysqli_num_rows($sql); // 검색된 게시판 총 레코드 수
                                        
                                        $list = 10; // 한 페이지에 보여줄 개수
                                        $block_cnt = 5; // 블록당 보여줄 페이지 개수
                                        $block_num = ceil($page / $block_cnt); // 현재 페이지 블록 구하기
                                        $block_start = (($block_num - 1) * $block_cnt) + 1; // 블록의 시작 번호  ex) 1,6,11 ...
                                        $block_end = $block_start + $block_cnt - 1; // 블록의 마지막 번호 ex) 5,10,15 ...
                                        
                                        $total_page = ceil($total_record / $list); // 페이징한 페이지 수
                                        if($block_end > $total_page){ // 블록의 마지막 번호가 페이지 수 보다 많다면
                                            $block_end = $total_page; // 마지막 번호는 페이지 수
                                        }
                                        $total_block = ceil($total_page / $block_cnt); // 블럭 총 개수
                                        $page_start = ($page - 1) * $list; // 페이지 시작

                                    /* 검색된 게시글 정보 가져오기  limit : (시작번호, 보여질 수) */
                                        $sql2 = mq("SELECT 
                                                        * 
                                                    FROM 
                                                        board 
                                                    WHERE
                                                        $search_category LIKE '%{$search}%'
                                                    UNION
                                                    SELECT 
                                                        * 
                                                    FROM 
                                                        board_ahn 
                                                    WHERE
                                                        $search_category LIKE '%{$search}%'
                                                    ORDER BY 
                                                        in_num DESC, wdate ASC LIMIT $page_start, $list
                                                ");

                                        while($board = $sql2->fetch_array()){
                                            $title=$board["title"];
                                            /* 글자수가 30이 넘으면 ... 처리해주기 */
                                            if(strlen($title)>30){
                                                $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]);
                                            }

                                            $sql3 = mq("SELECT 
                                                            * 
                                                        FROM 
                                                            reply
                                                        WHERE 
                                                            con_num='".$board['num']."'
                                                    ");
                                            $rep_count = mysqli_num_rows($sql3);
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
                                                        // if($board['depth']>1){
                                                            // echo "<img height=1 width=" . $board['depth']*10 . ">└";
                                                        // } else {
                                                            echo "└";
                                                        // }                                                    
                                                    }
                                            ?>                                                
                                                <span class="lock_check" style="cursor:pointer" data-action="./read.php?num=" data-check=<?=$role?> data-num="<?=$board['num']?>" ><?=$title?> <?=$lockimg?></span>
                                            <!-- 일반 글 가져오기 -->
                                            <?php                                                     
                                                }else{	// 아니면 공개 글
                                                    if($board['depth']>0) {                                                        
                                                        // if($board['depth']>1){
                                                            // echo "<img height=1 width=" . $board['depth']*10 . ">└";
                                                        // } else {
                                                            echo "└";
                                                        // }                                                    
                                                    }
                                            ?>
                                                <span class="read_check" style="cursor:pointer" data-action="./read.php?num=<?=$board['num']?>"><?=$title?>
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
                                                echo "<li class='page-item'><a class='page-link' href='/board/search_result.php?search_category=$search_category&search=$search&page=1' aria-label='Previous'>처음</a></li>";
                                            }
                                            
                                            if ($page <= 1){
                                                // 빈 값
                                            } else {
                                                $pre = $page - 1;
                                                echo "<li class='page-item'><a class='page-link' href='/board/search_result.php?search_category=$search_category&search=$search&page=$pre'>◀ 이전 </a></li>";
                                                
                                            }
                                            
                                            for($i = $block_start; $i <= $block_end; $i++){
                                                if($page == $i){
                                                    echo "<b> $i </b>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='/board/search_result.php?search_category=$search_category&search=$search&page=$i'> $i </a></li>";
                                                }
                                            }
                                            
                                            if($page >= $total_page){
                                                // 빈 값
                                            } else {
                                                $next = $page + 1;
                                                echo "<li class='page-item'><a class='page-link' href='/board/search_result.php?search_category=$search_category&search=$search&page=$next'> 다음 ▶</a></li>";
                                            }
                                            
                                            if($page >= $total_page){
                                                // 빈 값
                                            } else {
                                                echo "<li class='page-item'><a class='page-link' href='/board/search_result.php?search_category=$search_category&search=$search&page=$total_page'>마지막</a>";
                                            }
                                        ?>                                        
                                    </ul>                                                                  
                                </nav>

                                <!-- 페이징 하단 게시물 검색 -->
                                <div class="row justify-content-center">
                                    <div id="search_box">
                                        <form action="search_result.php" method="get">
                                            <select class="custom-select" name="search_category" style="display: inline-block; width: 12%;">
                                                <option value="title" <?php if($search_category == 'title') echo 'selected';?>>제목</option>
                                                <option value="writer" <?php if($search_category == 'writer') echo 'selected';?>>글쓴이</option>
                                                <option value="content" <?php if($search_category == 'content') echo 'selected';?>>내용</option>
                                            </select>
                                            <input type="text" name="search" size="70" required="required" style="display: inline-block; width: 70%;" value="<?=$search;?>">
                                            <button type="submit" style="padding: 0.65em 2em 0.65em 2em;">검색</button>
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