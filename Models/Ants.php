<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/2/2015
 * Time: 19:43
 */

namespace MVCProject\Models;


class Ants
{
    //"localhost", "root", "1234", "ant_rpg"
    //"localhost","antwarsc_antwars","c8ev6mfMK8vy","antwarsc_antwar"

    public static function getAnts(){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $request = mysqli_query($db, "SELECT * FROM ant");
        return $request;
    }
    public static function getAntByName($antName){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $request = mysqli_query($db, "SELECT * FROM ant WHERE name = '" . $antName . "'");
        return $request;
    }

    public static function tryTrain($ant,$quantity){
        $user = User::getUserById($_SESSION['id']);
        $water = $user["water_resource"] - ($ant[4]*$quantity);
        $food = $user['food_resource'] - ($ant[3]*$quantity);


        if($food<0||$water<0){
            throw new \Exception('Not enough resources');
        }else{
            User::updateResourceWaterAndFood($ant[4]*$quantity,$ant[3]*$quantity);
        }
    }

    public static function trainAnts($ants){
        while(!empty($ants)){
            $name = key($ants);
            $shift = array_shift($ants);
            if(empty($shift)){
                continue;
            }

            $ant = Ants::getAntByName($name)->fetch_all()[0];
            Ants::tryTrain($ant,$shift);
            $userID = User::getUserById($_SESSION['id'])['iduser'];
            $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
            $result = mysqli_query($db, "INSERT INTO train_ants (ant_id,user_id,quantity,trained) VALUES ('" . $ant[0] . "','" . $userID . "','" . $shift . "',0)");

        }
    }

    public static function checkForTrainedAnts(){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $request = mysqli_query($db, "SELECT ta.id,ta.quantity,a.ant_id,a.time_to_create_in_int,ta.user_id,ta.train_started_at,ta.trained FROM train_ants ta JOIN ant a ON ta.ant_id=a.ant_id WHERE ta.trained=0");
        $result = $request->fetch_all();
        $now = date_create();
        foreach($result as $train){
            $time = $train[5];
            $timeToAdd = $train[1]*$train[3];
            $time = date( "Y-M-d H:i:s", strtotime( $time ) + $timeToAdd );
            $ng = $now->getTimestamp();
            $newNow = date( "Y-M-d H:i:s",strtotime($ng)+ ($ng+3600) );
            $ants = mysqli_query($db,"Select * FROM user_ants where user_id=".$train[4] . " LIMIT 1 ")->fetch_all()[0];

            $antsToAdd = $ants[3]+$train[1];
            $trainId = $ants[0];
            $isEmpty = empty(array_shift($ants));
            if($newNow>$time){

                if($isEmpty){
                    var_dump(3);
                    mysqli_query($db,"UPDATE train_ants SET trained=1 WHERE id =".$train[0]);
                    mysqli_query($db,"INSERT INTO user_ants (user_id,ant_id,quantity) VALUES ('" . $train[4] . "','" .$train[2] . "','" . $train[1] . "')");
                }else{
                    var_dump($antsToAdd);
                    mysqli_query($db,"UPDATE train_ants SET trained=1 WHERE id =".$train[0]);
                    mysqli_query($db,"UPDATE user_ants SET quantity=" . $antsToAdd . " WHERE id =".$trainId);
                }
            }else{

            }

        }

    }
}