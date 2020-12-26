<?php
if(basename($_SERVER['PHP_SELF']) == "index.php"){
    include_once "db_con.php";
} else {
    include_once "../db_con.php";
}

for($i=0; $i<5; $i++){
    if(isset($_COOKIE["recenttitle_".$i])) {
        $cookie = $_COOKIE["recenttitle_".$i];
        // echo "쿠키 출력 : ".$cookie;
    }
}
?>

<div class="container">
    <div class="row">						

    </div>    
    <div class="row pt-5">
        <!-- 최근 게시물 5개 / 최고 조회수 TOP5 게시물 -->
        <table class="table col-6">
            <thead>
                <tr>                        
                    <th scope="col" class="text-center text-white">댓글수 TOP5 게시물</th>                        
                </tr>
            </thead>
            <tbody>
            <?php
            $sql = mq("SELECT * FROM board WHERE rep_num>=1 UNION SELECT * FROM board_ahn WHERE rep_num>=1 ORDER BY rep_num DESC LIMIT 5");
            while($board = $sql->fetch_array()) {
                include "headpiece.php";
                $title=$board["title"];
                /* 글자수가 60이 넘으면 ... 처리해주기 */
                if(strlen($title)>50){
                    $title=str_replace($board["title"],mb_substr($board["title"],0,50,"utf-8")."...",$board["title"]);
                }
            ?>
                <tr><td>
                <a class="text-white" href="./read.php?num=<?=$board['num']?>">[<?=$headpiece?>] <?=$title?></a>
                </td></tr>
            <?php } ?>
            </tbody>
        </table>        
        <table class="table col-6">
            <thead>
                <tr>                       
                    <th scope="col" class="text-center text-white">조회수 TOP5 게시물</th>                        
                </tr>
            </thead>
            <tbody>
            
            <?php
            $sql2 = mq("SELECT * FROM board UNION SELECT * FROM board_ahn ORDER BY views DESC LIMIT 5");
            
            while($board = $sql2->fetch_array()) {
                include "headpiece.php";
                $title=$board["title"];
                /* 글자수가 60이 넘으면 ... 처리해주기 */
                if(strlen($title)>50){
                    $title=str_replace($board["title"],mb_substr($board["title"],0,50,"utf-8")."...",$board["title"]);
                }            
            ?>
                <tr><td>
                <a class="text-white" href="./read.php?num=<?=$board['num']?>">[<?=$headpiece?>] <?=$title?></a>
                </td></tr>
            <?php } ?>
                            
            </tbody>
        </table>

        <div class="col-12">            

            <!-- Contact -->
                <section class="contact">
                    <header>
                        <h3>Contact</h3>
                    </header>                                        
                    <p>seah.ahn.nt@gmail.com</p>
                </section>

            <!-- Copyright -->
                <div class="copyright">
                    <ul class="menu">
                        <!-- <li><a href="#">Sitemap</a></li> -->
                        <li>&copy; Salon de Ahn. All rights reserved.</li>
                        <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
                    </ul>
                </div>

        </div>

    </div>
</div>