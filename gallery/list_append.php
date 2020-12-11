<?php 
include_once "../db_con.php";

$start = $_POST['start'];
$list = $_POST['list'];

$q = mq("SELECT * FROM photosave WHERE num>0 ORDER BY num DESC LIMIT {$start}, {$list}");
while($d = mysqli_fetch_array($q)){
?>
    <article>
        <a class="thumbnail" href="<?php echo $d['filepath']; ?>"><img src="<?php echo $d['filepath']; ?>" alt="" /></a>
        <!-- <h2><?php echo $d['title']; ?></h2>
        <p><?php echo $d['caption']; ?></p> -->
    </article>
<?php
}
?>