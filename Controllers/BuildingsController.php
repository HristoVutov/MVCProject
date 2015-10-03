<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/2/2015
 * Time: 14:48
 */

namespace MVCProject\Controllers;
use MVCProject\Models\Ants;
use MVCProject\Models\Barracks;
use MVCProject\View;
use MVCProject\Models\User;
use MVCProject\Models\Nest;

class BuildingsController extends BaseController
{
    public static function barrack(){


        $us = User::getUserById($_SESSION['id']);
        $nests = Nest::getUserNests($_SESSION['id']);
        $us['nests'] = $nests;
        View::$data['user'] = $us;
        if(empty($_SESSION['nestid'])){
            $_SESSION['nestid'] = $nests[0];
        }
        $barrack = Barracks::getBarracks($_SESSION['nestid'])->fetch_all();
        $isBuilded = empty($barrack);

        if(!$isBuilded) {


            $barrackNextLevel = Barracks::getNextLevel($barrack[0][2])->fetch_all();

            $upgradeWater = $barrackNextLevel[0][3];
            $upgradeFood = $barrackNextLevel[0][4];
            $upgradeLevelTo = $barrackNextLevel[0][2];

            View::$data["upgrade"]["water"] = $upgradeWater;
            View::$data["upgrade"]["food"] = $upgradeFood;
            View::$data["upgrade"]["levelto"] = $upgradeLevelTo;

            View::$data["ants"] = Ants::getAnts()->fetch_all();

            if(isset($_POST['Upgrade'])){
                Barracks::upgradeBarracks($barrack[0],$upgradeLevelTo);
                header("Location: /MVCProject/buildings/barrack");
                exit;
            }
        }
        $barracksData = [];

        array_push($barracksData,$isBuilded);
        View::$data['barracks'] = $barracksData;

        if(isset($_POST['nest_change'])){
           $_SESSION['nestid'] = $_POST['select_nest'];
            header("Location: /MVCProject/buildings/barrack");
            exit;
        }

        ////

        if(isset($_POST['Create'])){
            Barracks::createBarracks($_SESSION['nestid']);
            header("Location: /MVCProject/buildings/barrack");
            exit;
        }

        /////

        if(isset($_POST['Train'])){
            $bull = $_POST['bull_ant'];
            $ant = $_POST['ant'];
            $ants = [];
            $ants["bull_ant"] = $bull;
            $ants["ant"] = $ant;
            Ants::trainAnts($ants);

        }

        Ants::checkForTrainedAnts();
        var_dump($_SESSION['nestid']);
        $model = null;
        return new View($model);
    }

    public static function nest(){

    }


    function onInit()
    {

    }
}