    <select class="custom-select col-8 mr-2 p-0" name="category" id="category" <?php if(isset($_GET['num'])) echo 'readonly';?>>
        <?php
        if(isset($_POST['category'])){ // 글 읽기 상태에서 글쓰기 누른 경우. 읽던 글의 카테고리 선택하게 함
            $category = $_POST['category'];
        ?>        
        <option value="none_category" <?php if(!isset($_POST['category'])) echo 'selected'?> disabled>게시판 분류</option> <!-- 마이페이지 내가 쓴 글 목록에서 글쓰기 누른 경우는 이게 초기값으로 지정됨(해당되는 카테고리가 없기 때문)-->
        <option value="it_dev" <?php if($category == 'it_dev') echo 'selected'?>> - IT 주제 게시판 -</option>
        <?php
        if($role == "ADMIN") {
        ?>
        <!-- <option <?php if($category == 'it_dev_learnings') echo 'selected'?> value="it_dev_learnings">학습 내용 / 자료</option>         -->
        <?php }?>        
        <option value="finance" <?php if($category == 'finance') echo 'selected'?>>- 금융 주제 게시판 -</option>
        <?php
        if($role == "ADMIN") {
        ?>
        <!-- <option <?php if($category == 'finance_usefulinfo') echo 'selected'?> value="finance_usefulinfo">유용한 정보</option> -->
        <?php }?>                
        <option value="languages" <?php if($category == 'languages') echo 'selected'?>> - 언어 학습 주제 게시판 -</option>
        <?php
        if($role == "ADMIN") {
        ?>
        <!-- <option <?php if($category == 'languages_usefuldata') echo 'selected'?> value="languages_usefuldata">학습 자료</option>         -->
        <?php }?>                
        <option value="daily_life_share" <?php if($category == 'daily_life_share') echo 'selected'?>> - 자유게시판 -</option>
        <?php
        if($role == "ADMIN") {
        ?>
        <!-- <option <?php if($category == 'daily_life') echo 'selected'?> value="daily_life">일상 기록</option> -->
        <?php }?>        

        <?php                                                                
        } else if(isset($_GET['num'])) { // 글 읽기 상태에서 답글 누른 경우. 읽던 글의 카테고리 선택 후 고정되게 함
        $bno = $_GET['num']; // $bno에 num값을 받아와 넣음
        /* 받아온 num값을 선택해서 게시글 정보 가져오기 */
        $sql = mq("SELECT 
                     * 
                    FROM 
                        board 
                    WHERE 
                        num='$bno'
                ");
        $board = $sql->fetch_array();	
        $category = $board['category'];
            switch ($category){
                case 'it_dev': 
        ?>            
            <option selected value="it_dev">- IT 주제 게시판 -</option>
        <?php
                break;                
                case 'finance': 
        ?>
            <option selected value="finance">- 금융 주제 게시판 -</option>
        <?php
                break;                                                                                    
                case 'languages': 
        ?>
            <option selected value="languages">- 언어 학습 주제 게시판 -</option>
        <?php
                break;                                                                                
                case 'daily_life_share': 
        ?>
            <option selected value="daily_life_share">- 자유게시판 -</option>
        <?php
                break;
            }
        ?>                                                                
        <?php
        }
        ?>
    </select>
    <select class="custom-select col mr-2" name="sub_ctgr" id="sub_ctgr">        
    <?php                
    if(strpos($category, "it_dev") !== false) { ?>
        <option value="none_subctgr" <?php if($sub_ctgr == '') echo 'selected'?> disabled>분야 선택</option>
        <option value="frontend" <?php if($sub_ctgr == 'frontend') echo 'selected'?>>프론트엔드</option>
        <option value="backend" <?php if($sub_ctgr == 'backend') echo 'selected'?>>백엔드</option>
        <option value="ds" <?php if($sub_ctgr == 'ds') echo 'selected'?>>데이터 사이언스</option>
        <option value="bc" <?php if($sub_ctgr == 'bc') echo 'selected'?>>블록체인</option>
        <option value="embed" <?php if($sub_ctgr == 'embed') echo 'selected'?>>임베디드</option>        
    <?php } ?>
    <?php                
    if(strpos($category, "finance") !== false) { ?>
        <option value="none_subctgr" <?php if($sub_ctgr == '') echo 'selected'?> disabled>분류 선택</option>
        <option value="stocks" <?php if($sub_ctgr == 'stocks') echo 'selected'?>>주식</option>
        <option value="futures" <?php if($sub_ctgr == 'futures') echo 'selected'?>>선물</option>
        <option value="options" <?php if($sub_ctgr == 'options') echo 'selected'?>>옵션</option>
        <option value="fx" <?php if($sub_ctgr == 'fx') echo 'selected'?>>외환</option>
    <?php } ?>
    <?php                
    if(strpos($category, "languages") !== false) { ?>
        <option value="none_subctgr" <?php if($sub_ctgr == '') echo 'selected'?> disabled>언어 선택</option>
        <option value="en" <?php if($sub_ctgr == 'en') echo 'selected'?>>영어</option>
        <option value="cn" <?php if($sub_ctgr == 'cn') echo 'selected'?>>중국어</option>
        <option value="ru" <?php if($sub_ctgr == 'ru') echo 'selected'?>>러시아어</option>
        <option value="ge" <?php if($sub_ctgr == 'ge') echo 'selected'?>>독일어</option>
    <?php } ?>
    <?php                
    if(strpos($category, "daily_life_share") !== false) { ?>
        <option value="none_subctgr" <?php if($sub_ctgr == '') echo 'selected'?> disabled>주제 선택</option>
        <option value="past">과거</option>
        <option value="now">현재</option>
        <option value="future">미래</option>
    <?php } ?>
    <option value="etc" <?php if($sub_ctgr == 'etc') echo 'selected'?>>기타(etc)</option>
</select>
<select class="custom-select col" name="headpiece" id="headpiece">
    <option value="none_headpiece" <?php if($headpiece == '') echo 'selected'?> disabled>말머리</option>    
    <option value="disc" <?php if($headpiece == 'disc') echo 'selected'?>>토론</option>
    <option value="exp" <?php if($headpiece == 'exp') echo 'selected'?>>경험 공유</option>
    <option value="info" <?php if($headpiece == 'info') echo 'selected'?>>정보 공유</option>
    <option value="qna" <?php if($headpiece == 'qna') echo 'selected'?>>Q & A</option>
    <option value="talk" <?php if($headpiece == 'talk') echo 'selected'?>>잡담</option>
</select>

<!-- 게시물 대분류에 따른 소분류, 말머리 바꾸기-->
<script>
function itemChange() {
    var selectCtgr = $("#category").val();
    var sub;

    var sub_dev = ['<option selected disabled>분야 선택</option>', 
        '<option value="frontend">프론트엔드</option>',
        '<option value="backend">백엔드</option>',
        '<option value="ds">데이터 사이언스</option>',
        '<option value="bc">블록체인</option>',
        '<option value="embed">임베디드</option>'];
    var sub_fin = ['<option selected disabled>분류 선택</option>',
        '<option value="stock">주식</option>',
        '<option value="future">선물</option>',
        '<option value="option">옵션</option>',
        '<option value="fx">외환</option>'];
    var sub_lan = ['<option selected disabled>언어 선택</option>',
        '<option value="en">영어</option>',
        '<option value="cn">중국어</option>',
        '<option value="ru">러시아어</option>',
        '<option value="ge">독일어</option>'];
    var sub_dai = ['<option selected disabled>주제 선택</option>',
        '<option value="past">과거</option>',
        '<option value="now">현재</option>',
        '<option value="future">미래</option>'];   

    if(selectCtgr == "it_dev") {
        sub = sub_dev;        
    }
    if(selectCtgr == "finance") {
        sub = sub_fin;        
    }
    if(selectCtgr == "languages") {
        sub = sub_lan;
    }
    if(selectCtgr == "daily_life_share") {
        sub = sub_dai;
    }

    $("#sub_ctgr").empty();

    for(var i = 0; i < sub.length; i++) {        
        var sub_opt = $(sub[i]);
        $("#sub_ctgr").append(sub_opt);
    }    
}
</script>