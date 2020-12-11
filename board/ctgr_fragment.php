
    <select class="custom-select col-8 mr-2 p-0" name="category" id="category" <?php if(isset($_GET['num'])) echo 'disabled';?>>
        <?php
        if(isset($_POST['category'])){ // 글 읽기 상태에서 글쓰기 누른 경우. 읽던 글의 카테고리 선택하게 함
            $category = $_POST['category'];
        ?>
        <script>console.log('post ctgr');</script>
        <option value="none_category">게시판 분류</option> <!-- 마이페이지 내가 쓴 글 목록에서 글쓰기 누른 경우는 이게 초기값으로 지정됨(해당되는 카테고리가 없기 때문)-->
        <option disabled>- IT 개발 -</option>
        <?php
        if($role == "ADMIN") {
        ?>
        <!-- <option <?php if($category == 'it_dev_learnings') echo 'selected'?> value="it_dev_learnings">학습 내용</option>
        <option <?php if($category == 'it_dev_usefulinfo') echo 'selected'?> value="it_dev_usefulinfo">유용한 정보</option> -->
        <?php }?>
        <option <?php if($category == 'it_dev_discussion') echo 'selected'?> value="it_dev_discussion">토론</option>
        <option <?php if($category == 'it_dev_recordshare') echo 'selected'?> value="it_dev_recordshare">경험 공유</option>
        <option <?php if($category == 'it_dev_infoshare') echo 'selected'?> value="it_dev_infoshare">정보 공유</option>
        <option <?php if($category == 'it_dev_qna') echo 'selected'?> value="it_dev_qna">Q & A</option>
        <option disabled></option>
        <option disabled>- 금융 -</option>
        <?php
        if($role == "ADMIN") {
        ?>
        <!-- <option <?php if($category == 'finance_usefulinfo') echo 'selected'?> value="finance_usefulinfo">유용한 정보</option> -->
        <?php }?>
        <option <?php if($category == 'finance_discussion') echo 'selected'?> value="finance_discussion">토론</option>
        <option <?php if($category == 'finance_recordshare') echo 'selected'?> value="finance_recordshare">거래 기록 공유</option>
        <option <?php if($category == 'finance_infoshare') echo 'selected'?> value="finance_infoshare">정보 공유</option>
        <option <?php if($category == 'finance_qna') echo 'selected'?> value="finance_qna">Q & A</option>
        <option disabled></option>
        <option disabled>- 언어 학습 -</option>
        <?php
        if($role == "ADMIN") {
        ?>
        <!-- <option <?php if($category == 'languages_usefuldata') echo 'selected'?> value="languages_usefuldata">학습 자료</option>         -->
        <?php }?>
        <option <?php if($category == 'languages_discussion') echo 'selected'?> value="languages_discussion">토론</option>
        <option <?php if($category == 'languages_recordshare') echo 'selected'?> value="languages_recordshare">학습 기록</option>
        <option <?php if($category == 'languages_infoshare') echo 'selected'?> value="languages_infoshare">정보 공유</option>
        <option <?php if($category == 'languages_qna') echo 'selected'?> value="languages_qna">Q & A</option>
        <option disabled></option>
        <option disabled>- 일상 -</option>
        <?php
        if($role == "ADMIN") {
        ?>
        <!-- <option <?php if($category == 'daily_life') echo 'selected'?> value="daily_life">일상 기록</option> -->
        <?php }?>
        <option <?php if($category == 'daily_life_share') echo 'selected'?> value="daily_life_share">자유 주제 글</option>

        <?php                                                                
        } else if(isset($_GET['num'])) { // 글 읽기 상태에서 답글 누른 경우. 읽던 글의 카테고리 선택 후 고정되게 함            
        ?>
        <!-- <option selected value="<?=$category?>"><?=$category?></option> -->
        <script>console.log('get num');</script>
        <?php
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
        echo '<script>console.log("'.$category.'");</script>';
            switch ($category){
                case 'it_dev_discussion': 
        ?>            
            <option value="it_dev_discussion" selected>IT - 토론</option>
        <?php
                break;                                                                    
                case 'it_dev_recordshare': 
        ?>
            <option selected value="it_dev_recordshare">IT - 경험 공유</option>
        <?php
                break;
                case 'it_dev_infoshare': 
        ?>
            <option selected value="it_dev_infoshare">IT - 정보 공유</option>
        <?php
                break;
                case 'it_dev_qna': 
        ?>
            <option selected value="it_dev_qna">IT - Q & A</option>
        <?php
                break;                

                case 'finance_discussion': 
        ?>
            <option selected value="finance_discussion">금융 - 토론</option>
        <?php
                break;                                                                    
                case 'finance_recordshare': 
        ?>
            <option selected value="finance_recordshare">금융 - 경험 공유</option>
        <?php
                break;
                case 'finance_infoshare': 
        ?>
            <option selected value="finance_infoshare">금융 - 정보 공유</option>
        <?php
                break;
                case 'finance_qna': 
        ?>
            <option selected value="finance_qna">금융 - Q & A</option>
        <?php
                break;

                case 'languages_discussion': 
        ?>
            <option selected value="languages_discussion">언어 학습 - 토론</option>
        <?php
                break;                                                                    
                case 'languages_recordshare': 
        ?>
            <option selected value="languages_recordshare">언어 학습 - 경험 공유</option>
        <?php
                break;
                case 'languages_infoshare': 
        ?>
            <option selected value="languages_infoshare">언어 학습 - 정보 공유</option>
        <?php
                break;
                case 'languages_qna': 
        ?>
            <option selected value="languages_qna">언어 학습 - Q & A</option>
        <?php
                break;

                case 'daily_life_share': 
        ?>
            <option selected value="daily_life_share">자유 주제 글</option>
        <?php
                break;

                default : break;
            }
        ?>                                                                
        <?php
        } 
        // else { // 그 외 경우. ex) 마이페이지 내가 쓴 글 목록에서 글쓰기 누른 경우 등
        ?>
        <!-- // <option selected>게시판 분류</option>
        // <option disabled>- IT 개발 -</option>
        // <option value="it_dev_learnings">IT - 학습 내용</option>
        // <option value="it_dev_usefulinfo">IT - 유용한 정보</option>
        // <option value="it_dev_discussion">IT - 토론</option>
        // <option value="it_dev_recordshare">IT - 경험 공유</option>
        // <option value="it_dev_infoshare">IT - 정보 공유</option>
        // <option value="it_dev_qna">IT - Q & A</option>
        // <option disabled></option>
        // <option disabled>- 금융 -</option>
        // <option value="finance_usefulinfo">금융 - 유용한 정보</option>
        // <option value="finance_discussion">금융 - 토론</option>
        // <option value="finance_recordshare">금융 - 경험 공유</option>
        // <option value="finance_infoshare">금융 - 정보 공유</option>
        // <option value="finance_qna">금융 - Q & A</option>
        // <option disabled></option>
        // <option disabled>- 언어 학습 -</option>
        // <option value="languages_usefuldata">언어 학습 - 학습 자료</option>
        // <option value="languages_discussion">언어 학습 - 토론</option>
        // <option value="languages_recordshare">언어 학습 - 경험 공유</option>
        // <option value="languages_infoshare">언어 학습 - 정보 공유</option>
        // <option value="languages_qna">언어 학습 - Q & A</option>
        // <option disabled></option>
        // <option disabled>- 일상 -</option>
        // <option value="daily_life">일상 기록</option>
        // <option value="daily_life_share">자유 주제 글</option>         -->
        <?php
        // }
        ?>
    </select>
    <select class="custom-select col p-0" name="headpiece" <?php if(isset($_GET['num'])) echo 'disabled';?>>
        <option selected>말머리</option>
        <!-- <option value="1">One</option>
        <option value="2">Two</option>
        <option value="3">Three</option> -->
    </select>