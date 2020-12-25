<?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";

// 페이징 구현
if(isset($_GET["page"])){
    $page = $_GET["page"];
} else {
    $page = 1;
}

// 사용자가 클릭한 항목에 맞는 카테고리 값을 GET으로 받아서 해당하는 게시물만 보여줌
// 마이페이지에서 '내가 쓴 글'을 클릭한 경우, 카테고리 값으로 사용자의 이메일 주소를 가져옴
$category = "langstudyrecord";
// 마이페이지로부터 사용자 고유번호를 전달받음. 카테고리로 전달된 이메일 주소와 사용자의 고유 번호 둘 다 일치하는 게시물만 가져오기 위함 (탈퇴 후 동일 메일로 재가입 시에(동일인이든 타인이든) 이전 계정의 게시물을 볼 수 없도록 하게 만듦)
if(isset($_GET["lang"])) $lang = $_GET["lang"];

$s3 = new aws_s3;
$bucket = $s3->bucket;
$url = $s3->url;
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
        <!-- 파일 업로드 기능 -->            
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js" ></script>
        <script type="text/javascript">
        $(document).ready (function(){            
            $("#fileAdd").click(function(){
                $("#fileList").append(
                    '<div>\
                    <input type="file" accept="audio/*" class="col-8 btn-sm" id="fileUpload" name="record[]">\
                    <button type="button" class="btn-sm btnRemove">첨부 취소</button><br/>\
                    <div class="d-flex">\
					<input type="text" class="form-control form-control-sm col" placeholder="언어" name="lang[]">\
                    <input type="text" class="form-control form-control-sm col" placeholder="분류" name="ctgr[]">\
                    <input type="text" class="form-control form-control-sm col" placeholder="기록명" name="title[]">\
                    <input type="text" class="form-control form-control-sm col" placeholder="기록일" name="date[]">\
					</div>\
                    </div>'
                );
                $(".btnRemove").on('click', function(){
                    // $(this).prev().remove();
                    // $(this).next().remove();
                    $(this).siblings().remove();
                    $(this).remove();
                });                            
            });

            $("#filesAdd").click(function(){ // 사진 여러 장 업로드
                $("#fileList").append(					
					'<div>\
					<input type="file" accept="audio/*" class="col-8 btn-sm" id="filesUpload" name="records[]" multiple>\
					<button type="button" class="btn-sm btnRemove">첨부 취소</button>\
					<div class="d-flex">\
					<input type="text" class="form-control form-control-sm col" placeholder="언어(여러 개 공통)" name="langs">\
                    <input type="text" class="form-control form-control-sm col" placeholder="분류(여러 개 공통)" name="ctgrs">\
                    <input type="text" class="form-control form-control-sm col" placeholder="기록명(여러 개 공통)" name="titles">\
                    <input type="text" class="form-control form-control-sm col" placeholder="기록일(여러 개 공통)" name="dates">\
					</div>\
					</div>'
                );
                $(".btnRemove").on('click', function(){
                    // $(this).prev().remove();
					// $(this).next().remove();					
					$(this).siblings().remove();
					$(this).remove();
					
                });                            
            });
        });
        </script>
	</head>
	<body class="right-sidebar is-preload">
		<div id="page-wrapper">

			<!-- Header -->
				<div class="mb-4" id="header">
                    <?php include_once "../fragments/header.php"; ?>
                </div>              

                <!-- 녹음 기록 정보 수정 모달창 양식 구현-->
                <div class="modal fade modal-center" id="modal_div">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <!-- header -->
                            <div class="modal-header">                                
                                <!-- header title -->
                                <h4 class="modal-title"><b>녹음 기록 정보 수정</b></h4>
                                <!-- 닫기(x) 버튼 -->
                                <button type="button" class="close" data-dismiss="modal">X</button>
                            </div>
                            <!-- body -->
                            <div class="modal-body">
                                <form name="edit" id="edit" action="langrecord_edit.php" method="POST">
                                    <input id="edit_num" name="edit_num" type="hidden" value="">
                                    <div class="d-flex">                                        
                                        <input type="text" class="form-control form-control-sm col" placeholder="언어" name="lang_input" id="lang_input" value="">
                                        <input type="text" class="form-control form-control-sm col" placeholder="분류" name="ctgr_input" id="ctgr_input" value="">
                                    </div>                                    
                                    <input type="text" class="form-control form-control-sm col" placeholder="기록명" name="title_input" id="title_input" value="">
                                    <input type="text" class="form-control form-control-sm col" placeholder="기록일" name="date_input" id="date_input" value="">
                                    <button type="button" class="btn-sm float-right" onclick="document.edit.submit();">수정</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- 녹음 기록 정보 수정 모달창 구현 끝-->
                
			<!-- Main -->
				<!-- <div class="wrapper style1"> -->
					<div class="container">			                        
                        <br/>                       
                        <?php include_once "./ctgr_explain.php" ?>
						<div class="row"> <!-- 메인 글 영역-->
							<div class="col-12" id="content">
                                <!-- 게시물 목록 -->
                                <form id="record_list" name="record_list" action="langrecord_delete.php" method="post" enctype="multipart/form-data">
								<table class="table table-sm">
									<thead>
										<tr>
                                            <?php
                                            if($role == "ADMIN") {
                                            ?>
                                            <th scope="col" class="text-center">수정</th>
                                            <th scope="col" class="text-center">삭제</th>
                                            <?php
                                            }
                                            ?>
											<th scope="col" class="text-center">번호</th>
                                            <th scope="col" class="text-center">언어</th>
											<th scope="col" class="text-center">분류</th>
                                            <th scope="col" class="text-center">기록명</th>
                                            <th scope="col" class="text-center">녹음 파일</th>
                                            <th scope="col" class="text-center">기록일</th>                                            
										</tr>
                                    </thead>

                                    <?php
                                    // 페이징 구현
                                    if(isset($lang)){
                                        $sql = mq("SELECT * FROM langrecord WHERE lang_key='".$lang."'");
                                    } else {
                                        $sql = mq("SELECT * FROM langrecord");
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
                                    if(isset($lang)){
                                        $sql2 = mq("SELECT * FROM langrecord WHERE lang_key='".$lang."' ORDER BY wdate DESC LIMIT $page_start, $list"); // $page_start를 시작으로 $list의 수만큼 보여주도록 가져옴                                   
                                    } else {
                                        $sql2 = mq("SELECT * FROM langrecord ORDER BY wdate DESC LIMIT $page_start, $list"); // $page_start를 시작으로 $list의 수만큼 보여주도록 가져옴                                   
                                    }

                                    $post_count = 0;
                                    while($board = $sql2->fetch_array()){
                                        $title=$board["title"];
                                        /* 글자수가 50이 넘으면 ... 처리해주기 */
                                        if(strlen($title)>50){
                                            $title=str_replace($board["title"],mb_substr($board["title"],0,50,"utf-8")."...",$board["title"]);
                                        }                                        
                                    ?>

									<tbody>                                        
										<tr>
                                            <?php
                                            if($role == "ADMIN") {
                                            ?>
                                            <td width="40" class="text-center align-middle">
                                                <button type="button" class="btn-sm edit" value="<?=$board['num'];?>">수정</button>
                                            </td>
                                            <td width="40" class="text-center align-middle">
                                                <input type="checkbox" class="del_rec" name="del_rec[]" value="<?=$board['num'];?>" style="width: 26px; height: 26px;">
                                            </td>
                                            <?php
                                            }
                                            ?>
                                            <td width="40" class="text-center align-middle"><?=$board['num'];?></td>
                                            <td width="60" id="lang_<?=$board['num'];?>" value="<?=$board['lang'];?>" class="text-center align-middle" style="font-size: 1rem;"><?=$board['lang'];?></td>
                                            <td width="80" id="ctgr_<?=$board['num'];?>" value="<?=$board['ctgr'];?>" class="text-center align-middle" style="font-size: 1rem;"><?=$board['ctgr'];?></td>
                                            <td width="300" id="title_<?=$board['num'];?>" value="<?=$board['title'];?>" class="align-middle" style="font-size: 1rem;"><?=$title?></td>
                                            <td width="50" class="align-middle">
                                                <audio class="" src="<?=$url.$board['filepath']?>" controls></audio>
                                            </td>                                            
                                            <td width="90" id="date_<?=$board['num'];?>" value="<?=$board['wdate'];?>" class="text-center align-middle"><?=$board["wdate"];?></td>                                            
                                            
										</tr>
                                    </tbody>
                                    <?php
                                    $post_count++;
                                    }                                                                                                            
                                    ?>
                                </table>
                                </form>
                                <?php                                    
                                    if($post_count == 0) {
                                    ?>                                    
                                            <div class="d-flex align-items-center justify-content-center" style="height: 25vh;">
                                            <p class="text-center">작성된 게시물이 없습니다.</p>
                                            </div>                                                                                       
                                    <?php
                                    }
                                    ?>
                                
                                <div class="row justify-content-between">                                
                                    <?php
                                        if($role == "ADMIN") {
                                    ?>
                                        <form action="langrecord_upload.php" method="POST" enctype="multipart/form-data">                                            
                                            <button type="submit" class="btn-sm p-2">녹음파일 업로드하기</button>
                                            <button type="button" id="fileAdd" class="btn-sm p-2">녹음파일 추가</button>
                                            <button type="button" id="filesAdd" class="btn-sm p-2">녹음파일 여러 개 추가</button>
                                            <button type="button" class="btn-sm p-2" onclick="javascript:document.record_list.submit();">선택한 녹음파일 삭제</button>
                                            <ul id="fileList"></ul>
                                        </form>
                                    <?php } ?>
                                </div>
                                <br/>

                                <!-- 게시물 목록 중앙 하단 페이징 부분-->
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <?php
                                            if ($page <= 1){
                                                // 빈 값
                                            } else {
                                                if(isset($lang)){
                                                    echo "<li class='page-item'><a class='page-link' href='/intro/langstudyrecord.php?ctgr=$category&unum=$lang&page=1' aria-label='Previous'>처음</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='/intro/langstudyrecord.php?ctgr=$category&page=1' aria-label='Previous'>처음</a></li>";
                                                }
                                            }
                                            
                                            if ($page <= 1){
                                                // 빈 값
                                            } else {
                                                $pre = $page - 1;
                                                if(isset($lang)){
                                                    echo "<li class='page-item'><a class='page-link' href='/intro/langstudyrecord.php?ctgr=$category&unum=$lang&page=$pre'>◀ 이전 </a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='/intro/langstudyrecord.php?ctgr=$category&page=$pre'>◀ 이전 </a></li>";
                                                }
                                            }
                                            
                                            for($i = $block_start; $i <= $block_end; $i++){
                                                if($page == $i){
                                                    echo "<li class='page-item'><a class='page-link' disabled><b style='color: #df7366;'> $i </b></a></li>";
                                                } else {
                                                    if(isset($lang)){
                                                        echo "<li class='page-item'><a class='page-link' href='/intro/langstudyrecord.php?ctgr=$category&unum=$lang&page=$i'> $i </a></li>";
                                                    } else {
                                                        echo "<li class='page-item'><a class='page-link' href='/intro/langstudyrecord.php?ctgr=$category&page=$i'> $i </a></li>";
                                                    }
                                                }
                                            }
                                            
                                            if($page >= $total_page){
                                                // 빈 값
                                            } else {
                                                $next = $page + 1;
                                                if(isset($lang)){
                                                    echo "<li class='page-item'><a class='page-link' href='/intro/langstudyrecord.php?ctgr=$category&unum=$lang&page=$next'> 다음 ▶</a></li>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='/intro/langstudyrecord.php?ctgr=$category&page=$next'> 다음 ▶</a></li>";
                                                }
                                            }
                                            
                                            if($page >= $total_page){
                                                // 빈 값
                                            } else {
                                                if(isset($lang)){
                                                    echo "<li class='page-item'><a class='page-link' href='/intro/langstudyrecord.php?ctgr=$category&unum=$lang&page=$total_page'>마지막</a>";
                                                } else {
                                                    echo "<li class='page-item'><a class='page-link' href='/intro/langstudyrecord.php?ctgr=$category&page=$total_page'>마지막</a>";
                                                }
                                            }
                                        ?>                                        
                                    </ul>                                                                  
                                </nav>

                                <!-- 페이징 하단 게시물 검색 -->
                                <div class="row justify-content-center">
                                    <div id="search_box">
                                        <form action="search_result.php" method="get">
                                            <select class="custom-select" name="search_category" style="display: inline-block; width: 12%;">
                                                <option value="title">제목</option>
                                                <option value="writer">글쓴이</option>
                                                <option value="content">내용</option>
                                            </select>
                                            <input type="text" name="search" size="70" required="required" style="display: inline-block; width: 70%;">
                                            <button type="submit" style="padding: 0.65em 2em 0.65em 2em;">검색</button>
                                        </form>
                                    </div>
                                </div>

							</div>											
						</div>																	
					</div>
										
				<!-- </div> -->

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

        <!-- 녹음 기록 정보 수정 모달창 띄우는 이벤트-->
            <script>
                $(function(){
                    $(".edit").click(function(){
                        var num = $(this).val();                        
                        $("#modal_div").modal();                        
                        $("#edit_num").attr("value", num);                        
                        
                        $.ajax({
                            url : "./langrecord_info.php",
                            type : "POST",
                            contentType: 'application/x-www-form-urlencoded; charset=euc-kr',
                            dataType : "JSON",
                            data : {
                                "num" : num
                            },                            
                            success : function(data){
                                $("#lang_input").attr("value", data.lang);
                                $("#ctgr_input").attr("value", data.ctgr);
                                $("#title_input").attr("value", data.title);
                                $("#date_input").attr("value", data.date);
                            }
                        });
                        
                    });
                });
            </script>
	</body>
</html>