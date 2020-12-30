
<?php
    // if(isset($_POST['category'])){ // 글 읽기 상태에서 글쓰기 누른 경우. 읽던 글의 카테고리 선택하게 함
    //     $category = $_POST['category'];
    // }
    // if(isset($_POST['num'])) {
    //     $category = $_POST['category'];
    // }
?>    
<select class="custom-select col-8 mr-2" name="category" id="category" onchange="itemChange()">
    <option value="none_category" disabled>게시판 분류</option> <!-- 마이페이지 내가 쓴 글 목록에서 글쓰기 누른 경우는 이게 초기값으로 지정됨(해당되는 카테고리가 없기 때문)-->
    <option disabled>- IT 개발 -</option>        
    <option <?php if($category == 'it_dev_learnings') echo 'selected'?> value="it_dev_learnings">학습 내용 / 자료</option>    
    <option disabled></option>
    <option disabled>- 금융 -</option>        
    <option <?php if($category == 'finance_usefulinfo') echo 'selected'?> value="finance_usefulinfo">유용한 정보</option>        
    <option disabled></option>
    <option disabled>- 언어 학습 -</option>        
    <option <?php if($category == 'languages_usefuldata') echo 'selected'?> value="languages_usefuldata">학습 자료</option>                
    <option disabled></option>
    <option disabled>- 일상 -</option>        
    <option <?php if($category == 'daily_life') echo 'selected'?> value="daily_life">일상 기록</option>
    
</select>
<select class="custom-select col mr-2" name="sub_ctgr" id="sub_ctgr">        
    <?php                
    if(strpos($category, "it_dev_learnings") !== false) { ?>
        <option value="none_subctgr" <?php if($sub_ctgr == '') echo 'selected'?> disabled>분야 선택</option>
        <option value="web" <?php if($sub_ctgr == 'web') echo 'selected'?>>웹</option>
        <option value="app" <?php if($sub_ctgr == 'app') echo 'selected'?>>앱</option>
    <?php } ?>
    <?php                
    if(strpos($category, "finance_usefulinfo") !== false) { ?>
        <option value="none_subctgr" <?php if($sub_ctgr == '') echo 'selected'?> disabled>분류 선택</option>
        <option value="stocks" <?php if($sub_ctgr == 'stocks') echo 'selected'?>>주식</option>
        <option value="futures" <?php if($sub_ctgr == 'futures') echo 'selected'?>>선물</option>
        <option value="options" <?php if($sub_ctgr == 'options') echo 'selected'?>>옵션</option>
        <option value="fx" <?php if($sub_ctgr == 'fx') echo 'selected'?>>외환</option>
    <?php } ?>
    <?php                
    if(strpos($category, "languages_usefuldata") !== false) { ?>
        <option value="none_subctgr" <?php if($sub_ctgr == '') echo 'selected'?> disabled>언어 선택</option>
        <option value="en" <?php if($sub_ctgr == 'en') echo 'selected'?>>영어</option>
        <option value="cn" <?php if($sub_ctgr == 'cn') echo 'selected'?>>중국어</option>
        <option value="ru" <?php if($sub_ctgr == 'ru') echo 'selected'?>>러시아어</option>
        <option value="ge" <?php if($sub_ctgr == 'ge') echo 'selected'?>>독일어</option>
    <?php } ?>
    <?php                
    if(strpos($category, "daily_life") !== false) { ?>
        <option value="none_subctgr" <?php if($sub_ctgr == '') echo 'selected'?> disabled>주제 선택</option>
        <option value="past">과거</option>
        <option value="now">현재</option>
        <option value="future">미래</option>
    <?php } ?>
</select>
<select class="custom-select col" name="headpiece" id="headpiece">
    <option value="none_headpiece" <?php if($headpiece == '') echo 'selected'?> disabled>말머리</option>
    <?php                
    if(strpos($category, "it_dev_learnings") !== false) { ?>
        <option value="learning" <?php if($sub_ctgr == 'learning') echo 'selected'?>>학습 내용</option>
        <option value="data" <?php if($sub_ctgr == 'data') echo 'selected'?>>자료</option>
    <?php } ?>
    <?php                
    if(strpos($category, "finance_usefulinfo") !== false) { ?>
        <option value="chart" <?php if($sub_ctgr == 'chart') echo 'selected'?>>차트 관련</option>
        <option value="tip" <?php if($sub_ctgr == 'tip') echo 'selected'?>>팁</option>
    <?php } ?>
    <?php                
    if(strpos($category, "languages_usefuldata") !== false) { ?>
        <option value="gram" <?php if($sub_ctgr == 'gram') echo 'selected'?>>문법</option>
        <option value="voca" <?php if($sub_ctgr == 'voca') echo 'selected'?>>어휘</option>
    <?php } ?>
    <?php                
    if(strpos($category, "daily_life") !== false) { ?>
        <option value="idea" <?php if($sub_ctgr == 'idea') echo 'selected'?>>생각</option>
        <option value="life" <?php if($sub_ctgr == 'life') echo 'selected'?>>일상</option>
    <?php } ?>
</select>
<!-- 게시물 대분류에 따른 소분류, 말머리 바꾸기-->
<script>
function itemChange() {
    var selectCtgr = $("#category").val();
    var sub;
    var hp;

    var sub_dev = ['<option value="none_subctgr" selected disabled>분야 선택</option>', 
        '<option value="web">웹</option>', 
        '<option value="app">앱</option>'];    
    var sub_fin = ['<option value="none_subctgr" selected disabled>분류 선택</option>',
        '<option value="stock">주식</option>',
        '<option value="future">선물</option>',
        '<option value="option">옵션</option>',
        '<option value="fx">외환</option>'];
    var sub_lan = ['<option value="none_subctgr" selected disabled>언어 선택</option>',
        '<option value="en">영어</option>',
        '<option value="cn">중국어</option>',
        '<option value="ru">러시아어</option>',
        '<option value="ge">독일어</option>'];
    var sub_dai = ['<option value="none_subctgr" selected disabled>주제 선택</option>',
        '<option value="past">과거</option>',
        '<option value="now">현재</option>',
        '<option value="future">미래</option>'];
    
    var hp_dev = ['<option value="none_headpiece" selected disabled>말머리</option>',
        '<option value="learning">학습 내용</option>',
        '<option value="data">자료</option>'];
    var hp_fin = ['<option value="none_headpiece" selected disabled>말머리</option>',
        '<option value="chart">차트 관련</option>',
        '<option value="tip">팁</option>'];
    var hp_lan = ['<option value="none_headpiece" selected disabled>말머리</option>',
        '<option value="gram">문법</option>',
        '<option value="voca">어휘</option>'];
    var hp_dai = ['<option value="none_headpiece" selected disabled>말머리</option>',
        '<option value="idea">생각</option>',
        '<option value="life">일상</option>'];

    if(selectCtgr == "it_dev_learnings") {
        sub = sub_dev;
        hp = hp_dev;
    }
    if(selectCtgr == "finance_usefulinfo") {
        sub = sub_fin;
        hp = hp_fin;
    }
    if(selectCtgr == "languages_usefuldata") {
        sub = sub_lan;
        hp = hp_lan;
    }
    if(selectCtgr == "daily_life") {
        sub = sub_dai;
        hp = hp_dai;
    }

    $("#sub_ctgr").empty();
    $("#headpiece").empty();

    for(var i = 0; i < sub.length; i++) {        
        var sub_opt = $(sub[i]);
        $("#sub_ctgr").append(sub_opt);
    }
    for(var i = 0; i < hp.length; i++) {        
        var hp_opt = $(hp[i]);
        $("#headpiece").append(hp_opt);
    }
    
}
</script>