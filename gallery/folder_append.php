<?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";

$s3 = new aws_s3;
$bucket = $s3->bucket;
$url = $s3->url;

$start = $_POST['start'];
$list = $_POST['list'];

$q = mq("SELECT * FROM photofolder WHERE num>0 ORDER BY num DESC LIMIT {$start}, {$list}");
while($f = mysqli_fetch_array($q)){
?>
    <article class="location-listing">
        <form name="gotophotos_<?=$f['title']?>" action="photos.php" method="POST">
            <input type="hidden" name="folder" value="<?=$f['title']?>">
        </form>
        <!-- <a class="location-title" href="photos.php?folder=<?=$f['title']?>"><?=$f['title']?></a> -->
        <a class="location-title" href="javascript:document.gotophotos__<?=$f['title']?>.submit();"><?=$f['title']?></a>
        <div class="location-image" data-num="<?=$f['num']?>">
            <a href="javascript:document.gotophotos.submit();">
                <img width="300" height="169" src="<?=$url.$f['thumb']?>" alt="<?=$f['title']?>">
            </a>
            <?php if($role == 'ADMIN') {
            echo '<button class="btn del_album" style="z-index: 1;
            position: absolute;
            top: 0px;
            right: 0px;
            font-size: 2rem;">X</button>';
            } ?>
        </div>        
    </article>
<?php
}
?>
<script>
    /* 사진첩 삭제 이벤트 */
    $(".del_album").click(function(){
        console.log('작동 확인');
            num = $(this).parent().data("num");
            $("#album_no").attr("value", num);
            $("#album_modal_del").modal();
        });
</script>