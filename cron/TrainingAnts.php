<?php
$db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
$attackerRequest = mysqli_query($db, "SELECT u.iduser,n.id_level,b.level_id FROM nest n JOIN user u ON u.iduser = n.id_owner LEFT JOIN barrack b ON n.idnest=b.nest_id");
while($row = $attackerRequest->fetch_assoc()){
    $addWater = 30;
    $addFood = 30;
    $user = mysqli_query($db, "SELECT * FROM user WHERE iduser = " . $row['iduser'])->fetch_all()[0];
    if(!is_null($row['id_level'])){
        $level = mysqli_query($db, "SELECT * FROM levels WHERE id = " . $row['id_level'])->fetch_assoc();
        $addFood = $addFood+($level[0][2]*15);
    }if(!is_null($row['level_id'])){
        $level = mysqli_query($db, "SELECT * FROM levels WHERE id = " . $row['level_id'])->fetch_assoc();
        $addWater = $addWater+($level['level']*15);
    }
    mysqli_query($db,"UPDATE user SET water_resource = " . ($user[3]+$addWater) . ",food_resource=".($user[4]+$addFood) ." WHERE iduser =". $row['iduser'] );
}
?>