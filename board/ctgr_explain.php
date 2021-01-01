
<?php
switch ($category){
        case 'it_dev_portfolio': 
?>            
        <h1 class="fs-1">IT 개발 포트폴리오</h1>
        <p class="fs-1">IT 개발을 공부하면서 만든 작품들에 대한 기록입니다.</p>
<?php
        break; 
        case 'it_dev_learnings': 
?>            
        <h1 class="fs-1">IT - 학습 내용 / 자료</h1>
        <p class="fs-1">IT 개발을 공부하면서 배운 내용 및 유용한 자료들을 기록한 게시판입니다.</p>                       
<?php
        break;          
        case 'it_dev': 
?>            
    <h1 class="fs-1">IT 주제 게시판</h1>
    <p class="fs-1">IT 개발에 대한 이야기를 나누는 공간입니다.</p>
<?php
        break;                                                                   

        case 'tradingrecord': 
?>            
        <h1 class="fs-1">금융 거래 기록</h1>
        <p class="fs-1">주식, 선물, 외환 등을 거래한 기록들입니다.</p>
<?php
        break;

        case 'finance_usefulinfo': 
?>            
    <h1 class="fs-1">금융 - 유용한 정보</h1>
    <p class="fs-1">금융과 관련된 유용한 정보를 모아둔 게시판입니다.</p>                       
<?php
        break;
        case 'finance': 
?>
    <h1 class="fs-1">금융 주제 게시판</h1>
    <p class="fs-1">금융에 대한 이야기를 나누는 공간입니다.</p>                       
<?php
        break;                                                                    
        
        case 'langstudyrecord':                 
?>
        <h1 class="fs-1">언어 학습 녹음 기록<?php if(isset($_GET['lang'])) { $langs = $_GET['lang']; echo '('.$langs.')';} ?></h1>
        <p class="fs-1">언어 학습을 하면서 녹음한 음성 파일을 모아두었습니다.</p>
<?php
        break;
        case 'languages_usefuldata': 
?>
    <h1 class="fs-1">언어 학습 - 학습 자료</h1>
    <p class="fs-1">언어 학습과 관련된 학습 자료를 모아둔 게시판입니다.</p>                       
<?php
        break;         
        case 'languages': 
?>
    <h1 class="fs-1">언어 학습 주제 게시판</h1>
    <p class="fs-1">언어 학습에 대한 이야기를 나누는 공간입니다.</p>                       
<?php
        break;                                                                            

        case 'daily_life': 
?>
    <h1 class="fs-1">일상 기록</h1>
    <p class="fs-1">Ahn의 개인적인 일상을 기록해둔 공간입니다.</p>                       
<?php
        break;
        case 'daily_life_share': 
?>
    <h1 class="fs-1">자유게시판</h1>
    <p class="fs-1">누구나 자유로운 주제로 글을 작성할 수 있는 게시판입니다.</p>                       
<?php
        break;
}
?>