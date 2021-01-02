
<?php
switch ($category){
        case 'it_dev_portfolio': 
?>            
        <!-- <option value="it_dev_learnings" selected>IT - 학습 내용</option> -->
        <h1 class="fs-1">IT 개발 포트폴리오</h1>
        <p class="fs-1">IT 개발을 공부하면서 만든 작품들에 대한 기록입니다.</p>
<?php
        break; 
        case 'it_dev_learnings': 
?>            
        <!-- <option value="it_dev_learnings" selected>IT - 학습 내용</option> -->
        <h1 class="fs-1">IT - 학습 내용 / 자료</h1>
        <p class="fs-1">IT 개발을 공부하면서 배운 내용 및 유용한 자료들을 기록한 게시판입니다.</p>                       
<?php
        break;          
        case 'it_dev': 
?>            
    <!-- <option value="it_dev_discussion" selected>IT - 토론</option> -->
    <h1 class="fs-1">IT 주제 게시판</h1>
    <p class="fs-1">IT 개발에 대한 이야기를 나누는 공간입니다.</p>
<?php
        break;                                                                   

        case 'tradingrecord': 
?>            
        <!-- <option value="finance_usefulinfo" selected>금융 - 유용한 정보</option> -->
        <h1 class="fs-1">금융 거래 기록</h1>
        <p class="fs-1">주식, 선물, 외환 등을 거래한 기록들입니다.</p>
<?php
        break;

        case 'finance_usefulinfo': 
?>            
    <!-- <option value="finance_usefulinfo" selected>금융 - 유용한 정보</option> -->
    <h1 class="fs-1">금융 - 유용한 정보</h1>
    <p class="fs-1">금융과 관련된 유용한 정보를 모아둔 게시판입니다.</p>                       
<?php
        break;
        case 'finance': 
?>
    <!-- <option selected value="finance_discussion">금융 - 토론</option> -->
    <h1 class="fs-1">금융 주제 게시판</h1>
    <p class="fs-1">금융에 대한 이야기를 나누는 공간입니다.</p>                       
<?php
        break;                                                                    
        
        case 'langstudyrecord':                 
?>
        <!-- <option selected value="languages_usefuldata">언어 학습 - 학습 자료</option> -->
        <h1 class="fs-1">언어 학습 녹음 기록<?php if(isset($_GET['lang'])) { $langs = $_GET['lang']; echo '('.$langs.')';} ?></h1>
        <p class="fs-1">언어 학습을 하면서 녹음한 음성 파일을 모아두었습니다.</p>
<?php
        break;
        case 'languages_usefuldata': 
?>
    <!-- <option selected value="languages_usefuldata">언어 학습 - 학습 자료</option> -->
    <h1 class="fs-1">언어 학습 - 학습 자료</h1>
    <p class="fs-1">언어 학습과 관련된 학습 자료를 모아둔 게시판입니다.</p>                       
<?php
        break;         
        case 'languages': 
?>
    <!-- <option selected value="languages_discussion">언어 학습 - 토론</option> -->
    <h1 class="fs-1">언어 학습 주제 게시판</h1>
    <p class="fs-1">언어 학습에 대한 이야기를 나누는 공간입니다.</p>                       
<?php
        break;                                                                            

        case 'daily_life': 
?>
    <!-- <option selected value="daily_life">일상 기록</option> -->
    <h1 class="fs-1">일상 기록</h1>
    <p class="fs-1">Ahn의 개인적인 일상을 기록해둔 공간입니다.</p>                       
<?php
        break;
        case 'daily_life_share': 
?>
    <!-- <option selected value="daily_life_share">자유게시판</option> -->
    <h1 class="fs-1">자유게시판</h1>
    <p class="fs-1">누구나 자유로운 주제로 글을 작성할 수 있는 게시판입니다.</p>                       
<?php
        break;
}
?>