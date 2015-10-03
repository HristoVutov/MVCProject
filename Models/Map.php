<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/2/2015
 * Time: 11:35
 */

namespace MVCProject\Models;
use MVCProject\Models\Nest;

class Map
{

    //$db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
    //$result = mysqli_query($db, "SELECT * FROM user WHERE username = '" . $user ."'");

    public static function getMap(){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "SELECT * FROM map");
        mysqli_close($db);
        return $result;
    }

    public static function seedMap(){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        for($i = 0; $i < 10; $i++){
            for($j = 0; $j < 10; $j++){
                mysqli_query($db, "INSERT INTO map (x,y,ocuppied,ocuppied_by) VALUES (" . $i . "," . $j . ",0,null)");
            }
        }
       mysqli_close($db);
    }

    public static function assignMap(){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        for($i = 0; $i < 2; $i++) {
            $result = mysqli_query($db, "SELECT * FROM map WHERE ocuppied = 0");
            $rows = $result->fetch_all();
            $idToAssign = rand(0, count($rows));
            $update = mysqli_query($db, "UPDATE map SET ocuppied=1,ocuppied_by='" . $_SESSION['id'] . "' WHERE map_id='" . $rows[$idToAssign][0] . "'");
            Nest::createNest($rows[$idToAssign][0]);
            mysqli_close($db);
        }
    }
}