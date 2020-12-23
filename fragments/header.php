<?php
    if(basename($_SERVER['PHP_SELF']) == "index.php"){
        include_once "./util/config.php";
        include_once "./util/ctgr_list.php";
    }else if(basename($_SERVER['PHP_SELF']) == "websocket_server.php") {
        include_once "../../util/config.php";
        include_once "../../util/ctgr_list.php";
    } else {
        include_once "../util/config.php";
        include_once "../util/ctgr_list.php";
    }
?>

<!-- Header 내부 -->

<!-- Inner -->
    <?php
        if(basename($_SERVER['PHP_SELF']) == "index.php"){ // 메인 페이지는 중앙에 버튼과 함께 사이트 제목 표시함
    ?>
        <div class="inner">
            <header>
                <h1><a href="/index.php" id="logo">Salon de Ahn</a></h1>
                <!-- 중앙 사이트 제목 부분-->
                <hr />
                <p>Self-introduction & Sharing interests and infomation</p>
                <!-- 중앙 사이트 제목 아래의 문장-->
            </header>
            <footer>
                <a href="#banner" class="button circled scrolly"> ↓ </a>
                <!-- 문장 아래 원형 버튼. 누르면 아래쪽으로 부드럽게 스크롤되면서 내려감-->
            </footer>
        </div>
    <?php
    } else { // 메인 페이지 외에는 메뉴바 아래에 사이트 제목만 표시함
    ?>
        <div class="inner">
            <header>
                <h1><a href="/index.php" id="logo">Salon de Ahn</a></h1>
            </header>
        </div>
    <?php
    }
    ?>

<!-- Nav -->
<!-- 메인 페이지 열면 첫번째로 보이는 화면의 상단 메뉴 부분-->
    <nav id="nav">
        <ul>
            <li><a href="/index.php">Intro</a></li>
            <li><a href="/intro/it_dev.php">IT-Dev</a>
                <ul>
                    <li><a href="/intro/it_dev.php">경력 소개 - IT개발자로서</a>
                        <ul>
                            <li><a href="/intro/it_dev.php">소개</a></li>
                            <li><a href="/intro/it_dev_portfolio.php">IT개발 포트폴리오</a></li>
                        </ul>
                    </li>
                    <li><a href="/board_ahn/board_list.php?ctgr=<?=$it_dev_learnings?>">학습 내용</a></li>
                    <li><a href="/board_ahn/board_list.php?ctgr=<?=$it_dev_usefulinfo?>">유용한 정보</a></li>
                    <li><a href="/board/board_list.php?ctgr=<?=$it_dev_discussion?>">IT 주제 게시판</a>
                        <ul>
                            <li><a href="/board/board_list.php?ctgr=<?=$it_dev_discussion?>">토론</a></li>
                            <li><a href="/board/board_list.php?ctgr=<?=$it_dev_recordshare?>">경험 공유</a></li>
                            <li><a href="/board/board_list.php?ctgr=<?=$it_dev_infoshare?>">정보 공유</a></li>
                            <li><a href="/board/board_list.php?ctgr=<?=$it_dev_qna?>">Q & A</a></li>                            
                        </ul>
                    </li>                    
                </ul>
            </li>
            <li><a href="/intro/finance.php">Finance</a>
                <ul>
                    <li><a href="/intro/finance.php">경력 소개 - 트레이더로서</a>
                        <ul>
                            <li><a href="/intro/finance.php">소개</a></li>
                            <li><a href="/intro/tradingrecord.php">거래 기록</a></li>
                        </ul>
                    </li>                    
                    <li><a href="/board_ahn/board_list.php?ctgr=<?=$finance_usefulinfo?>">유용한 정보</a></li>                        
                    <li><a href="/board/board_list.php?ctgr=<?=$finance_discussion?>">금융 주제 게시판</a>
                        <ul>
                            <li><a href="/board/board_list.php?ctgr=<?=$finance_discussion?>">토론</a></li>
                            <li><a href="/board/board_list.php?ctgr=<?=$finance_recordshare?>">경험 공유</a></li>
                            <li><a href="/board/board_list.php?ctgr=<?=$finance_infoshare?>">정보 공유</a></li>
                            <li><a href="/board/board_list.php?ctgr=<?=$finance_qna?>">Q & A</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="/intro/languages.php">Language Studies</a>
                <ul>
                    <li><a href="/intro/languages.php">경력 소개 - 언어 학습자로서</a>
                        <ul>
                            <li><a href="/intro/languages.php">소개</a></li>
                            <li><a href="/intro/langstudyrecord.php">공부 기록</a>
                                <ul>
                                    <li><a href="/intro/langstudyrecord.php?lang=en">영어</a></li>
                                    <li><a href="/intro/langstudyrecord.php?lang=cn">중국어</a></li>
                                    <li><a href="/intro/langstudyrecord.php?lang=ru">러시아어</a></li>
                                    <li><a href="/intro/langstudyrecord.php?lang=ge">독일어</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>                    
                    <li><a href="/board_ahn/board_list.php?ctgr=<?=$languages_usefuldata?>">학습 자료</a>
                        <ul>
                            <li><a href="/board_ahn/board_list.php?ctgr=<?=$languages_usefuldata?>?lang=en">영어</a></li>
                            <li><a href="/board_ahn/board_list.php?ctgr=<?=$languages_usefuldata?>?lang=cn">중국어</a></li>
                            <li><a href="/board_ahn/board_list.php?ctgr=<?=$languages_usefuldata?>?lang=ru">러시아어</a></li>
                            <li><a href="/board_ahn/board_list.php?ctgr=<?=$languages_usefuldata?>?lang=ge">독일어</a></li>
                        </ul>
                    </li>                        
                    <li><a href="/board/board_list.php?ctgr=<?=$languages_discussion?>">언어 학습 주제 게시판</a>
                        <ul>
                            <li><a href="/board/board_list.php?ctgr=<?=$languages_discussion?>">토론</a></li>
                            <li><a href="/board/board_list.php?ctgr=<?=$languages_recordshare?>">경험 공유</a></li>
                            <li><a href="/board/board_list.php?ctgr=<?=$languages_infoshare?>">정보 공유</a></li>
                            <li><a href="/board/board_list.php?ctgr=<?=$languages_qna?>">Q & A</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li><a href="/board_ahn/board_list.php?ctgr=<?=$daily_life?>">Daily Life</a>
                <ul>                
                    <li><a href="/board_ahn/board_list.php?ctgr=<?=$daily_life?>">일상 기록</a></li>
                    <li><a href="/board/board_list.php?ctgr=<?=$daily_life_share?>">자유게시판</a></li>
                    <li><a href="/gallery/albums.php">일상 사진 모음</a></li>
                </ul>
            </li>            
            <li><a href="/chatting/chatting.php">Chatting</a></li>                

            <?php
                if(!$useremail){ // 로그인 하지 않은 경우
            ?>
            <li><a href="/login/login.php">Login</a>
                <ul>
                    <li><a href="/login/login.php">Login</a></li>
                    <li><a href="/login/register.php">Register</a></li>
                </ul>
            </li>
            <?php
            } else { // 로그인한 경우
                $logged = $useremail."(".$usernickname.")";
            ?>
            <li><a href="/login/mypage.php">My Page</a>
                <ul>
                    <li><a href="/login/mypage.php"><?=$logged?></a></li>
                    <li><a href="/login/logout.php">Logout</a></li>
                </ul>
            </li>
            <?php
            }
            ?>

        </ul>
    </nav>