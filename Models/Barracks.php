<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/2/2015
 * Time: 14:55
 */

namespace MVCProject\Models;


class Barracks
{
    //$db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
    //$result = mysqli_query($db, "SELECT * FROM user WHERE username = '" . $user ."'");

    public static function getBarracks($nestId){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "SELECT * FROM barrack where nest_id = " . $nestId);
        return $result;
    }

    public static function createBarracks($nestId){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        mysqli_query($db, "INSERT INTO barrack (nest_id,level_id) VALUES ('" . $nestId . "','41')");
    }

    public static function upgradeBarracks($barrackId,$level){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $request = mysqli_query($db, "SELECT * FROM levels WHERE level_to_id = 1 AND level = " . $level);
        $level_id = $request->fetch_all()[0];
        var_dump($level_id);
        mysqli_query($db,"UPDATE barrack SET level_id = '" . $level_id[0] . "' WHERE idbarrack = '" . $barrackId[0] ."'");
        User::updateResourceWaterAndFood($level_id[4],$level_id[3]);
    }

    public static function getNextLevel($level){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $request = mysqli_query($db, "SELECT * FROM levels WHERE id = " . $level);
        $result = mysqli_query($db, "SELECT * FROM levels Join building_level_id bli
         ON levels.level_to_id = bli.building_id WHERE building_name = 'Barrack'
         AND level = " . ($request->fetch_all()[0][2]+1));
        return $result;
    }




}