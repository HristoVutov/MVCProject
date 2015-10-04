<?php
/**
 * Created by PhpStorm.
 * User: Hristo
* Date: 10/4/2015
* Time: 11:37
*/

$db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
$request = mysqli_query($db,"SELECT * FROM attack WHERE battled = 0");
while($row = $request->fetch_assoc()) {
    $now = date_create();
    $time = $row['journey_start_at'];
    $timeToAdd = ($row['cordinateDiffrence'] * 60);
    $time = date("Y-M-d H:i:s", strtotime($time) + $timeToAdd);
    $ng = $now->getTimestamp();
    $newNow = date("Y-M-d H:i:s", strtotime($ng) + ($ng + 3600));
    if ($newNow > $time) {
        Action::startBattle($row['idattack'], $row['attacker_id'], $row['defender_id']);
    }
}