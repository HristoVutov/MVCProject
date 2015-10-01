<?php
/**
 * Created by PhpStorm.
 * User: Hristo
 * Date: 9/28/2015
 * Time: 18:05
 */
namespace MVCProject\Controllers;

use MVCProject\View;
use MVCProject\ViewModels\UserEditViewModel;
use MVCProject\ViewModels\UserRegisterViewModel;
use MVCProject\Models\User;

class UsersController extends BaseController
{



    public function edit($id, $name)
    {
        $db = mysqli_connect("localhost", "root", "1234", "ant_rpg");

        $result = mysqli_query($db , "SELECT * FROM user");
        while ($row = $result->fetch_assoc()) {
            var_dump($row);
        }


        $model = new UserEditViewModel($id,$name);
        return new View($model);
    }

    public function register(){
        if (isset($_POST['username'], $_POST['password'])) {
            try {
                htmlspecialchars($user = $_POST['username']);
                htmlspecialchars($pass = $_POST['password']);
                if(!empty($user)&&!empty($pass)) {
                    if (User::isRegistered($user)) {
                        throw new \Exception('Username already exists');
                    } else {
                        var_dump(User::tryReg($user, $pass));
                    }
                }else{
                    throw new \Exception('All fields required');
                }


            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        $model = new UserRegisterViewModel();
        return new View($model);
    }

    public function login(){
        if (isset($_POST['username'], $_POST['password'])) {
            try {
                htmlspecialchars($user = $_POST['username']);
                htmlspecialchars($pass = $_POST['password']);
                if(User::tryLog($user,$pass)){
                    echo "logged";
                }
                else{
                    echo "wrong pass/name";
                }

            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }

        $model = new UserRegisterViewModel();
        return new View($model);
    }
}