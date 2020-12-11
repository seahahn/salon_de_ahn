
<?php
switch ($category){
        case 'it_dev_learnings': 
?>            
    <option value="it_dev_learnings" selected>IT - 학습 내용</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break; 
        case 'it_dev_usefulinfo': 
?>            
    <option value="it_dev_usefulinfo" selected>IT - 유용한 정보</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break; 
        case 'it_dev_discussion': 
?>            
    <option value="it_dev_discussion" selected>IT - 토론</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;                                                                    
        case 'it_dev_recordshare': 
?>
    <option selected value="it_dev_recordshare">IT - 경험 공유</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;
        case 'it_dev_infoshare': 
?>
    <option selected value="it_dev_infoshare">IT - 정보 공유</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;
        case 'it_dev_qna': 
?>
    <option selected value="it_dev_qna">IT - Q & A</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;                

        case 'finance_usefulinfo': 
?>            
    <option value="finance_usefulinfo" selected>금융 - 유용한 정보</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;
        case 'finance_discussion': 
?>
    <option selected value="finance_discussion">금융 - 토론</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;                                                                    
        case 'finance_recordshare': 
?>
    <option selected value="finance_recordshare">금융 - 경험 공유</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;
        case 'finance_infoshare': 
?>
    <option selected value="finance_infoshare">금융 - 정보 공유</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;
        case 'finance_qna': 
?>
    <option selected value="finance_qna">금융 - Q & A</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;

        case 'languages_usefuldata': 
?>
    <option selected value="languages_usefuldata">언어 학습 - 학습 자료</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break; 
        case 'languages_discussion': 
?>
    <option selected value="languages_discussion">언어 학습 - 토론</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;                                                                    
        case 'languages_recordshare': 
?>
    <option selected value="languages_recordshare">언어 학습 - 경험 공유</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;
        case 'languages_infoshare': 
?>
    <option selected value="languages_infoshare">언어 학습 - 정보 공유</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;
        case 'languages_qna': 
?>
    <option selected value="languages_qna">언어 학습 - Q & A</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;

        case 'daily_life': 
?>
    <option selected value="daily_life">일상 기록</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;
        case 'daily_life_share': 
?>
    <option selected value="daily_life_share">자유 주제 글</option>
    <h1 class="fs-1">게시판 제목</h1>
    <p class="fs-1">게시판 설명</p>                       
<?php
        break;

        default : break;
}
?>                                                                

<!-- <option value="it_dev_learnings">IT - 학습 내용</option>
<option value="it_dev_usefulinfo">IT - 유용한 정보</option>
<option value="it_dev_discussion">IT - 토론</option>
<option value="it_dev_recordshare">IT - 경험 공유</option>
<option value="it_dev_infoshare">IT - 정보 공유</option>
<option value="it_dev_qna">IT - Q & A</option>
<option value="finance_usefulinfo">금융 - 유용한 정보</option>
<option value="finance_discussion">금융 - 토론</option>
<option value="finance_recordshare">금융 - 경험 공유</option>
<option value="finance_infoshare">금융 - 정보 공유</option>
<option value="finance_qna">금융 - Q & A</option>
<option value="languages_usefuldata">언어 학습 - 학습 자료</option>
<option value="languages_discussion">언어 학습 - 토론</option>
<option value="languages_recordshare">언어 학습 - 경험 공유</option>
<option value="languages_infoshare">언어 학습 - 정보 공유</option>
<option value="languages_qna">언어 학습 - Q & A</option>
<option value="daily_life">일상 기록</option>
<option value="daily_life_share">자유 주제 글</option> -->