<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/4/2015
 * Time: 11:37
 */

$db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
$request = mysqli_query($db,"SELECT rt.id,rt.return_start,rt.distance,rt.return_to,tfb.ant_id,tfb.quantity FROM return_troops rt JOIN troops_for_battle tfb ON rt.tfb_id=tfb.id
 WHERE returned = 0");
while($row = $request->fetch_assoc()) {
    $now = date_create();
    $time = $row['return_start'];
    $timeToAdd = ($row['distance'] * 60);
    $time = date("Y-M-d H:i:s", strtotime($time) + $timeToAdd);
    $ng = $now->getTimestamp();
    $newNow = date("Y-M-d H:i:s", strtotime($ng) + ($ng + 3600));
    if ($newNow > $time) {
        Ants::updateAntsPlus($row['ant_id'],$row['quantity'],$row['return_to']);
        mysqli_query($db,"UPDATE return_troops SET returned = 1 WHERE id=" . $row['id'] );
    }
}