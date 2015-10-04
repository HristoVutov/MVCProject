<?php
$db = mysqli_connect("localhost","root","1234","ant_rpg");
$barrack = mysqli_query($db,"SELECT ug.id,ug.upgrade_start_at,ug.building_id,ug.building_type_id,b.level_id FROM upgrade_building ug JOIN barrack b ON ug.building_id=b.idbarrack
        WHERE finished = 0");
$nest = mysqli_query($db,"SELECT ug.id,ug.upgrade_start_at,ug.building_id,ug.building_type_id,n.id_level FROM upgrade_building ug JOIN nest n ON ug.building_id=n.idnest WHERE finished = 0");
while($row = $barrack->fetch_assoc()){
    $now = date_create();
    $time = $row['upgrade_start_at'];
    $level = Barracks::getNextLevel($row['level_id'])->fetch_all()[0] ;
    var_dump($level);
    $timeToAdd = ($level[1]* 30);
    $time = date("Y-M-d H:i:s", strtotime($time) + $timeToAdd);
    $ng = $now->getTimestamp();
    $newNow = date("Y-M-d H:i:s", strtotime($ng) + ($ng + 3600));
    if($newNow>$time){
        mysqli_query($db,"UPDATE barrack SET level_id = '" . $level[0] . "' WHERE idbarrack = '" . $row['building_id'] ."'");
        mysqli_query($db,"UPDATE upgrade_building SET finished = 1 WHERE id = ".$row['id']);
    }
}
while($row = $nest->fetch_assoc()){
    $now = date_create();
    $time = $row['upgrade_start_at'];
    $level = Barracks::getNextLevel($row['id_level'])->fetch_all()[0] ;
    var_dump($level);
    $timeToAdd = ($level[1]* 30);
    $time = date("Y-M-d H:i:s", strtotime($time) + $timeToAdd);
    $ng = $now->getTimestamp();
    $newNow = date("Y-M-d H:i:s", strtotime($ng) + ($ng + 3600));
    if($newNow>$time){
        mysqli_query($db,"UPDATE barrack SET level_id = '" . $level[0] . "' WHERE idnest = '" . $row['building_id'] ."'");
        mysqli_query($db,"UPDATE upgrade_building SET finished = 1 WHERE id = ".$row['id']);
    }
}
