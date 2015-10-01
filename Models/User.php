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
        return $result;
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
        $result = mysqli_query($db, "INSERT INTO user (username,password,food_resource,water_resource,dirt_resource)VALUES (".$username.",".$password.",500,500,500)");
        mysqli_close($db);
        var_dump($result);
        
    }
}