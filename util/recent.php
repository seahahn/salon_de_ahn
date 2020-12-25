<?php
$recent = $_POST['recent_'];
$recenthp = $_POST['recenthp_'];
$recenttitle = $_POST['recenttitle_'];

//최근 게시물 목록에 지금 보는 게시물 집어넣기    
$count = 0;
$recent = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$recenthp = $board['headpiece'];
$recenttitle = $board['title'];
for($i=5; $i>0; $i--){        
    if(!isset($_COOKIE['recent_'.$i])) {                        
        setcookie("recent_".$i, $recent, time() + 60 * 60 * 24);
        setcookie("recenthp_".$i, $recenthp, time() + 60 * 60 * 24);           
        setcookie("recenttitle_".$i, $recenttitle, time() + 60 * 60 * 24);                
        if($i<5) {
            $i_ = $i+1;
            if($_COOKIE['recent_'.$i_] == $_COOKIE['recent_'.$i]) {
                setcookie("recent_".$i, $recent, time() -1);
                setcookie("recenthp_".$i, $recenthp, time() -1);           
                setcookie("recenttitle_".$i, $recenttitle, time() -1);    
            }
        }
        break;
    }
    $count++;
}

if($count == 5) {        
    for($i=1; $i<5; $i++){
        $num = $i+1;
        $curl = $_COOKIE["recent_".$num];
        $chp = $_COOKIE["recenthp_".$num];
        $ctitle = $_COOKIE["recenttitle_".$num];            
        setcookie("recent_".$i, $curl, time() + 60 * 60 * 24);
        setcookie("recenthp_".$i, $chp, time() + 60 * 60 * 24);           
        setcookie("recenttitle_".$i, $ctitle, time() + 60 * 60 * 24);
    }
    setcookie("recent_".$count, $recent, time() + 60 * 60 * 24);
    setcookie("recenthp_".$i, $recenthp, time() + 60 * 60 * 24);           
    setcookie("recenttitle_".$count, $recenttitle, time() + 60 * 60 * 24);
}

?>
