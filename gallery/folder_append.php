<?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";

$s3 = new aws_s3;
$bucket = $s3->bucket;
$url = $s3->url;

$start = $_POST['start'];
$list = $_POST['list'];

$q = mq("SELECT * FROM photofolder WHERE num>0 ORDER BY rcday DESC LIMIT {$start}, {$list}");
while($f = mysqli_fetch_array($q)){
?>
    <article class="location-listing">
        <form name="gotophotos_<?=$f['title_key']?>" action="photos.php" method="POST">
            <input type="hidden" name="folder" value="<?=$f['title_key']?>">
        </form>
        <!-- <a class="location-title" href="photos.php?folder=<?=$f['title']?>"><?=$f['title']?></a> -->
        <a class="location-title text-center" href="javascript:document.gotophotos_<?=$f['title_key']?>.submit();"><?=$f['title']?></a>
        <div class="location-image h-100" data-num="<?=$f['num']?>" data-title="<?=$f['title']?>" data-day="<?=$f['rcday']?>" data-cap="<?=$f['caption']?>" data-thumb="<?=$f['thumb']?>">
            <a style="vertical-align:middle;" href="javascript:document.gotophotos_<?=$f['title_key']?>.submit();">
                <img src="<?=$url.$f['thumb']?>" alt="<?=$f['title']?>" style="height: 100%;
                width: 100%;
                object-fit: cover;">
            </a>
            <?php if($role == 'ADMIN') {
            echo '<button class="btn del_album" style="z-index: 1;
            position: absolute;
            top: 0;
            right: 0;
            font-size: 2rem;">X</button>
            <button class="btn edit_album" style="z-index: 1;
            position: absolute;
            top: 0;
            left: 0;
            font-size: 2rem;">수정</button>';
            } ?>
        </div>        
    </article>
<?php
}
?>
<script>
    /* 사진첩 삭제 이벤트 */
    $(".del_album").click(function(){        
        num = $(this).parent().data("num");
        $("#album_no_del").attr("value", num);
        $("#album_modal_del").modal();
    });

    /* 사진첩 수정 이벤트 */
    $(".edit_album").click(function(){
        num = $(this).parent().data("num");
        title = $(this).parent().data("title");
        day = $(this).parent().data("day");
        cap = $(this).parent().data("cap");
        thumb = $(this).parent().data("thumb");
        $("#album_no_edit").attr("value", num);
        $("#title_edit").attr("value", title);
        $("#rcday_edit").attr("value", day);
        $("#caption_edit").attr("value", cap);
        $("#thumb_edit").attr("value", thumb);
        $("#album_modal_edit").modal();
    });
</script>