<!-- <?php
include_once "../util/config.php";
include_once "../db_con.php";
include_once "../s3.php";

$start = $_POST['start'];
$list = $_POST['list'];

// S3 객체를 생성하여 버킷과 파일 경로 저장 및 불러오기에 필요한 URL을 가져옴
$s3 = new aws_s3;
$bucket = $s3->bucket;
$url = $s3->url;

$q = mq("SELECT * FROM photosave WHERE num>0 AND folder='".$folder."' ORDER BY num DESC LIMIT {$start}, {$list}");
if(mysqli_num_rows($q) != 0) {
    $row = mysqli_num_rows($q); // 해당 사진첩의 사진 총 갯수 불러오기
} else {
    $row = 0;
}

if($row != 0) {
    while($p = mysqli_fetch_array($q)){
?>
    var del_btn = $('#fileAdd').clone();
    del_btn.attr('id', '<?=$p['num']?>._del');
    del_btn.attr('class', 'btn del_photo');
    del_btn.text('X')
    del_btn.css({'z-index': '1',
            'position': 'absolute',
            'top': '1px',
            'right': '1px',
            'font-size': '2rem'});

    var photo = $('#sample').clone();
    photo.attr('id', '<?=$p['num']?>');
    photo.attr('class', '');
    photo.css('display', 'block');
    photo.children('img').attr('alt', '<?=$p['title']?>');
    photo.children('img').attr('src', '<?=$url.$p['filepath']?>');
    photo.children('div').children('h3').text('<?=$p['caption']?>');
    photo.append(del_btn);
    $('#thumbnails').append(photo);
<?php
    }					
    $start += $list;					
}				
echo $start;
?> -->