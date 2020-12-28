<?php
include_once "../db_con.php"; 
?>

<?php
    $bno = $_GET['num']; // $bno num값을 받아와 넣음

    /* 받아온 num값의 행 정보를 가져옴 */
    $sql = mq("SELECT * FROM board WHERE num='".$bno."' "); 
    $board = $sql->fetch_array();
?>
<!-- DB의 비밀번호($bpw)와 모달창의 비밀번호($pwk)를 비교 -->
<?php
    $bpw = $board['pw'];

    if(isset($_POST['pw_chk'])) {
        $pwk = $_POST['pw_chk']; 
        if(password_verify($pwk,$bpw)) {
            $pwk == $bpw;
?>
    <!-- pwk와 bpw값이 같으면 read.php로 보내고 -->
    <script>
        location.replace("read.php?num=<?=$board["num"] ?>");
    </script>
        <?php 
        }else{ 
        ?>
    <!--- 아니면 비밀번호가 틀리다는 메시지를 보여줌 -->
    <script>
        alert('비밀번호가 틀립니다');        
    </script>
    <?php 
        } 
    } 
    ?>