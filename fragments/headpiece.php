<?php
switch($board['sub_ctgr']) {
    case 'web' :
        $sub_ctgr = '웹';
        break;
    case 'app' :
        $sub_ctgr = '앱';
        break;

    case 'frontend' :
        $sub_ctgr = '프론트엔드';
        break;
    case 'backend' :
        $sub_ctgr = '백엔드';
        break;
    case 'ds' :
        $sub_ctgr = '데이터 사이언스';
        break;
    case 'bc' :
        $sub_ctgr = '블록체인';
        break;
    case 'embed' :
        $sub_ctgr = '임베디드';
        break;

    case 'stocks' :
        $sub_ctgr = '주식';
        break;
    case 'futures' :
        $sub_ctgr = '선물';
        break;
    case 'options' :
        $sub_ctgr = '옵션';
        break;
    case 'fx' :
        $sub_ctgr = '외환';
        break;

    case 'en' :
        $sub_ctgr = '영어';
        break;
    case 'cn' :
        $sub_ctgr = '중국어';
        break;
    case 'ru' :
        $sub_ctgr = '러시아어';
        break;
    case 'ge' :
        $sub_ctgr = '독일어';
        break;

    case 'past' :
        $sub_ctgr = '과거';
        break;
    case 'now' :
        $sub_ctgr = '현재';
        break;
    case 'future' :
        $sub_ctgr = '미래';
        break;

    case 'etc' :
        $sub_ctgr = '기타(etc)';
        break;
}

switch($board['headpiece']) {
    case 'learning' :
        $headpiece = '학습 내용';
        break;
    case 'data' :
        $headpiece = '자료';
        break;    

    case 'chart' :
        $headpiece = '차트 관련';
        break;
    case 'tip' :
        $headpiece = '팁';
        break;    

    case 'gram' :
        $headpiece = '문법';
        break;
    case 'voca' :
        $headpiece = '어휘';
        break;   

    case 'disc' :
        $headpiece = '토론';
        break;
    case 'exp' :
        $headpiece = '경험 공유';
        break;
    case 'info' :
        $headpiece = '정보 공유';
        break;
    case 'qna' :
        $headpiece = 'Q & A';
        break;
    case 'talk' :
        $headpiece = '잡담';
        break;

    case 'idea' :
        $headpiece = '생각';
        break;
    case 'life' :
        $headpiece = '일상';
        break;
}
?>