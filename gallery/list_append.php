<?php 
include_once "../db_con.php";

$start = $_POST['start'];
$list = $_POST['list'];

$q = mq("SELECT * FROM photosave WHERE num>0 ORDER BY num DESC LIMIT {$start}, {$list}");
while($p = mysqli_fetch_array($q)){
?>    
    <li>        
        <div data-alt="<?=$p['title']?>" data-description="<h3><?=$p['caption']?></h3>" data-max-width="1800" data-max-height="1350">								
            <div data-src="<?=$p['filepath']?>" data-min-width="200"></div>
        </div>
    </li>
<?php
}
?>