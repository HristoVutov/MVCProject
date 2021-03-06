<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/2/2015
 * Time: 12:36
 */

namespace MVCProject\Models;


class Nest
{


    //$db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
    //$result = mysqli_query($db, "SELECT * FROM user WHERE username = '" . $user ."'");

    public static function createNest($mapId){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        mysqli_query($db, "INSERT INTO nest (id_owner,id_level,map_id) VALUES (" . $_SESSION['id']. ",42," . $mapId . ")");
        mysqli_close($db);
    }

    public static function getUserNests($userId){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "SELECT idnest FROM nest WHERE id_owner = ".$userId);
        $nests = [];
        while($row = $result->fetch_assoc()){
            array_push($nests,$row['idnest']);
        }
        return $nests;
    }
    public static function getNestsLevelID($nestId){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "SELECT * FROM nest WHERE idnest = ".$nestId);
        return $result->fetch_all()[0];
    }
    public static function getNestCords($nestId){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "SELECT m.x FROM nest n JOIN map m ON n.map_id=m.map_id WHERE n.idnest =".$nestId);
        return $result->fetch_all()[0][0];
    }


}