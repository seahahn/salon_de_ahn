<?php 
include_once "../db_con.php";

$start = $_POST['start'];
$list = $_POST['list'];

$q = mq("SELECT * FROM photofolder WHERE num>0 ORDER BY num DESC LIMIT {$start}, {$list}");
while($f = mysqli_fetch_array($q)){
?>
    <article class="location-listing">
        <a class="location-title" href="test.php"><?=$f['title']?></a>
        <div class="location-image">
            <a href="test.php">
                <img width="300" height="169" src="<?=$f['thumb']?>" alt="<?=$f['title']?>">
            </a>
        </div>
    </article>
<?php
}
?>