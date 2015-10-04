<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 9/29/2015
 * Time: 18:54
 */

namespace MVCProject\Models;

class User
{
    private $username;
    private $food;
    private $water;
    private $dirt;

    /**
     * User constructor.
     * @param $username
     * @param $food
     * @param $water
     * @param $dirt
     */
    public function __construct($username, $food, $water, $dirt)
    {
        $this->username = $username;
        $this->food = $food;
        $this->water = $water;
        $this->dirt = $dirt;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getFood()
    {
        return $this->food;
    }

    /**
     * @return mixed
     */
    public function getWater()
    {
        return $this->water;
    }

    /**
     * @return mixed
     */
    public function getDirt()
    {
        return $this->dirt;
    }





    //$db = mysqli_connect("antwarsc_antwars","c8ev6mfMK8vy","antwarsc_antwar");
    //$db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
    //$result = mysqli_query($db, "SELECT * FROM user WHERE username = '" . $user ."'");

    /**
     * @return bool|\mysqli_result
     */
    public static function getAll()
    {

        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "SELECT * FROM user");
        mysqli_close($db);
        return $result;
    }

    public static function getUser($username){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "SELECT * FROM user WHERE username = '" . $username ."'");
        mysqli_close($db);
        return $result->fetch_all()[0];
    }

    public static function getUserById($username){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "SELECT * FROM user WHERE iduser = '" . $username ."'");
        mysqli_close($db);
        return $result->fetch_assoc();
    }

    public static function getUserByMapCords($x,$y){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "SELECT ocuppied_by FROM map WHERE x = '" . $x ."' AND y = ".$y);
        return $result->fetch_all();
    }

    public static function isRegistered($username){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "SELECT * FROM user WHERE username = '" . $username ."'");
        mysqli_close($db);
        return $result->num_rows;

    }

    public static function tryLog($username,$password){
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "SELECT * FROM user WHERE username = '" . $username ."'");
        $row = $result->fetch_assoc();
        mysqli_close($db);
        return password_verify($password,$row['password']);
    }

    public static function tryReg($username,$password){
        $password= password_hash($password,PASSWORD_DEFAULT);
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        $result = mysqli_query($db, "INSERT INTO user (username,password,dirt_resource,water_resource,food_resource)VALUES ('$username','$password',500,500,500)");
        mysqli_close($db);
        return $result;

    }

    public static function updateResourceWaterAndFood($water,$food){
        $user = User::getUserById($_SESSION['id']);
        $waterDB = $user['water_resource']-$water;
        $foodDB = $user['food_resource']-$food;
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");
        mysqli_query($db, "UPDATE user SET food_resource = '" . $foodDB . "',
        water_resource = '" . $waterDB . "' WHERE iduser = ".$user['iduser']);
    }
}