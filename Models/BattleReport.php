<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/3/2015
 * Time: 17:12
 */

namespace MVCProject\Models;


class BattleReport
{
    public static function sendReport($userID,$massage,$lostTroops){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $request = mysqli_query($db,"INSERT INTO report (user_id,massage,lost_troops) VALUES ('" . $userID . "','" . $massage . "','" . $lostTroops . "')");
    }

    public static function getBattles(){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $request = mysqli_query($db,"SELECT u.username,a.journey_start_at,a.cordinateDiffrence FROM attack a JOIN user u on a.defender_id = u.iduser WHERE battled = 0 AND a.attacker_id = ".$_SESSION['id'])->fetch_all();
        $arr = [];
//        while($row = $request->fetch_assoc()){
//            $time = $row['journey_start_at'];
//            $timeToAdd = ($row['cordinateDiffrence'] * 60);
//            $time = date("Y-M-d H:i:s", strtotime($time) + $timeToAdd);
//            $arr[$row['username']] = $time;
//
//        }
        for($i = 0;$i <count($request);$i++){
            $time = $request[$i][1];
            $timeToAdd = ($request[$i][2] * 60);
            $time = date("Y-M-d H:i:s", strtotime($time) + $timeToAdd);
            $message = "You have battle versus ".$request[$i][0] . " at " . $time;
            array_push($arr,$message);
        }


        return $arr;
    }
}