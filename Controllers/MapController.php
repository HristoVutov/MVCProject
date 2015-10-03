<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/2/2015
 * Time: 20:37
 */

namespace MVCProject\Controllers;

use MVCProject\View;
use MVCProject\Models\Map;
use MVCProject\Models\User;
use MVCProject\ViewModels\MapProfileViewModel;

class MapController
{
    public static function map(){
        $map = Map::getMap()->fetch_all();
        View::$data['map'] = $map;
        $model = null;
        return new View($model);
    }

    public static function profile($x,$y){
        $us = User::getUserById($_SESSION['id']);
        View::$data['user'] = $us;

        if(isset($_POST['agrresion_type'])){
            $agrresionType = $_POST['agrresion_type'];
            if($agrresionType=='Scout'&&isset($_POST['numberOfScouts'])){
                $scouts = $_POST['numberOfScouts'];
                var_dump($scouts);
            }elseif($agrresionType=='Attack'&&isset($_POST['numberOfAnt'],$_POST['numberOfBullAnt'])){
                $ants = $_POST['numberOfAnt'];
                $bull = $_POST['numberOfBullAnt'];
            }

        }

        $model = null;
        return new View($model);
    }
}