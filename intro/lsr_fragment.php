<?php
switch ($board['lang_key']){
    
    case 'en' :
        $langrc = '영어';
        break;
    case 'cn' :
        $langrc = '중국어';
        break;
    case 'ru' :
        $langrc = '러시아어';
        break;
    case 'ge' :
        $langrc = '독일어';
        break;
    
    default : break;
}
switch ($board['ctgr']){
    
    case 'book' :
        $ctgr = '교재 녹음';
        break;
    case 'exam' :
        $ctgr = '시험 문제 답하기';
        break;
    case 'freetalk' :
        $ctgr = '자유 발화';
        break;
    
    default : break;
}
?>