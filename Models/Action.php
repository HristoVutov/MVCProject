<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 10/2/2015
 * Time: 23:38
 */

namespace MVCProject\Models;


class Action
{
    public static function scoutEnemy(){

    }

    public static function sendArmy($x,$y,$ants){
        $xCord = Nest::getNestCords($_SESSION['nestid']);
        $diff = abs($x - $xCord);
        $defenderId = User::getUserByMapCords($x,$y)[0][0];
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        mysqli_query($db,"INSERT INTO attack (attacker_id,defender_id,cordinateDiffrence) VALUES ('" . $_SESSION['id'] ."','" . $defenderId . "','" . $diff . "')");
        $request = mysqli_query($db,"SELECT * FROM attack Where attacker_id = " . $_SESSION['id'] . " order by idattack desc Limit 1");
        $battleId = $request->fetch_all()[0][0];
        for($i = 0; $i<2; $i++){
            if(empty($ants[$i])){
                continue;
            }
            mysqli_query($db,"INSERT INTO troops_for_battle (ant_id,quantity,battleid) VALUES ('" . ($i+1) ."','" . $ants[$i] . "','" . $battleId . "')");
            Ants::updateAnts($i+1,$ants[$i]);
        }

    }

    public static function checkForTroopReturn(){

    }

    public static function returnArmy($battleID){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $request = mysqli_query($db,"SELECT * FROM attack WHERE idattack = ".$battleID)->fetch_all()[0][4];
        $requestTroops = mysqli_query($db,"SELECT * FROM troops_for_battle WHERE battleid = ".$battleID);
        while($row = $requestTroops->fetch_assoc()){
            mysqli_query($db,"INSERT INTO return_troops (tfb_id,distance) VALUES ('" . $row['id'] . "','" . $request . "')");
        }

    }



    public static function startBattle($battleId,$attackerId,$defenderId){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $attackerRequest = mysqli_query($db, "SELECT tfb.quantity,a.ant_id,a.attack FROM troops_for_battle tfb
      	JOIN ant a
	    	ON tfb.ant_id=a.ant_id
        WHERE tfb.battleid = " .$battleId);
        $defenderRequest = mysqli_query($db, "SELECT ua.quantity,a.attack,a.ant_id FROM user_ants ua JOIN ant a ON ua.ant_id=a.ant_id
        WHERE user_id = " .$defenderId);
        $attackerATT = 0;
        while($row = $attackerRequest->fetch_assoc()) {
            $attackerATT = $attackerATT + ($row['quantity'] * $row['attack']);
        }
        $defendATT = 0;
        $attacker = User::getUserById($attackerId)['username'];
        $defender = User::getUserById($defenderId)['username'];
        while($row = $defenderRequest->fetch_assoc()) {
            $defendATT = $defendATT + ($row['quantity'] * $row['attack']);
        }
        if($attackerATT>$defendATT){
            $diff = $defendATT;
            $attackerAnts = Ants::getAntsByUserId($attackerId);
            for($i = 0; $i < 2 ;$i++){
                if($i==count($attackerAnts)-1){
                    $attackerAnts[$i] = $attackerAnts[$i]-$diff;

                }
                else if($diff>$attackerAnts[$i]){
                    $diff = $diff-$attackerAnts[$i];
                    $attackerAnts[$i] = 0;
                }
               Ants::updateTroops($i+1,$attackerAnts[$i],$battleId);
            }

            BattleReport::sendReport($attackerId,"You have won the attack versus player " .$defender . " and lost ". $defendATT . " troops" ,$defendATT);
           BattleReport::sendReport($defenderId,"You lost defence versus " . $attacker . " and lost ". $defendATT . " troops" ,$defendATT);
            Action::returnArmy($battleId);
          Ants::UpdateAntsToZero($defenderId);

        }
        elseif($attackerATT==$defendATT){
            BattleReport::sendReport($attackerId,"Draw you lost all your troops versus ".$defender,$defendATT);
            BattleReport::sendReport($attackerId,"Draw you lost all your troops versus ".$attacker,$defendATT);
            Ants::UpdateAntsToZero($defenderId);
        }
        else{
            $diff = $attackerATT;
            $defenderAnts = Ants::getAntsByUserId($defenderId);
            for($i = 0; $i < 2 ;$i++){
                if($i==count($defenderAnts)-1){
                    $defenderAnts[$i] = $defenderAnts[$i]-$diff;

                }
                else if($diff>$defenderAnts[$i]){
                    $diff = $diff-$defenderAnts[$i];
                    $defenderAnts[$i] = 0;
                }
               Ants::updateAntsTo($i+1,$defenderAnts[$i],$defenderId);
            }

            BattleReport::sendReport($defenderId,"You have won the defence versus player " .$attacker . " and lost ". $attackerATT . " troops" ,$attackerATT);
            BattleReport::sendReport($attackerId,"You lost the attack versus " . $defender . " and lost ". $attackerATT . " troops" ,$attackerATT);

        }
        mysqli_query($db,"UPDATE attack SET battled=1 WHERE idattack=".$battleId);


    }
}